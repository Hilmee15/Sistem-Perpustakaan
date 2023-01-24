<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjamans';
    protected $guarded = [];

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'peminjaman_detail');
    }

}
