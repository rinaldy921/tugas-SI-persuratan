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

$periodeRKT = (new Rkt())->monthByRKT();

$formData = [
    [
        'id' => 'ganis',
        'text' => 'Perlindungan & Pemberdayaan Masyarakat (Pembangunan Penyaluran Infrastruktur Pemukiman)',
        'uri' => Yii::app()->createUrl('//perusahaan/rekapSosial/pembangunanInfrastruktur')
    ],
    [
        'id' => 'batas_blok',
        'text' => 'Perlindungan & Pemberdayaan Masyarakat (Peningkatan SDM)',
        'uri' => Yii::app()->createUrl('//perusahaan/rekapSosial/peningkatanSDM')
    ],
    [
        'id' => 'ruang_lindung',
        'text' => 'Pembinaan Kelembagaan Masyarakat (Kerjasama Koperasi)',
        'uri' => Yii::app()->createUrl('//perusahaan/rekapSosial/kerjasamaKoperasi')
    ],
    [
        'id' => 'ruang_lindung2',
        'text' => 'Pembinaan Kelembagaan Masyarakat (Kemitraan Usaha)',
        'uri' => Yii::app()->createUrl('//perusahaan/rekapSosial/mitraUsaha')
    ]    
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
    <h4 class="page-header">Rekapitulasi - Kelestarian Fungsi Sosial</h4>    
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
                echo CHtml::link("Perlindungan & Pemberdayaan Masyarakat", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapSosial/pemberdayaan'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link("Pembinaan Kelembagaan Masyarakat", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapSosial/pembinaan'),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>            
            <li>
                <?php
                echo CHtml::link("Penanganan Konflik Sosial", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rekapSosial/konflik'),
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