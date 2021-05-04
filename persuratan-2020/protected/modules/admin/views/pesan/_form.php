<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => Yii::app()->controller->id . '-form',
    'type' => 'horizontal',
    'enableClientValidation' => true,
    'htmlOptions' => array(
           'enctype' => 'multipart/form-data',
        ),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'enableAjaxValidation' => false,
        ));
?>
<?php
$role = Yii::app()->user->findUser()->id_role;
$userBphp = Yii::app()->user->findUser()->id_bphp;
$userProv = Yii::app()->user->findUser()->id_propinsi;
$condition;
$list;


if($role == 1 || $role == 5){   // ADMIN  
    //$condition = array('provinsi'=>$userProv);
    //$list = CHtml::listData(AppUsers::model()->getByPropinsi($userProv));
    $list =  AppUsers::model()->getByAdmin();
    
    //print_r($list);die();
}

if($role == 4){   // DISHUT  
    //$condition = array('provinsi'=>$userProv);
    $list = AppUsers::model()->getByPropinsi($userProv);
    //$list = CHtml::listData(Perusahaan::model()->findAllByAttributes($condition), 'id_perusahaan', 'nama_perusahaan');
}
else if($role == 3){  //BPHP
    $list = AppUsers::model()->getByBphp($userBphp);
}

//print_r($list); die();

?>

<?php echo $form->errorSummary($model); ?>


 <?php //echo $form->dropDownList($model, 'penerima_id', $list, array('prompt' => '    ---------- Pilih Penerima ---------', 'multiple' => true, 'Selected' => 'Selected')); 

                echo $form->select2Group($model, 'penerima', array('groupOptions' => array('id' => 'nama_user'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'placeholder' => 'Pilih Penerima')))); ?>
    
<?php echo $form->textFieldGroup($model, 'subyek', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255)))); ?>
<?php echo $form->select2Group($model, 'tipe', array('groupOptions' => array('id' => "tipe"), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => array('1'=>'Surat Himbauan','2'=>'Surat Peringatan','3'=>'Surat Teguran'), 'htmlOptions' => array('class' => 'form-control ', 'placeholder' => Yii::t('app', '--- Pilih Jenis Surat ---'))))); ?>
<?php echo $form->textAreaGroup($model, 'isi', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength' => 255, 'rows'=>5)))); ?>

<div class="form-group">
    <label class="col-sm-3 control-label" for="LegalitasPerusahaan_tanggal">File SK (PDF)</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input name="file_lampiran" type="file">
        </div>
                    <i>Ukuran File Maksimal 2 Mb</i>
        <br>
        <?php
                if(!is_null($model->file_lampiran)) {
//                    $perusahaan = Perusahaan::model()->findByPk(Yii::app()->user->idPerusahaan());
//                    $ad = strtolower(str_replace(" ", "", $perusahaan->nama_perusahaan));
//                    $p = preg_replace("/[^A-Za-z0-9 ]/", '_', $ad);
                    echo "Upload File : <a href='".Yii::app()->createUrl('/').$model->file_lampiran."' target='_blank' class='btn btn-sm btn-primary'><i class='fa fa-file-pdf-o'></i></a>";
                }
        ?>
    </div>
</div>



<div class="form-group">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'submit',
            'context' => 'primary',
            'label' => $model->isNewRecord ? 'Kirim' : 'Simpan',
        ));
        echo ' ';
        $this->widget('booster.widgets.TbButton', array(
            'buttonType' => 'reset',
            'context' => 'danger',
            'size' => 'medium',
            'htmlOptions' => array('class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
            'label' => Yii::t('app', 'Batal'),
        ));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>




