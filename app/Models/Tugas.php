<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'user_id',
        'kategori_id',
        'status_id',
        'judul_tugas',
        'deskripsi',
        'deadline'
    ];
    public function status()
{
    return $this->belongsTo(StatusTugas::class, 'status_id');
}
}
