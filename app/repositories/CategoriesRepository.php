<?php

namespace App\repositories;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesRepository {

    public function getAll(){
        return Category::all();
    }

    public function getDataPagination(Request $req){

        $data = Category::orderBy('id','DESC')
            ->paginate($req->per_page)
            ->through(function ($category) {
                $parent = $category->parent()->first();
                return [
                    "id" => $category->id,
                    "name" => $category->name,
                    "category_parent" => $category->category_parent,
                    "parent" => $parent?$parent->name:null,
                ];
            });

        return $data;
    }

    public function create(Request $req){

        $category = new Category();
        $category->name = $req->name;
        $category->category_parent = $req->category_parent;

        return $category->save();
    }

    public function update(Request $req){

        $category = Category::find($req->id);
        if(!$category) return -1; //not found
        $category->name = $req->name;
        $category->category_parent = $req->category_parent;

        return $category->save();
    }

    public function delete($id){
        return Category::where('id','=',$id)->delete();
    }

}