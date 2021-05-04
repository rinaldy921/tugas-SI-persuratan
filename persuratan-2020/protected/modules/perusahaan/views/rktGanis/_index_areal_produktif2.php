

<?php
$idrkt = Yii::app()->user->setState('idRkt', $idRkt);
// $blok = BlokSektor::model()->findAll(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
// foreach($bloksektor as $bl) {
    // $areal = new CActiveDataProvider('RktArealProduktif', array(
    //     'criteria'=>array(
    //         'condition'=>'id_blok = '.$bl->id_blok.' AND id_rkt = '. $idRkt
    //     )
    // ));
    $this->widget('booster.widgets.TbListView', array(
    'id' => Yii::app()->controller->id.'-arealproduktif',
    'dataProvider' => $model,
    'itemView' => '_list',
    // 'pagerCssClass' => 'pagination col-sm-12',
    // 'replaceContent' => true,
    // 'pager' => array(
    //     'class' => 'booster.widgets.TbPager',
    //     'loadMore' => true,
    //     'containerHtmlOptions' => array('style' => 'margin-right:-15px'),
    // ),
    'template' => '{items}',
));
    // echo '<tr><td><strong>Sub Total</strong></td>';
    // $total = 0;
    // foreach($areal->data as $ar) {
    //     $total+=(float) $ar->jumlah;
    // }
    // echo '<td><strong>'.round($total,2).'</strong></td></tr>';
// }
// var_dump($model->search()->data);die;
// $this->widget('booster.widgets.TbListView', array(
//     'id' => Yii::app()->controller->id.'-arealproduktif-grid',
//     'dataProvider' => $model,
//     'itemView' => '_list',
//     // 'pagerCssClass' => 'pagination col-sm-12',
//     // 'replaceContent' => true,
//     // 'pager' => array(
//     //     'class' => 'booster.widgets.TbPager',
//     //     'loadMore' => true,
//     //     'containerHtmlOptions' => array('style' => 'margin-right:-15px'),
//     // ),
//     'template' => '{items}',
// ));
?>
