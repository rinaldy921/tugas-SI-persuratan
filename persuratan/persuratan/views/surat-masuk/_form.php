<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\StafPengolah;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SuratMasuk */
/* @var $form yii\widgets\ActiveForm */


$staf = StafPengolah::find()
        ->orderBy(['lama_proses'=>SORT_ASC])
        ->all();
// $staf=StafPengolah::find()->all();
$listkinerja=ArrayHelper::map($staf,"id_staf", "nama");
?>

<div class="surat-masuk-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tangggal_agenda')->textInput()->hint('yyyy-bb-tt contoh : 2021-04-25') ?>

    <?= $form->field($model, 'no_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_surat')->textInput()->hint('yyyy-bb-tt contoh : 2021-04-25') ?>

    <?= $form->field($model, 'asal_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perihal_surat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_staf')->radioList(
        $listkinerja,
        ['prompt'=>'Select...']
        );
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
