<?php

namespace App\Mail;

use App\Models\CollegeInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CollegeRegistrationMail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public CollegeInfo $collegeInfo,
        public string $email,
        public string $password,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            to: [$this->email],
            subject: 'Welcome to ' . config('app.name') . ' - Your College Account Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.college-registration',
            with: [
                'collegeName' => $this->collegeInfo->college_name,
                'contactPerson' => $this->collegeInfo->contact_person,
                'email' => $this->email,
                'password' => $this->password,
                'loginUrl' => route('login'),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
