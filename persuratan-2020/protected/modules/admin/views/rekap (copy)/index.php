<?php
$this->breadcrumbs = array(
    'Rekapitulasi Kinerja'
);

$tahun_mulai = Rku::model()->find(array('select' => 'distinct tahun_mulai', 'order' => 'tahun_mulai ASC'));
$tahun_sampai = Rku::model()->find(array('select' => 'distinct tahun_sampai', 'order' => 'tahun_sampai DESC'));

foreach (range($tahun_mulai->tahun_mulai, date('Y')) as $key => $year) {
    $dt[$year] = (string) $year;
}
$prov = new Provinsi;
$tahun = CHtml::listData(Rkt::model()->findAll(array('select' => 'distinct tahun_mulai', 'order' => 'tahun_mulai ASC')), 'tahun_mulai', 'tahun_mulai');
$params = array(
    'select' => 't.id_provinsi, t.nama'
);
if (Yii::app()->user->type == 3) {
    $_params = array(
        'join' => 'INNER JOIN bphp_wilayah_kerja wil ON wil.id_provinsi = t.id_provinsi',
        'condition' => 'wil.id_master_bphp = :id_master_bphp',
        'params' => array(
            ':id_master_bphp' => Yii::app()->user->id_bphp
        )
    );
    $params = array_merge($params, $_params);
}
$provinsi = CHtml::listData(Provinsi::model()->findAll($params), 'id_provinsi', 'nama');
?>
<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Data Rekapitulasi Kinerja Per Tahun</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-filtertahun-form',
                'type' => 'inline',
                'htmlOptions' => array('class' => 'well well-sm')
            ));
            ?>

            <!--  <div class="form-group">
                 <label for="Rkt_tahun_mulai">Pilih Tahun : </label>
                 <div class="input-group">
                     <select id="Rkt_tahun_mulai" class="form-control" name="Filter[tahun]">
                         <option value="">Pilih Tahun...</option>
            <?php foreach ($dt as $th) : ?>
                                 <option value="<?php echo $th; ?>" <?php echo (isset($tahun) && $tahun === $th) ? 'selected' : '' ?>><?php echo $th; ?></option>
<?php endforeach; ?>
                     </select>
                 </div>
             </div> -->
<?php echo $form->select2Group($prov, 'tahun', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "tahun"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $tahun, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Tahun...'))))); ?>
<?php echo $form->select2Group($prov, 'provinsi', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "prov"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $provinsi, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Provinsi...'))))); ?>
            <div class="form-group">
                <!-- <div class="col-sm-3"></div>
                <div class="col-sm-9"> -->
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'id' => 'sbm',
                    'buttonType' => 'submit',
                    'context' => 'primary',
                    'label' => $prov->isNewRecord ? 'Cari' : 'Cari',
                ));
                ?>
                <!-- </div> -->
            </div>
            <!-- <div class="form-group">
                <label for="Rkt_provinsi">Pilih Provinsi : </label>
                <div class="input-group">
                    <select id="Rkt_provinsi" class="form-control" name="Filter[provinsi]">
                        <option value="">Pilih Provinsi...</option>
<?php foreach ($provinsi as $pr) : ?>
                                <option value="<?php //echo $pr; ?>"><?php //echo $pr; ?></option>
<?php endforeach; ?>
                    </select>
                </div>
            </div> -->
            <div id="load" class="form-group">
                <img src="<?php echo Yii::app()->baseUrl . '/img/ajax-loader.gif'; ?>"/>
            </div>
            <div class="pull-right">
                <a id="th" class="btn btn-success" href="#"><i class="glyphicon glyphicon-save"></i> Export to Excel</a>
            </div>
        <?php //echo $form->datePickerGroup($model,'tahun_mulai',array('widgetOptions'=>array('events'=>array('hide'=>'js:function(){$("#'.Yii::app()->controller->id.'-filtertahun-form").submit();}'), 'options' => array('format'=>'yyyy','startView'=>'decade','minViewMode'=>2,'autoclose'=>true ),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>'));  ?>
        <?php $this->endWidget(); ?>
        </div>
    </div>
    <div id="data">
        <?php
        $this->widget('booster.widgets.HeaderGroupGridView', array(
            'id' => Yii::app()->controller->id . '-rekap-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider' => $model,
            'itemsCssClass' => 'nipz',
            // 'filter' => $model,
            'template' => '{items}',
            'mergeHeaders' => array(
                array(
                    'name' => 'Penanaman',
                    'start' => '4',
                    'end' => '12',
                ),
                array(
                    'name' => 'Produksi',
                    'start' => '13',
                    'end' => '15',
                    'rowspan' => '2'
                )
            ),
            'subHeaders' => array(
                array(
                    'name' => 'Tanaman Pokok',
                    'start' => '4',
                    'end' => '6',
                ),
                array(
                    'name' => 'Tanaman Unggulan',
                    'start' => '7',
                    'end' => '9',
                ),
                array(
                    'name' => 'Tanaman Kehidupan',
                    'start' => '10',
                    'end' => '12',
                )
            ),
            'columns' => array(
                array('header' => 'No', 'value' => '$row+1'),
                array(
                    'name' => 'nama_badan',
                    'header' => 'Nama Perusahaan',
                    'value' => '!empty($data->idPerusahaan->nama_perusahaan) ? $data->idPerusahaan->nama_perusahaan : ""',
                // 'headerHtmlOptions'=>array('style'=>'text-align:center')
                ),
                // 'nomor',
                array(
                    'name' => 'nomor',
                    'header' => 'Nomor SK IUPHHK',
                    'value' => '$data->idPerusahaan->iuphhks[0]->nomor',
                ),
                array(
                    'name' => 'luas',
                    'header' => 'Luas Areal (Ha)',
                    'value' => '$data->idPerusahaan->iuphhks[0]->luas',
                ),
                //tapok 4,5,6
                array(
                    'header' => 'Jenis',
                    'name' => '$data->getTapok($data->id_rkt)'
                ),
                array(
                    'header' => 'Rencana (Ha)',
                    'name' => '$data->getTapok($data->id_rkt)'
                ),
                array(
                    'header' => 'Realisasi (Ha)',
                    'name' => '$data->getTapok($data->id_rkt)'
                ),
                //end tapok
                //tanggul 7,8,9
                array(
                    'header' => 'Jenis',
                    'name' => 'tanggul'
                ),
                array(
                    'header' => 'Rencana (Ha)',
                    'name' => 'tanggul'
                ),
                array(
                    'header' => 'Realisasi (Ha)',
                    'name' => 'tanggul'
                ),
                //end tanggul
                //tadup 10,11,12
                array(
                    'header' => 'Jenis',
                    'name' => 'tadup'
                ),
                array(
                    'header' => 'Rencana (Ha)',
                    'name' => 'tadup'
                ),
                array(
                    'header' => 'Realisasi (Ha)',
                    'name' => 'tadup'
                ),
                //end tadup
                //produksi 13,14,15
                array(
                    'header' => 'Jenis',
                    'name' => 'jenis_produksi',
                    'value' => '$data->getProduksiTanaman($data->id_rkt)'
                ),
                array(
                    'header' => 'Rencana (M3)',
                    'name' => 'rencana_produksi',
                    'value' => '$data->getRencanaProduksi($data->id_rkt,"jumlah")'
                ),
                array(
                    'header' => 'Realisasi (M3)',
                    'name' => 'realisasi_produksi',
                    'value' => '$data->getRencanaProduksi($data->id_rkt,"realisasi")'
                ),
                //end produksi
                // array(
                //     'name' => 'tahun',
                //     'header' => 'Tahun',
                //     'value' => '!empty($data->tahun) ? $data->tahun : ""'
                // ),
                array(
                    'name' => 'nilai_kinerja',
                    'header' => 'Nilai Kinerja',
                    'value' => '!empty($data->id_perusahaan) ? $data->getKinerja($data->id_perusahaan,$data->id_rkt) : ""',
                    'headerHtmlOptions' => array('style' => 'text-align:center')
                ),
            ),
        ));
        ?>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
var tahun = '';
var provinsi = '';
jQuery('#sbm').on('click', function(e){
    e.preventDefault();
    // $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
    var data = $(\"#" . Yii::app()->controller->id . "-filtertahun-form\");
    tahun = $(\"#Provinsi_tahun\").val();
    provinsi = $(\"#Provinsi_provinsi\").val();
    $.ajax({
        type:'POST',
        url:data.attr('href'),
        // dataType: 'json',
        data: data.serialize(),
        beforeSend: function() {
            $('#load').show();
        },
        success: function(data) {
            $('#data').empty();
            $('#data').html(data).find('table').hide().fadeIn(\"slow\");
            $('#load').hide();
        }
    });
});
jQuery('#th').on('click', function(){
    var base = '" . Yii::app()->baseUrl . "/admin/" . Yii::app()->controller->id . "/test/tahun/'+tahun+'/provinsi/'+provinsi;
    window.location.href = base;
    // $.ajax({
    //     type:'POST',
    //     url:'" . Yii::app()->createUrl('/admin/' . Yii::app()->controller->id . '/test') . "',
    //     data:{tahun:tahun}
    // });
    return false;
});
", CClientScript::POS_END);

Yii::app()->clientScript->registerScript("filter_tahun", "
    $('#load').hide();
", CClientScript::POS_READY);
