<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use stdClass;

class reportController extends Controller
{
    /**
     * Gets the necessary information from the activity name
     */
    public function getDataNameActivity(Request $request) {
        $message = '';
        $success = false;
        $nameActivity = $request::get('nameActivity'); // Get the activity name provided by the ajax

        $attendance = '';
        $activityData  = '';
        $listPersonsCategory = '';
        $arrayPersonsCategory = array();
        $finalArrayAttendance= array();
        
        // Extract the id of the activity found
        $activity = DB::table('tbactivity')->where('name', $nameActivity)->get();
        
        if(sizeof($activity) != 0) { // Enter if the activity name is present in the system

            $activity = $activity[0]; // Take the first element of the activities

            // Stores activity data
            $activityData = new stdClass();
            $activityData->nameAcvivity = $activity->name;
            $activityData->date = $activity->date;
            $activityData->start_time = $activity->start_time;
            $activityData->end_time = $activity->end_time;
            $activityData->manager = $activity->manager;

            // Extract the categories related to the activity
            $activityCategories = DB::table('tbactivity_category')->where('id_activity', $activity->id)->pluck('category');
            
            foreach ($activityCategories as $category) {
                /**
                 * Extract the people that belong to a search category and
                 * that are active within the system
                 */
                $listPersonsCategory = DB::table('tbperson')->where('category', $category)->get();
                array_push($arrayPersonsCategory, $listPersonsCategory);
            }
    
            foreach ($arrayPersonsCategory as $groupPersonCategories) {
                foreach ($groupPersonCategories as $person) {
                    /**
                     * Search the relationship of people with the activity sought
                     */
                    $attendance = DB::table('tbactivity_person')
                    ->where([['id_activity', $activity->id], ['id_person', $person->id]])->get();

                    // Personal data is stored
                    $activityInfoPackage = new stdClass();
                    $activityInfoPackage->name = $person->name;
                    $activityInfoPackage->first_lastname = $person->first_lastname;
                    $activityInfoPackage->second_lastname = $person->second_lastname;
                    $activityInfoPackage->category = $person->category;

                    // The person's attendance data is stored
                    if(sizeof($attendance) != 0){
                        $asisst = $attendance[0];
                        $activityInfoPackage->present = 'Si';
                        $activityInfoPackage->entry_hour = $asisst->entry_hour;
                    }else{
                        $activityInfoPackage->present = 'No';
                        $activityInfoPackage->entry_hour = '00:00:00';
                    }

                    /**
                     * Packaging of data to send to the report design
                     */
                    $arrayAux = array("activityInfoPackage" => $activityInfoPackage);
                    array_push($finalArrayAttendance, $arrayAux);
                }
            }
            $success = true; // Confirms that the entered activity did exist
        }else{
            $message = 'Actividad no encontrada por el nombre ingresado';
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("data" => $finalArrayAttendance, "activityData" => $activityData, "message" => $message, "success" => $success);
        echo json_encode($arrayInfo);
    }

    /**
     * Make the design of the activity name report
     */
    public function desingReportNameActivity(Request $request) {
        // Get the data provided from the ajax
        $dataActivity = json_decode($request::get('packageNameActivity'));
        $onlyActivityData = json_decode($request::get('activityData'));

        // Makes the call to generate the report with the data provided
        $pdf = Pdf::loadView('report.designs.desingReportNameActivityView', 
        compact('dataActivity', 'onlyActivityData'));

        // Perform PDF Layout Generator
        $path = public_path('pdf/');
        $fileName = time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);
        $pdf = public_path('pdf/'.$fileName);
        return response()->download($pdf); // Respond to ajax with the generated PDF
    }

    /**
     * Obtains the necessary attendance information on a date
     */
    public function getInfoDateReport(Request $request) {
        $message = '';
        $success = false;
        $dateReport = $request::get('dateReport'); // Get the date provided by the ajax

        $attendance = '';
        $listPersonsCategory = '';
        $arrayPersonsCategory = array();
        $finalArrayAttendance= array();

        // Extracts the activities that match the date
        $activities = DB::table('tbactivity')->where('date', $dateReport)->get();

        if(sizeof($activities) != 0) { 
            foreach($activities as $activity) {
                // Extract the categories related to the activity
                $activityCategories = DB::table('tbactivity_category')->where('id_activity', $activity->id)->pluck('category');
                foreach ($activityCategories as $category) {
                    /**
                     * Extract the people that belong to a search category and
                     * that are active within the system
                     */
                    $listPersonsCategory = DB::table('tbperson')->where('category', $category)->get();
                    array_push($arrayPersonsCategory, $listPersonsCategory);
                }

                foreach ($arrayPersonsCategory as $groupPersonCategories) {
                    foreach ($groupPersonCategories as $person) {
                        /**
                         * Search the relationship of people with the activity sought
                         */
                        $attendance = DB::table('tbactivity_person')
                        ->where([['id_activity', $activity->id], ['id_person', $person->id]])->get();
    
                        // Personal data is stored
                        $activityInfoPackage = new stdClass();
                        $activityInfoPackage->nameActivity = $activity->name;
                        $activityInfoPackage->name = $person->name;
                        $activityInfoPackage->first_lastname = $person->first_lastname;
                        $activityInfoPackage->second_lastname = $person->second_lastname;
    
                        // The person's attendance data is stored
                        if(sizeof($attendance) != 0){
                            $asisst = $attendance[0];
                            $activityInfoPackage->present = 'Si';
                            $activityInfoPackage->entry_hour = $asisst->entry_hour;
                        }else{
                            $activityInfoPackage->present = 'No';
                            $activityInfoPackage->entry_hour = '00:00:00';
                        }
    
                        /**
                         * Packaging of data to send to the report design
                         */
                        $arrayAux = array("activityInfoPackage" => $activityInfoPackage);
                        array_push($finalArrayAttendance, $arrayAux);
                    }
                }
                $arrayPersonsCategory = []; // Reset array for persons by category for each activity 
            }
            $success = true; // Confirms that the entered activity did exist
        }else{
            $message = 'No hay actividades por la fecha ingresada';
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("data" => $finalArrayAttendance, "message" => $message, "success" => $success);
        echo json_encode($arrayInfo);
    }

    /**
     * 
     */
    public function desingReportDate(Request $request) {
        // Get the data provided from the ajax
        $packageDateReport = json_decode($request::get('packageDateReport'));
        $date = json_decode($request::get('date'));

        // Makes the call to generate the report with the data provided
        $pdf = Pdf::loadView('report.designs.desingReportDateView', 
        compact('packageDateReport', 'date'));

        // Perform PDF Layout Generator
        $path = public_path('pdf/');
        $fileName = time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);
        $pdf = public_path('pdf/'.$fileName);
        return response()->download($pdf); // Respond to ajax with the generated PDF
    }

    /**
     * 
     */
    public function dataReportIdPerson(Request $request) {
        $message = '';
        $success = false;
        $idPerson = $request::get('idPerson'); // Get the date provided by the ajax

        $activityData = '';
        $personData = '';
        $packArrayActivity = array();

        // Extracts the data of the person to search
        $person = DB::table('tbperson')->where('id', $idPerson)->get();

        if(sizeof($person) != 0) {

            $person = $person[0]; // Take the first element of the persons

            // Stores person data
            $personData = new stdClass();
            $personData->id = $person->id;
            $personData->name = $person->name;
            $personData->first_lastname = $person->first_lastname;
            $personData->second_lastname = $person->second_lastname;
            $personData->category = $person->category;

            // Extracts the activities related to the category of the person
            $activityCategory = DB::table('tbactivity_category')->where('category', $person->category)->get();

            foreach($activityCategory as $auxAct) {

                // The general data of the activity is extracted
                $activity = DB::table('tbactivity')->where('id', $auxAct->id_activity)->get();

                foreach($activity as $aux) {
                    // Relations of activities and assistance of person are extracted
                    $activityPerson = DB::table('tbactivity_person')->where('id_activity', $aux->id)->get();

                    if(sizeof($activityPerson) != 0){ // Si fue iniciada antes

                        // Datos relacionados a la actividad
                        $activityData = new stdClass();
                        $activityData->name = $aux->name;
                        $activityData->date = $aux->date;
                        $activityData->manager = $aux->manager;

                        foreach($activityPerson as $aux2){
                            if($aux2->id_person == $idPerson){
                                // Asistio
                                $activityData->entry_hour = $aux2->entry_hour;
                                $activityData->present = 'Si';
                            }else{
                                // No asistio
                                $activityData->entry_hour = '00:00:00';
                                $activityData->present = 'No';
                            }
                        }
    
                        $arrayAux = array("activityInfoPackage" => $activityData);
                        array_push($packArrayActivity, $arrayAux);
                    }
                }
            }
            $success = true;
        }else{
            $message = 'No hay personas registradas bajo ese número de cédula';
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("activity" => $packArrayActivity, "person" => $personData, "message" => $message, "success" => $success);
        echo json_encode($arrayInfo);
    }
    
    /**
     * Design the report by ID number person
     */
    public function desingReportIdPerson(Request $request) {
        // Get the data provided from the ajax
        $personData = json_decode($request::get('personData'));
        $activityArrayData = json_decode($request::get('activityArrayData'));

        // Makes the call to generate the report with the data provided
        $pdf = Pdf::loadView('report.designs.desingReportPersonView', 
        compact('personData', 'activityArrayData'));

        // Perform PDF Layout Generator
        $path = public_path('pdf/');
        $fileName = time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);
        $pdf = public_path('pdf/'.$fileName);
        return response()->download($pdf); // Respond to ajax with the generated PDF
    }

    /**
     * Removes junk files from pdf generated for reports
     */
    public function deleteGarbageReportPDF() {
        $files = glob('pdf/*'); // Select all existing files in the folder
        foreach($files as $file){
            if(is_file($file))
            unlink($file); // Delete all selected files
        }
    }
}