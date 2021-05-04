<?php
	// var_dump($data->idJenisProduksiLahan);die;
	// foreach($model->idBlok() as $c) :
	$tes = Yii::app()->user->getState('idRkt');
	// var_dump($tes);die;
	$ar = RktArealProduktif::model()->findAll(array('condition'=>'id_blok = ' .$data->id_blok. ' AND id_rkt = '. $tes));
	// var_dump($ar);die;
?>
<table class="table">
<tr>
	<td><?php echo $data->id_blok; ?></td>
</tr>
</table>