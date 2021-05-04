<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StafPengolahSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staf-pengolah-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_staf') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'lama_proses') ?>

    <?= $form->field($model, 'kinerja') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
