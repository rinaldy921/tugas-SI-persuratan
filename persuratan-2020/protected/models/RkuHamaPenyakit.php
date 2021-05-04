<?php

/**
 * This is the model class for table "rku_hama_penyakit".
 *
 * The followings are the available columns in table 'rku_hama_penyakit':
 * @property integer $id
 * @property integer $id_rku
 * @property string $hama
 * @property string $solusi
 *
 * The followings are the available model relations:
 * @property Rku $idRku
 */
class RkuHamaPenyakit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_hama_penyakit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, hama, solusi', 'required'),
			array('id_rku', 'numerical', 'integerOnly'=>true),
			array('hama, solusi', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, hama, solusi', 'safe', 'on'=>'search'),
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
			'hama' => 'Hama',
			'solusi' => 'Solusi',
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
		$criteria->compare('hama',$this->hama,true);
		$criteria->compare('solusi',$this->solusi,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuHamaPenyakit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
