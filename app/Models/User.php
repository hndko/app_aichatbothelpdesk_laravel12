<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'avatar',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Cek apakah user adalah admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah user biasa.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Cek apakah user adalah service desk.
     */
    public function isServiceDesk(): bool
    {
        return $this->role === 'service_desk';
    }

    /**
     * Cek apakah user adalah helpdesk teknisi.
     */
    public function isHelpdesk(): bool
    {
        return $this->role === 'helpdesk';
    }

    /**
     * Cek apakah user adalah staf internal (admin, service desk, atau helpdesk).
     */
    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'service_desk', 'helpdesk']);
    }

    /**
     * Relasi: Tiket yang dibuat user ini.
     */
    public function tickets()
    {
        return $this->hasMany(\App\Models\Ticket::class, 'user_id');
    }

    /**
     * Relasi: Tiket yang di-assign ke admin ini.
     */
    public function assignedTickets()
    {
        return $this->hasMany(\App\Models\Ticket::class, 'assigned_admin_id');
    }

    /**
     * Relasi: Riwayat chat user.
     */
    public function chatHistories()
    {
        return $this->hasMany(\App\Models\ChatHistory::class, 'user_id');
    }

    /**
     * Relasi: Spesialisasi kategori (untuk auto-assign).
     */
    public function specializations()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'admin_categories', 'admin_id', 'category_id');
    }
}
