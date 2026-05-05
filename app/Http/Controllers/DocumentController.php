<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function create()
    {
        return view('documents.upload');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $q = trim((string) $request->string('q'));
        $tab = (string) $request->string('tab', 'all');
        $type = trim((string) $request->string('type'));
        $from = $request->date('from');
        $to = $request->date('to');

        $documentsQuery = Document::query()
            ->where('user_id', $user->id)
            ->when($q !== '', fn ($query) => $query->where('title', 'ilike', "%{$q}%"))
            ->when($type !== '', fn ($query) => $query->whereHas('currentVersion', fn ($v) => $v->where('mime_type', 'ilike', "{$type}%")))
            ->when($from, fn ($query) => $query->whereDate('created_at', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('created_at', '<=', $to))
            ->with(['currentVersion'])
            ->latest();

        $sharedQuery = $user->sharedDocuments()
            ->when($q !== '', fn ($query) => $query->where('title', 'ilike', "%{$q}%"))
            ->when($type !== '', fn ($query) => $query->whereHas('currentVersion', fn ($v) => $v->where('mime_type', 'ilike', "{$type}%")))
            ->when($from, fn ($query) => $query->whereDate('documents.created_at', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('documents.created_at', '<=', $to))
            ->with(['currentVersion', 'owner'])
            ->latest();

        $documents = $tab === 'shared'
            ? $documentsQuery->whereRaw('1 = 0')->paginate(20)->withQueryString()
            : $documentsQuery->paginate(20)->withQueryString();

        $sharedDocuments = $tab === 'my'
            ? $sharedQuery->whereRaw('1 = 0')->paginate(20, ['documents.*'], 'shared_page')->withQueryString()
            : $sharedQuery->paginate(20, ['documents.*'], 'shared_page')->withQueryString();

        return view('documents.index', [
            'documents' => $documents,
            'sharedDocuments' => $sharedDocuments,
            'q' => $q,
            'tab' => in_array($tab, ['all', 'my', 'shared'], true) ? $tab : 'all',
            'type' => $type,
            'from' => $from?->toDateString(),
            'to' => $to?->toDateString(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'max:51200'], // 50MB
            'change_summary' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = $request->user();
        $file = $request->file('file');

        return DB::transaction(function () use ($user, $validated, $file) {
            $document = Document::create([
                'user_id' => $user->id,
                'title' => $validated['title'],
            ]);

            $path = $file->storeAs(
                "documents/{$document->id}/v1",
                Str::uuid()->toString().'.'.$file->getClientOriginalExtension(),
                ['disk' => config('filesystems.default', 'local')]
            );

            $version = DocumentVersion::create([
                'document_id' => $document->id,
                'storage_disk' => config('filesystems.default', 'local'),
                'file_path' => $path,
                'original_filename' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'size_bytes' => $file->getSize(),
                'version_number' => 1,
                'uploaded_by' => $user->id,
                'change_summary' => $validated['change_summary'] ?? null,
                'is_current' => true,
            ]);

            $document->update([
                'current_version_id' => $version->id,
            ]);

            return redirect()
                ->route('documents.show', $document)
                ->with('status', 'Document uploaded.');
        });
    }

    public function show(Request $request, Document $document)
    {
        $this->authorize('view', $document);

        $document->load([
            'owner',
            'currentVersion.uploader',
            'versions' => fn ($q) => $q->with('uploader')->orderByDesc('version_number'),
            'shares.sharedWith',
            'shares.sharedBy',
        ]);

        $canEdit = $request->user()->can('edit', $document);

        return view('documents.show', [
            'document' => $document,
            'canEdit' => $canEdit,
        ]);
    }

    public function download(Request $request, Document $document)
    {
        $this->authorize('view', $document);

        $document->load('currentVersion');
        abort_unless($document->currentVersion, 404);

        return Storage::disk($document->currentVersion->storage_disk)->download(
            $document->currentVersion->file_path,
            $document->currentVersion->original_filename
        );
    }

    public function update(Request $request, Document $document)
    {
        $this->authorize('edit', $document);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $document->update([
            'title' => $validated['title'],
        ]);

        return back()->with('status', 'Document renamed.');
    }

    public function destroy(Request $request, Document $document)
    {
        $this->authorize('delete', $document);

        $document->load('versions');

        DB::transaction(function () use ($document) {
            foreach ($document->versions as $version) {
                Storage::disk($version->storage_disk)->delete($version->file_path);
            }
            $document->delete();
        });

        return redirect()->route('documents.index')->with('status', 'Document deleted.');
    }
}

