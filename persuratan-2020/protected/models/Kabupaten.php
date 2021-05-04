<?php

/**
 * This is the model class for table "kabupaten".
 *
 * The followings are the available columns in table 'kabupaten':
 * @property string $id_kabupaten
 * @property string $provinsi_id
 * @property string $nama
 *
 * The followings are the available model relations:
 * @property IuphhkAdmPemangkuanHutan[] $iuphhkAdmPemangkuanHutans
 * @property IuphhkAdmPemerintahan[] $iuphhkAdmPemerintahans
 * @property Provinsi $provinsi
 * @property Kecamatan[] $kecamatans
 * @property Perusahaan[] $perusahaans
 * @property PerusahaanCabang[] $perusahaanCabangs
 */
class Kabupaten extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kabupaten';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama', 'required'),
			array('provinsi_id', 'length', 'max'=>2),
			array('nama', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_kabupaten, provinsi_id, nama', 'safe', 'on'=>'search'),
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
			'iuphhkAdmPemangkuanHutans' => array(self::HAS_MANY, 'IuphhkAdmPemangkuanHutan', 'dinhut_kab'),
			'iuphhkAdmPemerintahans' => array(self::HAS_MANY, 'IuphhkAdmPemerintahan', 'kabupaten'),
			'kabupatenProvinsi' => array(self::BELONGS_TO, 'Provinsi', 'provinsi_id'),
			'kecamatans' => array(self::HAS_MANY, 'Kecamatan', 'kabupaten_id'),
			'perusahaanKabupaten' => array(self::HAS_MANY, 'Perusahaan', 'kabupaten'),
			'perusahaanCabang' => array(self::HAS_MANY, 'PerusahaanCabang', 'kabupaten'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id_kabupaten'=>Yii::t('app','Id Kabupaten'),
						'provinsi_id'=>Yii::t('app','Provinsi'),
						'nama'=>Yii::t('app','Nama'),
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

		$criteria->compare('id_kabupaten',$this->id_kabupaten,true);
		$criteria->compare('provinsi_id',$this->provinsi_id,true);
		$criteria->compare('nama',$this->nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kabupaten the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
