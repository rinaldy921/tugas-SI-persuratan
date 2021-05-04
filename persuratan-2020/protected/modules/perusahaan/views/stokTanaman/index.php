<?php
/* @var $this StokTanamanController */
/* @var $model StokTanaman */

$this->breadcrumbs=array(
	'',
	'Stok Tanaman'=>array('index'),
);


?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_stok_awal.php'; ?>
        </div>
    </div>
</div>


<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header"><?php echo Yii::t('app', 'Stok Awal Tanaman'); ?></h4>
    <?php
        echo CHtml::link("<i class='glyphicon glyphicon-plus-sign'></i> " . Yii::t('app', '  Tambah'), array('create'), array('class' => 'btn btn-primary btn-sm'));
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
                        'id',
                        'tahun_tanam',
                        array(
                                'name' => 'sektor',
                                'header' => 'Unit Kelestarian',
                                'headerHtmlOptions' => array('style' => 'text-align:center'),
                                'value' => '$data->idBlok->namaSektor->nama_sektor',
                                'htmlOptions' => array('style' => 'text-align:center')
                            ),
                            array(
                                'name' => 'blok',
                                'header' => 'Petak Kerja',
                                'headerHtmlOptions' => array('style' => 'text-align:center'),
                                'value' => '$data->idBlok->nama_blok',
                                'htmlOptions' => array('style' => 'text-align:center')
                            ),  
                        'jumlah_luas',
                       // 'jenis_lahan',
                        /*
                        'id_perusahaan',
                        */
                    
            array(
                'header'=>'Aksi',
                'class' => 'booster.widgets.TbButtonColumn',
                'template'=>' {update} {delete} ',
                'htmlOptions' => array('style'=>'width:100px', "text-align" => "center"),
               
                
            ),
        ),
    ));
    ?>
    
    
    
</div>