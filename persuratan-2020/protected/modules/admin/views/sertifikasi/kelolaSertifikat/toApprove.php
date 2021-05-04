<?php
use yii\data\ActiveDataProvider;

$this->breadcrumbs=array(
	'RKT'=>array('index'),
	'Kelola Sertifikat Ganis',
);
?>

<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Daftar Pengesahan Sertifikat Ganis</h4>

<?php $this->widget('booster.widgets.BootGroupGridView',array(
'id'=>Yii::app()->controller->id . '-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model, 
//'mergeColumns' => array('perusahaan', 'nama_ganis', 'jenis_ganis', 'nomor_sertifikat','file_sertifikat'),
'enableSorting'=>true,
'emptyText' => 'Tidak ada data',
//'filter' => $model,
//'rowCssClassExpression'=>'($data->status==2)?"normal":"especial"',
'template' => '{items}{summary}{pager}',
'columns'=>array(
        array(
            'header' => 'No.',
            'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
            * $this->grid->dataProvider->pagination->pageSize) + 1',
        ),
        array(   
            'name' => 'perusahaan',
            'header' => 'Nama Perusahaan',
            'value' => '$data->idIuphhkTenagaKerja->idPerusahaan->nama_perusahaan',
        ),
        array(   
            'name' => 'nama_ganis',
            'header' => 'Nama',
            'value' => '$data->idIuphhkTenagaKerja->nama',
        ),
	array(   
            'name' => 'jenis_ganis',
            'header' => 'Jenis Ganis',
            'value' => '$data->idIuphhkTenagaKerja->idJenisTenagaKerja->nama_jenis',
        ),
        array(   
            'name' => 'nomor_sertifikat',
            'header' => 'Nomor Sertifikat',
            'value' => '$data->idIuphhkTenagaKerja->no_sertifikat',
        ),
        array(
            'name' => 'file_sertifikat',
            'header' => 'File Sertifikat',
            'type'  => 'raw',
            'value' => function ($data) {
                if(!is_null($data->idIuphhkTenagaKerja->file_doc)) {
                    $file = $file_name. " <a href='".$this->createUrl('/').$data->idIuphhkTenagaKerja->file_doc."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                    return $file;
                }
            }
        ),
        array(   
            'name' => 'no_reg',
            'header' => 'Nomor Register',
            'value' => '$data->no_reg',
        ),
        array(
            'header' => 'File Register',
            'type'  => 'raw',
            'value' => function ($data) {
                if(!is_null($data->file_reg)) {
                    $file = $file_name. " <a href='".$this->createUrl('/').$data->file_reg."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                    return $file;
                }
            }
        ),      
        array(   
            'name' => 'no_sk',
            'header' => 'Nomor SK',
            'value' => '$data->no_sk',
        ),
        array(   
            'name' => 'masa_berlaku',
            'header' => 'Masa Berlaku',
            'value' => function($data) {
                $awal = isset($data->tgl_awal_sk) ? Yii::app()->controller->getDateMonth($data->tgl_awal_sk) : "-";
                $akhir = isset($data->tgl_akhir_sk) ? Yii::app()->controller->getDateMonth($data->tgl_akhir_sk) : "-";
                return $awal . ' s/d ' . $akhir;
            }
        ),
        array(
            'header' => 'File SK',
            'type'  => 'raw',
            'value' => function ($data) {
                if(!is_null($data->file_sk)) {
                    $file = $file_name. " <a href='".$this->createUrl('/').$data->file_sk."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                    return $file;
                }
            }
        ), 
////        array(   
////            'name' => 'bphp',
////            'header' => 'Wilayah BPHP',
////            'value' => '$data[bphp]',
////        ),
//    
        array(   
            'name' => 'approval_status',
            'header' => 'Status Persetujuan',
            'value' => '$data[approval_status] == 0 ? "Belum Di Setujui" : "Di Setujui"'
        ),
	
        array(
        'header'=>'Aksi',
		'class'=>'booster.widgets.TbButtonColumn',
		'template'=>'{approve}{unapprove}',
		'buttons'=>array(
		
            'approve' => array(
            	'label' => "<i class='glyphicon glyphicon-ok'></i>",
            	'options' => array('title' => Yii::t('app', 'Setujui RKT'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/doApproveSertifikat", array("id"=>$data[id]))',
            	'visible' => '$data[approval_status] == 0 ? "1" : "0"'
            ),
            'unapprove' => array(
            	'label' => "<i class='glyphicon glyphicon-remove'></i>",
            	'options' => array('title' => Yii::t('app', 'Batal Setujui RKT'), 'class' => 'modal-fancy-auto', 'data-fancybox-type' => 'iframe'),
                'url' => 'Yii::app()->createUrl("/admin/' . Yii::app()->controller->id . '/unApproveSertifikat", array("id"=>$data[id]))',
            	'visible' => '$data[approval_status] == 1 ? "1" : "0"'
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
