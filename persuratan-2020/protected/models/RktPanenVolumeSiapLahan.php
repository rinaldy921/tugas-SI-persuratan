<?php

/**
 * This is the model class for table "rkt_panen_volume_siap_lahan".
 *
 * The followings are the available columns in table 'rkt_panen_volume_siap_lahan':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_jenis_kayu
 * @property integer $id_jenis_kelompok_kayu
 * @property double $jumlah
 * @property double $realisasi
 *
 * The followings are the available model relations:
 * @property MasterJenisKelompokKayu $idJenisKelompokKayu
 * @property MasterJenisKayu $idJenisKayu
 * @property Rkt $idRkt
 */
class RktPanenVolumeSiapLahan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_panen_volume_siap_lahan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, id_jenis_kayu, id_jenis_kelompok_kayu', 'required'),
			array('id_rkt, id_jenis_kayu, id_jenis_kelompok_kayu', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, id_jenis_kayu, id_jenis_kelompok_kayu, jumlah, realisasi, persentase', 'safe', 'on'=>'search'),
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
			'idJenisKelompokKayu' => array(self::BELONGS_TO, 'MasterJenisKelompokKayu', 'id_jenis_kelompok_kayu'),
			'idJenisKayu' => array(self::BELONGS_TO, 'MasterJenisKayu', 'id_jenis_kayu'),
			'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_rkt' => 'Id Rkt',
			'id_jenis_kayu' => 'Jenis Kayu',
			'id_jenis_kelompok_kayu' => 'Jenis Kelompok Kayu',
			'jumlah' => 'Rencana (M³)',
			'realisasi' => 'Realisasi (M³)',
			'persentase' => 'Persentase (%)',
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
		$criteria->compare('id_jenis_kayu',$this->id_jenis_kayu);
		$criteria->compare('id_jenis_kelompok_kayu',$this->id_jenis_kelompok_kayu);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktPanenVolumeSiapLahan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        return number_format($total,2,',','.');
    }

    public function getTotalPersen($records, $colName) {
    	$totalJumlah = 0;
    	$totalRealisasi = 0;
    	foreach($records as $rec) {
    		$totalJumlah += $rec->jumlah;
    		$totalRealisasi +=$rec->realisasi;
    	}

    	$subTotal = $totalRealisasi > 0 ? ($totalRealisasi / $totalJumlah) * 100 : 0 ;
    	return number_format($subTotal,2,',','.');
    }
}
