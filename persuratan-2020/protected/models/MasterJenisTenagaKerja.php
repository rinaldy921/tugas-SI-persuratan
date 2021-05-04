<?php

/**
 * This is the model class for table "master_jenis_tenaga_kerja".
 *
 * The followings are the available columns in table 'master_jenis_tenaga_kerja':
 * @property integer $id
 * @property string $is_tenaga_tetap
 * @property string $jenis_tenaga_kerja
 */
class MasterJenisTenagaKerja extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'master_jenis_tenaga_kerja';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_tenaga_tetap', 'required'),
			array('is_tenaga_tetap', 'length', 'max'=>1),
			array('jenis_tenaga_kerja', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, is_tenaga_tetap, jenis_tenaga_kerja', 'safe', 'on'=>'search'),
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
						'id'=>Yii::t('app','ID'),
						'is_tenaga_tetap'=>Yii::t('app','Is Tenaga Tetap'),
						'jenis_tenaga_kerja'=>Yii::t('app','Jenis Tenaga Kerja'),
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
		$criteria->compare('is_tenaga_tetap',$this->is_tenaga_tetap,true);
		$criteria->compare('jenis_tenaga_kerja',$this->jenis_tenaga_kerja,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MasterJenisTenagaKerja the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
