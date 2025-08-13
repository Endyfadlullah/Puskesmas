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
        'waktu_panggil'
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



    public function riwayatPanggilan()
    {
        return $this->hasMany(RiwayatPanggilan::class);
    }

    public function getWaktuPanggilAttribute($value)
    {
        // If waktu_panggil is not set but we have call history, get it from there
        if (!$value && $this->status === 'dipanggil') {
            $latestCall = $this->riwayatPanggilan()->latest('waktu_panggilan')->first();
            if ($latestCall) {
                return $latestCall->waktu_panggilan;
            }
        }

        // Ensure we return a Carbon instance for proper formatting
        if ($value) {
            return \Carbon\Carbon::parse($value);
        }

        return null;
    }
}
