<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SuratMasukSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="surat-masuk-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_agenda') ?>

    <?= $form->field($model, 'tangggal_agenda') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'tanggal_surat') ?>

    <?= $form->field($model, 'asal_surat') ?>

    <?php // echo $form->field($model, 'perihal_surat') ?>

    <?php // echo $form->field($model, 'id_staf') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
