<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ChatHistory;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreated;
use App\Notifications\TicketStatusUpdated;
use App\Services\LlmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TiketController extends Controller
{
    /**
     * Daftar tiket dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Ticket::with(['category', 'user', 'assignedAdmin']);

        if ($user->isUser()) {
            $query->where('user_id', $user->id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Pencarian subject atau nomor tiket
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $tickets = $query->latest()->paginate(10)->withQueryString();
        $tickets->getCollection()->transform(function ($ticket) {
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

            $ticket->sentiment_badge = match($ticket->sentiment) {
                'positive' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800',
                'negative' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800',
                default    => 'bg-sky-100 text-sky-800 dark:bg-sky-900/40 dark:text-sky-300 border border-sky-200 dark:border-sky-800',
            };

            $ticket->sentiment_label = match($ticket->sentiment) {
                'positive' => '😊 Puas',
                'negative' => '😠 Urgent',
                default    => '😐 Netral',
            };

            $ticket->formatted_date = $ticket->created_at->translatedFormat('d F Y, H:i WIB');
            $ticket->category_name  = strtoupper($ticket->category->name ?? '-');

            return $ticket;
        });

        $data['title']      = 'Tiket Kendala';
        $data['tickets']    = $tickets;
        $data['categories'] = Category::all();

        return view('backend.tiket.index', $data);
    }

    /**
     * Tampilkan form pembuatan tiket baru (User).
     */
    public function create()
    {
        $data['title']      = 'Buat Tiket Baru';
        $data['categories'] = Category::all();

        return view('backend.tiket.create', $data);
    }

    /**
     * Simpan tiket baru ke database beserta log percakapan awal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'     => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority'    => ['required', 'in:low,medium,high'],
            'description' => ['required', 'string'],
        ], [
            'subject.required'     => 'Subjek masalah wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'description.required' => 'Deskripsi detail masalah wajib diisi.',
        ]);

        $ticket = null;

        DB::transaction(function () use ($validated, &$ticket) {
            // Deteksi sentimen AI awal
            $sentiment = LlmService::detectSentiment($validated['subject'] . ' ' . $validated['description']);

            $ticket = Ticket::create([
                'user_id'           => auth()->id(),
                'category_id'       => $validated['category_id'],
                'assigned_admin_id' => null,
                'subject'           => $validated['subject'],
                'description'       => $validated['description'],
                'priority'          => $validated['priority'],
                'status'            => 'open',
                'sentiment'         => $sentiment,
                'is_ai_active'      => true,
            ]);

            // Simpan deskripsi awal sebagai pesan pertama di chat history
            ChatHistory::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => auth()->id(),
                'sender_type' => 'user',
                'message'     => $validated['description'],
            ]);
        });

        // Kirim notifikasi email ke pelapor
        if ($ticket) {
            $ticket->load('category');
            try {
                $ticket->user()->first()?->notify(new TicketCreated($ticket));
            } catch (\Exception $e) {
                Log::warning('Gagal mengirim email TicketCreated: ' . $e->getMessage());
            }
        }

        return redirect()->route('tiket.index')
            ->with('success', 'Tiket berhasil dibuat! Tim teknis kami akan segera menindaklanjuti.');
    }

    /**
     * Tampilkan detail tiket dan riwayat percakapan.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with(['user', 'category', 'assignedAdmin', 'chatHistories.user'])->findOrFail($id);

        if (auth()->user()->isUser() && $ticket->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat tiket ini.');
        }

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

        $ticket->sentiment_badge = match($ticket->sentiment) {
            'positive' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800',
            'negative' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300 border border-rose-200 dark:border-rose-800',
            default    => 'bg-sky-100 text-sky-800 dark:bg-sky-900/40 dark:text-sky-300 border border-sky-200 dark:border-sky-800',
        };

        $ticket->sentiment_label = match($ticket->sentiment) {
            'positive' => '😊 Puas / Positif',
            'negative' => '😠 Tidak Puas / Urgent',
            default    => '😐 Netral / Normal',
        };

        $ticket->formatted_date = $ticket->created_at->translatedFormat('d F Y, H:i:s WIB');
        $ticket->category_name  = strtoupper($ticket->category->name ?? '-');

        $data['title']  = 'Detail Tiket #' . $ticket->ticket_number;
        $data['ticket'] = $ticket;
        $data['admins'] = User::whereIn('role', ['helpdesk', 'admin'])->get();

        return view('backend.tiket.show', $data);
    }

    /**
     * Perbarui status tiket (Admin & Service Desk).
     */
    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:open,progress,closed'],
        ]);

        $ticket    = Ticket::findOrFail($id);
        $oldStatus = $ticket->status;

        if ($oldStatus !== $validated['status']) {
            $ticket->update(['status' => $validated['status']]);

            try {
                $ticket->user()->first()?->notify(new TicketStatusUpdated($ticket, $oldStatus));
            } catch (\Exception $e) {
                Log::warning('Gagal mengirim email TicketStatusUpdated: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Status tiket berhasil diperbarui menjadi ' . strtoupper($validated['status']) . '.');
    }

    /**
     * Perbarui penugasan teknisi pada tiket (Admin & Service Desk).
     */
    public function updateAssignee(Request $request, string $id)
    {
        $validated = $request->validate([
            'assigned_admin_id' => ['nullable', 'exists:users,id'],
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update(['assigned_admin_id' => $validated['assigned_admin_id']]);

        return back()->with('success', 'Penugasan teknisi tiket berhasil diperbarui.');
    }

    /**
     * Aktifkan atau nonaktifkan otomatisasi balasan AI pada obrolan tiket.
     */
    public function toggleAiStatus(Request $request, string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['is_ai_active' => !$ticket->is_ai_active]);

        $statusMsg = $ticket->is_ai_active ? 'diaktifkan kembali' : 'dinonaktifkan (diambil alih teknisi)';
        return back()->with('success', "Asisten AI berhasil $statusMsg pada tiket ini.");
    }
}
