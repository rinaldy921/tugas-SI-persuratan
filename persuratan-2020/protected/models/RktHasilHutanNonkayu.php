<?php

/**
 * This is the model class for table "rkt_hasil_hutan_nonkayu".
 *
 * The followings are the available columns in table 'rkt_hasil_hutan_nonkayu':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_rku_hasil_hutan_nonkayu_silvikultur
 * @property integer $id_jenis_produksi_lahan
 * @property integer $id_hasil_hutan_nonkayu
 * @property integer $id_satuan_volume_nonkayu
 * @property integer $id_blok
 * @property double $jumlah
 * @property double $realisasi
 * @property double $persentase
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property RealisasiRktHasilHutanNonkayu[] $realisasiRktHasilHutanNonkayus
 * @property RealisasiRktHasilHutanNonkayuBak[] $realisasiRktHasilHutanNonkayuBaks
 * @property Rkt $idRkt
 * @property MasterHasilHutanNonkayu $idHasilHutanNonkayu
 * @property RkuHasilHutanNonkayuSilvikultur $idRkuHasilHutanNonkayuSilvikultur
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property SatuanVolumeNonkayu $idSatuanVolumeNonkayu
 * @property BlokSektor $idBlok
 */
class RktHasilHutanNonkayu extends CActiveRecord
{
	public $sektor, $jumlah_not_null;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_hasil_hutan_nonkayu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, id_rku_hasil_hutan_nonkayu_silvikultur, id_jenis_produksi_lahan, id_hasil_hutan_nonkayu, id_satuan_volume_nonkayu, id_blok', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,id_jenis_lahan, id_rkt, id_rku_hasil_hutan_nonkayu_silvikultur, id_jenis_produksi_lahan, id_hasil_hutan_nonkayu, id_satuan_volume_nonkayu, id_blok, jumlah, realisasi, persentase, created, updated', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'realisasiRktHasilHutanNonkayus' => array(self::HAS_MANY, 'RealisasiRktHasilHutanNonkayu', 'id_rkt_hasil_hutan_nonkayu'),
			'realisasiRktHasilHutanNonkayuBaks' => array(self::HAS_MANY, 'RealisasiRktHasilHutanNonkayuBak', 'id_rkt_hasil_hutan_nonkayu'),
			'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
			'idHasilHutanNonkayu' => array(self::BELONGS_TO, 'MasterHasilHutanNonkayu', 'id_hasil_hutan_nonkayu'),
			'idRkuHasilHutanNonkayuSilvikultur' => array(self::BELONGS_TO, 'RkuHasilHutanNonkayuSilvikultur', 'id_rku_hasil_hutan_nonkayu_silvikultur'),
			'idJenisProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
			'idSatuanVolumeNonkayu' => array(self::BELONGS_TO, 'SatuanVolumeNonkayu', 'id_satuan_volume_nonkayu'),
			'idBlok' => array(self::BELONGS_TO, 'BlokSektor', 'id_blok'),
			'idJenisLahan' => array(self::BELONGS_TO, 'MasterJenisLahan','id_jenis_lahan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_rkt'=>Yii::t('app','Id Rkt'),
						'id_rku_hasil_hutan_nonkayu_silvikultur'=>Yii::t('app','Id Rku Hasil Hutan Nonkayu Silvikultur'),
						'id_jenis_produksi_lahan'=>Yii::t('app','Jenis Produksi Lahan'),
						'id_hasil_hutan_nonkayu'=>Yii::t('app','Jenis HHBK'),
						'id_satuan_volume_nonkayu'=>Yii::t('app','Satuan'),
						'id_jenis_lahan'=>Yii::t('app','Jenis Lahan'),
						'id_blok'=>Yii::t('app','Blok'),
						'jumlah'=>Yii::t('app','Jumlah'),
						'realisasi'=>Yii::t('app','Realisasi'),
						'persentase'=>Yii::t('app','Persentase'),
						'created'=>Yii::t('app','Created'),
						'updated'=>Yii::t('app','Updated'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_rkt',$this->id_rkt);
		$criteria->compare('id_rku_hasil_hutan_nonkayu_silvikultur',$this->id_rku_hasil_hutan_nonkayu_silvikultur);
		$criteria->compare('id_jenis_produksi_lahan',$this->id_jenis_produksi_lahan);
		$criteria->compare('id_hasil_hutan_nonkayu',$this->id_hasil_hutan_nonkayu);
		$criteria->compare('id_satuan_volume_nonkayu',$this->id_satuan_volume_nonkayu);
		$criteria->compare('id_jenis_lahan',$this->id_jenis_lahan);
		$criteria->compare('id_blok',$this->id_blok);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		if($this->jumlah_not_null) {
			$criteria->condition='TRIM(jumlah) !=""';
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktHasilHutanNonkayu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        return number_format($total,0,',','.');
    }

    public function getTotalPersen($records, $colName){
    	$totalJumlah = 0;
    	$totalRealisasi = 0;
    	foreach($records as $rec){
    		$totalJumlah += $rec->jumlah;
    		$totalRealisasi +=$rec->realisasi;
    	}
    	$subTotal = $totalRealisasi > 0 ? ($totalRealisasi / $totalJumlah) * 100 : 0 ;
    	return number_format($subTotal,2,',','.');
    }
}
