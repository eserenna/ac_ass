<?php

namespace App\Jobs;

use App\Models\Bid;
use App\Models\User;
use App\Notifications\BidSaved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class BidSavedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected string $latestBidPrice;

    public function __construct(
        $latestBidPrice
    ) {
        $this->latestBidPrice = $latestBidPrice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::chunk(20, function ($users) {
            foreach ($users as $user) {
                $userLastBidPrice = Bid::where('user_id', $user->id)->latest()->first();
                $userLastBidPrice = $userLastBidPrice ? number_format($userLastBidPrice->price, 2, '.', '') : "0.00";

                $user->notify(new BidSaved($this->latestBidPrice, $userLastBidPrice));
            }
        });
    }
}
