<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Transfer
 * @package App\Models
 */
class Transfer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $fillable = [
        'amount',
        'status',
        'notified',
        'paying_purse_id',
        'receiver_purse_id',
    ];

    /**
     * @return BelongsTo
     */
    public function payingPurse(): BelongsTo
    {
        return $this->belongsTo(Purse::class, 'paying_purse_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function receiverPurse(): BelongsTo
    {
        return $this->belongsTo(Purse::class, 'receiver_purse_id', 'id');
    }
}
