<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\repositories\ProductsRepository;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct(ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProducts(Request $req){

        $validatorArr = [
            'per_page' => 'required|integer',
        ];
        
        // validate request data
        $validator = Validator::make($req->all(), $validatorArr);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $this->productRepository->getDataPagination($req);

        return response()->json([ "data" => $data], 200);

    }

    public function addProduct(Request $req){

        $validatorArr = [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'id_category' => 'required|integer',
        ];
        
        // validate request data
        $validator = Validator::make($req->all(), $validatorArr);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 400);
        }

        $check = $this->productRepository->create($req);

        if($check){
            return response()->json(['success'=>true], 200);
        }
        else{
            return response()->json(['message'=>"Server error"], 500);
        }

    }

    public function updateProduct(Request $req){

        $validatorArr = [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'id_category' => 'required|integer',
            'id' => 'required|integer',
        ];
        
        // validate request data
        $validator = Validator::make($req->all(), $validatorArr);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 400);
        }

        $check = $this->productRepository->update($req);

        if($check){
            return response()->json(['success'=>true], 200);
        }
        else if($check == -1){ //not found
            return response()->json(['message'=>'product not found'], 404);
        }
        else{
            return response()->json(['message'=>"Server error"], 500);
        }

    }

    public function deleteProduct(Request $req){
        if(!$req->id) return response()->json(['message'=>'id is required'], 400);
        $this->productRepository->delete($req->id);
        return response()->json(['success'=>true], 200);
    }

}
