<?php

/**
 * This is the model class for table "attachment".
 *
 * The followings are the available columns in table 'attachment':
 * @property string $id
 * @property string $Keterangan
 * @property string $Model
 * @property integer $Model_id
 * @property string $File_Name
 * @property string $File_Type
 * @property string $File_Path
 * @property integer $File_Size
 * @property string $created_at
 * @property string $modified_at
 */
class Attachment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'attachment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Model_id, File_Size', 'numerical', 'integerOnly'=>true),
			array('Keterangan', 'length', 'max'=>1000),
			array('Model', 'length', 'max'=>60),
			array('File_Name, File_Type, File_Path', 'length', 'max'=>255),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Keterangan, Model, Model_id, File_Name, File_Type, File_Path, File_Size, created_at, modified_at', 'safe', 'on'=>'search'),
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
						'Keterangan'=>Yii::t('app','Keterangan'),
						'Model'=>Yii::t('app','Model'),
						'Model_id'=>Yii::t('app','Model'),
						'File_Name'=>Yii::t('app','File Name'),
						'File_Type'=>Yii::t('app','File Type'),
						'File_Path'=>Yii::t('app','File Path'),
						'File_Size'=>Yii::t('app','File Size'),
						'created_at'=>Yii::t('app','Created At'),
						'modified_at'=>Yii::t('app','Modified At'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('Keterangan',$this->Keterangan,true);
		$criteria->compare('Model',$this->Model,true);
		$criteria->compare('Model_id',$this->Model_id);
		$criteria->compare('File_Name',$this->File_Name,true);
		$criteria->compare('File_Type',$this->File_Type,true);
		$criteria->compare('File_Path',$this->File_Path,true);
		$criteria->compare('File_Size',$this->File_Size);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attachment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
