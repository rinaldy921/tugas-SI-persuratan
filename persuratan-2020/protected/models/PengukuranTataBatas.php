<?php

/**
 * This is the model class for table "pengukuran_tata_batas".
 *
 * The followings are the available columns in table 'pengukuran_tata_batas':
 * @property integer $id
 * @property integer $id_perusahaan
 * @property double $realisasi
 * @property string $tanggal
 */
class PengukuranTataBatas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        
        public $total;
        public function tableName()
	{
		return 'pengukuran_tata_batas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_perusahaan', 'numerical', 'integerOnly'=>true),
			array('realisasi', 'numerical'),
			array('tanggal, total', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_perusahaan, realisasi, total, tanggal', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_perusahaan' => 'Id Perusahaan',
			'realisasi' => 'Realisasi',
			'tanggal' => 'Tanggal',
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
		$criteria->compare('id_perusahaan',$this->id_perusahaan);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('tanggal',$this->tanggal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PengukuranTataBatas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
