<?php
$this->breadcrumbs = array(
    'RKU' => array('index'),
    'Blok Sektor'
);
?>

<style media="screen">
/* grid border */
.grid-view table.items th, .grid-view table.items td {
border: 1px solid gray !important;
}

/* disable selected for merged cells */
.grid-view td.merge {
background: none repeat scroll 0 0 #F8F8F8;
}
</style>
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
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">

    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <div class="panel-title">Kelola Sektor UPHHK-HTI</div>
            </div>
        </div>

       
        <div class="panel-body">
  <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => Yii::app()->controller->id . '-form',
        'type' => 'horizontal',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'enableAjaxValidation' => false,
            ));
    ?>
            
            
            <?php //echo $form->checkBoxGroup($model, 'statusCheck', array('enableClientValidation' => false, 'widgetOptions' => array('options' => array(), 'htmlOptions' => array('id'=>'checkbox', 'checked' => false)))); ;?>

            <div class="well well-sm" id="sektor">
                <?php //echo $form->textFieldGroup($model, 'blok', array('groupOptions' => array('class' => 'display'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength'=>255)))); ?>
                <?php echo $form->select2Group($model, 'blok', array('labelOptions' => array('label' => 'Pilih Blok'), 'widgetOptions' => array('options' => array('allowClear' => true), 'data' => $list, 'htmlOptions' => array('class' => '', 'palceholder' => 'Pilih Blok')))); ?>

                <?php echo $form->textFieldGroup($model, 'sektor', array('groupOptions' => array('class' => 'display'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5', 'maxlength'=>255)))); ?>

                
                <?php //echo $form->textFieldGroup($model, 'id_sektor', array('widgetOptions' => array('htmlOptions' => array('class' => 'span5','maxlength'=>255))));?>
                
                <div id="generate-group" class="form-group">
                     <div class="col-md-3"></div>
                        <div class="col-md-9">
                        <button id="generate" class="btn btn-primary">Tambah Sektor</button>
                        </div>
                </div>
            </div>


            <?php // echo  $form->textFieldGroup($model, 'blok', array('labelOptions'=>array('class'=>'required'), 'groupOptions'=>array('id'=>'blok'), 'widgetOptions' => array('htmlOptions' => array('class' => 'span5')))); ?>

        </div>
   <?php $this->endWidget(); ?>
        
        
        <?php
      

        $this->widget('ext.groupgridview.GroupGridView', array(
          'id' => 'grid1',
          'dataProvider' => $modelblok,
          'mergeColumns' => 'Sektor',
          'columns' => array(
            array(
              'name'=>'Sektor',
              'value' => function($data) {
                  return $data['nama_sektor'];
              }
            ),
            array(
              'name' => 'Blok',
              'value' => function($data) {
                  return $data['nama_blok'];
              }
            ),
            array(
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => '{update} {delete2}',
                'buttons' => array(
                    'update' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Edit'),
                        // 'label' => '<i class="fa fa-pencil-square-o"></i>',
                        'label' => '<i class="fa fa-edit"></i>',
                        'url' => function($data) {
                            $url = "javascript:deleteSektor('".Yii::app()->createUrl("perusahaan/rku/deletebloksektor",array("id_blok"=>$data['id']))."',".$data['id'].")";
                            return $url;
                        }
                    ),
                    'delete2' => array(
                        'options' => array('data-toggle' => 'tooltip', 'title' => 'Hapus'),
                        // 'label' => '<i class="fa fa-pencil-square-o"></i>',
                        'label' => '<i class="fa fa-trash"></i>',
                        'url' => function($data) {
                            $url = "javascript:deleteSektor('".Yii::app()->createUrl("perusahaan/rku/deletebloksektor",array("id_blok"=>$data['id']))."',".$data['id'].")";
                            return $url;
                        }
                    ),
                )
            ),
          ),
        ));
        ?>
    </div>
</div>

