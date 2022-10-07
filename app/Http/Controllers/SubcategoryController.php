<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends Controller
{
    /**
     * Receives the data of the subcategory to insert them into the database
     */
    public function insertSubcategory(Request $request) {

        $message = "";
        $name = $request->input('name');
        $description = $request->input('description');

        if(!empty($name)){
            DB::insert("insert into tbsubcategory (name, description) values ('".$name."', '".$description."')");
            $message = "<h1>Todo bien registrado</h1>";
        }else{
            $message = "<h1>Error, valide datos</h1>";
        }
        
        echo $message;
    }
}
