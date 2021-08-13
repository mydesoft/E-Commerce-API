<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use Symfony\Component\HttpFoundation\Response;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        if(!($product->reviews->count() > 0)){

            return response()->json(['message' => 'No Review Yet for this Product']);
        }
        return ReviewResource::collection($product->reviews);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->validate([
            'customer' => 'required',
            'review' => 'required',
            'star' => 'required'
        ]);

        $product = Product::find($id);

        $review = Review::create([
            'product_id' => $product->id,
            'customer' => $request->customer,
            'review' => $request->review,
            'star' => $request->star
        ]);

        return response()->json([
            'data' => new ReviewResource($review),
            'status' => 'Review for '.$product->name.' created'  
        ], Response::HTTP_CREATED);

        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Review $review)
    {
        $review->update($request->all());
        return response()->json([
            'data' =>  new ReviewResource($review),
            'message' => 'Review was updated'
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Review $review)
    {
        $review->delete();
        return response()->json(['message' => 'Review deleted'], Response::HTTP_NO_CONTENT);
    }
}
