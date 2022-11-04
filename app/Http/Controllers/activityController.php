<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Models\Activity;
use App\Models\Person;
use App\Models\ActivityGuests;
use DateTimeZone;
use DateTime;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Arr;

class activityController extends Controller
{
    //function for receive the New Activity form
    public function startActivity(Request $request){
        
        //dd($request->all());  //to check all the datas dumped from the form
        //if your want to get single element,someName in this case
        //$AllInfo ="{". $request->activityName .",".$request->activityDescription.",". ($request->categoryCheck1?'Administrativo':'') ."}"; 
        //dd($AllInfo);
        $today = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
        $today = $today->format('Y-m-d');
        $hour = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
        $hour = $hour->format("H:i A");
        $newActivity=new Activity(['id'=>0, 'name'=>$request::get('activityName'),'date'=>$today , 'startTime'=>$hour ,'endTime'=>'' ,
                                        'description'=>$request::get('activityDescription'),'manager'=>$request::get('activityManagername'),
                                        'subcategories'=>'']);
        //$activityGuests = ActivityGuests::orderBy('entryHour', 'DESC')->get();
        $currentGuests =null;
        return view('/activity/scanningQR', compact('newActivity','currentGuests'));
    }

    //function for put datas into dinamic table ***EN PROCESO
    public function guestsTableControl(Request $request1){
        if(isset($_POST['hw'])){
            $id = $_POST['hw']; 
        }else{

            $id="NOAvailable".$request1->hw."-";
        }
        
        $time="horaActual";
        $date="fechaActual";
        echo ($id);

        //sent with compact the person datas and date and time of scan
        $person = new Person(['id'=>$id, 'name'=>'Test','firstLastName'=>'firstLN', 'secondLastName'=>'secondLN' ,'email'=>'' ,
        'category'=>'','subcategories'=>'','status'=> '', 'institutionalCard'=>'','phone'=>'']);
        return json_encode(array('success' => 1, 'qrCode'=>$id,'time'=>$time));
        //return view('/activity/scanningQR',["time"=> 'time']);
    }

    //for add new guest at the actual list 
    public function currentGuests(Request $request){
        $idGuest=$request::get('idGuest');
        $success=false;
        $message="No se pudo registrar su ingreso";
        $currentGuests=null;
        $currentPersons=array();

        if($idGuest!=null){
            $currentHour = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
            $currentHour = $currentHour->format("H:i:m");
            
            $activityGuests = new ActivityGuests();
           
            $activityGuests->idActivity = 0; //PENDIENTE
            $activityGuests->idPerson = $idGuest;
            $activityGuests->entryHour = $currentHour;
            
            try{
                DB::beginTransaction();
                if (DB::table('tbactivity_person')->where('id_activity', $activityGuests->idActivity)->where('id_person', $activityGuests->idPerson)->exists()) {
                    $message="Ya se encuentra en la lista";

                } else if (DB::table('tbperson')->where('id', $activityGuests->idPerson)->doesntExist()) {
                    $message="Codigo QR no válido";

                }else{
                    DB::insert(
                        "insert into tbactivity_person (id_activity,id_person,entry_hour) values (?, ?, ?)",
                        [$activityGuests->idActivity,
                        $activityGuests->idPerson,
                        $activityGuests->entryHour
                        ]
                    );
                    
                    //get only this activity's guests
                    $currentGuests = DB::table('tbactivity_person')->where('id_activity','LIKE',$activityGuests->idActivity)->orderBy('created_at','desc')->get();
                    //get persons data
                    foreach ($currentGuests as $currentGuest) {
                        $currentId= $currentGuest->id_person;
                        $currentPerson =DB::table('tbperson')->where('id','LIKE',$currentId)->get();
                        
                        array_push($currentPersons,$currentPerson);
                    }
                    
    
                    DB::commit();
    
                    $message='Invitado '.$activityGuests->idPerson.' Registrado Correctamente!';
                    $success=true;

                }

            }catch(Exception $e){
                DB::rollBack();
                $message = "¡No se pudo realizar la transacción, por favor intente de nuevo! Error: " . $e->getMessage();
            }
            
        
        }else{
            $message="cedula vacia";
        }

        // Send data by json to javascript ajax
        $arrayResponse=array();
        $arrayResponse=array("success"=> $success, "message"=>$message,"currentGuests"=>$currentGuests,"currentPersons"=>$currentPersons);
        echo json_encode($arrayResponse);



    }

    public function subcategoryList(){
        $subcategories= DB::table('tbsubcategory')->get();

        $arrayInfo = array();
        if(count($subcategories)==0){
            array_push($arrayInfo, array("success"=>0));
        }else{
            array_push($arrayInfo, array("success"=>1));

            foreach ($subcategories as $subcategory) {

                $arrayAux = array("id"=>$subcategory->id, "name"=>$subcategory->name,
                "description"=>$subcategory->description);
                
                array_push($arrayInfo, $arrayAux);
            }
    
        }
        return response()->json($arrayInfo);
    }

    public function activitiesList(){
        $activities= DB::table('tbactivity')->where('status','LIKE',1)->get();

        $arrayInfo = array();
        if(count($activities)==0){
            array_push($arrayInfo, array("success"=>0));
        }else{
            array_push($arrayInfo, array("success"=>1));

            foreach ($activities as $activity) {

                $arrayAux = array("id"=>$activity->id, "name"=>$activity->name,
                "date"=>$activity->date,"manager"=>$activity->manager);
                
                array_push($arrayInfo, $arrayAux);
            }
    
        }
        
        return response()->json($arrayInfo);


    }

    /**
     * Receives the data of the NEW ACTIVITY to insert them into the database
     */
    public function insertActivity(Request $request) {

        $message = "Error";
        $success = false;

        $activityName = $request::get('activityName');
        $activityDescription = $request::get('activityDescription');
        $activityManagername = $request::get('activityManagername');
        $activityDate = $request::get('activityDate');

        $CategorySubcategoryList=$request::get('CategorySubcategoryList');

        if($activityName!=null&&$activityDescription!=null&&$activityManagername!=null&&$activityDate!=null){
        if($CategorySubcategoryList!=null){
            if($this->validateDate($activityDate)){
                $flagInsert = DB::insert("INSERT INTO tbactivity (name,date, description,manager,status) VALUES ('".$activityName."', '".$activityDate."', '".$activityDescription."', '".$activityManagername."',". 1 .")");
                if($flagInsert){
                    $success = true;
                    $message = "Actividad registrada con éxito";
                }else{
                    $message = "Error al registrar en la base de datos";
                }
            }else{
                $message = "Error en la fecha, no puede ser anterior al día actual";
            }
        }else{
            $message = "Error, debe agregar al menos una categoría o subcategoría!";
        }
        }else{
            $message = "Error, verifique que no hayan datos vacíos.";
        }
        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("success"=>$success, "message"=>$message);
        echo json_encode($arrayInfo);

    }

    public function validateDate($date){
        $today= date("Y-m-d");
        $dateCreate = date_create($date);
        $dateFormat =date_format($dateCreate, 'Y-m-d');
        $result=false;
        if ($today <= $dateFormat) {
            $result=true;
        }
        return $result;
    }

}
