<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="panel-title">Form Isian Data UPHHK-HTI</div>
        </div>
    </div>

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
    <div class="panel-body">
        <p class="help-block">Kolom dengan tanda <span class="required">*</span> harus diisi.</p>

        <?php // echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldGroup($model, 'id_perusahaan', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'value' => Yii::app()->user->idPerusahaan())))); ?>

        <?php echo $form->textFieldGroup($model, 'nomor', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>

        <?php echo $form->datePickerGroup($model, 'tanggal', array('widgetOptions' => array('options' => array('autoclose' => true, 'format' => 'yyyy-mm-dd'), 'htmlOptions' => array('class' => 'span5')), 'append' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

        <?php echo $form->textFieldGroup($model, 'luas', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->textFieldGroup($model, 'investasi_rupiah', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->textFieldGroup($model, 'investasi_dolar', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        <?php echo $form->datePickerGroup($model, 'tgl_start', array('widgetOptions' => array('options' => array('autoclose' => true, 'format' => 'yyyy-mm-dd'), 'htmlOptions' => array('class' => 'span5')), 'append' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

        <?php echo $form->datePickerGroup($model, 'tgl_end', array('widgetOptions' => array('options' => array('autoclose' => true, 'format' => 'yyyy-mm-dd'), 'htmlOptions' => array('class' => 'span5')), 'append' => '<i class="glyphicon glyphicon-calendar"></i>')); ?>

        <?php echo $model->isNewRecord ? $form->checkBoxGroup($model, 'statusCheck', array('enableClientValidation' => false, 'widgetOptions' => array('options' => array(), 'htmlOptions' => array('id'=>'checkbox', 'checked' => false)))) : '' ;?>

        <div class="well well-sm" id="sektor">
            <?php echo $form->textFieldGroup($model, 'sektor', array('groupOptions'=>array('id'=>'sektorgroup'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5','id'=>'isi_sektor'))));?>
            <div id="generate-group" class="form-group">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <button id="generate" class="btn btn-primary">Generate</button>
                </div>
            </div>
        </div>

        <div class="well well-sm" id="generatedblok"></div>

        <?php echo $model->isNewRecord ? $form->textFieldGroup($model, 'blok', array('labelOptions'=>array('class'=>'required'), 'groupOptions'=>array('id'=>'blok'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))) : ''; ?>

    </div>
    <div class="panel-footer">
        <!--        <div class="form-group">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">-->
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'htmlOptions' => array('class' => 'btn-sm','id'=>'nipzsubmit'),
            'context' => 'primary',
            'label' => 'Simpan',
        ));
        ?>
        <!--</div>-->
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$cs = Yii::app()->clientScript;
$cs->registerScript('sektor', "
$('#blok label').append(' <span class=\"required\">*</span>');
$('#sektor').hide();
$('#generatedblok').hide();
$('#checkbox').change(function() {
    if (this.checked) {
        $('#sektor').show('slow');
        $('#blok').hide('slow');
        $('button[type=\"submit\"]').prop('disabled',true);
    }else{
        $('#sektor').hide('slow');
        $('#blok').show('slow');
        $('button[type=\"submit\"]').prop('disabled',false);
        $('#generatedblok').children().remove();
        $('#generatedblok').hide();
    }
});

$('#generate').click(function(e){
    e.preventDefault();
    var val = $('#isi_sektor').val();
    if(val == '') {
        $('#Iuphhk_sektor_em_').prop('style',false);
        $('#Iuphhk_sektor_em_').text('Silahkan isi jumlah sektor');
    }else {
        for(var i=0; i<val;i++) {
            var c = i+1;
            $('#sektor').hide('slow');
            $('#sektor').hide('slow');
            $('#generatedblok').show('slow');

            $('#generatedblok').append('<div class=\"form-group\"> \
                <label for=\"Iuphhk_blok_'+i+'\" class=\"col-md-3 control-label\">Jumlah Blok Sektor '+c+'</label> \
                <div class=\"col-md-3\"> \
                    <input id=\"blokcustom'+i+'\" class=\"span2 form-control\" type=\"text\" name=\"Iuphhk[blokcustom]['+i+']\" placeholder=\"contoh : 3\"/> \
                    <div id=\"Iuphhk_blokcustom_em_'+i+'\" class=\"help-block\" style=\"display:none\"></div> \
                </div> \
            </div>');
        }
        $('button[type=\"submit\"]').prop('disabled',false);
    }
});

$('#nipzsubmit').click(function(e) {
    var blok = $('#generatedblok').children().length;
    var tt = '';
    for(var j=0;j<blok;j++) {
        var cing = $('#blokcustom'+j).val();
        if(cing == '') {
            $('#Iuphhk_blokcustom_em_'+j).prop('style',false);
            $('#Iuphhk_blokcustom_em_'+j).text('Jumlah blok tidak boleh kosong');
            tt = 'true';
        } else if(!cing.match(/^\d+$/)) {
            $('#Iuphhk_blokcustom_em_'+j).prop('style',false);
            $('#Iuphhk_blokcustom_em_'+j).text('Isikan hanya angka');
            tt = 'true';
        } else {
            $('#Iuphhk_blokcustom_em_'+j).prop('style','display:none');
        }
    }
    if(tt == 'true') {
        return false;
    }
    if($('#checkbox').prop('checked') == false) {
        if($('#blok input').val() == '') {
            alert($(this).val());
            $('#Iuphhk_blok_em_').prop('style',false);
            $('#Iuphhk_blok_em_').text('Jumlah blok tidak boleh kosong');
            return false;
        }
    }
});
", CClientScript::POS_END);
$cs->registerScript('numeric',"
$('#blok input').keydown(function (e) {

        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||

            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||

            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }

        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
", CClientScript::POS_READY);
