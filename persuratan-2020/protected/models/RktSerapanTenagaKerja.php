<?php

/**
 * This is the model class for table "rkt_serapan_tenaga_kerja".
 *
 * The followings are the available columns in table 'rkt_serapan_tenaga_kerja':
 * @property integer $id
 * @property integer $id_rkt
 * @property string $is_tenaga_kehutanan
 * @property string $is_tenaga_tetap
 * @property integer $id_pendidikan
 * @property integer $id_jenis_kewarganegaraan
 * @property integer $jumlah
 * @property string $realisasi
 * @property string $persentase
 *
 * The followings are the available model relations:
 * @property RealisasiRktSerapanTenagaKerja[] $realisasiRktSerapanTenagaKerjas
 * @property MasterJenisKewarganegaraan $idJenisKewarganegaraan
 * @property MasterPendidikan $idPendidikan
 * @property Rkt $idRkt
 */
class RktSerapanTenagaKerja extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_serapan_tenaga_kerja';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, is_tenaga_kehutanan, is_tenaga_tetap', 'required'),
			array('id_rkt, id_pendidikan, id_jenis_kewarganegaraan, jumlah', 'numerical', 'integerOnly'=>true),
			array('is_tenaga_kehutanan, is_tenaga_tetap', 'length', 'max'=>1),
			array('realisasi, persentase', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, is_tenaga_kehutanan, is_tenaga_tetap, id_pendidikan, id_jenis_kewarganegaraan, jumlah, realisasi, persentase', 'safe', 'on'=>'search'),
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
			'realisasiRktSerapanTenagaKerjas' => array(self::HAS_MANY, 'RealisasiRktSerapanTenagaKerja', 'id_rkt_serapan_tenaga_kerja'),
			'idJenisKewarganegaraan' => array(self::BELONGS_TO, 'MasterJenisKewarganegaraan', 'id_jenis_kewarganegaraan'),
			'idPendidikan' => array(self::BELONGS_TO, 'MasterPendidikan', 'id_pendidikan'),
			'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_rkt'=>Yii::t('app','Id Rkt'),
						'is_tenaga_kehutanan'=>Yii::t('app','Is Tenaga Kehutanan'),
						'is_tenaga_tetap'=>Yii::t('app','Is Tenaga Tetap'),
						'id_pendidikan'=>Yii::t('app','Id Pendidikan'),
						'id_jenis_kewarganegaraan'=>Yii::t('app','Id Jenis Kewarganegaraan'),
						'jumlah'=>Yii::t('app','Jumlah'),
						'realisasi'=>Yii::t('app','Realisasi'),
						'persentase'=>Yii::t('app','Persentase'),
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
		$criteria->compare('id_rkt',$this->id_rkt);
		$criteria->compare('is_tenaga_kehutanan',$this->is_tenaga_kehutanan,true);
		$criteria->compare('is_tenaga_tetap',$this->is_tenaga_tetap,true);
		$criteria->compare('id_pendidikan',$this->id_pendidikan);
		$criteria->compare('id_jenis_kewarganegaraan',$this->id_jenis_kewarganegaraan);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('realisasi',$this->realisasi,true);
		$criteria->compare('persentase',$this->persentase,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktSerapanTenagaKerja the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
