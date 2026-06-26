<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ChatHistory;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketCreated;
use App\Notifications\TicketStatusUpdated;
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

        $data['title']      = 'Tiket Kendala';
        $data['tickets']    = $query->latest()->paginate(10)->withQueryString();
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
            // Auto-assign admin berdasarkan spesialisasi kategori
            $assignedAdminId = null;
            $specialistAdmin = User::where('role', 'admin')
                ->whereHas('specializations', function ($q) use ($validated) {
                    $q->where('categories.id', $validated['category_id']);
                })->inRandomOrder()->first();

            if ($specialistAdmin) {
                $assignedAdminId = $specialistAdmin->id;
            } else {
                $anyAdmin = User::where('role', 'admin')->inRandomOrder()->first();
                $assignedAdminId = $anyAdmin?->id;
            }

            $ticket = Ticket::create([
                'user_id'           => auth()->id(),
                'category_id'       => $validated['category_id'],
                'assigned_admin_id' => $assignedAdminId,
                'subject'           => $validated['subject'],
                'description'       => $validated['description'],
                'priority'          => $validated['priority'],
                'status'            => 'open',
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

        $data['title']  = 'Detail Tiket #' . $ticket->ticket_number;
        $data['ticket'] = $ticket;

        return view('backend.tiket.show', $data);
    }

    /**
     * Perbarui status tiket (Admin only).
     */
    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:open,progress,closed'],
        ]);

        $ticket    = Ticket::findOrFail($id);
        $oldStatus = $ticket->status;

        // Hanya kirim notifikasi jika status benar-benar berubah
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
}
