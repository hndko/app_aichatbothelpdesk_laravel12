<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected Ticket $ticket;
    protected string $oldStatus;

    public function __construct(Ticket $ticket, string $oldStatus)
    {
        $this->ticket    = $ticket;
        $this->oldStatus = $oldStatus;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/tiket/' . $this->ticket->id);
        $statusLabel = strtoupper($this->ticket->status);
        $emoji = match ($this->ticket->status) {
            'progress' => '🔄',
            'closed'   => '✅',
            default    => '📋',
        };

        $mail = (new MailMessage)
            ->subject("{$emoji} Status Tiket Diperbarui: {$this->ticket->ticket_number}")
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line("Status tiket Anda telah diperbarui oleh Tim IT Helpdesk:")
            ->line('**No. Tiket:** ' . $this->ticket->ticket_number)
            ->line('**Subjek:** ' . $this->ticket->subject)
            ->line('**Status Sebelumnya:** ' . strtoupper($this->oldStatus))
            ->line("**Status Terbaru:** {$statusLabel}")
            ->action('Lihat Detail Tiket', $url);

        if ($this->ticket->status === 'closed') {
            $mail->line('Tiket Anda telah diselesaikan. Jika kendala masih berlanjut, silakan buat tiket baru.');
        } else {
            $mail->line('Teknisi kami sedang menangani kendala Anda. Anda akan mendapatkan notifikasi jika ada perkembangan.');
        }

        return $mail->salutation('Salam, Tim MariDesk AI');
    }
}
