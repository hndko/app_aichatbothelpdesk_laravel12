<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Helpdesk - NexusDesk AI</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4f46e5; }
        .header p { margin: 5px 0 0 0; color: #666; font-size: 12px; }
        .stats { margin-bottom: 15px; width: 100%; border-collapse: collapse; }
        .stats td { padding: 8px; background: #f8fafc; border: 1px solid #e2e8f0; text-align: center; font-weight: bold; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #cbd5e1; padding: 6px 8px; text-align: left; }
        .table th { background-color: #4f46e5; color: white; font-size: 11px; }
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .badge-open { background: #fee2e2; color: #991b1b; }
        .badge-progress { background: #fef3c7; color: #92400e; }
        .badge-closed { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>

<div class="header">
    <h2>NEXUSDESK AI — LAPORAN PERFORMA IT HELPDESK</h2>
    <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB | Oleh: {{ auth()->user()->name ?? 'Administrator' }}</p>
</div>

<table class="stats">
    <tr>
        <td>TOTAL TIKET: {{ $total }}</td>
        <td>OPEN: {{ $open }}</td>
        <td>CLOSED: {{ $closed }}</td>
    </tr>
</table>

<table class="table">
    <thead>
        <tr>
            <th>No. Tiket</th>
            <th>Pelapor</th>
            <th>Subjek Masalah</th>
            <th>Kategori</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th>Sentimen AI</th>
            <th>Teknisi Assignee</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tickets as $t)
            <tr>
                <td><strong>{{ $t->ticket_number }}</strong></td>
                <td>{{ $t->user->name ?? '-' }}</td>
                <td>{{ $t->subject }}</td>
                <td>{{ strtoupper($t->category->name ?? '-') }}</td>
                <td>{{ ucfirst($t->priority) }}</td>
                <td><span class="badge badge-{{ $t->status }}">{{ strtoupper($t->status) }}</span></td>
                <td>{{ ucfirst($t->sentiment ?? 'Neutral') }}</td>
                <td>{{ $t->assignedAdmin->name ?? 'Belum di-assign' }}</td>
                <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align: center; padding: 15px;">Tidak ada data tiket.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
