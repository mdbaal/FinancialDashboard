<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account',
        'receiver',
        'description',
        'amount',
        'amount_after',
        'category',
        'date'
    ];

    public function account(): BelongsTo{
        return $this->belongsTo(account::class,'account','name');
    }

    public function category(): HasOne{
        return $this->hasOne(Category::class,'category','name');
    }
}
