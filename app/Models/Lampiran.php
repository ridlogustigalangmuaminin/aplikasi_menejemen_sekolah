<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tugas;

class Lampiran extends Model
{
    use HasFactory;

    protected $table = 'lampiran';

    protected $fillable = [
        'tugas_id',
        'nama_file',
        'path',
        'type'
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
}