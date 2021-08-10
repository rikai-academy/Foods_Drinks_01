<?php

namespace App\Http\Controllers;

use App\Models\Evaluates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
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
            $this->create($data);
            return back()->with([
              'message' => __('custom.rating_success'),
              'alert' => 'alert-success',
            ]);
        }
        return abort(404);
    }

    /**
     * Insert review to Database.
     */
    private function create($data)
    {
        return Evaluates::create([
            'review' => $data['review'],
            'rating' => $data['rating'],
            'user_id' => $data['user_id'],
            'product_id' => $data['product_id'],
        ]);
    }
}
