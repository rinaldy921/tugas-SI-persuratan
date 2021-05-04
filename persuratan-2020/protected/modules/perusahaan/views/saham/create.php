<?php
// $this->breadcrumbs = array(
//     'Saham' => array('index'),
//     'Create',
// );
?>

    <h4 class="page-header">Data Saham</h4>
    <?php echo $this->renderPartial('_form', array('model' => $model, 'modal' => $modal,'id_legalitas'=>$id_legalitas)); ?>
