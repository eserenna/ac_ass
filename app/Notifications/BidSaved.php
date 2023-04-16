<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BidSaved extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected string $latestBidPrice;
    protected string $userLastBidPrice;

    public function __construct(
        $latestBidPrice,
        $userLastBidPrice
    )
    {
        $this->latestBidPrice = $latestBidPrice;
        $this->userLastBidPrice = $userLastBidPrice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            "latest_bid_price"      => number_format($this->latestBidPrice, 2, '.', ''),
            "user_last_bid_price"   => number_format($this->userLastBidPrice, 2, '.', '')
        ];
    }
}
