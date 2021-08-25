<?php

namespace App\Http\Controllers;

use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    protected $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Add Product review.
     *
     * @param Request $request
     * @return Response
     */
    public function ratingProduct(Request $request)
    {
        if ($request || Auth::check())
        {
            $data = [
              'review'     => $request->get('review'),
              'rating'     => $request->get('rating'),
              'user_id'    => Auth::user()->id,
              'product_id' => $request->get('product_id'),
            ];
            if ($this->ratingService->ratingProduct($data)) {
                return back()->with([
                    'message' => __('custom.rating_success'),
                    'alert'   => 'alert-success',
                ]);
            }
        }
        return abort(404);
    }
}
