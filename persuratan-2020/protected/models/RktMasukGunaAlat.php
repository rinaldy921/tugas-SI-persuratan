<?php

/**
 * This is the model class for table "rkt_masuk_guna_alat".
 *
 * The followings are the available columns in table 'rkt_masuk_guna_alat':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_jenis_peralatan
 * @property double $jumlah
 * @property double $realisasi
 * @property double $persentase
 *
 * The followings are the available model relations:
 * @property MasterJenisPeralatan $idJenisPeralatan
 * @property Rkt $idRkt
 */
class RktMasukGunaAlat extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_masuk_guna_alat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt', 'required'),
                        array('nama_peralatan', 'length', 'max'=>255),
			array('id_rkt, id_jenis_peralatan, sesuai_rku', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			//array('id_jenis_peralatan' , 'cekexist','on'=>'inputForm'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, id_jenis_peralatan, jumlah, realisasi, persentase', 'safe', 'on'=>'search'),
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
			'idJenisPeralatan' => array(self::BELONGS_TO, 'MasterJenisPeralatan', 'id_jenis_peralatan'),
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
			'id_jenis_peralatan' => 'Jenis Peralatan',
			'jumlah' => 'Rencana (Unit)',
			'realisasi' => 'Realisasi (Unit)',
                        'nama_peralatan' => 'Nama Peralatan',
			'persentase' => 'Persentase',
                        'sesuai_rku' => 'Pilih Jenis Peralatan',
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
		$criteria->compare('id_jenis_peralatan',$this->id_jenis_peralatan);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase);

		return new CActiveDataProvider($this, array(
			'pagination'=>false,
			'criteria'=>$criteria,
		));
	}

	public function cari()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_rkt',$this->id_rkt);
		$criteria->compare('id_jenis_peralatan',$this->id_jenis_peralatan);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase);
		$criteria->condition('id_perusahaan = 0 AND id_perusahaan = '.Yii::app()->user->idPerusahaan());

		return new CActiveDataProvider($this, array(
			'pagination'=>array('pageSize'=>100),
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktMasukGunaAlat the static model class
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

    public function getTotalPersen($records, $colName) {
    	$totalJumlah = 0;
    	$totalRealisasi = 0;
    	foreach($records as $rec) {
    		$totalJumlah += $rec->jumlah;
    		$totalRealisasi +=$rec->realisasi;
    	}

    	// $subTotal = count($records)>0 ? ($total / count($records)) : 0 ;
    	$subTotal = $totalRealisasi > 0 ? ($totalRealisasi / $totalJumlah) * 100 : 0 ;
    	return number_format($subTotal,2,',','.');
    }

    public function cekexist()
	{
	    $model = self::findByAttributes(array('id_jenis_peralatan'=>$this->id_jenis_peralatan,'id_rkt'=>$this->id_rkt));
	    if ($model)
	         $this->addError('id_jenis_peralatan', 'Jenis Peralatan yang dipilih Sudah tersimpan sebelumnya, silahkan untuk mengupdate data bila diperlukan') ;

	}
}
