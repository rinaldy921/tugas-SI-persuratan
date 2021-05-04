<?php

/**
 * This is the model class for table "blok_sektor".
 *
 * The followings are the available columns in table 'blok_sektor':
 * @property integer $id
 * @property integer $id_perusahaan
 * @property integer $id_iuphhk
 * @property integer $id_sektor
 * @property integer $id_blok
 *
 * The followings are the available model relations:
 * @property MasterBlok $idBlok
 * @property Iuphhk $idIuphhk
 * @property MasterSektor $idSektor
 * @property Perusahaan $idPerusahaan
 * @property RktArealNonProduktif[] $rktArealNonProduktifs
 * @property RktKawasanLindung[] $rktKawasanLindungs
 * @property RkuArealNonProduktif[] $rkuArealNonProduktifs
 * @property RkuArealProduktif[] $rkuArealProduktifs
 * @property RkuKawasanLindung[] $rkuKawasanLindungs
 */
class BlokSektor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blok_sektor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_perusahaan, id_iuphhk, id_sektor, id_blok', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_perusahaan, id_iuphhk, id_sektor, id_blok, id_rku', 'safe', 'on'=>'search'),
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
			'idBlok' => array(self::BELONGS_TO, 'MasterBlok', 'id_blok'),
			'idIuphhk' => array(self::BELONGS_TO, 'Iuphhk', 'id_iuphhk'),
			'idSektor' => array(self::BELONGS_TO, 'MasterSektor', 'id_sektor'),
			'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
			'rktArealNonProduktifs' => array(self::HAS_MANY, 'RktArealNonProduktif', 'id_blok'),
			'rktArealProduktifs' => array(self::HAS_MANY, 'RktArealProduktif', 'id_blok'),
			'rktKawasanLindungs' => array(self::HAS_MANY, 'RktKawasanLindung', 'id_blok'),
			'rkuArealNonProduktifs' => array(self::HAS_MANY, 'RkuArealNonProduktif', 'id_blok'),
			'rkuArealProduktifs' => array(self::HAS_MANY, 'RkuArealProduktif', 'id_blok'),
			'rkuKawasanLindungs' => array(self::HAS_MANY, 'RkuKawasanLindung', 'id_blok'),
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
			'id_iuphhk' => 'Id Iuphhk',
			'id_sektor' => 'Id Sektor',
			'id_blok' => 'Id Blok',
			'id_rku' => 'Id RKU',
                        'nama_blok' => 'Nama Petak Kerja',
                        'nama_sektor' => 'Nama Unit Kelestarian'
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
		$criteria->compare('id_iuphhk',$this->id_iuphhk);
		$criteria->compare('id_sektor',$this->id_sektor);
		$criteria->compare('id_blok',$this->id_blok);
		$criteria->compare('id_rku',$this->id_rku);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlokSektor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
