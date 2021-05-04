<?php 
   
    $userRole = Yii::app()->user->findRole();
    $sql = "SELECT t.id, t.title, t.link, t.icon  FROM t_menu t WHERE t.id IN (SELECT id_menu FROM t_menu_role WHERE id_role=".$userRole.") ORDER BY urutan asc;";
    
    
    $connection=Yii::app()->db;   
    $command=$connection->createCommand();
    $command->text=$sql;
    $rows=$command->queryAll();
    
    foreach($rows as $itemMenu){
      
       $menu[] = //array('label'=>$itemMenu->title);
               array('label'=>'<i class="'.$itemMenu['icon'].'"></i><span class="menu_label">'.$itemMenu['title'].'</span>', 'url'=>array($itemMenu['link']), 'active'=>(Yii::app()->controller->module->id == 'admin' && Yii::app()->controller->id == 'default') ? true : false);
    // array('label'=>'<i class='.$itemMenu['icon'].'></i><span class="menu_label">'.$itemMenu['title'].'</span>', 'url'=>array($itemMenu['link']), 'active'=>(Yii::app()->controller->module->id == 'admin' && Yii::app()->controller->id == 'default') ? true : false);
    

    }
//          debug($menu); die();
  
    
?>



<nav id="top_navigation">
    <div class="container">
        <?php
//        if(Yii::app()->user->isAdmin()){
            $this->widget('zii.widgets.CMenu', array(
                'encodeLabel' => FALSE,
                'htmlOptions' => array('class' => 'top_ico_nav clearfix', 'id' => 'icon_nav_h'),
                'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
                'items' =>$menu,
                
//                array(
//                   
//                        array(
//                              'label' => '<i class="'.$itemMenu['icon'].'"></i><span class="menu_label">'.$itemMenu['title'].'</span>',
//                              'url' => array(''.$itemMenu['link']),
//                              'active' => (Yii::app()->controller->module->id == 'admin' && Yii::app()->controller->id == 'default') ? true : false
//                         ),
                    
//                    array(
//                        'label' => '<i class="fa fa-home fa-2x"></i><span class="menu_label">Home</span>',
//                        'url' => array('/admin/default/index'),
//                        'active' => (Yii::app()->controller->module->id == 'admin' && Yii::app()->controller->id == 'default') ? true : false
//                    ),
//                    array(
//                        'label' => '<i class="fa fa-database fa-2x"></i><span class="menu_label">Master Data</span>',
//                        'url' => array('/admin/provinsi/index'),
//                        'active' => in_array(Yii::app()->controller->id, array('provinsi','kabupaten','user','perusahaan')) ? true : false
//                    ),
//                    array(
//                        'label' => '<i class="fa fa-pencil-square-o fa-2x"></i><span class="menu_label">Pemegang IUPHHK</span>',
//                        'url' => array('/admin/iuphhk/index'),
//                        'active' => in_array(Yii::app()->controller->id, array('iuphhk')),
//                    ),
//                    array(
//                        'label' => '<i class="fa fa-globe fa-2x"></i><span class="menu_label">Peta Wilayah</span>',
//                        'url' => array('/admin/peta'),
//                        'active' => in_array(Yii::app()->controller->id, array('peta')),
//                    ),
//                    array(
//                        'label' => '<i class="fa fa-archive fa-2x"></i><span class="menu_label">Rekapitulasi Kinerja</span>',
//                        'url' => array('/admin/rekap'),
//                        'active' => in_array(Yii::app()->controller->id, array('rekap')),
//                    ),
//                    array(
//                        'label' => '<i class="fa fa-book fa-2x"></i><span class="menu_label">Publik</span>',
//                        'url' => array('/cms/page/admin'),
//                        'active' => in_array(Yii::app()->controller->id, array('page')),
//                    )
//                ),
//            ));
//        } else if(Yii::app()->user->isBPHP()) {
//            $this->widget('zii.widgets.CMenu', array(
//                'encodeLabel' => FALSE,
//                'htmlOptions' => array('class' => 'top_ico_nav clearfix', 'id' => 'icon_nav_h'),
//                'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
//                'items' => array(
//                    array(
//                        'label' => '<i class="fa fa-home fa-2x"></i><span class="menu_label">Home</span>',
//                        'url' => array('/admin/default/index'),
//                        'active' => (Yii::app()->controller->module->id == 'admin' && Yii::app()->controller->id == 'default') ? true : false
//                    ),
//                    array(
//                        'label' => '<i class="fa fa-pencil-square-o fa-2x"></i><span class="menu_label">Pemegang IUPHHK</span>',
//                        'url' => array('/admin/iuphhk/index'),
//                        'active' => in_array(Yii::app()->controller->id, array('iuphhk')),
//                    ),
//                    array(
//                        'label' => '<i class="fa fa-globe fa-2x"></i><span class="menu_label">Peta Wilayah</span>',
//                        'url' => array('/admin/peta'),
//                        'active' => in_array(Yii::app()->controller->id, array('peta')),
//                    ),
//                    array(
//                        'label' => '<i class="fa fa-archive fa-2x"></i><span class="menu_label">Rekapitulasi Kinerja</span>',
//                        'url' => array('/admin/rekap'),
//                        'active' => in_array(Yii::app()->controller->id, array('rekap')),
//                    ),
//                ),
//            ));            
//        }
                ));
        ?>
    </div>
</nav>