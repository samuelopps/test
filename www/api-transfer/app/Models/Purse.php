<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Purse
 * @package App\Models
 */
class Purse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'balance',
        'status',
        'user_id',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function payingTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'paying_purse_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function receiverTransfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'receiver_purse_id', 'id');
    }
}
