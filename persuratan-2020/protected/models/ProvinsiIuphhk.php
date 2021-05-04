<?php

/**
 * This is the model class for table "provinsi_iuphhk".
 *
 * The followings are the available columns in table 'provinsi_iuphhk':
 * @property string $id_provinsi
 * @property integer $id_iuphhk
 * @property string $nama_provinsi
 * @property integer $id_perusahaan
 */
class ProvinsiIuphhk extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'provinsi_iuphhk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_provinsi', 'required'),
			array('id_iuphhk, id_perusahaan', 'numerical', 'integerOnly'=>true),
			array('id_provinsi', 'length', 'max'=>2),
			array('nama_provinsi', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_provinsi, id_iuphhk, nama_provinsi, id_perusahaan', 'safe', 'on'=>'search'),
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
						'id_provinsi'=>Yii::t('app','Id Provinsi'),
						'id_iuphhk'=>Yii::t('app','Id Iuphhk'),
						'nama_provinsi'=>Yii::t('app','Nama Provinsi'),
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

		$criteria->compare('id_provinsi',$this->id_provinsi,true);
		$criteria->compare('id_iuphhk',$this->id_iuphhk);
		$criteria->compare('nama_provinsi',$this->nama_provinsi,true);
		$criteria->compare('id_perusahaan',$this->id_perusahaan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProvinsiIuphhk the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
