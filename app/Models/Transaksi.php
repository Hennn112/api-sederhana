<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = "transaksi";
    protected $fillable = [
        'name',
        'jumlah',
        'product_id',
    ];

    public function transaksi()
    {
        return $this->hasMany(Product::class, 'id', 'product_id');
    }
}
