<?php
/* @var $this RoleUserController */
/* @var $model RoleUser */

$this->breadcrumbs=array(
	
	'Group User'=>array('index'),
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
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
 <h4 class="page-header">Detil Group User</h4>
 
 

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nama_role',
                'deskripsi',
		'created_at',
		'modified_at',
	),
)); ?>

 <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <?php
             
                echo ' ';
                $this->widget('booster.widgets.TbButton', array(
                    'buttonType' => 'reset',
                    'context' => 'danger',
                    'size' => 'medium',
                    'htmlOptions' => array('class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
                    'label' => Yii::t('app', 'Kembali'),
                ));
                ?>
            </div>
        </div>
