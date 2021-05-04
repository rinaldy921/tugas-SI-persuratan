<?php
/* @var $this RktBulanController */
/* @var $model RktBulan */

$this->breadcrumbs=array(
	'Rkt Bulan'=>array('index'),
	'Create',
);
?>

<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_realisasi.php'; ?>       </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Tambah Rkt Bulan</div>
            </div>
        </div>
        
    <div class="panel-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>