<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; // Add this line

class UserCommentedOnPost extends Mailable
{
    use Queueable, SerializesModels;

    public $post;
    public $comment;

    /**
     * Create a new message instance.
     */
    public function __construct($post, $comment)
    {
        $this->post = $post;
        $this->comment = $comment;

        // Log that the Mailable was instantiated
        Log::info('UserCommentedOnPost Mailable instantiated', [
            'post_id' => $post->id,
            'comment_id' => $comment->id,
            'post_author_email' => $post->user->email,
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Comment on Your Post',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.postComment',
            with: [
                'post' => $this->post,
                'comment' => $this->comment,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
