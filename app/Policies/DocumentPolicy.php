<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function view(User $user, Document $document): bool
    {
        if ($document->user_id === $user->id) {
            return true;
        }

        return $document->sharedWithUsers()
            ->where('users.id', $user->id)
            ->whereIn('document_shares.permission', ['view', 'edit'])
            ->exists();
    }

    public function edit(User $user, Document $document): bool
    {
        if ($document->user_id === $user->id) {
            return true;
        }

        return $document->sharedWithUsers()
            ->where('users.id', $user->id)
            ->where('document_shares.permission', 'edit')
            ->exists();
    }

    public function delete(User $user, Document $document): bool
    {
        return $document->user_id === $user->id;
    }
}

