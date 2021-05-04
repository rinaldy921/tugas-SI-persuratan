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
<input type="text" id="thn-report" value="<?=$_tahun;?>" />
<input type="text" id="prov-report" value="<?=$_provinsi;?>" />
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

            <?php echo $form->select2Group($prov, 'tahun', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "select2tahun"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $tahun, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Tahun...'))))); ?>
            <?php echo $form->select2Group($prov, 'provinsi', array('wrapperHtmlOptions' => array('class' => 'col-md-8'), 'enableAjaxValidation' => false, 'groupOptions' => array('id' => "prov"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $provinsi, 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', 'Pilih Provinsi...'))))); ?>
            <div class="form-group">
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

            <div id="load" class="form-group">
                <img src="<?php echo Yii::app()->baseUrl . '/img/ajax-loader.gif'; ?>"/>
            </div>
            <div class="pull-right">
                <a id="th" class="btn btn-success" href="#"><i class="glyphicon glyphicon-save"></i> Export to Excel</a>
            </div>            
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <div id="data" style="width: 1200px; height: 600px; overflow: auto">
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
                    'name' => 'SK Izin',
                    'start' => '5',
                    'end' => '7',
                    'rowspan' => '2'
                ),
                array(
                    'name' => 'RKU',
                    'start' => '8',
                    'end' => '9',
                    'rowspan' => '2'
                ),                
                array(
                    'name' => 'RKT',
                    'start' => '10',
                    'end' => '17',
                    //'rowspan' => '2'
                ),
                array(
                    'name' => 'Sertifikasi PHPL',
                    'start' => '18',
                    'end' => '20',
                    'rowspan' => '2'
                ),                
                array(
                    'name' => 'Sertifikasi VLK',
                    'start' => '21',
                    'end' => '23',
                    'rowspan' => '2'
                ),                                
            ),
            'subHeaders' => array(
                array(
                    'name' => 'SK',
                    'start' => '10',
                    'end' => '11',
                    //'rowspan' => '2'
                ),                
                array(
                    'name' => 'Produksi',
                    'start' => '12',
                    'end' => '14',                    
                ),
                array(
                    'name' => 'Penanaman',
                    'start' => '15',
                    'end' => '17',                    
                ),
            ),
            'columns' => array(
                array('header' => 'No', 'value' => '$row+1'),
                array(
                    'name' => 'nama_perusahaan',
                    'header' => 'Nama Perusahaan',                                    
                    //'rowspan' => '2'
                ),                
                array(
                    'name' => 'provinsi',
                    'header' => 'Provinsi',                                    
                ),                                
                array(
                    'header' => 'Investasi',
                    'name' => 'investasi',
                    'value' => function($data){
                        return number_format($data['investasi'],0,'.', ',');
                    }                    
                ),                
                array(
                    'header' => 'Tenaga Kerja',
                    'name' => 'jml_naker'
                ),                        
                array(
                    'name' => 'no_sk_izin',
                    'header' => 'Nomor',                    
                ),                        
                array(
                    'name' => 'luas_izin',
                    'header' => 'Luas (Ha)',   
                    'value' => function($data){
                        return number_format($data['luas_izin'],2,'.', ',');
                    }
                ),                        
                array(
                    'name' => 'status_izin',
                    'header' => 'Status',                    
                ),
                array(
                    'header' => 'Nomor',
                    'name' => 'sk_rku'
                ),
                array(
                    'header' => 'Tanggal',
                    'name' => 'tgl_sk_rku',
                    'value' => function($data){
                        return TinyHelper::dateIndo($data['tgl_sk_rku']);
                    }
                ),                                                
                array(
                    'header' => 'Nomor',
                    'name' => 'no_sk_rkt'
                ),
                array(
                    'header' => 'Tanggal',
                    'name' => 'tgl_sk_rkt',
                    'value' => function($data){
                        return TinyHelper::dateIndo($data['tgl_sk_rkt']);
                    }                    
                ),
                array(
                    'header' => 'Target',
                    'name' => 'target_produksi',
                    'value' => function($data){
                        return number_format($data['target_produksi'],0,'.', ',');
                    }                                        
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'realisasi_produksi',
                    'value' => function($data){
                        return number_format($data['realisasi_produksi'],0,'.', ',');
                    }                                                            
                ),
                array(
                    'header' => 'Persentase',
                    'name' => 'persentase',
                    'value' => function($data){
                        if($data->realisasi_produksi <> 0) return number_format((($data->realisasi_produksi/$data->target_produksi) * 100),2,'.',',')." %";
                        return 0;
                    }
                ), 
                array(
                    'header' => 'Target',
                    'name' => 'target_penanaman',
                    'value' => function($data){
                        return number_format($data['target_penanaman'],0,'.', ',');
                    }                                                            
                ),
                array(
                    'header' => 'Realisasi',
                    'name' => 'realisasi_penanaman',
                    'value' => function($data){
                        return number_format($data['realisasi_penanaman'],0,'.', ',');
                    }                                                                                
                ),
                array(
                    'header' => 'Persentase',
                    'name' => 'persentase',
                    'value' => function($data){
                        if($data->realisasi_penanaman > 0) return number_format((($data->realisasi_penanaman/$data->target_penanaman) * 100),2,',','.')." %";
                        return 0;
                    }
                ),                       
                array(
                    'header' => 'Tahun',
                    'name' => 'tahun_phpl'
                ),
                array(
                    'header' => 'Predikat',
                    'name' => 'predikat_phpl'
                ),
                array(
                    'header' => 'Berakhir',
                    'name' => 'berakhir_phpl'
                ),                
                array(
                    'header' => 'Tahun',
                    'name' => 'tahun_vlk'
                ),
                array(
                    'header' => 'Predikat',
                    'name' => 'predikat_vlk'
                ),
                array(
                    'header' => 'Berakhir',
                    'name' => 'berakhir_vlk'
                ),                               
                array(
                    'header' => 'Evaluasi Kinerja',
                    'name' => 'eval',                   
                    'value' => function($data){
                        if(!empty($data['eval']['grade']))
                            return  $data['eval']['grade']." - ".$data['eval']['rekomendasi'];
                    }
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

$('#select2tahun').on('select2:select', function (e) {
    var data = e.params.data;
    console.log(data);
});


jQuery('#sbm').on('click', function(e){
    e.preventDefault();
    // $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
    var data = $(\"#" . Yii::app()->controller->id . "-filtertahun-form\");
    tahun = $(\"#tahun\").val();
    provinsi = $(\"#prov\").val();
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
    var tahun = $('#select2tahun').select2('val');
    //alert(tahun);
    console.log(tahun);
    return;
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
