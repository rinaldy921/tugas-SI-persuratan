<?php

/**
 * This is the model class for table "rkt_peningkatan_sdm".
 *
 * The followings are the available columns in table 'rkt_peningkatan_sdm':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_peningkatan_sdm
 * @property double $jumlah
 * @property double $realisasi
 * @property double $persentase
 *
 * The followings are the available model relations:
 * @property MasterJenisPeningkatanSdm $idPeningkatanSdm
 * @property Rkt $idRkt
 */
class RktPeningkatanSdm extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_peningkatan_sdm';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, id_peningkatan_sdm', 'required'),
			array('id_rkt, id_peningkatan_sdm', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			array('keterangan','length', 'max'=>255),
			array('id_peningkatan_sdm' , 'cekexist','on'=>'inputForm'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, id_peningkatan_sdm, jumlah, keterangan, realisasi, persentase', 'safe', 'on'=>'search'),
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
			'idPeningkatanSdm' => array(self::BELONGS_TO, 'MasterJenisPeningkatanSdm', 'id_peningkatan_sdm'),
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
			'id_peningkatan_sdm' => 'Jenis',
			'jumlah' => 'Rencana (Kali/Orang)',
			'keterangan' => 'Keterangan',
			'realisasi' => 'Realisasi (Kali/Orang)',
			'persentase' => 'Persentase',
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
		$criteria->compare('id_peningkatan_sdm',$this->id_peningkatan_sdm);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('keterangan',$this->keterangan);
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
	 * @return RktPeningkatanSdm the static model class
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

    	$subTotal = $totalRealisasi > 0 ? ($totalRealisasi / $totalJumlah) * 100 : 0 ;
    	return number_format($subTotal,2,',','.');
    }

    public function cekexist()
	{
		
	    $model = self::findByAttributes(array('id_peningkatan_sdm'=>$this->id_peningkatan_sdm,'id_rkt'=>$this->id_rkt));
	    if ($model)
	         $this->addError('id_peningkatan_sdm', 'Jenis Peningkatan SDM yang dipilih Sudah tersimpan sebelumnya, silahkan untuk mengupdate data bila diperlukan') ;

	}
}