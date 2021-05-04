<?php

/**
 * This is the model class for table "bphp_wilayah_kerja".
 *
 * The followings are the available columns in table 'bphp_wilayah_kerja':
 * @property integer $id
 * @property integer $id_master_bphp
 * @property string $id_provinsi
 *
 * The followings are the available model relations:
 * @property MasterBphp $idMasterBphp
 * @property Provinsi $idProvinsi
 */
class BphpWilayahKerja extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bphp_wilayah_kerja';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_master_bphp', 'numerical', 'integerOnly'=>true),
			//array('id_provinsi', 'length', 'max'=>2),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_master_bphp, id_provinsi', 'safe', 'on'=>'search'),
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
			'idMasterBphp' => array(self::BELONGS_TO, 'MasterBphp', 'id_master_bphp'),
			'idProvinsi' => array(self::BELONGS_TO, 'Provinsi', 'id_provinsi'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_master_bphp'=>Yii::t('app','Nama BPHP'),
						'id_provinsi'=>Yii::t('app','Provinsi'),
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
		$criteria->compare('id_master_bphp',$this->id_master_bphp);
		$criteria->compare('id_provinsi',$this->id_provinsi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BphpWilayahKerja the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
