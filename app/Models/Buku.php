<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pengarangs()
    {
        return $this->belongsTo(Pengarang::class);
    }

    public function penerbits()
    {
        return $this->belongsTo(Penerbit::class);
    }

    public function raks()
    {
        return $this->belongsTo(Rak::class);
    }

    public function peminjamans()
    {
        return $this->belongsToMany(Peminjamans::class);
    }
}
