<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrians';
    protected $fillable = [
        'user_id',
        'poli_id',
        'no_antrian',
        'tanggal_antrian',
        'is_call',
        'status',
        'waktu_panggil',
        'loket_id'
    ];

    protected $casts = [
        'tanggal_antrian' => 'date',
        'waktu_panggil' => 'datetime',
        'is_call' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function loket()
    {
        return $this->belongsTo(Loket::class);
    }

    public function riwayatPanggilan()
    {
        return $this->hasMany(RiwayatPanggilan::class);
    }
}
