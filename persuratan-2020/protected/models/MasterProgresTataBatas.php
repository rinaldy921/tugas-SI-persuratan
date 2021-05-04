<?php

/**
 * This is the model class for table "master_progres_tata_batas".
 *
 * The followings are the available columns in table 'master_progres_tata_batas':
 * @property integer $id_progres_tata_batas
 * @property string $nama_progres_tata_batas
 *
 * The followings are the available model relations:
 * @property ProgresTataBatas[] $progresTataBatases
 */
class MasterProgresTataBatas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'master_progres_tata_batas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama_progres_tata_batas', 'required'),
			array('nama_progres_tata_batas', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_progres_tata_batas, nama_progres_tata_batas', 'safe', 'on'=>'search'),
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
			'progresTataBatases' => array(self::HAS_MANY, 'ProgresTataBatas', 'id_progres_tata_batas'),
                        'id_progres_tata_batas' => array(self::BELONGS_TO, 'MasterKetProgresTataBatas', 'id_progres_tata_batas'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id_progres_tata_batas'=>Yii::t('app','Id Progres Tata Batas'),
						'nama_progres_tata_batas'=>Yii::t('app','Nama Progres Tata Batas'),
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

		$criteria->compare('id_progres_tata_batas',$this->id_progres_tata_batas);
		$criteria->compare('nama_progres_tata_batas',$this->nama_progres_tata_batas,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MasterProgresTataBatas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
