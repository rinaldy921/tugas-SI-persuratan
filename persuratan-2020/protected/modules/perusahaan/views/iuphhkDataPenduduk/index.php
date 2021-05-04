<?php
$this->breadcrumbs = array(
    'Data Jumlah Penduduk'
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_sosial_ekonomi.php'; ?>
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Jumlah Penduduk</h4>
    <?php
    $this->widget('booster.widgets.BootGroupGridView',array(
        'id'=>Yii::app()->controller->id . '-grid',
        'type' => 'bordered condensed striped get',
        'responsiveTable' => true,
        'dataProvider'=>$model->search(), 
        'enableSorting'=>false,
        'summaryText' => false,
        'extraRowColumns'=> array('id_kategori_penduduk'),
         'extraRowExpression' => '"<strong>".$data->idKategoriPenduduk->kategori."</strong>"',
        'columns'=>array(
            array(
                'name'=>'id_kategori_penduduk',
                'value'=>'$data->idKategoriPenduduk->kategori',
                'headerHtmlOptions'=>array('style'=>'display:none'),
                'htmlOptions'=>array('style'=>'display:none'),
                'footerHtmlOptions'=>array('style'=>'display:none'),
            ),
            array(
                'name'=>'id_jenis_kelamin',
                'value'=>'$data->idJenisKelamin->jenis_kelamin',
                'htmlOptions'=>array('style'=>'padding-left:30px')
            ),
            array(
                'name'=>'jumlah',
                'class'=>'booster.widgets.TbEditableColumn',
                'editable'=> array('url'=>$this->createUrl('//perusahaan/iuphhkDataPenduduk/inputJumlahPenduduk'),
                    'success'=>'js:function() {
                        $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-grid");
                    }'
                ),
            )
        ),
    ));
    ?>
</div>