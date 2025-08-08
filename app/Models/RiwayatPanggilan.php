<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPanggilan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_panggilan';
    protected $fillable = ['antrian_id', 'waktu_panggilan', 'created_at', 'updated_at'];

    protected $casts = [
        'waktu_panggilan' => 'datetime',
    ];

    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }
}
