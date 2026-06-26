<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard.
     */
    public function index()
    {
        $data['title'] = 'Dashboard';

        // Statistik akan diisi setelah model Ticket dibuat (Fase 2)
        $data['totalTickets']    = 0;
        $data['openTickets']     = 0;
        $data['progressTickets'] = 0;
        $data['closedTickets']   = 0;
        $data['recentTickets']   = collect();

        return view('backend.dashboard.index', $data);
    }
}
