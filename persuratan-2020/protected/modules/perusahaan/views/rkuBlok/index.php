<?php
$this->breadcrumbs=array(
	'Rku Bloks'=>array('index'),
	'Manage',
);


//        print_r("<pre>");
//        print_r($model);
//        print_r("</pre>"); exit(1);

?>



<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>
        </div>
    </div>
</div>


<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Daftar Blok RKU</h4>
  
    
     <?php
    echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', 'Tambah Blok Baru'), array('create'), array('class' => 'btn btn-primary btn-sm'));
   
    ?>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'id' => Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped',
        'responsiveTable' => true,
        'dataProvider' => $model->search(),
//        'filter' => $model,
        'enableSorting' => false,
        'emptyText' => 'Tidak ada data',
        'template' => '{items}{summary}{pager}',
        'columns' => array(
            
            'nama_blok',
            array(
                'name' => 'id_sektor',
                'header'=> 'Nama Sektor',
                'value' => 'isset($data->namaSektor->nama_sektor) ? $data->namaSektor->nama_sektor : "" ',
            ),
           'desc'
        ),
        
    ));
    
    ?>
</div>