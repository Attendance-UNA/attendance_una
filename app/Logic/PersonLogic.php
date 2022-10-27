<?php
namespace App\Logic;
use App\Models\Person;

class PersonLogic
{

    public function countInsertedAndUpdatedPerson($people, $peopleInDB){
        $countInsert = 0;
        $countUpdate = 0;
        for ($i = 0; $i < count($people); $i++) {
            $find = false;
            for ($j = 0; $j < count($peopleInDB); $j++){
                if (strcasecmp($people[$i]->id, $peopleInDB[$j]->id) == 0){
                    $find = true;
                    $j = count($peopleInDB);
                }
            }
            if ($find){
                $countUpdate++; 
            }else{
                $countInsert++;
            }
        }
        return ["inserted"=>$countInsert, "updated"=>$countUpdate];
    }
}
