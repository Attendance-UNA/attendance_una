<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use stdClass;

class reportController extends Controller
{
    /**
     * It is responsible for creating a PDF document with the data provided
     */
    public function createPdfDocument($pdf) {
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

    /**
     * Get the activity data and send it to present in a table
     */
    public function requestTableNameActivity(Request $request) {
        $message = '';
        $success = true;
        $namesActivities = [];

        // Get the date provided by the ajax
        $nameActivity = $request::get('nameActivity');

        $namesActivities = DB::table('tbactivity')->where([['name', 'like', '%'.$nameActivity.'%'],['status', 0]])->get();

        if(sizeof($namesActivities) == 0){
            $success = false;
            $message = 'No se encuentra una actividad finalizada por el nombre ingresado';
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("data" => $namesActivities, "message" => $message, "success" => $success);
        echo json_encode($arrayInfo);
    }

    /**
     * Gets the necessary information from the activity name
     */
    public function requestDataNameActivity(Request $request) {
        $idActivity = $request::get('idActivity'); // Get the activity name provided by the ajax

        $attendance = '';
        $activityData  = '';
        $listPersonsCategory = '';
        $finalArrayAttendance= array();
        $arrayPersonsCategory = array();
        
        // Extract the data of the queried activity
        $activity = DB::table('tbactivity')->where([['id', $idActivity],['status', 0]])->get();

        $activity = $activity[0]; // Take the first element (activity) of the array

        // Stores activity data
        $activityData = new stdClass();
        $activityData->date = $activity->date;
        $activityData->manager = $activity->manager;
        $activityData->nameAcvivity = $activity->name;
        $activityData->end_time = $activity->end_time;
        $activityData->start_time = $activity->start_time;

        // Extract the categories related to the queried activity
        $activityCategories = DB::table('tbactivity_category')->where('id_activity', $activity->id)
        ->pluck('category');
        
        foreach ($activityCategories as $category) {
            /**
             * Extract the people that belong to a search category and
             * that are active within the system
             */
            $listPersonsCategory = DB::table('tbperson')->where('category', $category)->get();
            array_push($arrayPersonsCategory, $listPersonsCategory); // Save the data of each query
        }

        foreach ($arrayPersonsCategory as $groupPersonCategories) {
            /**
             * Browse the people who relate to the category
             */
            foreach ($groupPersonCategories as $person) {
                /**
                 * Search the relationship of people with the consulted activity
                 */
                $attendance = DB::table('tbactivity_person')
                ->where([['id_activity', $activity->id], ['id_person', $person->id]])->get();

                // Personal data is stored
                $activityInfoPackage = new stdClass();
                $activityInfoPackage->name = $person->name;
                $activityInfoPackage->category = $person->category;
                $activityInfoPackage->first_lastname = $person->first_lastname;
                $activityInfoPackage->second_lastname = $person->second_lastname;

                // The person's attendance data is stored
                if(sizeof($attendance) != 0){
                    /**
                     * It is recognized that he did attend
                     */
                    $activityInfoPackage->present = 'Si';
                    $activityInfoPackage->entry_hour = $attendance[0]->entry_hour;
                }else{
                    /**
                     * It is recognized that he was absent
                     */
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

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("data" => $finalArrayAttendance, "activityData" => $activityData);
        echo json_encode($arrayInfo);
    }

    /**
     * Print the report by activity name with the data provided
     */
    public function printReportNameActivity(Request $request) {
        // Get the data provided from the ajax
        $attendanceData = json_decode($request::get('attendanceData'));
        $onlyActivityData = json_decode($request::get('activityData'));

        // Makes the call to generate the report with the data provided
        $pdf = Pdf::loadView('report.designs.desingReportNameActivityView', 
        compact('attendanceData', 'onlyActivityData'));

        // Create the pdf document and respond to the ajax
        return $this->createPdfDocument($pdf);
    }

    /**
     * Obtains the necessary attendance information on a date
     */
    public function requestDataDate(Request $request) {
        $date = $request::get('date'); // Get the date provided by the ajax
        $message = '';
        $success = false;

        $attendance = '';
        $listPersonsCategory = '';
        $arrayPersonsCategory = array();
        $finalArrayAttendance= array();

        // Extract the activities that match the entered date
        $activities = DB::table('tbactivity')->where([['date', $date],['status', 0]])->get();

        if(sizeof($activities) != 0) { // Continue if query contains data
            foreach($activities as $activity) {
                // Extract the categories related to the activity
                $activityCategories = DB::table('tbactivity_category')->where('id_activity', $activity->id)
                ->pluck('category');
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
                        $activityInfoPackage->nameActivity = $activity->name;
                        $activityInfoPackage->first_lastname = $person->first_lastname;
                        $activityInfoPackage->second_lastname = $person->second_lastname;
    
                        // The person's attendance data is stored
                        if(sizeof($attendance) != 0){
                            /**
                             * It is recognized that he did attend
                             */
                            $activityInfoPackage->present = 'Si';
                            $activityInfoPackage->entry_hour = $attendance[0]->entry_hour;
                        }else{
                            /**
                             * It is recognized that he was absent
                             */
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
            $message = 'No hay actividades finalizadas por la fecha ingresada';
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("data" => $finalArrayAttendance, "message" => $message, "success" => $success);
        echo json_encode($arrayInfo);
    }

    /**
     * Print the report by date with the data provided
     */
    public function printReportDate(Request $request) {
        // Get the data provided from the ajax
        $attendanceData = json_decode($request::get('attendanceData'));
        $date = json_decode($request::get('date'));

        // Makes the call to generate the report with the data provided
        $pdf = Pdf::loadView('report.designs.desingReportDateView', 
        compact('attendanceData', 'date'));

        // Create the pdf document and respond to the ajax
        return $this->createPdfDocument($pdf);
    }

    /**
     * Obtains the necessary data for the filtered person
     */
    public function requestDataPerson(Request $request) {
        $idPerson = $request::get('idPerson'); // Get the date provided by the ajax
        $message = '';
        $success = false;

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
                $activity = DB::table('tbactivity')->where([['id', $auxAct->id_activity],['status', 0]])->get();

                foreach($activity as $aux) {
                    // Relations of activities and assistance of person are extracted
                    $activityPerson = DB::table('tbactivity_person')->where([['id_activity', $aux->id],['id_person', $idPerson]])->get();

                    // Datos relacionados a la actividad
                    $activityData = new stdClass();
                    $activityData->name = $aux->name;
                    $activityData->date = $aux->date;
                    $activityData->manager = $aux->manager;

                    if(sizeof($activityPerson) != 0) {
                        /**
                         * It is recognized that he did attend
                         */
                        $activityData->entry_hour = $activityPerson[0]->entry_hour;
                        $activityData->present = 'Si';
                    }else{
                        /**
                         * It is recognized that he was absent
                         */
                        $activityData->entry_hour = '00:00:00';
                        $activityData->present = 'No';
                    }

                    /**
                     * Packaging of data to send to the report design
                     */
                    $arrayAux = array("activityInfoPackage" => $activityData);
                    array_push($packArrayActivity, $arrayAux);
                }
            }
            $success = true;
        }else{
            $message = 'No hay personas registradas bajo ese número de cédula';
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("attendance" => $packArrayActivity, "person" => $personData,
        "message" => $message, "success" => $success);
        echo json_encode($arrayInfo);
    }
    
    /**
     * Design the report by ID number person
     */
    public function printReportPerson(Request $request) {
        // Get the data provided from the ajax
        $personData = json_decode($request::get('personData'));
        $attendanceData = json_decode($request::get('attendanceData'));

        // Makes the call to generate the report with the data provided
        $pdf = Pdf::loadView('report.designs.desingReportPersonView', 
        compact('personData', 'attendanceData'));

        // Create the pdf document and respond to the ajax
        return $this->createPdfDocument($pdf);
    }

    public function requestTableDataPerson(Request $request) {
        $message = '';
        $success = true;
        $namesPersons = [];

        // Get the date provided by the ajax
        $firstNamePerson = $request::get('firstNamePerson');
        $firstLastNamePerson = $request::get('firstLastNamePerson');
        $secondLastNamePerson = $request::get('secondLastNamePerson');

        if($secondLastNamePerson == ''){
            $namesPersons = DB::table('tbperson')
            ->where([['name', $firstNamePerson], ['first_lastname', $firstLastNamePerson]])->get();
        }else{
            $namesPersons = DB::table('tbperson')
            ->where([['name', $firstNamePerson], ['first_lastname', $firstLastNamePerson], 
            ['second_lastname', $secondLastNamePerson]])->get();
        }

        if(sizeof($namesPersons) == 0){
            $success = false;
            $message = 'No existen personas regitradas con el nombre ingresado';
        }

        // Send data by json to javascript ajax
        $arrayInfo = array();
        $arrayInfo = array("data" => $namesPersons, "message" => $message, "success" => $success);
        echo json_encode($arrayInfo);
    }
}