<?php
	if(!empty($rku)) {
    	$rkt = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku = '. $rku->id_rku));
	}
?>

<div class="col-md-12">
	<h4>Export Data</h4>
	<p>Ceklis pada checkbox untuk memilih data yang akan di export.</p>
	<?php
	$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	    'id' => Yii::app()->controller->id . '-form',
	    'type' => 'horizontal',
	    'enableClientValidation' => false,
	    'clientOptions' => array(
	        'validateOnSubmit' => false,
	    ),
	    'enableAjaxValidation' => false,
	        ));
	?>
	<div class="well well-sm">
		<div class="checkbox">
			<label>
				<input id="checkAll" type="checkbox" name="Print[all]"> Semua Data
			</label>
		</div>
	</div>

	<div class="well well-sm">
		<div class="checkbox">
			<label>
				<input id="checkIup" type="checkbox" name="Print[iuphhk]"> Export Data IUPHHK?
			</label>
		</div>
	</div>
        
        <div class="well well-sm">
		<div class="checkbox">
			<label>
				<input id="checkIup" type="checkbox" name="Print[iuphhk]"> Company Profile
			</label>
		</div>
	</div>
        
        
	<div class="clearfix"></div>
	<?php if(!empty($rku)): ?>
		<div class="well well-sm">
			<h5><strong>Data RKU</strong></h5>
			<div class="checkbox">
				<label>
					<input id="checkAllRku" type="checkbox" name="Print[allRku]"> Semua
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input id="checkRku" type="checkbox" name="Print[rku][dataUmum]"> Legalitas
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input id="checkRku" type="checkbox" name="Print[rku][silvi]"> Sistem Silvikultur
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input id="checkRku" type="checkbox" name="Print[rku][prasyarat]"> Prasyarat
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input id="checkRku" type="checkbox" name="Print[rku][kelProd]"> Kelestarian Fungsi Produksi
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input id="checkRku" type="checkbox" name="Print[rku][kelLing]"> Kelestarian Fungsi Lingkungan
				</label>
			</div>
			<div class="checkbox">
				<label>
					<input id="checkRku" type="checkbox" name="Print[rku][kelSos]"> Kelestarian Fungsi Sosial
				</label>
			</div>
		</div>
	<?php endif; ?>

	<?php if(isset($rkt) && !empty($rkt)): ?>
		<div class="well well-sm">
			<h5><strong>Data RKT</strong></h5>
			<div class="checkbox">
				<label>
					<input id="checkAllRkt" type="checkbox" name="Print[allRkt]"> Semua
				</label>
			</div>
			<?php foreach($rkt as $key => $dt): ?>
				<div class="checkbox">
					<label>
						<input id="checkRkt" type="checkbox" name="Print[rkt][<?php echo $key;?>]" value="<?php echo $dt->tahun_mulai; ?>"> Tahun <?php echo $dt->tahun_mulai; ?>
					</label>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="form-group">
	    <div class="col-sm-3"></div>
	    <div class="col-sm-9">
	        <?php
	        $this->widget('booster.widgets.TbButton', array(
	        	'id' => 'export',
	            'buttonType' => 'submit',
	            'context' => 'primary',
	            'size' => 'small',
	            'label' => 'Export',
	            // 'ajaxOptions' => array(
	            // 	'dataType' => 'json',
	            // 	'type' => 'post',
	            // 	'success' => 'js:function(data) {
	            // 		alert(data);
	            // 	}'
	            // )
	        ));
	        echo ' ';
	        $this->widget('booster.widgets.TbButton', array(
	            'buttonType' => 'reset',
	            'context' => 'danger',
	            'size' => 'small',
	            // 'size' => 'medium',
	            'htmlOptions' => array('class' => 'basebottom', 'onclick' => "parent.$.fancybox.close()"),
	            'label' => Yii::t('app', 'Tutup'),
	        ));
	        ?>
	    </div>
	</div>

	<?php $this->endWidget(); ?>
</div>
<?php
Yii::app()->clientScript->registerScript("check","
	$('#checkAll').change(function() {
		$('input[type=checkbox]').prop('checked', this.checked);
	});

	$('#checkAllRku').change(function() {
		$('input[id=checkRku]').prop('checked', this.checked);
	});
	
	$('#checkAllRkt').change(function() {
		$('input[id=checkRkt]').prop('checked', this.checked);
	});

	$('input[type=checkbox]').change(function() {
		if($('input[type=checkbox]:checked').length > 0) {
			$('#export').prop('disabled',false);
			$('#export').attr('title','');
			$('#export').tooltip('disable');
		} else {
			$('#export').prop('disabled',true);
			$('#export').attr('data-original-title','Pilih/Ceklis data terlebih dahulu');
			$('#export').tooltip('enable');
		}
	});

	// $('#checkIup').change(function(){
	// 	if($('input[id=checkIup]:checked').length == $('#checkIup').length) {
	// 		alert('iup checked');
	// 	}
	// });
",CClientScript::POS_END);
Yii::app()->clientScript->registerScript("btn","
	$('#export').prop('disabled',true);
	$('#export').attr('title','Pilih/Ceklis data terlebih dahulu');
	$('#export').tooltip();
",CClientScript::POS_READY);