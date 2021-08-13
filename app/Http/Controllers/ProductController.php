<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $products = Product::paginate(20);
        if(!$products->count() > 0){
            
           return response(['message' =>  'No Product Yet'], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'data' => ProductCollection::collection($products),
            'status' => 'Products Found'
        ], Response::HTTP_FOUND);
         
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         $data = $this->validatedExamRequests();

        $exam = new Exam();
        $exam->total_subject = $data['total_subject'];
        $exam->questions_per_subject = $data['questions_per_subject'];
        $exam->exam_Intruction = $data['exam_Intruction'];
        $exam->exam_date = $data['exam_date'];
        $exam->student_delay = $data['student_delay'];
        $exam->randomize_questions = $data['randomize_questions'];
        $exam->randomize_answer = $data['randomize_answer'];
        $exam->exam_end_instruction = $data['exam_end_instruction'];
        $exam->year = $data['year'];
        $exam->save();

        return $exam;
        // $data = $request->validate([
        //     'name' => 'required',
        //     'detail' => 'required',
        //     'price' => 'required',
        //     'stock' => 'required',
        //     'discount' => 'required'
        // ]); 
        
        
        // $user = Auth::user();
        // $product = Product::create([
        //     'user_id' => $user->id,
        //     'name' => $request->name,
        //     'detail' => $request->detail,
        //     'price' => $request->price,
        //     'stock' => $request->stock,
        //     'discount' => $request->discount
        // ]);
        // return response([
        //     'data' => new ProductResource($product),
        //     'message' => 'success'
        // ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

            if(!$product){
                return response()->json([
                    'error' => 'No Product found',
    
                ], Response::HTTP_NOT_FOUND);
            }
    

        return response()->json([
            'data' => new ProductResource($product)
        ], Response::HTTP_FOUND);

        return;
        
    }
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if(Auth::user()->id !== $product->user_id){
            return response([
                'error' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);  
        }

        $product->update($request->all());
        return response([
            'data' => new ProductResource($product),
            'message' => 'Updated Successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product = Product::where('id', $product->id)->firstOrFail();
        
        if(Auth::user()->id !== $product->user_id){
            return response([
                'error' => 'Unauthorized'
            ], Response::HTTP_UNAUTHORIZED);  
        }

        $product->delete();
        return response([
            'message' => 'Product Deleted'
        ], Response::HTTP_NO_CONTENT);
    }

     public function validatedExamRequests(){
        return $examRequests = request()->validate([
            'total_subject' => 'required',
            'questions_per_subject' => 'required',
            'exam_Intruction' =>  'required',
            'exam_date' => 'required',
            'student_delay' => 'required',
            'randomize_questions' => 'required',
            'randomize_answer' => 'required',
            'exam_end_instruction' => 'required',
            'year' => 'required',
        ]);
    }
}
