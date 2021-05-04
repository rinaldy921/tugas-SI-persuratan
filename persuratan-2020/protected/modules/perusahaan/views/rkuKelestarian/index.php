<?php
$this->breadcrumbs = array(
    'Kelestarian Fungsi Produksi'
);
?>
<style>
.deleteInFunction{
	cursor:pointer;
}
</style>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Kelestarian Fungsi Produksi</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-filtertahun-form',
//                'type' => 'inline',
                'htmlOptions' => array('class' => 'well well-sm form-inline')
            ));
            ?>
            <div class="form-group">
                <label for="Rku_periode">Periode Tahun : </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                    <input id="Rku_periode" class="span5 form-control ct-form-control" type="text" name="Rku[periode]" value="<?php echo $rku->tahun_mulai . ' - ' . ($rku->tahun_mulai + 9); ?>" placeholder="Pilih Periode RKU">
                </div>
            </div>
            <?php
            echo $form->datePickerGroup($rku, 'tahun_mulai', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array(), 'labelOptions' => array(), 'wrapperHtmlOptions' => array()));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'root-kelestarian',
//        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Pengadaan Bibit',
                'content' => $this->renderPartial('_index_bibit', array('model' => $bibit, 'rku'=>$rku), true),
                'active' => true
            ),
            array(
                'label' => 'Penyiapan Lahan',
                'content' => $this->renderPartial('_index_siap_lahan', array('model' => $siapLahan,'rku'=>$rku), true),
            ),
            array(
                'label' => 'Penanaman',
                'content' => $this->renderPartial('_index_penanaman', array('model' => $penanaman,'rku'=>$rku), true),
            ),
            array(
                'label' => 'Pemeliharaan',
                'content' => $this->renderPartial('_index_pemeliharaan', array('model' => $pemeliharaan,'rku'=>$rku), true),
            ),
            array(
                'label' => 'Pemanenan',
                'content' => $this->renderPartial('_index_pemanenan', array('panen' => $panen,'hhbk'=>$hhbk,'rku'=>$rku), true),
            ),
            array(
                'label' => 'Pemasaran',
                'content' => $this->renderPartial('_index_pemasaran', array('pasar' => $pasar,'pasarhhbk'=>$pasarhhbk,'rku'=>$rku), true),
            )    
            // array(
            //     'label' => 'Pemasaran',
            //     'content' => $this->renderPartial('_index_pemasaran', array('pasar' => $pasar,'pasarhhbk' => $pasarhhbk, 'rku'=>$rku), true),
            // )
        ),
    ));
    $this->endWidget();
    ?>
</div>


<script>
function deleteData(th){
		//alert($(th).attr("data-url"));
		var urlLink = $(th).attr("data-url");
		var idGrid = $(th).attr("data-grid");
		if (confirm("Apakah anda yakin ingin menghapus item ini ?") == true) {
			//return true;
			//var th = this,
			afterDelete = function(){};
			jQuery('#'+idGrid).yiiGridView('update', {
				type: 'POST',
				url: urlLink,
				success: function(data) {
					jQuery('#'+idGrid).yiiGridView('update');
					afterDelete(th, true, data);
				},
				error: function(XHR) {
					return afterDelete(th, false, XHR);
				}
			});
		  } else {
			//return false;
		  }
		return false;
	}


</script>
<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
jQuery('#Rku_periode').datepicker({
    format: { /* Say our UI should display a week ahead, but textbox should store the actual date. This is useful if we need UI to select local dates, but store in UTC */
        toDisplay: function (date, format, language) {
            var d = new Date(date);
            d = d.getFullYear() + ' - '+ (d.getFullYear() + 9);
            return d;
        },
        toValue: function (date, format, language) {
            var d = new Date(date);
            d.setDate(d.getDate() + 7);
            return new Date(d);
        }
    },
    'startView':'decade',
    'minViewMode':2,
    'autoclose':true,
    'language':'id'
}).on('change', function(){
    $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
});
", CClientScript::POS_END);
