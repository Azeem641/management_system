<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function getAllProducts(Request $request){
        return DB::table('products')->select('id', 'name', 'detail')->get();
    }

    public function create(Request $request){
        $product_id = DB::table('products')->insertGetId([
            'name' => $request->name,
            'detail' => $request->detail,
            'created_at' => Carbon::now()
        ]);
        if($product_id){
            foreach($request->ingredients as $single){
                DB::table('product_ingredients')->insert([
                    'name' => $single['name'],
                    'product_id' => $product_id,
                    'created_at' => carbon::now()
                ]);
            }
            foreach($request->steps as $single){
                DB::table('recipe_steps')->insert([
                    'step' => $single['step'],
                    'product_id' => $product_id,
                    'created_at' => carbon::now()
                ]);
            }
            return response()->json(['error' => 'false', 'message' => 'product created']);
        }
        return response()->json(['error' => 'true', 'message' => 'failed']);
    }

    public function productDetail(Request $request){
        $result = DB::table('products')->select('products.name as product_name',
        // 'products.detail', 'product_ingredients.name',
        // 'recipe_steps.step'
        DB::raw("(SELECT Group_CONCAT(name) FROM product_ingredients where product_ingredients.product_id = products.id) as ingredients"),
        DB::raw("(SELECT Group_CONCAT(step) FROM recipe_steps where recipe_steps.product_id = products.id) as recipe_steps")
        )
        // ->leftJoin('product_ingredients', 'products.id', 'product_ingredients.product_id')
        // ->leftJoin('recipe_steps', 'products.id', 'recipe_steps.product_id')
        ->where('products.id', $request->id)
        ->get();

        return response()->json(['error' => 'false', 'message' => 'product details', 'data' => ProductDetails::collection($result)]);
        return $result;
    }
}
