<?php

/**
 * This is the model class for table "iuphhk_adm_pemangkuan_hutan".
 *
 * The followings are the available columns in table 'iuphhk_adm_pemangkuan_hutan':
 * @property integer $id
 * @property integer $id_iuphhk
 * @property string $rph
 * @property string $bkph
 * @property integer $id_kph
 * @property string $dinhut_kab
 * @property string $dinhut_prov
 *
 * The followings are the available model relations:
 * @property MasterJenisKph $idKph
 * @property Iuphhk $idIuphhk
 * @property Kabupaten $dinhutKab
 * @property Provinsi $dinhutProv
 */
class AdmPemangkuanHutan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iuphhk_adm_pemangkuan_hutan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_kph, dinhut_kab, dinhut_prov', 'required'),
			array('id_iuphhk, id_kph', 'numerical', 'integerOnly'=>true),
			array('rph, bkph', 'length', 'max'=>50),
			array('dinhut_kab', 'length', 'max'=>4),
			array('dinhut_prov', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_iuphhk, rph, bkph, id_kph, dinhut_kab, dinhut_prov', 'safe', 'on'=>'search'),
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
			'idKph' => array(self::BELONGS_TO, 'MasterJenisKph', 'id_kph'),
			'idIuphhk' => array(self::BELONGS_TO, 'Iuphhk', 'id_iuphhk'),
			'dinhutKab' => array(self::BELONGS_TO, 'Kabupaten', 'dinhut_kab'),
			'dinhutProv' => array(self::BELONGS_TO, 'Provinsi', 'dinhut_prov'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_iuphhk' => 'Id Iuphhk',
			'rph' => 'Rph',
			'bkph' => 'Bkph',
			'id_kph' => 'Id Kph',
			'dinhut_kab' => 'Dinhut Kab',
			'dinhut_prov' => 'Dinhut Prov',
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
		$criteria->compare('id_iuphhk',$this->id_iuphhk);
		$criteria->compare('rph',$this->rph,true);
		$criteria->compare('bkph',$this->bkph,true);
		$criteria->compare('id_kph',$this->id_kph);
		$criteria->compare('dinhut_kab',$this->dinhut_kab,true);
		$criteria->compare('dinhut_prov',$this->dinhut_prov,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdmPemangkuanHutan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
