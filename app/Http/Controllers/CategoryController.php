<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\repositories\CategoriesRepository;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    
    private $categoriesRepository;

    public function __construct(CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function getAll(){
        $data = $this->categoriesRepository->getAll();
        return response()->json([ "data" => $data], 200);
    }

    public function getCategories(Request $req){

        $validatorArr = [
            'per_page' => 'required|integer',
        ];
        
        // validate request data
        $validator = Validator::make($req->all(), $validatorArr);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $this->categoriesRepository->getDataPagination($req);

        return response()->json([ "data" => $data], 200);

    }

    public function addCategory(Request $req){

        $validatorArr = [
            'name' => 'required|string|max:100',
            'category_parent' => 'nullable|integer',
        ];
        
        // validate request data
        $validator = Validator::make($req->all(), $validatorArr);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 400);
        }

        $check = $this->categoriesRepository->create($req);

        if($check){
            return response()->json(['success'=>true], 200);
        }
        else{
            return response()->json(['message'=>"Server error"], 500);
        }

    }

    public function updateCategory(Request $req){

        $validatorArr = [
            'name' => 'required|string|max:100',
            'category_parent' => 'nullable|integer',
            'id' => 'required|integer',
        ];
        
        // validate request data
        $validator = Validator::make($req->all(), $validatorArr);

        // check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()], 400);
        }

        $check = $this->categoriesRepository->update($req);

        if($check){
            return response()->json(['success'=>true], 200);
        }
        else if($check == -1){ //not found
            return response()->json(['message'=>'category not found'], 404);
        }
        else{
            return response()->json(['message'=>"Server error"], 500);
        }

    }

    public function deleteCategory(Request $req){
        if(!$req->id) return response()->json(['message'=>'id is required'], 400);
        $this->categoriesRepository->delete($req->id);
        return response()->json(['success'=>true], 200);
    }

}
