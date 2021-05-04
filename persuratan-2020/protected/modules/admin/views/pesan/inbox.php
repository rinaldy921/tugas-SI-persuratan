<?php
$this->breadcrumbs=array(
	'Pesan Masuk'=>array('index')
);

?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php  require_once dirname(__FILE__) . '/../layouts/menu_inbox.php'; ?>        </div>                   
    </div>
</div>

<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Inbox (Pesan Masuk)</h4>
    
    <?php
//        print_r("<pre>");
//        print_r(Yii::app()->user->findUser()->id_role);
//        print_r("</pre>"); die();
        $role = Yii::app()->user->findUser()->id_role;
        if($role == 1 || $role == 3 || $role == 4 || $role == 5){   //dishut / bphp / admin
    ?>
        <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Tambah Pesan / Peringatan'), array('create'), array('class' => 'btn btn-primary'));?>
        
        <?php }?>    
        
        
        <?php 
            $this->widget('booster.widgets.TbGridView',array(
                'id'=>Yii::app()->controller->id . '-grid',
                'type' => 'bordered condensed striped',
                'responsiveTable' => true,
                'dataProvider'=>$model,
               // 'filter'=>$model,
                'template' => '{items}{summary}{pager}',
                'columns'=>array(
                               
                                array(
                                    'name' => 'pengirim',
                                    'header' => 'Pengirim',
                                    'value' => '$data["pengirim"]',
                                ),
                              
                                'subyek',
                                array(
                                    'name' => 'tipe',
                                    'header' => 'Jenis Surat/Pesan',
                                    'value' => '$data["tipe"]',
                                ),
                                array(
                                    'name' => 'tgl_kirim',
                                    'header' => 'Tanggal Kirim',
                                    'value' => '$data["tgl_kirim"]',
                                ),
                                array(
                                    'name' => 'status_baca',
                                    'header' => 'Status',
                                    'value' => '$data["status_baca"]==1?"Sudah Di baca":"Belum Di baca"',
                                ),
                                //'isi',
                                
                               
                                array(
                                    'header'=>'Lampiran File',
                                    'class'=>'booster.widgets.TbButtonColumn',
                                    'template'=>'{file_1}',
                                    'buttons'=>array(
                                    'file_1' => array(
                                                    'options' => array('data-toggle' => 'tooltip', 'title' => 'File Surat' ),
                                                    'label' => '<i class="fa fa-file-pdf-o"></i>',
                                                    'visible' => '$data["file_lampiran"] == null ? "0" : "1"',
                                                    'url' => function ($data) {
                                                        if(!is_null($data['file_lampiran'])) {
                                                            $file = $this->createUrl('/').$data['file_lampiran'];
                                                            return $file;
                                                        }
                                                    }
                                                ),
                                    ),
                             ),  
                               
        
                        
                            array(
                                'header'=>'Aksi',
                                'class'=>'booster.widgets.TbButtonColumn',
                                'htmlOptions' => array('style'=>'width:90px', "text-align" => "center"),
                                'template'=>' {view} ',
                                'buttons'=>array(
                                        'view' => array(
                                                          'options' => array('data-toggle' => 'tooltip', 'title' => 'Lihat Pesan'),
                                                          'label' => '<i class="fa fa-newspaper-o"></i>',
                                                          'url' => 'Yii::app()->createUrl("/admin/pesan/view/",array("id"=>$data["id"]))',
                                                      ),
                                          ),
                                ),                    
),
)); ?>
</div>