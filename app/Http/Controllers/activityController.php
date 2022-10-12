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
    public function postFormToNewActivity(Request $request){
        
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

}
