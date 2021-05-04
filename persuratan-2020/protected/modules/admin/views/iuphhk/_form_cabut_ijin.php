<?php
$themeBase = Yii::app()->theme->baseUrl;

$dateJs  = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$dateCss = $themeBase . "/assets/bootstrap/datepicker/css/bootstrap-datepicker3.min.css";
?>
    <!-- <h4 class="page-header">Data LegalitasPerusahaan</h4> -->
    <link rel="stylesheet" type="text/css" href="<?=$dateCss?>" />
    <script type="text/javascript" src="<?=$dateJs?>"></script>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>
<p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>
<?php echo $form->errorSummary($model); ?>

<?php echo $form->textFieldGroup($model, 'no_sk_pencabutan', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50,'id' => "nosk")))); ?>

<?php echo $form->datePickerGroup($model, 'tgl_dicabut', array('widgetOptions' => array('options' => array('format' => 'yyyy-mm-dd', 'autoclose' => true, 'todayHighlight' => true), 'htmlOptions' => array('class' => 'span5 tangal' ,'id'=>"tgl_cabut")), 'append' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

<p>Keterangan Dicabut:</p>

<?php echo $form->textArea($model, "keterangan_dicabut", array('style'=>'width: 100%; height: 80px;' ,'class'=>'span5','id'=>"ket_cabut")); ?>
<br><br>

<button type="button" name="button" class="btn btn-primary pull-right" onclick="cabutijin(<?=$model->id_iuphhk?>)">Simpan</button>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $(".tangal").datepicker({'autoclose':true,'format':'yyyy-mm-dd','language':'id'});
    });

    function cabutijin(id)
    {
        var no = $("#nosk").val();
        var tgl = $("#tgl_cabut").val();
        var ket = $("#ket_cabut").val();
        if(no == "") {
            swal("Warning", "No SK Harus diisi", "warning");
            return false;
        }
        if(tgl == "") {
            swal("Warning", "Tgl Dicabut Harus diisi", "warning");
            return false;
        }
        if(ket == "") {
            swal("Warning", "Keterangan Harus diisi", "warning");
            return false;
        }


        swal({
          title: "Konfirmasi?",
          text: "Cabut ijin usaha?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
              var form = new FormData($("#<?=Yii::app()->controller->id . '-form'?>")[0]);
              $.ajax({
                type: "POST",
                data: form,
                dataType: "json",
                contentType: false,
                processData: false,
                url: "<?=Yii::app()->createUrl("/admin/iuphhk/cabutijin",array('id'=>$model->id_iuphhk))?>",
                success: function(result) {
                    swal(result.header, result.message, result.status).then((ok) => {
                        $.fn.yiiGridView.update("iuphhk-hti-grid");
                        $("#modal").modal("hide");
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal("Error submiting!", xhr.responseText, "error");
                }
            });
          } else {
            // swal("Your imaginary file is safe!");
          }
        });
    }
</script>
