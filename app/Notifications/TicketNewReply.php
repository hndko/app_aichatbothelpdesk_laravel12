<?php

namespace App\Notifications;

use App\Models\ChatHistory;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TicketNewReply extends Notification implements ShouldQueue
{
    use Queueable;

    protected Ticket $ticket;
    protected string $replierName;
    protected string $messagePreview;

    public function __construct(Ticket $ticket, string $replierName, string $message)
    {
        $this->ticket         = $ticket;
        $this->replierName    = $replierName;
        $this->messagePreview = Str::limit($message, 200);
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/tiket/' . $this->ticket->id);

        return (new MailMessage)
            ->subject('💬 Balasan Baru di Tiket ' . $this->ticket->ticket_number)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Ada balasan baru pada tiket Anda:')
            ->line('**No. Tiket:** ' . $this->ticket->ticket_number)
            ->line('**Subjek:** ' . $this->ticket->subject)
            ->line('**Dibalas oleh:** ' . $this->replierName)
            ->line('**Pesan:**')
            ->line('> ' . $this->messagePreview)
            ->action('Buka Percakapan', $url)
            ->line('Balas kembali melalui halaman tiket jika Anda membutuhkan bantuan lebih lanjut.')
            ->salutation('Salam, Tim MariDesk AI');
    }
}
