<?php

/**
 * This is the model class for table "master_jenis_tanaman_bibit".
 *
 * The followings are the available columns in table 'master_jenis_tanaman_bibit':
 * @property integer $id
 * @property integer $id_jenis_produksi_lahan
 * @property string $nama_tanaman
 *
 * The followings are the available model relations:
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property RktBibit[] $rktBibits
 */
class MasterJenisTanamanBibit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'master_jenis_tanaman_bibit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_jenis_produksi_lahan, nama_tanaman', 'required'),
			array('id_jenis_produksi_lahan', 'numerical', 'integerOnly'=>true),
			array('nama_tanaman', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_jenis_produksi_lahan, nama_tanaman', 'safe', 'on'=>'search'),
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
			'idJenisProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
			'rktBibits' => array(self::HAS_MANY, 'RktBibit', 'id_tanaman_bibit'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_jenis_produksi_lahan' => 'Id Jenis Produksi Lahan',
			'nama_tanaman' => 'Nama Tanaman',
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
		$criteria->compare('id_jenis_produksi_lahan',$this->id_jenis_produksi_lahan);
		$criteria->compare('nama_tanaman',$this->nama_tanaman,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MasterJenisTanamanBibit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
