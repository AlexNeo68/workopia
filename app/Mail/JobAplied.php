<?php

namespace App\Mail;

use App\Models\Aplicant;
use App\Models\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class JobAplied extends Mailable
{
    use Queueable, SerializesModels;

    public Aplicant $aplicant;
    public Job $job;

    /**
     * Create a new message instance.
     */
    public function __construct(Aplicant $aplicant, Job $job)
    {
        $this->aplicant = $aplicant;
        $this->job = $job;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Job Aplied',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.applied-job',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        if ($this->aplicant->resume_path) {
            $attachments[] = Attachment::fromPath(storage_path('app/public/' . $this->aplicant->resume_path));
        }

        return $attachments;
    }
}
