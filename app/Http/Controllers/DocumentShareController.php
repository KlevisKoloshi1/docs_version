<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentShare;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DocumentShareController extends Controller
{
    public function store(Request $request, Document $document)
    {
        $this->authorize('edit', $document);

        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'permission' => ['required', 'in:view,edit'],
        ]);

        $shareWith = User::whereRaw('LOWER(email) = ?', [strtolower($validated['email'])])->first();

        if (! $shareWith) {
            throw ValidationException::withMessages([
                'email' => 'No user found with this email address.',
            ]);
        }

        if ($shareWith->id === $request->user()->id) {
            return back()->withErrors(['email' => 'You cannot share a document with yourself.']);
        }

        DocumentShare::updateOrCreate(
            [
                'document_id' => $document->id,
                'shared_with_user_id' => $shareWith->id,
            ],
            [
                'shared_by_user_id' => $request->user()->id,
                'permission' => $validated['permission'],
            ],
        );

        return back()->with('status', 'Sharing updated.');
    }

    public function destroy(Request $request, Document $document, DocumentShare $share)
    {
        $this->authorize('edit', $document);

        abort_unless($share->document_id === $document->id, 404);

        $share->delete();

        return back()->with('status', 'Share removed.');
    }
}

