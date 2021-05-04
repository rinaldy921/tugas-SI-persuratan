<?php
use yii\data\ActiveDataProvider;

$this->breadcrumbs=array(
	'RKT'=>array('index'),
	'Kelola RKT',
);

$listTahun = CHtml::listData(Rkt::model()->bytahun()->findAll(), 'tahun_mulai', 'tahun_mulai');

$url = "javascript:getBlok('".Yii::app()->createUrl("admin/rkt/index");
                            
//
//print_r("<pre>");
//print_r($tahun); 
//print_r("</pre>");
//die();


$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));

?>

<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Daftar Rkt Per Provinsi</h4>
    
    <div class="form-group">
                <div class="col-sm-1" style="text-align: right">
                    Tahun RKT : 
                </div>
                <div class="col-sm-9">
                
                    <select id="tahun" name="tahun" class="">    
                        <option value="0">--- Pilih Tahun RKT ---</option>
                        <?php 
                            foreach($listTahun as $item){
                                if($tahun == $item){
                        ?>   
                        <option value="<?php echo $item ?>" selected><?php echo $item?></option>
                        <?php
                            }else{                            
                        ?>
                        <option value="<?php echo $item ?>"><?php echo $item?></option>
                            <?php } 
                            
                            }?>
                    </select>    
                </div>
             </div>   

    
    

<?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary'));?>
<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model, 
'enableSorting'=>false,
'emptyText' => 'Tidak ada data',
// 'filter' => $model,
//'rowCssClassExpression'=>'($data->status==2)?"normal":"especial"',
'template' => '{items}{summary}{pager}',
'columns'=>array(
//        array(   
//            'name' => 'id',
//            'header' => 'ID',
//            'value' => '$data[id]',
//        ),
        
        array(   
            'name' => 'nama_perusahaan',
            'header' => 'Nama Perusahaan',
        ),
	array(   
            'name' => 'nomor_sk',
            'header' => 'Nomor SK',
        ),
        array(   
            'name' => 'tanggal_sk',
            'header' => 'Tanggal SK',
        ),
        array(   
            'name' => 'tahun_mulai',
            'header' => 'Tahun Mulai',
        ),
        array(   
            'name' => 'akhir_berlaku',
            'header' => 'Akhir Berlaku',
        ),
    
        array(   
            'name' => 'approval_status',
            'header' => 'Status Persetujuan',
            'value' => '$data[approval_status] == 0 ? "Belum Di Setujui" : "Di Setujui"'
        ),
	
        array(
        'header'=>'Aksi',
		'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{approve}{unapprove} {file_1} {file_2}',
		'buttons'=>array(
		
            'approve' => array(
            	'label' => "<i class='glyphicon glyphicon-ok'></i>",
            	'options' => array('title' => Yii::t('app', 'Setujui RKT'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/doApproveRkt", array("id"=>$data[id]))',
            	'visible' => '$data[approval_status] == 0 ? "1" : "0"'
            ),
            'unapprove' => array(
            	'label' => "<i class='glyphicon glyphicon-remove'></i>",
            	'options' => array('title' => Yii::t('app', 'Batal Setujui RKT'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/unApproveRkt", array("id"=>$data[id]))',
            	'visible' => '$data[approval_status] == 1 ? "1" : "0"'
            ),
            'file_1' => array(
                'options' => array('data-toggle' => 'tooltip', 'title' => 'File SK RKT' ),
                'label' => '<i class="fa fa-file-pdf-o"></i>',
                'visible' => '$data->file_doc == null ? "0" : "1"',
                'url' => function ($data) {
                    if(!is_null($data->file_doc)) {
                        $file = $this->createUrl('/').$data->file_doc;
                        return $file;
                    }
                }
            ),
            'file_2' => array(
                'options' => array('data-toggle' => 'tooltip', 'title' => 'File SHP' ),
                'label' => '<i class="fa fa-file-pdf-o"></i>',
                'visible' => '$data->file_doc == null ? "0" : "1"',
                'url' => function ($data) {
                    if(!is_null($data->file_shp)) {
                        $file = $this->createUrl('/').$data->file_shp;
                        return $file;
                    }
                }
            ),
            
		)
	),
                    
),
)); ?>
</div>

<script>
     $("#tahun").change(function(){
           $("#rkt-form").submit();
        });
</script>


<?php $this->endWidget(); ?>