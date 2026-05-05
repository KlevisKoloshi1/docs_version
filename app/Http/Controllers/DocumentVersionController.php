<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentVersionController extends Controller
{
    public function store(Request $request, Document $document)
    {
        $this->authorize('edit', $document);

        $validated = $request->validate([
            'file' => ['required', 'file', 'max:51200'], // 50MB
            'change_summary' => ['nullable', 'string', 'max:2000'],
        ]);

        $user = $request->user();
        $file = $request->file('file');

        DB::transaction(function () use ($document, $user, $validated, $file) {
            $nextVersion = (int) (DocumentVersion::where('document_id', $document->id)->max('version_number') ?? 0) + 1;

            DocumentVersion::where('document_id', $document->id)
                ->where('is_current', true)
                ->update(['is_current' => false]);

            $path = $file->storeAs(
                "documents/{$document->id}/v{$nextVersion}",
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
                'version_number' => $nextVersion,
                'uploaded_by' => $user->id,
                'change_summary' => $validated['change_summary'] ?? null,
                'is_current' => true,
            ]);

            $document->update([
                'current_version_id' => $version->id,
            ]);
        });

        return back()->with('status', 'New version uploaded.');
    }

    public function restore(Request $request, Document $document, DocumentVersion $version)
    {
        $this->authorize('edit', $document);

        abort_unless($version->document_id === $document->id, 404);

        DB::transaction(function () use ($document, $version) {
            DocumentVersion::where('document_id', $document->id)
                ->where('is_current', true)
                ->update(['is_current' => false]);

            $version->update(['is_current' => true]);

            $document->update([
                'current_version_id' => $version->id,
            ]);
        });

        return back()->with('status', "Restored version v{$version->version_number}.");
    }
}

