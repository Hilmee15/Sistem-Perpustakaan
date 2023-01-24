<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengarang extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
