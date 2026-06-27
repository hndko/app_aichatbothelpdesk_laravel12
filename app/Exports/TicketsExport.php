<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Ticket::with(['user', 'category', 'assignedAdmin'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No. Tiket',
            'Pelapor',
            'Email Pelapor',
            'Subjek Masalah',
            'Kategori',
            'Prioritas',
            'Status',
            'Sentimen AI',
            'Teknisi Penanggung Jawab',
            'Tanggal Dibuat',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->user->name ?? '-',
            $ticket->user->email ?? '-',
            $ticket->subject,
            strtoupper($ticket->category->name ?? '-'),
            ucfirst($ticket->priority),
            strtoupper($ticket->status),
            ucfirst($ticket->sentiment ?? 'Neutral'),
            $ticket->assignedAdmin->name ?? 'Belum di-assign',
            $ticket->created_at->translatedFormat('d F Y, H:i:s WIB'),
        ];
    }
}
