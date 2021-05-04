<?php

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id' => 'side-menu', 'class' => 'nav nipznav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
    'items' => array(
        array(
            'label' => 'Daftar Pemegang Saham',
            'url' => array('/admin/penerbit/index'),
            'active' => (Yii::app()->controller->id == 'penerbit') ? true : false
        ),        
    ),
));
?>
<?php
// Yii::app()->clientScript->registerScript("load_nav_script", "
//     $('.nipznav').find('li.active').parents('li').addClass('active');
//     //$('.navigation').find('li').not('.active').has('ul').children('ul').addClass('hidden-ul');
//     $('.nipznav').find('li').has('ul').children('a').parent('li').addClass('has-ul');
//     $('.nipznav').find('li').has('ul').children('a').on('click', function (e) {
//         e.preventDefault();
//         if ($('body').hasClass('sidebar-narrow')) {
//             $(this).parent('li > ul li').not('.disabled').toggleClass('active').children('ul').slideToggle(250);
//             $(this).parent('li > ul li').not('.disabled').siblings().removeClass('active').children('ul').slideUp(250);
//         } else {
//             $(this).parent('li').not('.disabled').toggleClass('active').children('ul').slideToggle(250);
//             $(this).parent('li').not('.disabled').siblings().removeClass('active').children('ul').slideUp(250);
//         }
//     });
//     $('.nipznav').find('li.active.has-ul').children('ul').show();
//     $('.nipznav .disabled a, .navbar-nav > .disabled > a').click(function (e) {
//         e.preventDefault();
//     });
// ");
