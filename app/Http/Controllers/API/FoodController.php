<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $foods = Food::all();
        $total = $foods->count();
        return response()->json([
            'total' => $total,
            'data' => $foods
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRequest();
        $food = Food::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);
        return response()->json($food);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Food::findOrFail($id);
        } catch (\Throwable $th) {
            return response()
                ->json(['message' => 'The given food resource is not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validateRequest();
            $food = Food::findOrFail($id);
            $food->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description
            ]);
            return response()->json($food);
        } catch (\Throwable $th) {
            return response()
                ->json(['message' => 'The given food resource is not found.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $food = Food::findOrFail($id);
            $food->delete();
            return response()->json(['message' => 'Delete Success'], 204);
        } catch (\Throwable $th) {
            return response()
                ->json(['message' => 'The given food resource is not found.'], 404);
        }
    }

    // function untuk validasi data
    private function validateRequest()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:255|string',
            'price' => 'required|numeric',
            'description' => 'required|max:255|string'
        ]);

        if ($validator->fails()) {
            response()->json(['message' => 'The given data was invalid.', 'errors' => $validator->errors()], 422)->send();
            exit;
        }
    }
}
