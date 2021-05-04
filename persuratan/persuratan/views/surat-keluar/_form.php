<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SuratMasuk;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SuratKeluar */
/* @var $form yii\widgets\ActiveForm */

$Surat = SuratMasuk::find()
        ->orderBy(['no_agenda'=>SORT_ASC])
        ->all();
$listSurat=ArrayHelper::map($Surat,"no_agenda","no_agenda","tangggal_agenda");

?>

<div class="surat-keluar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tanggal_surat_keluar')->textInput()->hint('yyyy-bb-tt contoh : 2021-04-25') ?>

    <?= $form->field($model, 'perihal_surat_keluar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_agenda')->dropdownList(
        $listSurat,
        ['prompt'=>'Select...']
        );
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
