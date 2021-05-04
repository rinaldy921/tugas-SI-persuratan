<?php

/**
 * This is the model class for table "rku_teknik_pemadaman".
 *
 * The followings are the available columns in table 'rku_teknik_pemadaman':
 * @property integer $id
 * @property integer $id_rku
 * @property string $metode
 * @property string $kondisi_kebakaran
 * @property string $cara
 *
 * The followings are the available model relations:
 * @property Rku $idRku
 */
class RkuTeknikPemadaman extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_teknik_pemadaman';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, metode', 'required'),
			array('id_rku', 'numerical', 'integerOnly'=>true),
			array('metode, kondisi_kebakaran, cara', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, metode, kondisi_kebakaran, cara', 'safe', 'on'=>'search'),
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
			'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_rku' => 'Id Rku',
			'metode' => 'Metode',
			'kondisi_kebakaran' => 'Kondisi Kebakaran',
			'cara' => 'Cara',
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
		$criteria->compare('id_rku',$this->id_rku);
		$criteria->compare('metode',$this->metode,true);
		$criteria->compare('kondisi_kebakaran',$this->kondisi_kebakaran,true);
		$criteria->compare('cara',$this->cara,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuTeknikPemadaman the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
