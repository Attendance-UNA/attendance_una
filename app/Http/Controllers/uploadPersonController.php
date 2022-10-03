<?php

namespace App\Http\Controllers;

use App\Logic\XlsxLogic;
use App\Models\Person;
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
        $people = [];
        $xlsxLogic = new XlsxLogic($path);
        $data = $xlsxLogic->readContent(3, ["A","B","C","D","E","F","G","H","I","J"]);
        /*$reader = new ReaderXlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $workSheetInfo = $reader->listWorksheetInfo($path);
        $totalRows = $workSheetInfo[0]['totalRows'];
        if ($totalRows > 3){
            for ($i = 3; $i < $totalRows; $i++){
                $id = $sheet->getCell()->getValue();
                $name = $sheet->getCell("B{$i}")->getValue();
                $firstLastName = $sheet->getCell("C{$i}")->getValue();
                $secondLastName = $sheet->getCell("D{$i}")->getValue();
                $email = $sheet->getCell("E{$i}")->getValue();
                $category = $sheet->getCell("F{$i}")->getValue();
                $subcategory = $sheet->getCell("G{$i}")->getValue();
                $status = $sheet->getCell("H{$i}")->getValue();
                $institutionalCard = $sheet->getCell("I{$i}")->getValue();
                $phone = $sheet->getCell("J{$i}")->getValue();
                if (!empty($id) && !empty($name) && !empty($firstLastName) && !empty($secondLastName) && !empty($email)
                    && !empty($category) && !empty($subcategory) && !empty($status)) {
                    
                }

                $people[] = new Person([
                    "id" => $sheet->getCell("A{$i}")->getValue(),
                    "name" => $sheet->getCell("B{$i}")->getValue(),
                    "firstLastName" => $sheet->getCell("C{$i}")->getValue(),
                    "secondLastName" => $sheet->getCell("D{$i}")->getValue(),
                    "email" => $sheet->getCell("E{$i}")->getValue(),
                    "category" => $sheet->getCell("F{$i}")->getValue(),
                    "subcategories" => $sheet->getCell("G{$i}")->getValue(),
                    "status" => $sheet->getCell("H{$i}")->getValue(),
                    "institutionalCard" => $sheet->getCell("I{$i}")->getValue(),
                    "phone" => $sheet->getCell("J{$i}")->getValue()
                ]);  
                
    
                echo "{$id} {$name} {$firstLastName} {$secondLastName} {$email} {$category} {$subcategory} {$status} {$idCard} {$phone} <br>";
            }
        }else{
            //viene vacio
        }

        
        $data = Excel::import($path);

        if (!empty($data) && $data->count()){
            $dataArray = $data->toArray();
            for ($i = 0; $i < count($dataArray); $i++){
                $dataToImport[] = $dataArray[$i];
            }
        }*/

        return $data;
    }
}
