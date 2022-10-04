<?php

namespace App\Http\Controllers;

use App\Logic\XlsxLogic;
use App\Models\Person;
use Illuminate\Http\Request;
use Excel;

class uploadPersonController extends Controller
{

    public function importFile(Request $request){
        $message = "";
        $messageType = "error";
        if (!is_null($request->file('xlsx_person')) && $request->file('xlsx_person')->getClientOriginalExtension() == 'xlsx'){
            $path = $request->file('xlsx_person')->getRealPath();
            $people = [];
            $xlsxLogic = new XlsxLogic($path);
            $data = $xlsxLogic->readContent(3, ["A","B","C","D","E","F","G","H","I","J"]);
            if ($xlsxLogic->getTotalRows() > 2){
                if ($xlsxLogic->checkRequiredColumns(3, ["A","B","C","D","E","F","G","H"]) == true){
                    if ($xlsxLogic->checkDuplicateColumn(3, "A") == true){
                        $people = $xlsxLogic->toPersonArray($data);
                        $messageType = 'success';
                        $message = '¡Datos importados correctamente!';
                    }else{
                        $message = "¡Existen datos duplicados en la columna de A del archivo xlsx, por favor revise y corrija los campos!";
                    }
                }else{
                    $message = '¡Algunos campos son obligatorios, por favor llene los campos de manera correcta y asegurese de no tener filas en blanco!';
                }
            }else{
                $message = '¡Archivo *.xlsx vacío, por favor llene con los datos de manera correcta y con la estructura establecida!';
            } 
        }else{
            $message = 'Por favor seleccione un archivo con extensión *.xlsx';
        }
        return redirect('/person')->with($messageType, $message);
    }
}
