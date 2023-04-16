<?php

namespace App\Models;

use App\Jobs\BidSavedJob;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'price',
        'user_id',
    ];

    // created boot
    protected static function boot()
    {
        parent::boot();

        static::created(function (self $model) {
            self::dispatchBidSavedJob($model);
        });
    }

    private static function dispatchBidSavedJob($model)
    {
        $previousBid = Bid::where('user_id', $model->user_id)
            ->whereNot('id', $model->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $latestBidPrice = number_format($model->price, 2, '.', '');
        // $userLastBidPrice = $previousBid ? number_format($previousBid->price, 2, '.', '') : 0.00;

        dispatch(new BidSavedJob($latestBidPrice));
    }
}
