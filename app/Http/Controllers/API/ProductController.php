<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $product = Product::all(); //returns a collection
        return response()->json(["Status"=>200,"products"=>$product]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            "product_name"=>"required",
            "description"=>"required",
            "price"=>"required",
            "stock"=>"required"
        ]);

        // Fails
        if($validator -> fails()){
            return response()->json([
                "Status"=>422,
                "validate_err"=>$validator->errors()
            ]);
        }

        // INSERT INTO
        $product = new Product();
        $product -> product_name = $request -> input("product_name");
        $product -> description = $request -> input("description");
        $product -> price = $request -> input("price");
        $product -> stock = $request -> input("stock");
        $product -> save();

        // Successful
        return response()->json([
            "Status"=>200,
            "message"=>"Product added successfully"
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            "product_name"=>"required",
            "description"=>"required",
            "price"=>"required",
            "stock"=>"required"
        ]);

        if($validator -> fails()){
            return response()->json([
                "Status"=>422,
                "validate_err"=>$validator->errors()
            ]);
        }
        
        $product = Product::find($id);
        if($product){
            $product -> product_name = $request -> input("product_name");
            $product -> description = $request -> input("description");
            $product -> price = $request -> input("price");
            $product -> stock = $request -> input("stock");
            $product -> save();

            return response()->json([
                "Status"=>200,
                "message"=>"Product updated successfully"
            ]);
        }
    }
}