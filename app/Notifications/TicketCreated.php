<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/tiket/' . $this->ticket->id);

        return (new MailMessage)
            ->subject('🎫 Tiket Baru: ' . $this->ticket->ticket_number)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Tiket kendala IT Anda telah berhasil dibuat dengan detail berikut:')
            ->line('**No. Tiket:** ' . $this->ticket->ticket_number)
            ->line('**Subjek:** ' . $this->ticket->subject)
            ->line('**Kategori:** ' . strtoupper($this->ticket->category->name ?? '-'))
            ->line('**Prioritas:** ' . ucfirst($this->ticket->priority))
            ->line('**Status:** OPEN')
            ->action('Lihat Detail Tiket', $url)
            ->line('Tim IT Helpdesk kami akan segera menindaklanjuti tiket Anda. Terima kasih telah melapor!')
            ->salutation('Salam, Tim MariDesk AI');
    }
}
