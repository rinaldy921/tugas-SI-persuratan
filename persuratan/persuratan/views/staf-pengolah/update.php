<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StafPengolah */

$this->title = 'Update Staf Pengolah: ' . $model->id_staf;
$this->params['breadcrumbs'][] = ['label' => 'Staf Pengolahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_staf, 'url' => ['view', 'id' => $model->id_staf]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staf-pengolah-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
