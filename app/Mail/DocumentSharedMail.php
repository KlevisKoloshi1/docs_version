<?php

namespace App\Mail;

use App\Models\Document;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentSharedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Document $document,
        public User $sharedBy,
        public string $permission
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "{$this->sharedBy->name} shared a document with you",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.documents.shared',
            with: [
                'document' => $this->document,
                'sharedBy' => $this->sharedBy,
                'permission' => $this->permission,
                'documentUrl' => route('documents.show', $this->document),
            ],
        );
    }
}

