<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard statistik tiket dengan filter range date & analytics lengkap.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Ticket::query();

        if ($user->isUser()) {
            $query->where('user_id', $user->id);
        } elseif ($user->isHelpdesk()) {
            $query->where('assigned_admin_id', $user->id);
        }

        // Filter berdasarkan Range Date
        $range = $request->input('range', 'all');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($range === 'today') {
            $query->whereDate('created_at', now()->toDateString());
        } elseif ($range === '7days') {
            $query->where('created_at', '>=', now()->subDays(7)->startOfDay());
        } elseif ($range === '30days') {
            $query->where('created_at', '>=', now()->subDays(30)->startOfDay());
        } elseif ($range === 'month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($range === 'custom' && !empty($startDate) && !empty($endDate)) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $data['title'] = 'Dasbor Utama';
        $data['selectedRange'] = $range;
        $data['startDate'] = $startDate;
        $data['endDate'] = $endDate;

        // KPI Utama
        $totalTickets    = (clone $query)->count();
        $openTickets     = (clone $query)->where('status', 'open')->count();
        $progressTickets = (clone $query)->where('status', 'progress')->count();
        $closedTickets   = (clone $query)->where('status', 'closed')->count();

        $data['totalTickets']    = $totalTickets;
        $data['openTickets']     = $openTickets;
        $data['progressTickets'] = $progressTickets;
        $data['closedTickets']   = $closedTickets;
        $data['completionRate']  = $totalTickets > 0 ? round(($closedTickets / $totalTickets) * 100, 1) : 0;

        // Analytics 1: Distribusi Kategori Kendala
        $categories = Category::all();
        $categoryColors = [
            'Hardware' => 'bg-blue-600 dark:bg-blue-500',
            'Software' => 'bg-indigo-600 dark:bg-indigo-500',
            'Network'  => 'bg-purple-600 dark:bg-purple-500',
        ];
        $categoryIcons = [
            'Hardware' => '💻',
            'Software' => '📦',
            'Network'  => '🌐',
        ];

        $categoryAnalytics = [];
        foreach ($categories as $cat) {
            $count = (clone $query)->where('category_id', $cat->id)->count();
            $percent = $totalTickets > 0 ? round(($count / $totalTickets) * 100, 1) : 0;
            $categoryAnalytics[] = [
                'name'    => $cat->name,
                'count'   => $count,
                'percent' => $percent,
                'color'   => $categoryColors[$cat->name] ?? 'bg-slate-600 dark:bg-slate-500',
                'icon'    => $categoryIcons[$cat->name] ?? '📁',
            ];
        }
        $data['categoryAnalytics'] = $categoryAnalytics;

        // Analytics 2: Analisis Prioritas Tiket
        $priorities = [
            'urgent' => ['label' => 'Urgent / Darurat', 'color' => 'bg-purple-600 dark:bg-purple-500', 'badge' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300 border border-purple-200 dark:border-purple-800'],
            'high'   => ['label' => 'High / Tinggi', 'color' => 'bg-rose-600 dark:bg-rose-500', 'badge' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800'],
            'medium' => ['label' => 'Medium / Sedang', 'color' => 'bg-blue-600 dark:bg-blue-500', 'badge' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800'],
            'low'    => ['label' => 'Low / Rendah', 'color' => 'bg-slate-500 dark:bg-slate-400', 'badge' => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600'],
        ];

        $priorityAnalytics = [];
        foreach ($priorities as $key => $pInfo) {
            $count = (clone $query)->where('priority', $key)->count();
            $percent = $totalTickets > 0 ? round(($count / $totalTickets) * 100, 1) : 0;
            $priorityAnalytics[] = [
                'key'     => $key,
                'label'   => $pInfo['label'],
                'count'   => $count,
                'percent' => $percent,
                'color'   => $pInfo['color'],
                'badge'   => $pInfo['badge'],
            ];
        }
        $data['priorityAnalytics'] = $priorityAnalytics;

        // Analytics 3: Sentimen Kepuasan Pelapor (AI Detected)
        $sentiments = [
            'positive' => ['label' => 'Puas / Positif', 'emoji' => '😊', 'color' => 'bg-emerald-500 dark:bg-emerald-400', 'text' => 'text-emerald-600 dark:text-emerald-400'],
            'neutral'  => ['label' => 'Netral / Biasa', 'emoji' => '😐', 'color' => 'bg-amber-500 dark:bg-amber-400', 'text' => 'text-amber-600 dark:text-amber-400'],
            'negative' => ['label' => 'Tidak Puas / Kecewa', 'emoji' => '😠', 'color' => 'bg-rose-500 dark:bg-rose-400', 'text' => 'text-rose-600 dark:text-rose-400'],
        ];

        $sentimentAnalytics = [];
        foreach ($sentiments as $key => $sInfo) {
            $count = (clone $query)->where('sentiment', $key)->count();
            $percent = $totalTickets > 0 ? round(($count / $totalTickets) * 100, 1) : 0;
            $sentimentAnalytics[] = [
                'key'     => $key,
                'label'   => $sInfo['label'],
                'emoji'   => $sInfo['emoji'],
                'count'   => $count,
                'percent' => $percent,
                'color'   => $sInfo['color'],
                'text'    => $sInfo['text'],
            ];
        }
        $data['sentimentAnalytics'] = $sentimentAnalytics;

        // Tiket Terbaru yang sudah dipersiapkan atribut tampilannya (Menghindari blok PHP di blade)
        $data['recentTickets'] = (clone $query)->with('category')
            ->latest()
            ->limit(6)
            ->get()
            ->map(function ($ticket) {
                $ticket->status_badge = match($ticket->status) {
                    'open'     => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 border border-red-200 dark:border-red-800',
                    'progress' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300 border border-amber-200 dark:border-amber-800',
                    'closed'   => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800',
                    default    => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600',
                };

                $ticket->priority_badge = match($ticket->priority) {
                    'urgent' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/40 dark:text-purple-300 border border-purple-200 dark:border-purple-800',
                    'high'   => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800',
                    'medium' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-200 dark:border-blue-800',
                    default  => 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600',
                };

                $ticket->formatted_date = $ticket->created_at->translatedFormat('d F Y, H:i:s WIB');
                $ticket->category_name  = strtoupper($ticket->category->name ?? '-');

                return $ticket;
            });

        // Statistik Kinerja Helpdesk (Harian, Mingguan, Bulanan)
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

        return view('backend.dashboard.index', $data);
    }
}
