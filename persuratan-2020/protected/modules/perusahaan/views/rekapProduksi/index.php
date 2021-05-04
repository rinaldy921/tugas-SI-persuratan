<?php
$this->breadcrumbs = array(
    'Realisasi RKT'
);
$listRKT = CHtml::listData(
                Rkt::model()->findAll(
                        array(
                            'condition' => 'id_perusahaan = ' . Yii::app()->user->idPerusahaan(),
                            'order' => 'tahun_mulai DESC'
                        )
                ), 'tahun_mulai', 'tahun_mulai'
);
//$periodeRKT = (new Rkt())->monthByRKT();
$formData = [
    ['id' => 'ganis', 'text' => 'Pengadaan Bibit', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/pengadaanBibit')],
    ['id' => 'batas_blok', 'text' => 'Penyiapan Lahan', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/penyiapanLahan')],
    ['id' => 'ruang_lindung', 'text' => 'Penanaman', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/penanaman')],
    ['id' => 'ruang_tdk_efektif', 'text' => 'Pemeliharaan', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/pemeliharaan')],
//    ['id' => 'ruang_tdk_efektif', 'text' => 'Pemeliharaan (Penyulaman)', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/penyulaman')],
//    ['id' => 'ruang_efektif', 'text' => 'Pemeliharaan (Penjarangan)', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/penjarangan')],
//    ['id' => 'areal_kerja', 'text' => 'Pemeliharaan (Pendangiran)', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/pendangiran')],
    ['id' => 'panen_luas_area', 'text' => 'Pemanenan RKT', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/pemanenanRkt')],
//    ['id' => 'panen_vol_prod_hasil', 'text' => 'Pemanenan Penyiapan Lahan', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/penyiapanLahan')],
//    ['id' => 'panen_vol_prod_lahan', 'text' => 'Pemanenan (Volume Produksi Penyiapan Lahan - LOA & Non LOA)', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/volumePenyiapanLahan')],
    ['id' => 'pemasaran', 'text' => 'Pemasaran', 'uri' => Yii::app()->createUrl('//perusahaan/rekapProduksi/tabpemasaran')],
];
$id_grid = Yii::app()->controller->id . '-filtertahun-form';
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rekapitulasi.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Rekapitulasi - Kelestarian Fungsi Produksi</h4>    
    <div class="row">
        <div class="col-md-4">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => 'form-periode-rekap',
                'type' => 'horizontal',
                'htmlOptions' => array('class' => 'well well-sm')
            ));
            ?>            
            <?php echo $form->hiddenField($periodeModel, 'id_perusahaan'); ?>
            <?php
            echo $form->select2Group($periodeModel, 'rkt', array(
                'labelOptions' => array('label' => 'RKT', 'class' => 'span7'),
                'widgetOptions' => array('options' => array('allowClear' => false, 'label' => false),
                    'data' => $listRKT,
                    'htmlOptions' => array('class' => 'span12', 'placeholder' => 'Pilih Periode RKT'))
                    )
            );
            ?>
<?php $this->endWidget(); ?>
        </div>
    </div>

    <div id="tabs_rekap">
        <ul id="list_tabs" class="nav nav-tabs">
            <li class="active">
                <?php
                echo CHtml::link("Pengadaan Bibit", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapProduksi/pengadaanBibit'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link("Penyiapan Lahan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapProduksi/penyiapanLahan'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>            
            <li>
                <?php
                echo CHtml::link("Penanaman", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapProduksi/penanaman'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                        
            <li>
                <?php
                echo CHtml::link("Pemeliharaan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapProduksi/pemeliharaan'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                    
            <li>
                <?php
                echo CHtml::link("Pemanenan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapProduksi/pemanenan'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                                
            <li>
                <?php
                echo CHtml::link("Pemasaran", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapProduksi/tabPemasaran'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                                
        </ul>
        <div class="tab-content">
            <div id="resuls_content">
                <div class="loader" style="text-align:center"><h3>Loading...</h3></div>
            </div>
        </div>
    </div>    
</div>
<script type="text/javascript">
    
    $(document).ready(function () {
        $("#list_tabs").find('li.active > a').trigger('click');
        
        $('#FormPeriodeRekapPrasyarat_rkt').change(function(){
            //alert(this.value);
            $("#list_tabs").find('li.active > a').trigger('click');
        });
    });
    
    
    
    
    function ambilContent(obj) {
        //$("#<?= CHtml::activeId($model, 'jenis_form') ?>").val($(obj).text());

        var temp = '<div class="loader" style="text-align:center"><h3>Loading...</h3></div>';
        $("#resuls_content").html(temp);
        var link = $(obj).data('uri');
        if (link != undefined) {
            $.ajax({
                type: "POST",
                data: $('#form-periode-rekap').serialize(),
                dataType: 'html',
                url: link,
                success: function (response, statusText, xhr, $form) {
                    $('#resuls_content').html(response);
                },
                error: function (error) {
                    $('#resuls_content').html(error.responseText);
                }
            });
        } else {
            setTimeout(function () {
                $("#resuls_content").html("Data tidak valid");
            }, 1000);
        }
    }

</script>