<?php

/**
 * This is the model class for table "iuphhk_adm_pemerintahan".
 *
 * The followings are the available columns in table 'iuphhk_adm_pemerintahan':
 * @property string $id
 * @property integer $id_iuphhk
 * @property string $provinsi
 * @property string $kabupaten
 * @property string $kecamatan
 *
 * The followings are the available model relations:
 * @property Kabupaten $kabupaten0
 * @property Iuphhk $idIuphhk
 * @property Provinsi $provinsi0
 * @property Kecamatan $kecamatan0
 */
class AdmPemerintahan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iuphhk_adm_pemerintahan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('provinsi,kabupaten', 'required'),
			array('id_iuphhk', 'numerical', 'integerOnly'=>true),
			array('provinsi', 'length', 'max'=>2),
			array('kabupaten', 'length', 'max'=>4),
			array('kecamatan', 'length', 'max'=>6),
                        array('id_perusahaan','numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_iuphhk, provinsi, kabupaten, kecamatan', 'safe', 'on'=>'search'),
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
			'kabupaten0' => array(self::BELONGS_TO, 'Kabupaten', 'kabupaten'),
			'idIuphhk' => array(self::BELONGS_TO, 'Iuphhk', 'id_iuphhk'),
			'provinsi0' => array(self::BELONGS_TO, 'Provinsi', 'provinsi'),
			'kecamatan0' => array(self::BELONGS_TO, 'Kecamatan', 'kecamatan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_iuphhk' => 'Id Iuphhk',
			'provinsi' => 'Provinsi',
			'kabupaten' => 'Kabupaten',
			'kecamatan' => 'Kecamatan',
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
		$criteria->compare('id_iuphhk',$this->id_iuphhk);
		$criteria->compare('provinsi',$this->provinsi,true);
		$criteria->compare('kabupaten',$this->kabupaten,true);
		$criteria->compare('kecamatan',$this->kecamatan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdmPemerintahan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
