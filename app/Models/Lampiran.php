<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tugas;

class Lampiran extends Model
{
    use HasFactory;

    protected $table = 'lampirans';

    protected $fillable = [
        'tugas_id',
        'file_name',
        'file_path',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
}