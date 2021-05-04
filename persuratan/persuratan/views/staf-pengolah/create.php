<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StafPengolah */

$this->title = 'Create Staf Pengolah';
$this->params['breadcrumbs'][] = ['label' => 'Staf Pengolahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staf-pengolah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
