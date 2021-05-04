<?php

/**
 * This is the model class for table "rkt_kawasan_lindung".
 *
 * The followings are the available columns in table 'rkt_kawasan_lindung':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_kawasan_lindung
 * @property double $jumlah
 * @property double $realisasi
 * @property double $persentase
 *
 * The followings are the available model relations:
 * @property RealisasiRktKawasanLindung[] $realisasiRktKawasanLindungs
 * @property Rkt $idRkt
 * @property MasterJenisKawasanLindung $idKawasanLindung
 */
class RktKawasanLindung extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_kawasan_lindung';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, id_kawasan_lindung', 'required'),
			array('id_rkt, id_kawasan_lindung', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			array('id_kawasan_lindung' , 'cekexist','on'=>'inputForm'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, id_kawasan_lindung, jumlah, realisasi, persentase', 'safe', 'on'=>'search'),
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
			'realisasiRktKawasanLindungs' => array(self::HAS_MANY, 'RealisasiRktKawasanLindung', 'id_rkt_kawasan_lindung'),
			'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
			'idKawasanLindung' => array(self::BELONGS_TO, 'MasterJenisKawasanLindung', 'id_kawasan_lindung'),
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
						'id_kawasan_lindung'=>Yii::t('app','Kawasan Lindung'),
						'jumlah'=>Yii::t('app','Jumlah'),
						'realisasi'=>Yii::t('app','Realisasi'),
						'persentase'=>Yii::t('app','Persentase'),
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
		$criteria->compare('id_kawasan_lindung',$this->id_kawasan_lindung);
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
	 * @return RktKawasanLindung the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total += $rec->{$colName};
        return number_format($total, 2, ',', '.');
    }

    public function getTotalPersen($records, $colName) {
        $totalJumlah = 0;
        $totalRealisasi = 0;
        foreach ($records as $rec) {
            $totalJumlah += $rec->jumlah;
            $totalRealisasi += $rec->realisasi;
        }

        $subTotal = $totalRealisasi > 0 ? ($totalRealisasi / $totalJumlah) * 100 : 0;
        return number_format($subTotal, 2, ',', '.');
    }

    public function cekexist()
	{
		
	    $model = self::findByAttributes(array('id_kawasan_lindung'=>$this->id_kawasan_lindung,'id_rkt'=>$this->id_rkt));
	    if ($model)
	         $this->addError('id_kawasan_lindung', 'Jenis Kawasan Lindung yang dipilih Sudah tersimpan sebelumnya, silahkan untuk mengupdate data bila diperlukan') ;

	}
    
        
        
     public function deleteByRktId($idRkt)
    {
        $model = self::findByAttributes(array('id_rkt'=>$idRkt));
        
       // print_r($model);        exit(1);
        
        if($model){
            $Realisasi = RealisasiRktKawasanLindung::model()->deleteByRktKawasanId($model->id_kawasan_lindung);
        }
        
        
        // print_r($Realisasi);        exit(1);
        
        $this->getDbConnection()->createCommand('DELETE FROM rkt_kawasan_lindung WHERE id_rkt='.$idRkt)->execute();
    }
}
