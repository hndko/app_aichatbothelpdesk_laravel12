<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relasi: Tiket dalam kategori ini.
     */
    public function tickets()
    {
        return $this->hasMany(\App\Models\Ticket::class, 'category_id');
    }

    /**
     * Relasi: Knowledge base dalam kategori ini.
     */
    public function knowledgeBases()
    {
        return $this->hasMany(\App\Models\KnowledgeBase::class, 'category_id');
    }

    /**
     * Relasi: Admin yang punya spesialisasi di kategori ini.
     */
    public function admins()
    {
        return $this->belongsToMany(\App\Models\User::class, 'admin_categories', 'category_id', 'admin_id');
    }
}
