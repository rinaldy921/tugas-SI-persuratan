<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id' => 'side-menu', 'class' => 'nav nipznav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
    'items' => array(
        array(
            'label' => 'Company Profile',
            'url' => array('/admin/report/datapokok'),
        ),        
        array(
            'label' => 'Rencana Kerja Umum',
            'url' => array('/admin/report/pilihrku'),
        ),
        array(
            'label' => 'Rencana Kerja Tahunan',
            'url' => array('/admin/report/pilihrkt'),
        ),
        
        array(
                'label' => 'Neraca Tanaman',
                'url' => array('/admin/report/neracaht'),
            ),
        
         array(
                'label' => 'Absensi Laporan Realisasi Bulanan',
                'url' => array('/admin/report/absensirealisasi'),
            ),
        
        array(
            'label' => '&nbsp;&nbsp;&nbsp;&nbsp;---------------------------------------------------',
        ),
        
        
)));
?>

<?php
$role = Yii::app()->user->findUser()->id_role;

if($role != 2){
    $this->widget('zii.widgets.CMenu', array(
        'encodeLabel' => FALSE,
        'htmlOptions' => array('id' => 'side-menu2', 'class' => 'nav nipznav'),
        'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
        'items' => array(

            array(
                'label' => 'Daftar Pemegang IUPHHK-HT',
                'url' => array('/admin/report/pilihdaftar'),
            ),

             array(
                'label' => 'Monev IUPHHK-HT Aktif',
                'url' => array('/admin/report/monevikk'),
            ),
            
             array(
                'label' => 'Neraca Tanaman Per Provinsi',
                'url' => array('/admin/report/neracahtprop'),
            ),

           
            
            
             array(
                'label' => 'Neraca Tanaman Per Provinsi',
                'url' => array('/admin/report/neracahtprop'),
            ),
            
            array(
                'label' => '&nbsp;&nbsp;&nbsp;&nbsp;---------------------------------------------------',
            ),
        ),
    ));
}
?>

