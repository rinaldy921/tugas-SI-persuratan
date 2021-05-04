<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SuratKeluarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Surat Keluar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-keluar-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Surat Keluar', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_surat_keluar',
            'tanggal_surat_keluar',
            'perihal_surat_keluar',
            'no_agenda',
            [
                'label' => 'Tanggal Agenda',
                'value' => 'noAgenda.tangggal_agenda',
            ],
            [
                'label' => 'Staf Pengelola',
                'value' => 'noAgenda.staf.nama',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
