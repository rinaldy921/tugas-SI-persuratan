<?php $this->breadcrumbs=array(
	'General Rekap',
);?>
<div class="">&nbsp;</div>
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=> Yii::app()->controller->id . '-form',
    'type'=>'horizontal',
    'enableClientValidation' => false,
	'enableAjaxValidation'=>false,
));?>
<?php echo $form->textFieldGroup($model,'nama_user',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span2')))); ?>
<?php echo $form->hiddenField($model,'jenis_form'); ?>
<?php $this->endWidget(); ?>

<div class="col-md-12">
	<div id="tabs_rekap">
		<ul id="list_tabs" class="nav nav-tabs">
			<li class="active">
				<?php echo CHtml::link("Home", "#resuls_content", array(
					"data-uri"=>$this->createUrl('//admin/generalRekap/ambilContent'),
					"data-toggle"=>"tab",
					"aria-expanded"=>"true",
					"onclick"=>"return ambilContent(this)"
				)); ?>
			</li>
			<li>
				<?php echo CHtml::link("Profile", "#resuls_content", array(
					"data-uri"=>$this->createUrl('//admin/generalRekap/ambilContent'),
					"data-toggle"=>"tab",
					"aria-expanded"=>"false",
					"onclick"=>"return ambilContent(this)"
				)); ?>
			</li>
			<li>
				<?php echo CHtml::link("Messages", "#resuls_content", array(
					"data-uri"=>$this->createUrl('//admin/generalRekap/ambilContent'),
					"data-toggle"=>"tab",
					"aria-expanded"=>"false",
					"onclick"=>"return ambilContent(this)"
				)); ?>
			</li>
		</ul>
		<div class="tab-content">
			<div id="resuls_content">
				<div class="loader" style="text-align:center"><h3>Loading...</h3></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#list_tabs").find('li.active > a').trigger('click');
	function ambilContent(obj){
		$("#<?=CHtml::activeId($model, 'jenis_form')?>").val($(obj).text());

		var temp = '<div class="loader" style="text-align:center"><h3>Loading...</h3></div>';
		$("#resuls_content").html(temp);
		var link = $(obj).data('uri');
		if (link != undefined){
			$.ajax({
				type: "POST",
				data: $('#<?=Yii::app()->controller->id . '-form'?>').serialize(),
				dataType: 'html',
				url: link,
				success: function (response, statusText, xhr, $form) {
					$('#resuls_content').html(response);
				},
				error: function (error){
					$('#resuls_content').html(error.responseText);
				}
			});
		}else{
			setTimeout(function(){
				$("#resuls_content").html("Data tidak valid");
			}, 1000);
		}
	}
</script>