<nav id="top_navigation">
    <div class="container">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'encodeLabel' => FALSE,
            'htmlOptions' => array('class' => 'top_ico_nav clearfix', 'id' => 'icon_nav_h'),
            'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-pills-nipz nav-submenu'),
            'items' => array(
                array(
                    'label' => '<i class="fa fa-home fa-2x"></i><span class="menu_label">Home</span>',
                    'url' => array('/perusahaan/default/index'),
                    'active' => (Yii::app()->controller->module->id == 'perusahaan' && Yii::app()->controller->id == 'default') ? true : false
                ),
                array(
                    'label' => '<i class="fa fa-pencil-square-o fa-2x"></i><span class="menu_label">Profil Perusahaan</span>',
                    'url' => array('/perusahaan/data/index'),
                    'active' => (Yii::app()->controller->id == 'data' || Yii::app()->controller->id == 'dirkom' || Yii::app()->controller->id == 'branch' || Yii::app()->controller->id == 'legalitas') ? true : false
                ),
                array(
                    'label' => '<i class="fa fa-newspaper-o fa-2x"></i><span class="menu_label">Data IUPHHK-HTI</span>',
                    'url' => array('/perusahaan/hutan/index'),
                    'active' => (Yii::app()->controller->id == 'hutan') ? true : false
                ),
                array(
                    'label' => '<i class="fa fa-calendar-o fa-2x"></i><span class="menu_label">Rencana Kerja</span>',
                    'url' => array('/perusahaan/rku/index'),
                    'active' => in_array(Yii::app()->controller->id,array('rku', 'rkt')) ? true : false
                ),
                array(
                    'label' => '<i class="fa fa-desktop fa-2x"></i><span class="menu_label">Kinerja</span>',
                    'url' => array('/perusahaan/pelaporan/index'),
                    'active' => in_array(Yii::app()->controller->id,array('pelaporan')) ? true : false
                ),
//                array(
//                    'label' => '<i class="fa fa-book fa-2x"></i><span class="menu_label">Report</span>',
//                    'url' => array('/perusahaan/report/index'),
//                    'active' => in_array(Yii::app()->controller->id,array('report')) ? true : false
//                ),
//                array(
//                    'label' => '<i class="fa fa-globe fa-2x"></i><span class="menu_label">Peta Wilayah</span>',
//                    'url' => array('/perusahaan/peta/index'),
//                    'active' => in_array(Yii::app()->controller->id,array('peta')) ? true : false
//                ),
//                array(
//                    'label' => '<i class="fa fa-file-text-o fa-2x"></i><span class="menu_label">Dokumen</span>',
//                    'url' => array('/perusahaan/dokumen/index'),
//                    'active' => in_array(Yii::app()->controller->id,array('dokumen')) ? true : false
//                )
            ),
        ));
        ?>
    </div>
</nav>
