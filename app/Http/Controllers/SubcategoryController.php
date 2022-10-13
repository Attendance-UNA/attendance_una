<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Logic\GeneralValidationsLogic;

class SubcategoryController extends Controller
{
    /**
     * Receives the data of the subcategory to insert them into the database
     */
    public function insertSubcategory(Request $request) {

        $message = "Error";
        $success = false;
        $name = $request::get('name');
        $description = $request::get('description');
        $validation = new GeneralValidationsLogic();

        if($validation->validateNameSubcategory($name) && $validation->validateDescriptionSubcategory($description)){
            $flagInsert = DB::insert("INSERT INTO tbsubcategory (name, description) VALUES ('".$name."', '".$description."')");
            if($flagInsert){
                $success = true;
                $message = "Subcategoría registrada con éxito";
            }else{
                $message = "Error al registrar en la base de datos";
            }
        }else{
            $message = "Error, valide los datos";
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("success"=>$success, "message"=>$message);
        echo json_encode($arrayInfo);
    }

    /**
     * Obtains the data of the subcategories through the database
     */
    public function getSubcategories() {
        return DB::table('tbsubcategory')->get();
    }

    /**
     * Update the subcategory in the database
     */
    public function updateSubcategory(Request $request) {
        $message = "Error";
        $success = false;
        $name = $request::get('name');
        $description = $request::get('description');
        $id_subcategory = $request::get('id_subcategory');
        $validation = new GeneralValidationsLogic();

        if($validation->validateNameSubcategory($name) && $validation->validateDescriptionSubcategory($description)){
            $flagUpdate = DB::table('tbsubcategory')
            ->where('id', $id_subcategory )
            ->update(['name' => $name, 'description' => $description]);
            if($flagUpdate){
                $success = true;
                $message = "Subcategoría actualizada con éxito";
            }else{
                $message = "No actualizaste ningun dato";
            }
        }else{
            $message = "Error, por favor valide los datos";
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("success"=>$success, "message"=>$message);
        echo json_encode($arrayInfo);
    }
}
