<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(

        array(
            'label' => 'Profile Operator',
            'url' => array('/profilOperator'),
            'active' => (Yii::app()->controller->id == 'hutan') ? true : false
        ),
        array(
            'label' => 'Update Password',
            'url' => array('/updatePassword'),
            'active' => (Yii::app()->controller->id == 'administrasi') ? true : false
        ),
        array(
            'label' => 'Logout',
            'url' => array('/site/logout'),
            'active' => (Yii::app()->controller->id == 'lahan') ? true : false
        ),
        array(
            'label' => '&nbsp;',
            
        ),
        array(
            'label' => '&nbsp;',
            
        ),
        array(
            'label' => '&nbsp;',
            
        ),
        array(
            'label' => '&nbsp;',
            
        ),
        array(
            'label' => '&nbsp;',
            
        )
        
    ),
));
?>
