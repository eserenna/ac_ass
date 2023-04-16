<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Bids\StoreBidRequest;
use App\Services\v1\Bids\BidServices;
use App\Services\v1\Users\UserServices;

class BidController extends Controller
{
    private $bidServices;

    public function __construct(BidServices $bidServices)
    {
        $this->bidServices = $bidServices;
    }

    public function store(StoreBidRequest $request)
    {
        try {
            $this->bidServices->create($request);

            $userResponse = (new UserServices())->fetch($request->user_id, ['first_name', 'last_name']);

            return response()->json([
                'message'   => 'Success', // why do u need this when u already have status code?
                'data'      => [
                    'full_name'    => $userResponse->full_name,
                    'price'        => number_format($request->price, 2, '.', '')
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
