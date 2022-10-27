<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Logic\XlsxLogic;
use App\Logic\QRCodeLogic;
use App\Logic\PersonLogic;
use App\Models\Person;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Excel;

class uploadPersonController extends Controller
{

    public function downloadPersonTemplate(){
        $subcategories = DB::table('tbsubcategory')->get();
        $xlsxLogic = new XlsxLogic('files/xlsx/Plantilla_Invitados.xlsx');
        $result = $xlsxLogic->writeSubcategories(3, ["A", "B", "C", "D"], $subcategories);
        if ($result["success"]){
            return response()->download('files/xlsx/Plantilla_Invitados.xlsx');
        }
    }

    public function importFile(Request $request){
        $message = "";
        $messageType = "error";
        if (!is_null($request->file('xlsx_person')) && $request->file('xlsx_person')->getClientOriginalExtension() == 'xlsx'){
            $path = $request->file('xlsx_person')->getRealPath();
            $people = [];
            $peopleToInsertUpdate = [];
            $fileName = "";
            $counters = [];
            $xlsxLogic = new XlsxLogic($path);
            $personLogic = new PersonLogic();
            $data = $xlsxLogic->readContent(3, ["A","B","C","D","E","F","G","H","I","J"]);
            if ($xlsxLogic->getTotalRows() > 2){
                if ($xlsxLogic->checkRequiredColumns(3, ["A","B","C","D","E","F","G","H"]) == true){
                    if ($xlsxLogic->checkDuplicateColumn(3, "A") == true){
                        $people = $xlsxLogic->toPersonArray($data);
                        $peopleInDB = DB::table('tbperson')->get();
                        //call to logic
                        $counters = $personLogic->countInsertedAndUpdatedPerson($people, $peopleInDB);
                        $qrLogic = new QRCodeLogic();
                        DB::beginTransaction();
                        try{
                            foreach ($people as $person){
                                array_push($peopleToInsertUpdate,[
                                    "id" => $person->id,
                                    "name"=>$person->name,
                                    "first_lastname" => $person->firstLastName,
                                    "second_lastname" => $person->secondLastName,
                                    "email"=>$person->email,
                                    "category"=>$person->category,
                                    "subcategory"=>$person->subcategories,
                                    "status"=>$person->status,
                                    "institutional_card"=> (!is_null($person->institutionalCard))?$person->institutionalCard:'N/A',
                                    "phone"=> (!is_null($person->phone))?$person->phone:'N/A'
                                ]);

                            }
                           DB::table('tbperson')->upsert(
                                $peopleToInsertUpdate,
                                ['id'],
                                ['email', 'category', 'subcategory', 'status', 'institutional_card', 'phone']
                            );
                            DB::commit();
                            $messageType = 'success';
                            $message = "¡Datos importados correctamente! Resultados: {$counters["inserted"]} datos registrados y {$counters["updated"]} datos existentes actualizados";
                            $fileName = $qrLogic->writeQrCodeInDoc($people);
                        }catch(\Exception $e){
                            DB::rollBack();
                            $messageType = "error";
                            $message = "¡No se pudo realizar la transacción, por favor intente de nuevo! Error: " . $e->getMessage();
                        }
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
            $message = '¡Por favor seleccione un archivo con extensión *.xlsx!';
        }
        return ["messageType"=>$messageType, "message"=>$message, "fileName"=>(strcmp($messageType, "success") == 0)?$fileName:null];
    }

    public function testQRCode(){
        $qrLogic = new QRCodeLogic();
        return $qrLogic->generateQRCode("402530326");
    }
}
