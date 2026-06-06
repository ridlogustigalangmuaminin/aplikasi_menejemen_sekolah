<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tugas;

class StatusTugas extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'status_id');
    }
}