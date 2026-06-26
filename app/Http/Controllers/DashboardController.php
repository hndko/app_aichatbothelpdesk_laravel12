<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard statistik tiket.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Ticket::query();

        if ($user->isUser()) {
            $query->where('user_id', $user->id);
        }

        $data['title'] = 'Dashboard';
        $data['totalTickets']    = (clone $query)->count();
        $data['openTickets']     = (clone $query)->where('status', 'open')->count();
        $data['progressTickets'] = (clone $query)->where('status', 'progress')->count();
        $data['closedTickets']   = (clone $query)->where('status', 'closed')->count();
        
        $data['recentTickets']   = (clone $query)->with('category')
            ->latest()
            ->limit(6)
            ->get();

        return view('backend.dashboard.index', $data);
    }
}
