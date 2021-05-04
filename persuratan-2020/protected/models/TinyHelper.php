<?php



class TinyHelper {
    
    
    public static function dateIndo($date) {
        if(empty($date)) return "";
        $arr = explode("-", $date);
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }
    
    public static function numbering($number) {
        //return number_format($number, 2, ',', '.')
    }
    
}