<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return view('admin.add_category', ["categories" => $categories]);
    }

    public function saveCategory(Request $request)
    {

        $this->validate($request,[
            'category_name' => 'required'
        ]);

        $category_id = $request["category_id"];
        $category_name = $request["category_name"];
        $description = $request["description"];

        if($category_id == "-1"){
            $category = new Category();
            $category->name = $category_name;
            $category->description = $description;
            $saved = $category->save();
        }
        else{
            $category = Category::find($category_id);
            $category->name = $category_name;
            $category->description = $description;
            $saved = $category->update();
        }

        if($saved)
            $message = "Dodato uspješno";
        else
            $message = "Greška prilikom dodavanja";

        return redirect()->route('add_category')->with(['message' => $message]);

    }

    public function deleteCategory($category_id){

        $category = Category::findOrFail($category_id);

        try{
            if ($category->delete() === false)
                throw new \Exception("Greška prilikom brisanja!");
            $message = "Obrisano usjpješno.";
        }
        catch(\Exception $e){
            $message = $e->getMessage();
        }

        return redirect()->route('add_category')->with(['message' => $message]);
    }
}
