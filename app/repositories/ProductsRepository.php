<?php

namespace App\repositories;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsRepository {


    public function getDataPagination(Request $req){

        $query = Product::query();

        if($req->filters){
            if($req->filters['category']) {
                $query->where('id_category','=',$req->filters['category']);
            }
        }

        if($req->sort){
            if($req->sort['column'] && $req->sort['order'] ) {
                $query->orderBy($req->sort['column'],$req->sort['order']);
            }
        }

        $data = $query->paginate($req->per_page)
            ->through(function ($product) {
                return [
                    "id" => $product->id,
                    "name" => $product->name,
                    "description" => $product->description,
                    "price" => $product->price,
                    "image" => $product->image,
                    "id_category" => $product->id_category,
                    "category" => $product->category()->first()->name,
                ];
            });

        return $data;
    }

    public function create(Request $req){

        $product = new Product();
        $product->name = $req->name;
        $product->description = $req->description;
        $product->price = $req->price;
        $product->id_category = $req->id_category;
        $product->image = $req->image??null;

        return $product->save();
    }

    public function update(Request $req){

        $product = Product::find($req->id);
        if(!$product) return -1; //not found
        $product->name = $req->name;
        $product->description = $req->description;
        $product->price = $req->price;
        $product->id_category = $req->id_category;
        $product->image = $req->image??null;

        return $product->save();
    }

    public function delete($id){
        return Product::where('id','=',$id)->delete();
    }

}