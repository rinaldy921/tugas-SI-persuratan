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

if(isset($rkt)){
    $rkt = $rkt['0'];
}

$periodeRKT = (new Rkt())->monthByRKT();

$formData = [
    ['id' => 'ganis', 'text' => 'Pengadaan Bibit', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPengadaanBibit/index')],
    ['id' => 'batas_blok', 'text' => 'Penyiapan Lahan', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPenyiapanLahan/index')],
    ['id' => 'ruang_lindung', 'text' => 'Penanaman', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPenanaman/index')],
    ['id' => 'ruang_tdk_efektif', 'text' => 'Pemeliharaan', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPemeliharaan/index')],
    // ['id' => 'ruang_efektif', 'text' => 'Pemeliharaan (Penjarangan)', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPenjarangan/index')],
    // ['id' => 'areal_kerja', 'text' => 'Pemeliharaan (Pendangiran)', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPendangiran/index')],
    // ['id' => 'panen_luas_area', 'text' => 'Pemanenan (Luas Areal)', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPanenLuasAreal/index')],
    ['id' => 'panen_vol_prod_hasil', 'text' => 'Pemanenan RKT', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPanenProduksi/index')],
    ['id' => 'panen_vol_prod_lahan', 'text' => 'Pemanenan Penyiapan Lahan', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPanenLahan/index')],
    ['id' => 'panen_non_kayu', 'text' => 'Pemanenan (Hasil Hutan Non Kayu)', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiHasilHutanNonkayu/index')],
    ['id' => 'pemasaran', 'text' => 'Pemasaran (Hasil Kayu)', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPemasaran/index')],
    ['id' => 'pemasaran_hhbk', 'text' => 'Pemasaran (Hasil Hutan Non Kayu)', 'uri' => Yii::app()->createUrl('//perusahaan/realisasiPemasaranHhbk/index')],    
];
$id_grid = Yii::app()->controller->id . '-filtertahun-form';
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_monev_realisasi.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Realisasi RKT - Kelestarian Fungsi Produksi</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => $id_grid,
                'type' => 'horizontal',
                'htmlOptions' => array('class' => 'well well-sm')
            ));
            ?>
            <?php echo $form->hiddenField($periodeModel, 'tahun_periode', array());?>
            <?php
            echo $form->select2Group($periodeModel, 'form', array(
                //'labelOptions' => array('label' => 'Periode'),
                'widgetOptions' => array('options' => array('allowClear' => true),
                    //'data' => $listRKT,
                    'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Jenis Form'))
                    )
            );
            ?>
            <?php
            echo $form->select2Group($periodeModel, 'rkt', array(
                'labelOptions' => array('label' => 'RKT', 'class' => 'span7'),
                'widgetOptions' => array('options' => array('allowClear' => true),
                    'data' => $listRKT,
                    'htmlOptions' => array('class' => 'span12', 'placeholder' => 'Pilih Periode RKT'))
                    )
            );
            ?>
            <?php
            echo $form->select2Group($periodeModel, 'periode', array(
                //'labelOptions' => array('label' => 'Periode'),
                'widgetOptions' => array('options' => array('allowClear' => true),
                    //'data' => $listRKT,
                    'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Periode Realisasi'))
                    )
            );
            ?>
            <div class="form-group">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'id' => 'subm',
                        'buttonType' => 'submit',
                        'context' => 'success',
                        'size' => 'small',
                        'label' => 'Tampilkan',
                    ));
                    ?>
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
        $('#FormPeriodeRealisasiPrasyarat_periode').each(function(index, elm){
            var select = $(elm).val();
            if(select.length == 0){
                is_empty = 'Y';
            }
        });
        $('#FormPeriodeRealisasiPrasyarat_rkt').each(function(index, elm){
            var select = $(elm).val();
            if(select.length == 0){
                is_empty = 'Y';
            }
        });
        $('#FormPeriodeRealisasiPrasyarat_periode').each(function(index, elm){
            var select = $(elm).val();
            if(select.length == 0){
                is_empty = 'Y';
            }
        });
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
        $('#FormPeriodeRealisasiPrasyarat_rkt')
                    .empty()
                    .append('<option selected="selected" value="<?=$rkt['tahun_mulai'];?>"><?=$rkt['tahun_mulai'];?></option>');
    
        $('#FormPeriodeRealisasiPrasyarat_rkt').change();
        
        var thnRKT = $('#FormPeriodeRealisasiPrasyarat_rkt').val();
        var formPrasyarat = <?= json_encode($formData); ?>;
        setPeriode(periodeRKT, thnRKT);

        $('#FormPeriodeRealisasiPrasyarat_rkt').change(function () {
            setPeriode(periodeRKT, this.value);
        });

        //console.log(formPrasyarat);
        $.each(formPrasyarat, function (index, element){
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
