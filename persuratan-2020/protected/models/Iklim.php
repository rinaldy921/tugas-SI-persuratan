<?php

/**
 * This is the model class for table "iuphhk_iklim".
 *
 * The followings are the available columns in table 'iuphhk_iklim':
 * @property integer $id_iklim
 * @property integer $id_iuphhk
 * @property string $tipe_iklim
 * @property double $curah_hujan
 * @property double $hujan_terendah
 * @property double $hujan_tertinggi
 * @property integer $bulan_terendah
 * @property integer $bulan_tertinggi
 *
 * The followings are the available model relations:
 * @property Iuphhk $idIuphhk
 */
class Iklim extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iuphhk_iklim';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_iuphhk, tipe_iklim, curah_hujan','required'),
			array('id_iuphhk', 'numerical', 'integerOnly'=>true),
			array('curah_hujan, hujan_terendah, hujan_tertinggi', 'numerical'),
			array('tipe_iklim', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_iklim, id_iuphhk, tipe_iklim, curah_hujan, hujan_terendah, hujan_tertinggi', 'safe', 'on'=>'search'),
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
			'idIuphhk' => array(self::BELONGS_TO, 'Iuphhk', 'id_iuphhk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_iklim' => 'Id Iklim',
			'id_iuphhk' => 'Id Iuphhk',
			'tipe_iklim' => 'Tipe Iklim',
			'curah_hujan' => 'Curah Hujan',
			'hujan_terendah' => 'Curah Hujan Terendah',
			'hujan_tertinggi' => 'Curah Hujan Tertinggi',
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

		$criteria->compare('id_iklim',$this->id_iklim);
		$criteria->compare('id_iuphhk',$this->id_iuphhk);
		$criteria->compare('tipe_iklim',$this->tipe_iklim,true);
		$criteria->compare('curah_hujan',$this->curah_hujan);
		$criteria->compare('hujan_terendah',$this->hujan_terendah);
		$criteria->compare('hujan_tertinggi',$this->hujan_tertinggi);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Iklim the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
