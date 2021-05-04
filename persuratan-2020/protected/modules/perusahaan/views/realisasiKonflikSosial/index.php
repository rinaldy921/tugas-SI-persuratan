<style media="screen">
    #<?php echo Yii::app()->controller->id ?>-realisasi-grid th{
        text-align: center;
        vertical-align: middle
    }
</style>
<?php $box = $this->beginWidget(
    'booster.widgets.TbPanel',
    array(
        'title' => 'Konflik Sosial',
        'headerIcon' => 'save'
    )
);?>
    <center><h3>Konflik Sosial</h3></center>
    <?php $this->widget(
        'booster.widgets.TbButton',
        array(
            'label' => Yii::t('app', 'Buat Data Baru'),
            'icon' => "plus",
            'context' => 'primary',
            'htmlOptions' => array(
                'data-uri' => Yii::app()->createUrl('//perusahaan/realisasiKonflikSosial/create'),
                'onClick' => 'loadContent(this)'
            ),
        )
    );?>
    <div class="data-form" style="display:none">
        <div class="panel panel-default" style="padding:5px;margin-top:5px;">
            <?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-form',
                'type' => 'horizontal',
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'enableAjaxValidation' => false,
            ));?>
            <?php echo $form->hiddenField($modelRealisasi,'id'); ?>
            <?php echo $form->hiddenField($modelRealisasi,'id_bulan'); ?>
            <?php echo $form->hiddenField($modelRealisasi,'tahun'); ?>
            <?php echo $form->dropDownListGroup($modelRealisasi, 'id_rkt_konflik_sosial', array(
                'enableAjaxValidation' => false,
                'widgetOptions' => array(
                    'data' => $jenis_konflik,
                    'htmlOptions' => array(
                        'empty' => Yii::t('app', 'Pilih Jenis...'),
                        'maxlength' => 4
                    )
                )
            )); ?>
            <?php echo $form->textAreaGroup($modelRealisasi,'penanganan',array('widgetOptions'=>array('htmlOptions'=>array('rows'=>5)))); ?>
            <?php echo $form->textFieldGroup($modelRealisasi, 'status', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 50)))); ?>
            <?php echo $form->textFieldGroup($modelRealisasi, 'persentase', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class' => 'span2',
                        'maxlength' => 50
                    )
                )
            )); ?>
            <div class="form-group">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <?php $this->widget(
                        'booster.widgets.TbButton',
                        array(
                            'buttonType' => 'submit',
                            'context' => 'primary',
                            'label' => 'Simpan',
                            'htmlOptions' => array(
                                'id' => 'submitID'
                            ),
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>

    <div class="grid-view">
        <table class="items table table-bordered table-condensed table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jenis Konflik</th>
                    <th>Penanganan</th>
                    <th>Status</th>
                    <th>Persentase</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php if(count($modelRealisasi->search()->getData()) > 0): ?>
                <?php foreach($modelRealisasi->search()->getData() as $key => $value): ?>
                    <?php
                        $modRealisasi = RealisasiRktKonflikSosial::model()->findByPk($value['id']);
                        $endpoint = Yii::app()->createUrl('//perusahaan/realisasiKonflikSosial/inputRealisasi');
                    ?>
                    <tr>
                        <td><?=$key+1;?></td>
                        <td><?=$modRealisasi->idRktKonflikSosial->jenis_konflik;?></td>
                        <td>
                            <?php $this->widget(
                                'booster.widgets.TbEditableField',
                                array(
                                    'type' => 'textarea',
                                    'model' => $modRealisasi,
                                    'attribute' => 'penanganan',
                                    'url' => $endpoint,
                                )
                            );?>
                        <td>
                            <?php $this->widget(
                                'booster.widgets.TbEditableField',
                                array(
                                    'type' => 'text',
                                    'model' => $modRealisasi,
                                    'attribute' => 'status',
                                    'url' => $endpoint,
                                )
                            );?>
                        </td>
                        <td>
                            <?php $this->widget(
                                'booster.widgets.TbEditableField',
                                array(
                                    'type' => 'text',
                                    'model' => $modRealisasi,
                                    'attribute' => 'persentase',
                                    'url' => $endpoint,
                                )
                            );?>
                        </td>
                        <td style="width:50px;text-align:center">
                            <?php echo CHtml::link('<span class="fa fa-trash"></span>', array('//perusahaan/realisasiKonflikSosial/delete', 'id'=>$value['id']), array(
                                'onClick'=>'return removeMe(this)'
                            )); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Data tidak ditemukan</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $this->endWidget(); ?>

<div id="frmInput" class="modal fade" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <a class="close" data-dismiss="modal">&times;</a>
                <h4>Form Realisasi</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'context' => 'primary',
                        'label' => 'Simpan',
                        'htmlOptions' => array(
                            'onClick' => '$("#'. Yii::app()->controller->id . '-form' .'").submit();'
                        )
                    )
                ); ?>
                <?php $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'label' => 'Close',
                        'url' => '#',
                        'htmlOptions' => array(
                            'id' => 'closeID',
                            'data-dismiss' => 'modal'
                        ),
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function removeMe(obj){
        $.ajax({
            type: "POST",
            data:$('#<?=Yii::app()->controller->id . '-form'?>').serialize(),
            url:$(obj).attr('href'),
            dataType: 'JSON',
            success:function(response, statusText, xhr, $form){
                if(response.status == 'OK'){
                    $('#subm').trigger('click');
                }else{
                    alert(response.pesan);
                }
            },
            error: function(response, statusText, xhr, $form){
                alert(response.responseText);
            }
        });
        // $(obj).parents('tr').remove();
        return false;
    }
    function loadContent(obj){
        $('.data-form').slideToggle();
        return false;
    }
    $("#<?=Yii::app()->controller->id . '-form'?>").on("submit", function(){
        $('#submitID').attr('disabled','disabled');
        $('#submitID').text('Harap tunggu ...');

        $.ajax({
            type: "POST",
            data:$('#<?=Yii::app()->controller->id . '-form'?>').serialize(),
            url:$('#<?=Yii::app()->controller->id . '-form'?>').attr('action'),
            dataType: 'JSON',
            success:function(response, statusText, xhr, $form){
                $('#submitID').removeAttr('disabled');
                $('#submitID').text('Simpan');
                if(response.status == 'OK'){
                    $('#subm').trigger('click');
                }else{
                    alert(response.pesan);
                }
            },
            error: function(response, statusText, xhr, $form){

            }
        });
        return false;
    })
</script>