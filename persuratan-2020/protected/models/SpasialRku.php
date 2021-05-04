<?php

/**
 * This is the model class for table "spasial_rku".
 *
 * The followings are the available columns in table 'spasial_rku':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_perusahaan
 * @property string $file_name
 * @property string $file_path
 *
 * The followings are the available model relations:
 * @property Perusahaan $idPerusahaan
 * @property Rku $idRku
 */
class SpasialRku extends CActiveRecord
{
	public $dokumen_peta;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'spasial_rku';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, id_perusahaan', 'required'),
			array('id_rku, id_perusahaan', 'numerical', 'integerOnly'=>true),
			array('file_name, file_path', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, id_perusahaan, file_name, file_path', 'safe', 'on'=>'search'),
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
			'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_rku'=>Yii::t('app','Id Rku'),
						'id_perusahaan'=>Yii::t('app','Id Perusahaan'),
						'file_name'=>Yii::t('app','File Name'),
						'file_path'=>Yii::t('app','File Path'),
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
		$criteria->compare('id_perusahaan',$this->id_perusahaan);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_path',$this->file_path,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SpasialRku the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
