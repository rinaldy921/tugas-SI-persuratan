<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StafPengolahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Kinerja Staf Pengolah';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staf-pengolah-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Staf Pengolah', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_staf',
            'nama',
            'lama_proses',
            'kinerja',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
