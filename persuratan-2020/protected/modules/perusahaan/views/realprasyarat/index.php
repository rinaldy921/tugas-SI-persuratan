<?php
$this->breadcrumbs = array(
    'Realisasi RKT'
);
$listRKT = CHtml::listData(
    Rkt::model()->findAll(
            array(
                'condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan(). ' AND id_rku = '.Yii::app()->session['rku_id'],
                'order' => 'tahun_mulai DESC'
            )
    ), 'tahun_mulai', 'tahun_mulai'
);
$periodeRKT = (new Rkt())->monthByRKT();

//
//print_r("<pre>");
//print_r($listRKT);
//print_r("<pre>");
//exit(1);

 
$formPrasyarat = [
    // ['id' => 'ganis', 'text' => 'Organisasi & Tenaga Kerja','uri' => Yii::app()->createUrl('//perusahaan/realisasiGanis/index')],
    ['id' => 'ganis', 'text' => 'Organisasi & Tenaga Kerja','uri' => Yii::app()->createUrl('//perusahaan/serapanTenagaKerja/index')],
    ['id' => 'batas_blok', 'text' => 'Penataan Batas Blok','uri' => Yii::app()->createUrl('//perusahaan/realisasiTataBatas/index')],
    ['id' => 'ruang_lindung', 'text' => 'Penataan Ruang (Kawasan Lindung)','uri' => Yii::app()->createUrl('//perusahaan/realisasiKawasanLindung/index')],
    ['id' => 'ruang_tdk_efektif', 'text' => 'Penataan Ruang (Areal Tidak Efektif)','uri' => Yii::app()->createUrl('//perusahaan/realisasiArealNonProduktif/index')],
    ['id' => 'ruang_efektif', 'text' => 'Penataan Ruang (Areal Efektif)','uri' => Yii::app()->createUrl('//perusahaan/realisasiArealProduktif/index')],
    ['id' => 'areal_kerja', 'text' => 'Penataan Areal Kerja','uri' => Yii::app()->createUrl('//perusahaan/realisasiArealKerja/index')],
    ['id' => 'buka_hutan', 'text' => 'Pembukaan Wilayah Hutan','uri' => Yii::app()->createUrl('//perusahaan/realisasiPwh/index')],
    ['id' => 'peralatan', 'text' => 'Pemasukan & Penggunaan Peralatan','uri' => Yii::app()->createUrl('//perusahaan/realisasiMasukGunaAlat/index')],
    ['id' => 'sarana', 'text' => 'Pembangunan Sarana & Prasarana','uri' => Yii::app()->createUrl('//perusahaan/realisasiSarpras/index')]
];
$id_grid = Yii::app()->controller->id . '-filtertahun-form';
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_realisasi.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Realisasi RKT - Prasyarat</h4>
    <div class="col-md-12">
        <div class="row">
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => $id_grid,
                'type' => 'horizontal',
                'htmlOptions' => array('class' => 'well well-sm')
            ));?>
            <?php echo $form->hiddenField($periodeModel, 'tahun_periode', array());?>
            <?php echo $form->select2Group($periodeModel, 'form', array(
                'widgetOptions' => array('options' => array('allowClear' => true),
                    'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Form'))
                )
            );?>
            <?php echo $form->select2Group($periodeModel, 'rkt', array(
                'labelOptions' => array('label' => 'RKT', 'class' => 'span7'),
                'widgetOptions' => array('options' => array('allowClear' => true),
                    'data' => $listRKT,
                    'htmlOptions' => array('class' => 'span12', 'placeholder' => 'Pilih Periode RKT'))
                    )
            );?>
            <?php echo $form->select2Group($periodeModel, 'periode', array(
                'widgetOptions' => array('options' => array('allowClear' => true),
                    'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Periode Realisasi'))
                )
            );?>
            <div class="form-group">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <?php $this->widget('booster.widgets.TbButton', array(
                        'id' => 'subm',
                        'buttonType' => 'submit',
                        'context' => 'success',
                        'size' => 'small',
                        'label' => 'Tampilkan',
                    ));?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
            <div id="grid-content"></div>
        </div>
    </div>

</div>
<script type="text/javascript">
$('#<?=$id_grid?>').on('submit',function(){
    var is_empty = 'N';
    $('select').each(function(index, elm){
        var select = $(elm).val();
        if(select.length == 0){
            is_empty = 'Y';
        }
    })
    if(is_empty == 'Y'){
        alert('Silahkan, isi form yang telah disediakan');
    }else{
        $('#grid-content').empty();
        $('#grid-content').html('<div style="text-align:center;"><img src="<?php echo Yii::app()->baseUrl . '/img/ajax-loader.gif'; ?>"/></div>');
        var link = $('#<?=CHtml::activeId($periodeModel, "form")?>').find(":selected").data('uri');
        if(link != undefined){
            var thn_periode = $('#FormPeriodeRealisasiPrasyarat_periode').find(":selected").text();
            $('#<?=CHtml::activeId($periodeModel, "tahun_periode")?>').val(thn_periode);
            $.ajax({
                type: "POST",
                data:$('#<?=$id_grid?>').serialize(),
                dataType: 'html',
                url:link,
                success: function(response, statusText, xhr, $form){
                    $('#grid-content').html(response);
                },
                error: function(response, statusText, xhr, $form){
                    $('#grid-content').html(response);
                }
            });
        }else{
            $('#grid-content').html('<div class="alert alert-danger">Menu tidak ditemukan</div>');
        }
    }
    return false;
});

    var periodeRKT = <?= json_encode($periodeRKT); ?>;
    function setPeriode(jsonPeriode, tahunRKT)
    {
        $.each(jsonPeriode, function (index, element) {
            if (index == tahunRKT)
            {
                $('#FormPeriodeRealisasiPrasyarat_periode').empty();
                $.each(element, function (index2, element2) {
                    //console.log(element2);
                    $('#FormPeriodeRealisasiPrasyarat_periode').append($('<option>',
                            {
                                value: element2.id_bulan,
                                text: element2.bulan
                            }
                    ));
                });
            }
        });
    }

    $(document).ready(function () {
        var thnRKT = $('#FormPeriodeRealisasiPrasyarat_rkt').val();
        var formPrasyarat = <?= json_encode($formPrasyarat); ?>;
        setPeriode(periodeRKT, thnRKT);
        $('#FormPeriodeRealisasiPrasyarat_rkt').change(function () {
            setPeriode(periodeRKT, this.value);
        });
        $.each(formPrasyarat, function (index, element) {
            $('#FormPeriodeRealisasiPrasyarat_form').append($('<option>',
                {
                    'data-uri': element.uri,
                    'value': element.id,
                    'text': element.text
                }
            ));
        });

    });
</script>
