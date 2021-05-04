<?php

/**
 * This is the model class for table "iuphhk_data_penduduk".
 *
 * The followings are the available columns in table 'iuphhk_data_penduduk':
 * @property integer $id
 * @property integer $id_iuphhk
 * @property integer $id_kategori_penduduk
 * @property integer $id_jenis_kelamin
 * @property double $jumlah
 *
 * The followings are the available model relations:
 * @property MasterJenisKelamin $idJenisKelamin
 * @property MasterKategoriPenduduk $idKategoriPenduduk
 * @property Iuphhk $idIuphhk
 */
class IuphhkDataPenduduk extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iuphhk_data_penduduk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_iuphhk, id_kategori_penduduk, id_jenis_kelamin', 'required'),
			array('id_iuphhk, id_kategori_penduduk, id_jenis_kelamin', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_iuphhk, id_kategori_penduduk, id_jenis_kelamin, jumlah', 'safe', 'on'=>'search'),
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
			'idJenisKelamin' => array(self::BELONGS_TO, 'MasterJenisKelamin', 'id_jenis_kelamin'),
			'idKategoriPenduduk' => array(self::BELONGS_TO, 'MasterKategoriPenduduk', 'id_kategori_penduduk'),
			'idIuphhk' => array(self::BELONGS_TO, 'Iuphhk', 'id_iuphhk'),
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
			'id_kategori_penduduk' => 'Kategori Penduduk',
			'id_jenis_kelamin' => 'Jenis Kelamin',
			'jumlah' => 'Jumlah (%)',
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
		$criteria->compare('id_iuphhk',$this->id_iuphhk);
		$criteria->compare('id_kategori_penduduk',$this->id_kategori_penduduk);
		$criteria->compare('id_jenis_kelamin',$this->id_jenis_kelamin);
		$criteria->compare('jumlah',$this->jumlah);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IuphhkDataPenduduk the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
