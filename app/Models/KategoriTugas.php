<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tugas;

class KategoriTugas extends Model
{
    use HasFactory;

    protected $table = 'kategori_tugas';

    protected $fillable = [
        'name',
        'deskripsi'
    ];

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kategori_id');
    }
}