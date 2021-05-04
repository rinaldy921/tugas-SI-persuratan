<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id' => 'side-menu', 'class' => 'nav nipznav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
    'items' => array(
        array(
            'label' => 'Pesan Masuk',
            'url' => array('/admin/pesan/inbox'),
        ),        
   
       
    ),
));
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
            'label' => 'Pesan Keluar',
            'url' => array('/admin/pesan/outbox'),
        ),
       
       
    ),
));
}
?>

