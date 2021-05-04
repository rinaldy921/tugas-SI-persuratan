<?php

/**
 * This is the model class for table "spasial_tb".
 *
 * The followings are the available columns in table 'spasial_tb':
 * @property integer $id
 * @property integer $id_iup
 * @property integer $id_perusahaan
 *
 * The followings are the available model relations:
 * @property Perusahaan $idPerusahaan
 * @property Iuphhk $idIup
 */
class SpasialTb extends CActiveRecord
{
	public $dokumen_peta;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'spasial_tb';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_iup, id_perusahaan', 'required'),
			array('id_iup, id_perusahaan', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_iup, id_perusahaan', 'safe', 'on'=>'search'),
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
			'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
			'idIup' => array(self::BELONGS_TO, 'Iuphhk', 'id_iup'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_iup'=>Yii::t('app','Id Iup'),
						'id_perusahaan'=>Yii::t('app','Id Perusahaan'),
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
		$criteria->compare('id_iup',$this->id_iup);
		$criteria->compare('id_perusahaan',$this->id_perusahaan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SpasialTb the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
