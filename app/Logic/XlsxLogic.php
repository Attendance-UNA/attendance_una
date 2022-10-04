<?php

namespace App\Logic;

use App\Models\Person;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class XlsxLogic{

    private $reader;
    private $path;
    private $spreadsheet;
    private $sheet;
    private $workSheetInfo;

    public function __construct($path) {
        $this->reader = new ReaderXlsx();
        $this->spreadsheet = $this->reader->load($path);
        $this->sheet = $this->spreadsheet->getActiveSheet();
        $this->workSheetInfo = $this->reader->listWorksheetInfo($path);
    }

    public function readContent($rowBegin, $columns){
        $data = [];
        $tempRow = [];
        for ($i = $rowBegin; $i <= XlsxLogic::getTotalRows(); $i++){
            for ($j = 0; $j < count($columns); $j++){
                array_push($tempRow, $this->sheet->getCell("{$columns[$j]}{$i}")->getValue());
            }
            array_push($data, $tempRow);
            $tempRow = []; 
        }
        return $data;
    }

    public function checkRequiredColumns($rowBegin, $requiredColumns){
        for ($i = $rowBegin; $i <= XlsxLogic::getTotalRows(); $i++){
            for ($j = 0; $j < count($requiredColumns); $j++){
                if (strlen($this->sheet->getCell("{$requiredColumns[$j]}{$i}")->getValue()) == 0){
                    return false;
                }
            }
        }
        return true;
    }

    public function toPersonArray($data){
        $people = [];
        for ($i = 0; $i < count($data); $i++){
            $people[] = new Person([
                "id" => $data[$i][0],
                "name" => $data[$i][1],
                "firstLastName" => $data[$i][2],
                "secondLastName" => $data[$i][3],
                "email" => $data[$i][4],
                "category" => $data[$i][5],
                "subcategories" => $data[$i][6],
                "status" => $data[$i][7],
                "institutionalCard" => $data[$i][8],
                "phone" => $data[$i][9]
            ]); 
        }
        return $people;
    }

    public function getTotalRows(){
        return $this->workSheetInfo[0]['totalRows'];
    }

    public function getworkSheetInfo(){
        return $this->workSheetInfo;
    }

    public function getReader(){
        return $this->reader;
    }

    public function getSpreadsheet(){
        return $this->spreadsheet;
    }

    public function getPath(){
        return $this->path;
    }

    public function getSheet(){
        return $this->sheet;
    }

    public function setworkSheetInfo($workSheetInfo){
        $this->workSheetInfo = $workSheetInfo;
    }

    public function setReader($reader){
        $this->reader = $reader;
    }

    public function setSpreadsheet($spreadsheet){
        $this->spreadsheet = $spreadsheet;
    }

    public function setPath($path){
        $this->path = $path;
    }

    public function setSheet($sheet){
        $this->sheet = $sheet;
    }
}