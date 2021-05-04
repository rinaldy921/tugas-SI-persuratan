<?php

/**
 * This is the model class for table "iuphhk_keadaan_lahan".
 *
 * The followings are the available columns in table 'iuphhk_keadaan_lahan':
 * @property integer $id_keadaan_lahan
 * @property integer $id_iuphhk
 * @property double $lahan_kering
 * @property double $basah
 * @property double $payau
 *
 * The followings are the available model relations:
 * @property Iuphhk $idIuphhk
 */
class KeadaanLahan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iuphhk_keadaan_lahan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_iuphhk', 'numerical', 'integerOnly'=>true),
			array('lahan_kering, basah, payau', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_keadaan_lahan, id_iuphhk, lahan_kering, basah, payau', 'safe', 'on'=>'search'),
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
			'id_keadaan_lahan' => 'Id Keadaan Lahan',
			'id_iuphhk' => 'Id Iuphhk',
			'lahan_kering' => 'Lahan Kering',
			'basah' => 'Basah',
			'payau' => 'Payau',
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

		$criteria->compare('id_keadaan_lahan',$this->id_keadaan_lahan);
		$criteria->compare('id_iuphhk',$this->id_iuphhk);
		$criteria->compare('lahan_kering',$this->lahan_kering);
		$criteria->compare('basah',$this->basah);
		$criteria->compare('payau',$this->payau);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KeadaanLahan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
