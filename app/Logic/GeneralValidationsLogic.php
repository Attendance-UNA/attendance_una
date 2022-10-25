<?php
namespace App\Logic;

/**
 * The constants that usually need to be used for validations are defined.
 */
define("STRING_W_SPACE", '/^[a-zA-ZáéíóúÁÉÍÓÚÜüñÑ ]+$/i');
define("STRING_W_NUM_COMMA", '/^[a-zA-ZáéíóúÁÉÍÓÚÜüñÑ0-9 ,]*$/i');
define("STRING_PHONE", '/^[0-9 +()-]+$/i');
define("STRING_DETAILS", '/^[a-zA-ZáéíóúÁÉÍÓÚÜüñÑ0-9 ,.%-\/]*$/i');

class GeneralValidationsLogic{
    /**
     * Validate general text strings that need to be checked
     */
    public function validateString($string, $size, $regularExpression) {
        $flag = false;
        $string = trim($string);
        if(strlen($string) < $size){ // Verifica que cumpla con la cantidad de caracteres
            if (preg_match($regularExpression, $string)){
                $flag = true;
            }
        }
        return $flag;
    }

    /**
     * Validates that the name of the subcategory meets the specified conditions
     */
    public function validateNameSubcategory($nameSubcategory){
        return $this->validateString($nameSubcategory, 50, STRING_W_NUM_COMMA);
    }

    /**
     * Validate the descriptions of the subcategories in case you need to review them
     */
    public function validateDescriptionSubcategory($descriptionSubcategory){
        return $this->validateString($descriptionSubcategory, 200, STRING_DETAILS);
    }

    /**
     * Validate the manager name of the subcategories in case you neeed to review
     */
    public function validateManagerSubcategory($manager){
        return $this->validateString($manager, 100, STRING_W_SPACE);
    }
}