<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'assigned_admin_id',
        'subject',
        'description',
        'priority',
        'status',
        'sentiment',
        'is_ai_active',
    ];

    protected $casts = [
        'is_ai_active' => 'boolean',
    ];

    /**
     * Boot method: auto generate ticket_number TK-Ymd-XXXX
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $prefix = 'TK-' . date('Ymd') . '-';
                $lastTicket = static::where('ticket_number', 'like', $prefix . '%')->orderByDesc('id')->first();
                $nextNum = 1;
                if ($lastTicket) {
                    $lastNum = (int) substr($lastTicket->ticket_number, strrpos($lastTicket->ticket_number, '-') + 1);
                    $nextNum = $lastNum + 1;
                }
                $ticket->ticket_number = $prefix . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_admin_id');
    }

    public function chatHistories()
    {
        return $this->hasMany(\App\Models\ChatHistory::class, 'ticket_id')->orderBy('created_at', 'asc')->orderBy('id', 'asc');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeProgress($query)
    {
        return $query->where('status', 'progress');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }
}
