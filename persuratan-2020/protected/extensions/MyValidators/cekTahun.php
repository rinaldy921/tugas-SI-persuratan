<?php

class cekTahun extends CValidator {
	public $id_per;
	protected function validateAttribute($object,$attribute)
	{

	}
	public function clientValidateAttribute($object,$attribute)
	{
		$model = RKt::model()->findAll(array('condition'=>'status = 1 AND id_perusahaan = '.Yii::app()->user->idPerusahaan()));
		// $th = array();
		if(!empty($model)) {
			foreach($model as $md) {
				$th[] = $md->tahun_mulai;
			}
			return "
				var th = ".CJSON::encode($th).";
				for(var i=0;i<th.length;i++) {
					if(value == th[i]) {
				    	messages.push(".CJSON::encode('Tahun mulai yang dipilih sudah terdata. Silahkan pilih tahun yang lain.').");
					}
				}
			";
		}
		
	}
}