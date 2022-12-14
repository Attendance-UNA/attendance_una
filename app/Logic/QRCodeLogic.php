<?php

namespace App\Logic;
use App\Models\Person;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeLogic{

    public function generateQRCode($idPerson){
        return QrCode::format('png')->size(150)->generate($idPerson);
    }

    public function writeQrCodeInDoc($people){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        foreach ($people as $person){
            $section = $phpWord->addSection();
            $section->addText(
                $person->id . " - " . $person->name . " ". $person->firstLastName . " ". $person->secondLastName,
                array('name' => 'Arial', 'size' => 12)
            );
            $section->addTextBreak(1);
            $section->addImage(
                QRCodeLogic::generateQRCode($person->id),
                array(
                    'width'         => 150,
                    'height'        => 150,
                    'marginTop'     => -1,
                    'marginLeft'    => -1,
                    'wrappingStyle' => 'behind'
                )
            );
        }
        
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        date_default_timezone_set('America/Costa_Rica');
        $fileName = "attendace".date("Y") . date("m") . date("d"). "_". date("H"). date("i"). date("s") . ".docx";
        $objWriter->save('files/docx/'. $fileName);
        return $fileName;
    }
}