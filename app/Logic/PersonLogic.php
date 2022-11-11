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
                    $subcategorySplit = explode(":", $subcategoriesAux[$j]);
                    array_push($subcategoriesToInsert, ["idperson"=>$people[$i]->id, "idsubcategory"=>$subcategorySplit[0], "status"=>$subcategorySplit[1]]);
                }
            }else{
                $subcategorySplit = explode(":", $subcategoriesAux[0]);
                array_push($subcategoriesToInsert, ["idperson"=>$people[$i]->id, "idsubcategory"=>$subcategorySplit[0], "status"=>$subcategorySplit[1]]);
            }
        }
        return $subcategoriesToInsert;
    }

    public function validateStringData($data, $regularExpression){
        $flag = false;
        $data = trim($data);
        if (preg_match($regularExpression, $data)){
            $flag = true;
        }
        return $flag;
    }

    public function validateDataPeople($people, $dbCategories, $dbSubcategories){
        $errors = [];
        foreach ($people as $person){
            (PersonLogic::validateStringData($person->id, "/^[0-9]{9}$/") || PersonLogic::validateStringData($person->id, "/^[0-9]{12}$/"))?null:$errors[] = "La cédula debe contener solo números. Entre 9 y 12 caracteres";       
            (PersonLogic::validateStringData($person->name,"/^[a-zA-ZÀ-ÿ]{1,49}$/"))?null:$errors[] = "El nombre debe contener solo letras. Máximo 50 caracteres"; 
            (PersonLogic::validateStringData($person->firstLastName, "/^[a-zA-ZÀ-ÿ]{1,49}$/"))?null:$errors[] = "El apellido 1 debe contener solo letras. Máximo 50 caracteres"; 
            (PersonLogic::validateStringData($person->secondLastName, "/^[a-zA-ZÀ-ÿ]{1,49}$/"))?null:$errors[] = "El apellido 2 debe contener solo letras. Máximo 50 caracteres"; 
            (filter_var($person->email, FILTER_VALIDATE_EMAIL))?null:$errors[] = "Dirección de correo inválida";
            (in_array($person->category, $dbCategories) == true)?null:$errors[] = "Seleccione de manera correcta una categoria de las presentadas en la lista";
            ($person->status == 0 || $person->status == 1)?null:$errors[] = "El estado del invitado debe de ser 1 (activo) o 0 (inactivo)";
            (strlen($person->institutionalCard) > 0)?(PersonLogic::validateStringData($person->institutionalCard, "/^[0-9]{9}$/"))?null:$errors[] = "El cartnet institucional solo permite números. 9 caracateres fijos":null;
            (strlen($person->phone) > 0 )?(PersonLogic::validateStringData($person->phone, "/^[0-9]{8}$/"))?null:$errors[] = "El télefono solo permite números. 8 caracteres fijos":null;       
            (PersonLogic::validateStringData($person->name,"/^[a-zA-ZÀ-ÿ]{1,49}$/"))?null:$errors[] = "El nombre debe contener solo letras. Máximo 50 caracteres"; 
            (PersonLogic::checkSubcategories($person->subcategories, $dbSubcategories))?null:$errors[] = "Campo subcategoria con identificadores inexistentes o mal formato";
        }
        return $errors;
    }

    public function toStringCategoriesArray($categories){
        $categoriesArray = [];
        foreach($categories as $category){
            $categoriesArray[] = $category->namecategory;
        }
        return $categoriesArray;
    }

    public function toStringSubcategories($subcategories){
        $subcategoriesArray = [];
        for ($i = 0; $i < count($subcategories); $i++){
            $subcategoriesArray[] = $subcategories[$i]->id;
        }
        return $subcategoriesArray;
    }

    public function checkSubcategories($subcategories, $dbsubcategories){
        $flag = true;
        for ($i = 0; $i < count($subcategories); $i++){
            $subcategoryAndStatus = explode(":", $subcategories[$i]);
            if (count($subcategoryAndStatus) == 2 && strlen($subcategoryAndStatus[0]) > 0 && strlen($subcategoryAndStatus[1]) > 0){
                (in_array($subcategoryAndStatus[0], $dbsubcategories))?null:$flag = false; 
            }else{
                $flag = false;
            }
            if ($flag == false){
                $i = count($subcategories);
            }
        }
        return $flag;
    }


}
