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

    public function validateStringData($data, $regularExpression){
        $flag = false;
        $data = trim($data);
        if (preg_match($regularExpression, $data)){
            $flag = true;
        }
        return $flag;
    }

    public function validateDataPeople($people, $dbCategories){
        $errors = [];
        foreach ($people as $person){
            
            (PersonLogic::validateStringData($person->id, "/^[0-9]{9}$/") || PersonLogic::validateStringData($person->id, "/^[0-9]{12}$/"))?null:$errors[] = "La cédula debe contener solo números. Entre 9 y 12 caracteres";       
            (PersonLogic::validateStringData($person->name,"/^[a-zA-ZÀ-ÿ]{1,49}$/"))?null:$errors[] = "El nombre debe contener solo letras. Máximo 50 caracteres"; 
            (PersonLogic::validateStringData($person->firstLastName, "/^[a-zA-ZÀ-ÿ]{1,49}$/"))?null:$errors[] = "El apellido 1 debe contener solo letras. Máximo 50 caracteres"; 
            (PersonLogic::validateStringData($person->secondLastName, "/^[a-zA-ZÀ-ÿ]{1,49}$/"))?null:$errors[] = "El apellido 2 debe contener solo letras. Máximo 50 caracteres"; 
            (filter_var($person->email, FILTER_VALIDATE_EMAIL))?null:$errors[] = "Dirección de correo inválida";
            (in_array($person->category, $dbCategories) == true)?null:$errors[] = "Seleccione de manera correcta una categoria de las presentadas en la lista";
            ($person->status == 0 || $person->status == 1)?null:$errors[] = "El estado del invitado debe de ser 1 (activo) o 0 (inactivo)";       

            
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



}
