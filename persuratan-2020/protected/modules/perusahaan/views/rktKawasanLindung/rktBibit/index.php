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
    'Rkt Bibits' => array('index'),
    'Manage',
);
$rku = Rku::model()->find('id_rku = ' . $rkt->id_rku);
$sektor = !empty($modelSiapLahan->search()->data) ? $modelSiapLahan->search()->data[0]->idBlok->id_sektor : '';
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Kelestarian Fungsi Produksi</h4>
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
                <label for="Rkt_tahun_mulai">Blok RKT Tahun Ke : </label>
                <div class="input-group">
                  
                    <input id="Rkt_tahun_mulai" class="span5 form-control ct-form-control" type="text" name="Rkt[tahun_mulai]" value="<?php echo $tahun; ?>">
                </div>
            </div>
<?php //echo $form->datePickerGroup($model,'tahun_mulai',array('widgetOptions'=>array('events'=>array('hide'=>'js:function(){$("#'.Yii::app()->controller->id.'-filtertahun-form").submit();}'), 'options' => array('format'=>'yyyy','startView'=>'decade','minViewMode'=>2,'autoclose'=>true ),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>'));  ?>
<?php $this->endWidget(); ?>
        </div>
    </div>
    <div id="tabs_rekap">
        <ul id="list_tabs" class="nav nav-tabs">
            <li class="active">
                <?php
                echo CHtml::link("Pengadaan Bibit", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktPembibitan/index/rkt/'.$rkt->id),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>
            <li>
                <?php
                echo CHtml::link("Penyiapan Lahan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktPenyiapanLahan/index/rkt/'.$rkt->id),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>            
            <li>
                <?php
                echo CHtml::link("Penanaman", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktPenanaman/index/rkt/'.$rkt->id),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                        
            <li>
                <?php
                echo CHtml::link("Pemeliharaan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktPemeliharaan/index/rkt/'.$rkt->id),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                    
            <li>
                <?php
                echo CHtml::link("Pemanenan", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktPemanenan/index/rkt/'.$rkt->id),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                                
            <li>
                <?php
                echo CHtml::link("Pemasaran", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktPemasaran/index/rkt/'.$rkt->id),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                                
            <!-- 
            <li>
                <?php
                echo CHtml::link("Penataan Areal", "#resuls_content", array(
                    "data-uri" => $this->createUrl('//perusahaan/rktPenataanAreal/index/rkt/'.$rkt->id),
                    "data-toggle" => "tab",
                    "aria-expanded" => "true",
                    "onclick" => "return ambilContent(this)"
                ));
                ?>
            </li>                                                            
            -->
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
        
		// ini di hapus aja
        /* $('#Rkt_tahun_mulai').change(function(){
            $("#<?=Yii::app()->controller->id;?>-filtertahun-form").submit();
        }); */
        
        $('#Rkt_tahun_mulai').datepicker({
            'format':'yyyy',
            'startView':2,
            'minViewMode':2,
            'autoclose':true,
            'language':'id',
            beforeShowYear: function (date){
                      if (date.getFullYear() < <?=$rku->tahun_mulai;?>) {
                        return false;
                      }
                      if(date.getFullYear() > <?=$rku->tahun_sampai;?>) {
                        return false;
                      }
                    }
        }).on('change', function(){
           $("#<?=Yii::app()->controller->id;?>-filtertahun-form").submit();
        });

        /*$('#FormPeriodeRekapPrasyarat_rkt').change(function(){
            //alert(this.value);
            $("#list_tabs").find('li.active > a').trigger('click');
        });*/
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
            }, 1000);
        }
    }
	
	function showAlasan(th){
		//alert($(th).attr("data-url"));
		var urlLink = $(th).attr("data-url");
		$('#modal_alasan').modal('show');
		
		$.ajax({
			url: urlLink ,
			type: 'GET',
			//dataType:"JSON",
			//data: formData,
			//async: false,
			beforeSend :function(){
				
				$('#content_alasan').html('<b>Loading...</b>');
			},
			complete  : function(){
				
			},
			success: function (data) {
				$('#content_alasan').html(data);
			},
			error: function(xhr, status, error) {
				// this will display the error callback in the modal.
				alert( xhr.status + " " +xhr.statusText + " " + xhr.responseText);
				
			},
			cache: false,
			/* contentType: false,
			processData: false */
		});
		
		
		return false;
	}

</script>

<div class="modal fade" id="modal_alasan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" id ="model_reverse_close" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 style="color: #000;text-align: center;" class="modal-title" id="myModalLabel">Alasan (Tidak Sesuai RKU)</h4>
			  </div>
			  <div class="modal-body" id="content_alasan">
					
			  </div>
			 <div class="modal-footer">
				<button type="button" id="modal_close" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>
		  </div>
 </div>
<?php
// Yii::app()->clientScript->registerScript("filter_tahun", "
// jQuery('#Rkt_tahun_mulai').datepicker({
//     'format':'yyyy',
//     'startView':'decade',
//     'minViewMode':2,
//     'autoclose':true,
//     'language':'id'
// }).on('change', function(){
//     $(\"#".Yii::app()->controller->id."-filtertahun-form\").submit();
// });
// ", CClientScript::POS_END);
/*
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

*/