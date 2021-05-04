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
                    'url' => array('/admin/default/index'),
                    'active' => (Yii::app()->controller->module->id == 'admin' && Yii::app()->controller->id == 'default') ? true : false
                ),
                array(
                    'label' => '<i class="fa fa-database fa-2x"></i><span class="menu_label">Master Data</span>',
                    'url' => array('/admin/provinsi/index'),
                    'active' => in_array(Yii::app()->controller->id, array('provinsi','kabupaten','user','perusahaan')) ? true : false
                ),
                array(
                    'label' => '<i class="fa fa-pencil-square-o fa-2x"></i><span class="menu_label">Pemegang IUPHHK</span>',
                    'url' => array('/admin/iuphhk/index'),
                    'active' => in_array(Yii::app()->controller->id, array('iuphhk')),
                ),
                array(
                    'label' => '<i class="fa fa-globe fa-2x"></i><span class="menu_label">Peta Wilayah</span>',
                    'url' => array('/admin/peta'),
                    'active' => in_array(Yii::app()->controller->id, array('peta')),
                ),
                array(
                    'label' => '<i class="fa fa-archive fa-2x"></i><span class="menu_label">Rekapitulasi Kinerja</span>',
                    'url' => array('/admin/rekap'),
                    'active' => in_array(Yii::app()->controller->id, array('rekap')),
                )
            ),
        ));
        ?>
    </div>
</nav>