    <?php //echo CHtml::link("<i class='glyphicon glyphicon-plus'></i> " . Yii::t('app', 'Buat Data Baru'), array('createKawasanLindung'), array('class' => 'btn btn-primary'));?>

    <?php
        $criteria = new CDbCriteria();
        $criteria->distinct=true;
        $criteria->condition = "id_rkt=". $model->id_rkt ;
        $criteria->select = 'id_blok';
        $result = RktSiapLahan::model()->findAll($criteria);

        $id = "";
        foreach ($result as $key => $value) {
            $id .= $value['id_blok']. ",";
        }
        $id .= "0";

        $criteria = new CDbCriteria();
        $criteria->distinct=true;
        $criteria->condition = "id IN (". $id.")";
        $criteria->select = 'id_sektor';
        $result = BlokSektor::model()->findAll($criteria);
        $op = "<option value='0'>Semua Sektor</option>";
        foreach ($result as $key => $value) {
            $sektor = MasterSektor::model()->findByPk($value['id_sektor']);
            $op .= "<option value='".$value['id_sektor']."'>".$sektor->nama_sektor."</option>";
        }
    ?>

    <div class="col-md-5" style="margin-bottom:10px">
        <div class="form-group has-success">
            <label class="col-sm-3 control-label" for="LegalitasPerusahaan_jenis_legalitas">Pilih Sektor</label>
            <div class="col-sm-9">
                <select class="input-large form-control" placeholder="Jenis Legalitas" id="selecsiaplahan" name="selecsiaplahan" onchange="filterSektorselecsiaplahan()">
                    <?=$op?>
                </select>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function filterSektorselecsiaplahan()
        {
            var s = $("#selecsiaplahan").val();
            console.log(s);
             $.fn.yiiGridView.update("<?=Yii::app()->controller->id?>-siaplahan-grid",{data:"aksi=filterSektorRktSiapLahan&tahun=<?=$tahun?>&sektor="+s});
        }
    </script>


<?php $this->widget('booster.widgets.BootGroupGridView',array(
'id'=>Yii::app()->controller->id . '-siaplahan-grid',
'type' => 'bordered condensed',
'responsiveTable' => true,
'enableSorting'=>false,
'dataProvider'=>$model->search(),
'mergeColumns'=>array('id_jenis_lahan','sektor'),
'extraRowColumns'=> array('id_jenis_lahan'),
'extraRowTotals'=>function($data, $row, &$totals) {
     if(!isset($totals['jumlah'])) $totals['jumlah'] = 0;
     if(!isset($totals['realisasi'])) $totals['realisasi'] = 0;
     if(!isset($totals['persentase'])) {$totals['persentase'] = 0;$totals['pe'] = 0;}
     $totals['jumlah'] += $data['jumlah'];
     $totals['realisasi'] += $data['realisasi'];
     $totals['persentase'] += $data['persentase'];
     $totals['pe'] += 1;
 },
 'extraRowPos' => 'below',
 // 'extraRowExpression' => '"<span class=\"subtotal\">avg age - ".round($totals["jumlah"],2)."</span>"',
'extraNipzExpression' =>  '"<tr class=\"nipz-blue\">
    <td class=\"nipz-red text-left\" colspan=\"3\"><strong><i>Sub Total</i></strong></td>
    <td class=\"nipz-red\">".round($totals["jumlah"],2)."</td>
    <td class=\"nipz-red\">".round($totals["realisasi"],2)."</td>
    <td class=\"nipz-red\">".round(($totals["persentase"] / $totals["pe"]),2)."</td>"
',
'template' => '{items}',
'columns'=>array(
		array(
			'name'=>'id_jenis_lahan',
			'value'=>'$data->idJenisLahan->jenis_lahan',
			'footer' => '<strong>Total</strong>'
			// 'headerHtmlOptions' => array('style'=>'display:none'),
			// 'htmlOptions' =>array('style'=>'display:none'),
			// 'footerHtmlOptions' =>array('style'=>'display:none')
		),
		array(
			'name'=>'sektor',
			'value'=>'$data->idBlok->idSektor->nama_sektor',
			// 'footer' => '<strong>Total</strong>'
		),
		array(
			// 'header'=>'',
			'name'=>'id_blok',
			'value'=>'$data->idBlok->idBlok->nama_blok',
			'htmlOptions'=>array('style'=>'padding-left:30px'),
		),
		// 'jumlah',
		array(
			// 'header'=>'Jumlah',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'jumlah',
			'type'=>'raw',
			// 'value'=>'isset($data->jumlah) ? $data->jumlah : "coba" ',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktBibit/inputJumlahSiapLahan'),
				'success'=>'js:function() {
	                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-siaplahan-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
	            }'
			),
			'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'jumlah').'</strong>',
		),
		// 'realisasi',
		array(
			// 'header'=>'Realisasi',
			'class'=>'booster.widgets.TbEditableColumn',
			'name'=>'realisasi',
			'type'=>'raw',
			// 'value'=>'isset($data->realisasi) ? $data->realisasi : "coba" ',
			'editable'=> array('url'=>$this->createUrl('//perusahaan/rktBibit/inputJumlahSiapLahan'),
				'success'=>'js:function() {
	                $.fn.yiiGridView.update("'.Yii::app()->controller->id.'-siaplahan-grid",{data:"aksi=updateGrid&tahun='.$tahun.'"});
	            }'
			),
			'footer' => '<strong>'.$model->getTotal($model->search()->getData(), 'realisasi').'</strong>',
		),
		array(
            // 'header'=>'%',
            // 'value'=>'(isset($data->realisasi) && $data->realisasi > 0 && isset($data->jumlah) && $data->jumlah > 0) ? number_format(($data->realisasi / $data->jumlah) * 100) : "-"',
            // 'class'=>'TbPercentOfTypeEasyPieOperation'
            'name'=>'persentase',
            'value'=>'isset($data->persentase) ? $data->persentase : "0"',
            'footer' => '<strong>'.$model->getTotalPersen($model->search()->getData(), 'persentase').'</strong>',
        )
// array(
// 'class'=>'booster.widgets.TbButtonColumn',
// ),
),
)); ?>
