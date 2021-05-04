<?php
class Logic{
    public static function getLastLoginByPerusahan($id_perusahaan){
        $params = array(
            'id_perusahaan'=>$id_perusahaan
        );
        $user = AppUsers::model()->lastLoginByParams($params);
        $interval = $user['interval']->m;
        $last_login = $user['last_login'];

        $alert = '';
        switch($interval){
            case 0:
            $alert = 'label-success';
            break;
            case 1:
            $alert = 'label-warning';
            break;
            default:
            $alert = 'label-danger';
            break;
        }
        $label = '<span class="label '. $alert .'">'. date('d/m/Y H:i:s', strtotime($last_login)) .'</span>';
        return $label;
    }
}