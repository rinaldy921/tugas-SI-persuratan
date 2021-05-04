<?php
//di setiap indez yang ajas agar datepicker nya jalan maka tambahkan ini
$cs = Yii::app()->clientScript;
$booster = Booster::getBooster();
$themeBase = Yii::app()->theme->baseUrl;
$boosterBase= $booster->getAssetsUrl();


$cs->registerCssFile($boosterBase.'/bootstrap-datepicker/css/datepicker3.css');
$cs->registerScriptFile($themeBase . '/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js', CClientScript::POS_END);
$cs->registerScriptFile($boosterBase . "/bootstrap-datepicker/js/bootstrap-datepicker-noconflict.js", CClientScript::POS_END);

$this->breadcrumbs = array(
    'Prasyarat' => array('index'),
    'Manage',
);
$rku = Rku::model()->find('id_perusahaan = ' . Yii::app()->user->idPerusahaan());
// $sektor = isset($arealKerja->search()->data[0]->idBlok->id_sektor) ? null : $arealKerja->search()->data[0]->idBlok->id_sektor;
?>
<style>
.deleteInFunction{
    cursor:pointer;
}
</style>
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt.php'; ?>        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Prasyarat</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-filtertahun-form',
                'type' => 'inline',
                'htmlOptions' => array('class' => 'well well-sm')
                    //     'enableClientValidation' => true,
                    //     'clientOptions' => array(
                    //         'validateOnSubmit' => true,
                    //     ),
                    // 'enableAjaxValidation'=>false,
            ));
            ?>
            <div class="form-group">
                <label for="Rkt_tahun_mulai">Tahun : </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                    <input id="Rkt_tahun_mulai" class="span5 form-control ct-form-control" type="text" name="Rkt[tahun_mulai]" value="<?php echo $tahun; ?>">
                </div>
            </div>
            <?php //echo $form->datePickerGroup($model,'tahun_mulai',array('widgetOptions'=>array('events'=>array('hide'=>'js:function(){$("#'.Yii::app()->controller->id.'-filtertahun-form").submit();}'), 'options' => array('format'=>'yyyy','startView'=>'decade','minViewMode'=>2,'autoclose'=>true ),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>'));  ?>

        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div id="tabs_rekap">
        <ul id="list_tabs" class="nav nav-tabs">
            <li class="active">
                <?php
                echo CHtml::link("Pembinaan dan Pemberdayaan Masyarakat", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktsosInfraMukim/index',array('rkt'=>$idRkt,)),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link("Pembinaan Kelembagaan Masyarakat", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktsosKerjasamaKoperasi/index',array('rkt'=>$idRkt,)),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link("Penanganan Konflik Sosial", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktsosPenangananKonflik/index',array('rkt'=>$idRkt,)),
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


});


function ambilContent(obj) {

        var temp = '<div class="loader" style="text-align:center"><h3>Loading...</h3></div>';
        $("#resuls_content").html(temp);
        var link = $(obj).data('uri');
        if (link != undefined) {
            $.ajax({
                type: "POST",
                //data: $('#form-periode-rekap').serialize(),
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
                console.log("ambilContent: Link undefined!");
            }, 1000);
        }
    }

</script>

<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
    jQuery('#Rkt_tahun_mulai').datepicker({
    'format':'yyyy',
    'startView':2,
    'minViewMode':2,
    'autoclose':true,
    'language':'id',
    beforeShowYear: function (date){
              if (date.getFullYear() < " . $rku->tahun_mulai . ") {
                return false;
              }
              if(date.getFullYear() > " . $rku->tahun_sampai . ") {
                return false;
              }
            }
}).on('change', function(){
    $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
});
", CClientScript::POS_END);
