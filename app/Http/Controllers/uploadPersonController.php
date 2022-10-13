<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Logic\XlsxLogic;
use App\Logic\QRCodeLogic;
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
            $fileName = "";
            $countInsert = 0;
            $countUpdate = 0;
            $xlsxLogic = new XlsxLogic($path);
            $data = $xlsxLogic->readContent(3, ["A","B","C","D","E","F","G","H","I","J"]);
            if ($xlsxLogic->getTotalRows() > 2){
                if ($xlsxLogic->checkRequiredColumns(3, ["A","B","C","D","E","F","G","H"]) == true){
                    if ($xlsxLogic->checkDuplicateColumn(3, "A") == true){
                        $people = $xlsxLogic->toPersonArray($data);
                        $qrLogic = new QRCodeLogic();
                        DB::beginTransaction();
                        try{
                            foreach ($people as $person){
                                if (is_null(DB::table('tbperson')->find($person->id))){//if it is null it will insert the person
                                    DB::insert(
                                        'insert into tbperson (id, name, first_lastname, second_lastname, email, category, subcategory, status, institutional_card, phone) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
                                        [$person->id,
                                        $person->name,
                                        $person->firstLastName,
                                        $person->secondLastName,
                                        $person->email,
                                        $person->category,
                                        $person->subcategories,
                                        $person->status,
                                        (!is_null($person->institutionalCard))?$person->institutionalCard:'N/A',
                                        (!is_null($person->phone))?$person->phone:'N/A'
                                        ]
                                    );
                                    $countInsert++;
                                }else{//else it will update the person
                                    DB::table('tbperson')
                                        ->where('id', $person->id)
                                        ->update([
                                            'email' => $person->email, 
                                            'category' => $person->category, 
                                            'subcategory' => $person->subcategories, 
                                            'status' => $person->status,
                                            'institutional_card' => (!is_null($person->institutionalCard))?$person->institutionalCard:'N/A',
                                            'phone' => (!is_null($person->phone))?$person->phone:'N/A'
                                        ]);
                                    $countUpdate++;
                                }
                            }
                            DB::commit();
                            $messageType = 'success';
                            $message = "¡Datos importados correctamente! Resultados: {$countInsert} datos registrados y {$countUpdate} datos existentes actualizados";
                            $fileName = $qrLogic->writeQrCodeInDoc($people);
                        }catch(\Exception $e){
                            DB::rollBack();
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
