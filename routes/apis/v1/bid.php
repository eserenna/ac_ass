<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\BidController;

Route::group(['prefix' => 'bid'], function () {
    // should be bid.store as bid.create is used for creating a new bid form
    Route::post('', [BidController::class, 'store'])->name('bid.create');
});
