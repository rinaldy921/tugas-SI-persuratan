<?php

class cekMulai extends CValidator {

	protected function validateAttribute($object,$attribute)
	{

	}

	public function clientValidateAttribute($object,$attribute)
	{
		// var_dump(Yii::app()->user->idPerusahaan());die;
		$model = RKt::model()->findAll(array('condition'=>'status = 1 AND id_perusahaan = '.Yii::app()->user->idPerusahaan()));
		// $value = $object->$attribute;
		foreach($model as $md) {
			// $condition="value.match({$md->tahun_mulai})";
			$mulai = date('Y', strtotime($md->mulai_berlaku));
			$banding = $object->tahun_mulai;
			// var_dump($object);

			return "
				var d = new Date(value);
				var c = d.getFullYear();
				var t = {$mulai};
				// alert(c.toSource());alert(c.toSource());
				if(c < {$mulai}) {
					alert('tes');
				    messages.push(".CJSON::encode('Tahun mulai yang dipilih sudah terdata. Silahkan pilih tahun yang lain.').");
				}
			";
		}
		
	}
}