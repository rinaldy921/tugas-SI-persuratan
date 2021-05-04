<?php
$this->breadcrumbs = array(
    'Hidrologi' => array('index'),
    'Update Sungai',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
<?php require_once dirname(__FILE__) . '/../layouts/menu_data_pokok_areal_kerja.php'; ?>        
        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Update Data Sungai</h4>
<?php echo $this->renderPartial('_form_sungai', array('model' => $model,)); ?>
</div>