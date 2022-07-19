<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'prices';
    protected $fillable = ['coin_id', 'price', 'currency'];

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
