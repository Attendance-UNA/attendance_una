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
    //function for receive the New Activity data
    public function getActivityStartedById(Request $request){
        $idActivity=$request::get('idActivity');

        $activities= DB::table('tbactivity')->where('id','LIKE',$idActivity)->get();

        $guestsInThisActivity= DB::table('tbactivity_person')->where('id_activity','LIKE',$idActivity)->get();

        $arrayInfo = array();
        if(count($activities)==0){
            array_push($arrayInfo, array("success"=>false,"msj"=>$activities));
        }else{

            $today = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
            $today =date_format($today, 'Y-m-d');

            $dateScheduled = date_create($activities[0]->date);
            $dateFormat =date_format($dateScheduled, 'Y-m-d');

            if ($today == $dateFormat) {
                if(count($guestsInThisActivity)>0){
                    $hour=$activities[0]->start_time;
                    $hour = new DateTime($hour, new DateTimeZone("America/Costa_Rica"));
                    $hour = $hour->format("h:i A");
                }else{
                    $hour = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
                    
                    $hourToDB = $hour->format("h:i:m");
                    DB::table('tbactivity')->where('id', $idActivity)->update(
                        ['start_time' => $hourToDB]
                    );
                    $hour = $hour->format("h:i A");
                }

                array_push($arrayInfo, array("success"=>true,"id"=>$activities[0]->id,"name"=>$activities[0]->name,
                "date"=>$activities[0]->date,'startTime'=>$hour,"manager"=>$activities[0]->manager,'description'=>$activities[0]->description));
        
            }else{
                array_push($arrayInfo, array("success"=>false,"msj"=>"La fecha programada para esta reunion no coincide con la actual"));
            }
            

        }
        
        return response()->json($arrayInfo);


    }
    //function for receive the specific Activity data
    public function getActivityById(Request $request){
        $activities= DB::table('tbactivity')->where('id','LIKE',$request::get('idActivity'))->get();
        $categories= DB::table('tbactivity_category')->where('id_activity','LIKE',$request::get('idActivity'))->get();
        $subcategories= DB::table('tbactivity_subcategory')->where('id_activity','LIKE',$request::get('idActivity'))->get();
        
        $array_subcategories = array(); 
        $i = 0;

        foreach ($subcategories as $row_subcategory){
            $idSubcategory=$row_subcategory->id_subcategory;
            $subcategoryName= DB::table('tbsubcategory')->where('id','LIKE',$idSubcategory)->get();
            
            $array_subcategories [$i]["id"]= $idSubcategory;
            $array_subcategories [$i]["name"]= $subcategoryName[0]->name;
            $i++;
        }
       
        $arrayInfo = array();
        if(count($activities)==0){
            array_push($arrayInfo, array("success"=>false,"msj"=>$activities));
        }else{
            
            $hour = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
            $hour = $hour->format("h:i A");

            array_push($arrayInfo, array("success"=>true,"id"=>$activities[0]->id,"name"=>$activities[0]->name,
            "date"=>$activities[0]->date,'startTime'=>$hour,"manager"=>$activities[0]->manager,
            'description'=>$activities[0]->description,'categories'=>$categories,
            'subcategories'=>$array_subcategories));
    
        }
        
        return response()->json($arrayInfo);


    }


    //for add new guest at the actual list 
    public function currentGuests(Request $request){
        $idGuest=$request::get('idGuest');
        $idActivity=$request::get('idActivity');
        $success=false;
        $message="No se pudo registrar su ingreso";
        $currentGuests=null;
        $currentPersons=array();

        if($idGuest!=null && $idActivity!=null){
            $currentHour = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
            $currentHour = $currentHour->format("h:i:m");
            
            $activityGuests = new ActivityGuests();
           
            $activityGuests->idActivity = $idActivity;
            $activityGuests->idPerson = $idGuest;
            $activityGuests->entryHour = $currentHour;

            try{
                DB::beginTransaction();
                if (DB::table('tbactivity_person')->where('id_activity', $activityGuests->idActivity)->where('id_person', $activityGuests->idPerson)->exists()) {
                    $message="Ya se encuentra en la lista";

                } else if (DB::table('tbperson')->where('id', $activityGuests->idPerson)->doesntExist()) {
                    $message="Codigo QR no válido";

                }else if(!$this->validateCategorySubCategory($idGuest,$idActivity)){

                    $message="No se encuentra dentro de las categorías invitadas a esta actividad";
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
            $message="id vacia";
        }

        // Send data by json to javascript ajax
        $arrayResponse=array();
        $arrayResponse=array("success"=> $success, "message"=>$message,"currentGuests"=>$currentGuests,"currentPersons"=>$currentPersons);
        echo json_encode($arrayResponse);


    }

    public function validateCategorySubCategory($idGuest,$idActivity){
        //response
        $success=false;
        //get only category for this guest
        $guest_category = DB::table('tbperson')->where('id','LIKE',$idGuest)->get('category');
        
        //get only this subcategories's guest
        $guest_subcategories = DB::table('tbsubcategory_person')->where('idperson','LIKE',$idGuest)->get();
        //get only this activity's subcategories
        $activity_subcategories = DB::table('tbactivity_subcategory')->where('id_activity','LIKE',$idActivity)->get();
        
        //get only this activity's categories
        $activity_categories = DB::table('tbactivity_category')->where('id_activity','LIKE',$idActivity)->get('category');
        
        if($guest_category!=null){
            //validate category
            foreach ($activity_categories as $activity_category) {
                if($guest_category[0]==$activity_category){
                    $success=true;
                }
            }
        }
        if($guest_subcategories!=null && $activity_subcategories!=null && !$success) {
                //validate subcategory
            foreach ($guest_subcategories as $guest_subcategory) {      
                foreach ($activity_subcategories as $activity_subcategory) {

                    if($guest_subcategory->idsubcategory==$activity_subcategory->id_subcategory){
                        $success=true;
                    }
                }
            }

        }      

        return $success;
    }
    public function validateActivityName($activityName,$activityDate){
        //response
        $success=true;
        $dateScheduled = date_create($activityDate);
        $date =date_format($dateScheduled, 'Y-m-d');
        //get only activity name if is the same
        $sameNameActivity= DB::table('tbactivity')->where('name','LIKE',$activityName)->get();
        
        if($sameNameActivity!=null){
            //validate category
            foreach ($sameNameActivity as $sameActivityDate) {
                //if have a same name and same date is false
                if($date==$sameActivityDate->date){
                    $success=false;
                }
            }
        }
        return $success;
    }

    //get guests by an activity
    public function getGuestsByActivityId(Request $request){
        $idActivity=$request::get('idActivity');
        $success=false;
        $message="No se pudo obtener datos";
        $currentGuests=null;
        $currentPersons=array();

        if($idActivity!=null){
            
            $activityGuests = new ActivityGuests();
            
            $activityGuests->idActivity = $idActivity;
            
            try{
                //get only this activity's guests
                $currentGuests = DB::table('tbactivity_person')->where('id_activity','LIKE',$activityGuests->idActivity)->orderBy('created_at','desc')->get();
                if($currentGuests!=null){
                    //get persons data
                    foreach ($currentGuests as $currentGuest) {
                        $currentId= $currentGuest->id_person;
                        $currentPerson =DB::table('tbperson')->where('id','LIKE',$currentId)->get();
                        
                        array_push($currentPersons,$currentPerson);
                    }
                    $success=true;

                }

            }catch(Exception $e){
                DB::rollBack();
                $message = "¡No se pudo realizar la transacción, por favor intente de nuevo! Error: " . $e->getMessage();
            }
            
        
        }else{
            $message="id actividad vacia";
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
        $flagInsert=false;
        $activityName = $request::get('activityName');
        $activityDescription = $request::get('activityDescription');
        $activityManagername = $request::get('activityManagername');
        $activityDate = $request::get('activityDate');

        $categorySubcategoryList=$request::get('CategorySubcategoryList');

        if($activityName!=null&&$activityDescription!=null&&$activityManagername!=null&&$activityDate!=null){
        if($categorySubcategoryList!=null){
            if($this->validateDate($activityDate)){

                if($this->validateActivityName($activityName,$activityDate)){
                    DB::beginTransaction();
                    $idActivity = DB::table('tbactivity')->insertGetId(
                        ['name' => $activityName, 'date' => $activityDate,'description' => $activityDescription,'manager' => $activityManagername,'status' => 1]
                    );
                    
                    if($idActivity!=null){
                        DB::commit();
                        try {
                            $flagInsert =$this->insertCategoriesAndSubcategories($idActivity,$categorySubcategoryList);
                        } catch (Exception $e) {
                            DB::rollBack();
                            DB::table('tbactivity')->where('id', $idActivity)->delete();
                            $success = false;
                            $message =$e;
                        } 
                    }
                    if($flagInsert){
                        $success = true;
                        $message = "Actividad registrada con éxito";
                    }else{
                        DB::rollBack();
                        DB::table('tbactivity')->where('id', $idActivity)->delete();
                        $message ="Error al registrar en la base de datos";
                    }
                }else{
                    $message = "Error, ya existe esa actividad en la fecha seleccionada";
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
    public function insertCategoriesAndSubcategories($idActivity,$categoriesAndSubcategories){
        $flagInsert=false;
        $infoArray=explode(",",$categoriesAndSubcategories);
        #clean all old cat and sub for this activity
        DB::table('tbactivity_subcategory')->where('id_activity', $idActivity)->delete();
        DB::table('tbactivity_category')->where('id_activity', $idActivity)->delete();

        foreach ($infoArray as $item) {
            if(!preg_match('/[A-Za-z]/', $item) && preg_match('/[0-9]/', $item)){
                #Contains only numbers
                $flagInsert = DB::insert("INSERT INTO tbactivity_subcategory (id_activity,id_subcategory) VALUES (".$idActivity.",". (int)$item.")");

            }else if (preg_match('/[A-Za-z]/', $item)){
                #Contains letters
                $flagInsert = DB::insert("INSERT INTO tbactivity_category (id_activity,category) VALUES (".$idActivity.",'".$item."')");
            }

            if(!$flagInsert){
                #return item with problems
                return $item;
            }
        }
        
        return $flagInsert;
    }
    public function validateDate($date){
        $today = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
        $today =date_format($today, 'Y-m-d');

        $dateCreate = date_create($date);
        $dateFormat =date_format($dateCreate, 'Y-m-d');
        $result=false;
        if ($today <= $dateFormat) {
            $result=true;
        }
        return $result;
    }

    
        /**
     * Receives the data of the UPDATED ACTIVITY to update them into the database
     */
    public function updateActivity(Request $request) {

        $message = "Error";
        $success = false;
        $flagUpdate=false;
        $idActivity = $request::get('idActivity');
        $activityName = $request::get('activityName');
        $activityDescription = $request::get('activityDescription');
        $activityManagername = $request::get('activityManagername');
        $activityDate = $request::get('activityDate');

        $categorySubcategoryList=$request::get('CategorySubcategoryList');

        if($activityName!=null&&$activityDescription!=null&&$activityManagername!=null&&$activityDate!=null){
        if($categorySubcategoryList!=null){
            if($this->validateDate($activityDate)){

                    DB::beginTransaction();
                    $flagUpdate = DB::table('tbactivity')->where('id', $idActivity)->update(
                        ['date' => $activityDate,'description' => $activityDescription,'manager' => $activityManagername,'status' => 1]
                    );
                    
                    try {
                        $flagUpdate =$this->insertCategoriesAndSubcategories($idActivity,$categorySubcategoryList);
                    } catch (Exception $e) {
                        DB::rollBack();
                        $success = false;
                        $message =$e;
                    } 
                    
                    if($flagUpdate){
                        DB::commit();
                        $success = true;
                        $message = "Actividad actualizada con éxito";
                    }else{
                        DB::rollBack();
                        $message ="Error al actualizar en la base de datos";
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

            /**
     * Receives the data of the FINISH ACTIVITY to update status into the database
     */
    public function finishActivity(Request $request)
    {
        $message = "Error";
        $success = false;
        $flagUpdate = false;
        $idActivity = $request::get('idActivity');
        $startTime = $request::get('startTime');

        if ($idActivity != null && $startTime != null) {
            DB::beginTransaction();
            $currentHour = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
            $currentHour = $currentHour->format("h:i:m");

            $currentHour = new DateTime('NOW', new DateTimeZone("America/Costa_Rica"));
            $currentHour =date_format($currentHour, "h:i:m");

            $startTimeFormated = new DateTime($startTime, new DateTimeZone("America/Costa_Rica"));
            $startTimeFormated =date_format($startTimeFormated, "h:i:m");


            try {
                $flagUpdate = DB::table('tbactivity')->where('id', $idActivity)->update(
                    ['start_time' => $startTimeFormated, 'end_time' => $currentHour, 'status' => '0']);

                if ($flagUpdate) {
                    DB::commit();
                    $success = true;
                    $message = "Actividad finalizada con éxito";
                } else {
                    DB::rollBack();
                    $message = "Error al actualizar en la base de datos";
                }
            } catch (Exception $e) {
                DB::rollBack();
                $success = false;
                $message = "error".$e;
            }
        } else {
            $message = "Error, no se pudo rescatar datos necesarios para finalizar.".$startTime."-".$idActivity;
        }
        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("success" => $success, "message" => $message);
        echo json_encode($arrayInfo);
    }

}
