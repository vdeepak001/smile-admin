<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentRegistrationMail extends Mailable
{
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Student $student,
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
            subject: 'Welcome to ' . config('app.name') . ' - Your Student Account Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.student-registration',
            with: [
                'studentName' => $this->student->user->full_name ?? $this->student->user->first_name . ' ' . $this->student->user->last_name,
                'enrollmentNo' => $this->student->enrollment_no,
                'collegeName' => $this->student->user->college->college_name ?? 'Your College',
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
