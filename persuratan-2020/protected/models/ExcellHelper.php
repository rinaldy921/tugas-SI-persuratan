<?php

class ExcellHelper {

    public $startPoint;
    public $xlsLib;
    public $rows;
    public $format;
    public $filename;
    public $arrayColumn = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
        'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    ];
    
    public $idxStartCol;

    public function __construct($xlsLib, $sheetTitle) {
        $this->xlsLib = $xlsLib;
        $this->xlsLib->setActiveSheetIndex(0);
        $this->xlsLib->getActiveSheet()->setTitle($sheetTitle);        
    }

    public function customColumn($data) {
        if (count($data) == 1) {
            //die($data[key($data)]);
            $this->xlsLib->getActiveSheet()->setCellValue(key($data), $data[key($data)]);
        } else {
            foreach ($data as $idx => $value) {
                $this->xlsLib->getActiveSheet()->setCellValue($idx, $value);
            }
        }
    }

    private function getIdxColumn($startCol) {
        foreach ($this->arrayColumn as $idx => $values) {
            if ($values == $startCol) {
                $this->idxStartCol = $idx;
                break;
            }
        }
        //return $idxStartCol;
    }
    
    public function setRows($startPoint, $rows, $format, $customFormatter=array()) {
        $startCol = $startPoint['col'];
        $startRow = $startPoint['row'];
        
        foreach ($this->arrayColumn as $column){
            $this->xlsLib->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }
        
         
        $this->getIdxColumn($startCol);
        $idxStartCol = $this->idxStartCol;
                
        $this->xlsLib->getActiveSheet()->setCellValue($this->arrayColumn[$idxStartCol] . "$startRow", "No");
        $idxStartCol++;
        
        foreach ($format as $rowkey => $header) {
            //echo $this->arrayColumn[$idxStartCol] . "$startRow" . "<br />" . $header . "<hr />";
            $this->xlsLib->getActiveSheet()->setCellValue($this->arrayColumn[$idxStartCol] . "$startRow", $header);
            $idxStartCol++;
        }
        //exit();

        $startRow++;                
        
        foreach ($rows as $idx => $val) {
            $idxStartCol = $this->idxStartCol;
            
            $this->xlsLib->getActiveSheet()->setCellValue($this->arrayColumn[$idxStartCol]."$startRow", $idx+1);
            $idxStartCol++;
            
            foreach ($format as $rowkey => $header) {
                //echo $this->arrayColumn[$idxStartCol] . "$startRow" . "<br />" . $val->$rowkey . "<hr />";
                if(!array_key_exists($rowkey, $customFormatter)){
                    if(is_object($val)){
                        $this->xlsLib->getActiveSheet()->setCellValue($this->arrayColumn[$idxStartCol]."$startRow", $val->$rowkey);
                    } else {
                        $this->xlsLib->getActiveSheet()->setCellValue($this->arrayColumn[$idxStartCol]."$startRow", $val[$rowkey]);
                    }                    
                } else {
                    if(is_object($val)){
                        $unformatCell = $val->$rowkey;
                    } else {
                        $unformatCell = $val[$rowkey];
                    }                    
                    $functionFormatter = $customFormatter[$rowkey];
                    $cellValue = $functionFormatter($unformatCell);
                    $this->xlsLib->getActiveSheet()->setCellValue($this->arrayColumn[$idxStartCol]."$startRow", $cellValue);
                }
                //$cellpos = 
                //$this->xlsLib->getActiveSheet()->getColumnDimension($this->arrayColumn[$idxStartCol]."$startRow")->setAutoSize(true);
                $idxStartCol++;                
                
            }
            $startRow++;
        }
        //exit();
    }
    
    public function addTotalColumn($rows, $startRow, $arrayTotal) {
        
        $rowIndex = count($rows) + $startRow  + 1;
        $data = [];
        foreach ($rows as $idx => $val) {                
            
            foreach($arrayTotal as $column => $idxTotal){
                if(is_object($val)){
                    if(!array_key_exists('sum'.$idxTotal, $data)){
                        $data['sum'.$idxTotal] = $val->$idxTotal;
                    } else {
                        $data['sum'.$idxTotal] += $val->$idxTotal;
                    }                                      
                } else {
                    if(!array_key_exists('sum'.$idxTotal, $data)){
                        $data['sum'.$idxTotal] = $val[$idxTotal];
                    } else {
                        $data['sum'.$idxTotal] += $val[$idxTotal];
                    }                                        
                }
            }                       
        }
        
        foreach($arrayTotal as $column => $idxTotal){
            
            $this->xlsLib->getActiveSheet()->setCellValue($column . $rowIndex, $data['sum'.$idxTotal]);
            
        }
        
    }

    public function doExport($filename) {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        //header('Cache-Control: max-age=0');
        //debug($this->xlsLib);
        $objWriter = PHPExcel_IOFactory::createWriter($this->xlsLib, 'Excel2007');
        
        $objWriter->save('php://output');
    }
    
    public function saveXlsFile($filename) {
        $objWriter = PHPExcel_IOFactory::createWriter($this->xlsLib, 'Excel5');
        $objWriter->save($filename);
    }    
    
    public function readSheet($filePath, $idxSheet){
        $excelReader = PHPExcel_IOFactory::createReaderForFile($filePath);
        $excelObj = $excelReader->load($filePath);
        $worksheet = $excelObj->getSheet($idxSheet);
        return $worksheet;
        //$lastRow = $worksheet->getHighestRow();        
    }

}
