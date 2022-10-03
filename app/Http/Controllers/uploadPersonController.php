<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;

class uploadPersonController extends Controller
{

    public function importFile(Request $request){
        $validatedData = $request->validate([
            "xlsx_person" => 'required|mimes:xlsx'
        ],
        [
            "xlsx_person.required" => 'Por favor seleccione un archivo',
            "xlsx_person.mimes" => 'Por favor seleccione un archivo con extensión *.xlsx'
        ]);
        $path = $request->file('xlsx_person')->getRealPath();
        $data = Excel::load($path, function($reader){
        })->get();

        if (!empty($data) && $data->count()){
            $dataArray = $data->toArray();
            for ($i = 0; $i < count($dataArray); $i++){
                $dataToImport[] = $dataArray[$i];
            }
        }

        return $dataToImport;
    }
}
