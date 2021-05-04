<?php /*
<div id="rkt_alasan_tidak_sesuai_rku" class="grid-view">
	<table class="items table table-bordered table-condensed table-striped">
		<thead>
			<tr>
				<th> No Surat </th> <th> Tanggal </th> <th>Keterangan </th> <th> File </th> 
			</tr>
		</thead>
		<tbody>
<?php 
		foreach ($alasan as $data ){
			if ($data->file!=''){
				$linkFile = '<a href="'.Yii::app()->getBaseUrl(true).$data->file.'" target="_blank">File</a>';
			}else{
				$linkFile = '';
			}
			echo '

			<tr class="odd">
				<td>'.$data->no_surat.'</td>
				<td>'.date("d/m/Y",strtotime($data->tanggal)).'</td>
				<td>'.$data->keterangan.'</td>
				<td>'.$linkFile.'</td>
			</tr>

			';
		}

?>
		</tbody>
	</table>
</div>
*/ ?>


<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$alasan,
'attributes'=>array(
		array(
			'label'=>'No Surat',
			'value'=>$alasan->no_surat,
		),
		array(
			'label'=>'Tanggal',
			'value'=>date("d/m/Y",strtotime($alasan->tanggal)),
		),
		array(
			'label'=>'Keterangan',
			'value'=>$alasan->keterangan,
		),
		array(
			'label'=>'File',
			'type'=>'raw',
			'value'=>($alasan->file !='') ? '<a href="'.Yii::app()->getBaseUrl(true).$alasan->file.'" target="_blank">File</a>' : '',
		),
),
)); ?>
