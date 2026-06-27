<?php

namespace App\Http\Controllers;

use App\Exports\TicketsExport;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman rekapitulasi laporan Helpdesk.
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['user', 'category', 'assignedAdmin']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $data['title']      = 'Laporan Performa Helpdesk';
        $data['tickets']    = $query->latest()->paginate(15)->withQueryString();
        $data['categories'] = Category::all();

        // Statistik laporan
        $data['total']      = Ticket::count();
        $data['open']       = Ticket::open()->count();
        $data['progress']   = Ticket::progress()->count();
        $data['closed']     = Ticket::closed()->count();
        $data['positive']   = Ticket::where('sentiment', 'positive')->count();
        $data['negative']   = Ticket::where('sentiment', 'negative')->count();

        // Statistik Kinerja Helpdesk
        $data['helpdeskStats'] = User::whereIn('role', ['helpdesk', 'service_desk', 'admin'])->get()->map(function ($staff) {
            return (object) [
                'name'         => $staff->name,
                'role_label'   => strtoupper(str_replace('_', ' ', $staff->role)),
                'daily'        => $staff->assignedTickets()->whereDate('updated_at', \Carbon\Carbon::today())->count(),
                'weekly'       => $staff->assignedTickets()->whereBetween('updated_at', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()])->count(),
                'monthly'      => $staff->assignedTickets()->whereMonth('updated_at', \Carbon\Carbon::now()->month)->whereYear('updated_at', \Carbon\Carbon::now()->year)->count(),
                'total_closed' => $staff->assignedTickets()->where('status', 'closed')->count(),
                'total_active' => $staff->assignedTickets()->whereIn('status', ['open', 'progress'])->count(),
            ];
        });

        return view('backend.report.index', $data);
    }

    /**
     * Export laporan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $tickets = Ticket::with(['user', 'category', 'assignedAdmin'])->latest()->get();

        $pdf = Pdf::loadView('backend.report.pdf', [
            'tickets' => $tickets,
            'total'   => $tickets->count(),
            'open'    => $tickets->where('status', 'open')->count(),
            'closed'  => $tickets->where('status', 'closed')->count(),
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Laporan-Helpdesk-MariDeskAI-' . date('Ymd-His') . '.pdf');
    }

    /**
     * Export laporan statistik dan daftar tiket ke Excel.
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new TicketsExport, 'Laporan-Helpdesk-MariDeskAI-' . date('Ymd-His') . '.xlsx');
    }
}
