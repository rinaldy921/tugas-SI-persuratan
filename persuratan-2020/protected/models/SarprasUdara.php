<?php

/**
 * This is the model class for table "iuphhk_sarpras_udara".
 *
 * The followings are the available columns in table 'iuphhk_sarpras_udara':
 * @property integer $id_sarpras_udara
 * @property integer $id_iuphhk
 * @property integer $landasan
 * @property string $pesawat
 *
 * The followings are the available model relations:
 * @property Iuphhk $idIuphhk
 */
class SarprasUdara extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iuphhk_sarpras_udara';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_iuphhk, landasan', 'numerical', 'integerOnly'=>true),
			array('pesawat', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_sarpras_udara, id_iuphhk, landasan, pesawat', 'safe', 'on'=>'search'),
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
			'id_sarpras_udara' => 'Id Sarpras Udara',
			'id_iuphhk' => 'Id Iuphhk',
			'landasan' => 'Landasan',
			'pesawat' => 'Pesawat',
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

		$criteria->compare('id_sarpras_udara',$this->id_sarpras_udara);
		$criteria->compare('id_iuphhk',$this->id_iuphhk);
		$criteria->compare('landasan',$this->landasan);
		$criteria->compare('pesawat',$this->pesawat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SarprasUdara the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
