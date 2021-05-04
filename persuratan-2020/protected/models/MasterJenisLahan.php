<?php

/**
 * This is the model class for table "master_jenis_lahan".
 *
 * The followings are the available columns in table 'master_jenis_lahan':
 * @property integer $id
 * @property string $jenis_lahan
 *
 * The followings are the available model relations:
 * @property RktSiapLahan[] $rktSiapLahans
 * @property RktTanam[] $rktTanams
 * @property RkuSiapLahan[] $rkuSiapLahans
 * @property RkuTanam[] $rkuTanams
 */
class MasterJenisLahan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'master_jenis_lahan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenis_lahan', 'required'),
			array('jenis_lahan', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, jenis_lahan', 'safe', 'on'=>'search'),
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
			'rktSiapLahans' => array(self::HAS_MANY, 'RktSiapLahan', 'id_jenis_lahan'),
			'rktTanams' => array(self::HAS_MANY, 'RktTanam', 'id_jenis_lahan'),
			'rkuSiapLahans' => array(self::HAS_MANY, 'RkuSiapLahan', 'id_jenis_lahan'),
			'rkuTanams' => array(self::HAS_MANY, 'RkuTanam', 'id_jenis_lahan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'jenis_lahan' => 'Jenis Lahan',
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
		$criteria->compare('jenis_lahan',$this->jenis_lahan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MasterJenisLahan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
