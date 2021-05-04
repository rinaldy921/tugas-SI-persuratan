<?php
$this->breadcrumbs=array(
	'Kecamatans'=>array('index'),
	'Manage',
);
$kab = CHtml::listData(Kabupaten::model()->findAll(array('select' => 'id_kabupaten, nama','order'=>'id_kabupaten ASC')), 'id_kabupaten', 'nama');
// $kab = array_merge(array(""=>"Pilih Kabupaten..."), $kab);

// $kab = Kabupaten::model()->findAll(array('select'=>'nama'));
// foreach($kab as $kb) {
//     $nama[] = $kb->nama;
// }
// var_dump($nama);die;
// $kab = implode(',',$nama);
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
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Kecamatan</h4>
    <?php echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('create'), array('class' => 'btn btn-primary'));?><?php $this->widget('booster.widgets.TbGridView',array(
'id'=>Yii::app()->controller->id . '-grid',
'type' => 'bordered condensed striped',
'responsiveTable' => true,
'dataProvider'=>$model->search(),
'filter'=>$model,
'template' => '{items}{summary}{pager}',
'afterAjaxUpdate'=>'js:function(id,data) {
    $("#Kecamatan_kabupaten_id").select2({
        "width":"resolve",
        allowClear:true,
        placeholder:"Pilih Kabupaten..."
    });
    // .on("change",function(data) {
    //     nipz_id = data["added"]["id"];
    // });
    // $("#Kecamatan_kabupaten_id").val(nipz_id);
}',
'columns'=>array(
		// 'id_kecamatan',
        array(
                'header' => 'No.',
                'value' => '$row + ($this->grid->dataProvider->pagination->currentPage
                    * $this->grid->dataProvider->pagination->pageSize) + 1',
            ),
        array(
            'name'=>'kabupaten.provinsi',
            'value'=>'$data->kabupaten->kabupatenProvinsi->nama'
        ),
    //     array(
		  // 'name'=>'kabupaten_id',
    //       'value'=>'$data->kabupaten->nama'
    //     ),
        array(
            'htmlOptions'=>array('id'=>'kab'),
            'name' => 'kabupaten_id',
            'type' => 'raw',
            // 'filter' => $this->widget('booster.widgets.TbTypeahead', array('name'=>get_class($model).'kabupaten_id','datasets'=>array('source'=>$nama),'options' => array('hint' => true,'highlight' => true,'minLength' => 1),)),
            'filter' => $this->widget('booster.widgets.TbSelect2', array(
                'name'=>get_class($model) . '[kabupaten_id]', 
                'data'=>$kab,
                'value'=>!empty($model->kabupaten_id) ? $model->kabupaten_id : '',
                'options'=>array(
                    'allowClear'=>true,
                    'placeholder'=>'Pilih Kabupaten...'
                ),
                'htmlOptions'=>array(
                    // 'empty'=>'Pilih Kabupaten...'
                ),
                // 'events'=>array(
                //     'change'=>'js:function(data) {
                //         nipz_id = data["added"]["id"];
                //     }'
                // )
                ),true),
            
            // 'filter' => CHtml::dropDownList(get_class($model) . '[kabupaten_id]', $model->kabupaten_id, $kab, array('class' => 'form-control')),
            'value' => '($data->kabupaten_id) ? $data->kabupaten->nama : "-"',
        ),
		'nama',
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
</div>
<?php
Yii::app()->clientScript->registerScript("te","var nipz_id = '';",CClientScript::POS_HEAD);