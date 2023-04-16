<?php

namespace App\Services\v1\Bids;

use App\Http\Requests\v1\Bids\StoreBidRequest;
use App\Models\Bid;

class BidServices
{
    public function create(StoreBidRequest $request): Bid
    {
        $bid = Bid::create([
            'user_id'   => $request->user_id,
            'price'     => $request->price,
        ]);

        return $bid;
    }
}
