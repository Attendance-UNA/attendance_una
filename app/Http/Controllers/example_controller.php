<?php

namespace App\Http\Controllers;

use App\Models\Subgategory;
use Illuminate\Http\Request;

class example_controller extends Controller
{
    //

    public function index(){
        return "Me cago en la remilputa";
    }

    public function saludo(){
        return view('example_view', [
            "subcategory"=> new Subgategory(['identificador'=>123, 'name'=>"Animales", 'description'=>"Macotas"])
        ]);
    }
}
