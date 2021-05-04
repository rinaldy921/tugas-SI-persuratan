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

$formData = [
    [
        'id' => 'ganis',
        'text' => 'Perlindungan & Pengamanan Hutan',
        'uri' => Yii::app()->createUrl('//perusahaan/realisasiLingkunganDungtan/index')
    ],
    [
        'id' => 'batas_blok',
        'text' => 'Pengendalian Hama & Penyakit',
        'uri' => Yii::app()->createUrl('//perusahaan/realisasiKendaliHama/index')
    ],
    [
        'id' => 'ruang_lindung',
        'text' => 'Pengendalian Kebakaran',
        'uri' => Yii::app()->createUrl('//perusahaan/realisasiKendaliKebakaran/index')
    ]
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
    <h4 class="page-header">Realisasi RKT - Kelestarian Fungsi Lingkungan</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => $id_grid,
                'type' => 'horizontal',
                'htmlOptions' => array('class' => 'well well-sm')
            ));
            ?>
            <?php echo $form->select2Group($periodeModel, 'form', array(
                'widgetOptions' => array(
                    'options' => array(
                        'allowClear' => true
                    ),
                    'htmlOptions' => array(
                        'class' => '',
                        'placeholder' => 'Pilih Jenis Form'
                    )
                )
            ));?>            
            <?php echo $form->hiddenField($periodeModel, 'tahun_periode', array());?>
            <?php echo $form->select2Group($periodeModel, 'rkt', array(
                'labelOptions' => array('label' => 'RKT', 'class' => 'span7'),
                'widgetOptions' => array('options' => array('allowClear' => true),
                    'data' => $listRKT,
                    'htmlOptions' => array('class' => 'span12', 'placeholder' => 'Pilih Periode RKT'))
                    )
            );?>
            <?php echo $form->select2Group($periodeModel, 'periode', array(
                'widgetOptions' => array(
                        'options' => array(
                            'allowClear' => true
                        ),
                        'htmlOptions' => array(
                            'class' => '',
                            'placeholder' => 'Pilih Periode Realisasi'
                        )
                    )
                )
            );?>
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
        if($('select').val()==''){
            alert('Silahkan, isi form yang telah disediakan');
        }else{
            $('#grid-content').empty();
            $('#grid-content').html('<div style="text-align:center;"><img src="<?php echo Yii::app()->baseUrl . '/img/ajax-loader.gif'; ?>"/></div>');
            var link = $('#<?=CHtml::activeId($periodeModel, "form")?>').find(":selected").data('uri');
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
        var formPrasyarat = <?= json_encode($formData); ?>;
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