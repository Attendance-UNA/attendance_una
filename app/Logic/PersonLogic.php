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

    public function getSubcategoriesToInsert($people){
        $subcategoriesToInsert = [];
        for ($i = 0; $i < count($people); $i++) {
            $subcategoriesAux = $people[$i]->subcategories;
            if (is_array($subcategoriesAux) == true && count($subcategoriesAux) > 1){
                for ($j = 0; $j < count($subcategoriesAux); $j++){
                    array_push($subcategoriesToInsert, ["idperson"=>$people[$i]->id, "idsubcategory"=>$subcategoriesAux[$j]]);
                }
            }else{
                array_push($subcategoriesToInsert, ["idperson"=>$people[$i]->id, "idsubcategory"=>$subcategoriesAux[0]]);
            }
        }
        return $subcategoriesToInsert;
    }
}
