<?php $label = Logic::getLastLoginByPerusahan($iup->id_perusahaan); ?>
<?php
//die("VIEW");
$this->breadcrumbs = array(
    'Realisasi RKT'
);
$listRKT = CHtml::listData(
                Rkt::model()->findAll(
                        array(
                            'condition' => 'id_perusahaan = ' . $iup->idPerusahaan->id_perusahaan,
                            'order' => 'tahun_mulai DESC'
                        )
                ), 'tahun_mulai', 'tahun_mulai'
);
//debug($idPerusahaan);

$formPrasyarat = [
    ['id' => 'ganis', 'text' => 'Organisasi & Tenaga Kerja', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/ganis')],
    ['id' => 'batas_blok', 'text' => 'Penataan Batas Blok', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/tataBatas')],
    ['id' => 'ruang_lindung', 'text' => 'Penataan Ruang (Kawasan Lindung)', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/ruangLindung')],
    ['id' => 'ruang_tdk_efektif', 'text' => 'Penataan Ruang (Areal Tidak Efektif)', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/ruangNonEfektif')],
    ['id' => 'ruang_efektif', 'text' => 'Penataan Ruang (Areal Efektif)', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/ruangEfektif')],
    ['id' => 'areal_kerja', 'text' => 'Penataan Areal Kerja', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/arealKerja')],
    ['id' => 'buka_hutan', 'text' => 'Pembukaan Wialayah Hutan', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/bukaHutan')],
    ['id' => 'peralatan', 'text' => 'Pemasukan & Penggunaan Peralatan', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/peralatan')],
    ['id' => 'sarana', 'text' => 'Pembangunan Sarana & Prasarana', 'uri' => Yii::app()->createUrl('//admin/rekapPrasyarat/sarpras')]
];
$id_grid = Yii::app()->controller->id . '-filtertahun-form';
?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iup->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iup->idPerusahaan->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggak Keputusan</th>
                    <td><?= $this->getDateMonth($iup->tanggal) ?></td>
                    <th>Telepon</th>
                    <td><?= $iup->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Luas Areal</th>
                    <td><?= floatval($iup->luas) ?> Ha</td>
                    <th>Alamat</th>
                    <td><?= $iup->idPerusahaan->alamat ?></td>
                </tr>
                <tr>
                    <th></th>
                    <td></td>
                    <th>Login Terakhir</th>
                    <td class=""><?= $label ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
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
                    "data-uri" => $this->createUrl('//admin/rekapProduksi/pengadaanBibit'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link("Penyiapan Lahan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//admin/rekapProduksi/penyiapanLahan'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>            
            <li>
                <?php
                echo CHtml::link("Penanaman", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//admin/rekapProduksi/penanaman'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                        
            <li>
                <?php
                echo CHtml::link("Pemeliharaan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//admin/rekapProduksi/pemeliharaan'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                    
            <li>
                <?php
                echo CHtml::link("Pemanenan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//admin/rekapProduksi/pemanenan'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                                
            <li>
                <?php
                echo CHtml::link("Pemasaran", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//admin/rekapProduksi/tabpemasaran'),
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