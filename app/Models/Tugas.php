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
        'deadline',
        'jam_deadline',

    ];

    /**
     * Relasi ke Status Tugas
     */
    public function status()
    {
        return $this->belongsTo(StatusTugas::class, 'status_id');
    }

    /**
     * Relasi ke Kategori Tugas (TAMBAHKAN INI)
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriTugas::class, 'kategori_id');
    }

    /**
     * Relasi ke User / Siswa Pemilik Tugas (TAMBAHKAN INI)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lampirans()
    {
        return $this->hasMany(\App\Models\Lampiran::class, 'tugas_id');
    }
}
