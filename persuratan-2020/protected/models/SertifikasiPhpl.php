<?php

/**
 * This is the model class for table "sertifikasi_phpl".
 *
 * The followings are the available columns in table 'sertifikasi_phpl':
 * @property integer $id
 * @property integer $id_perusahaan
 * @property integer $nilai_kinerja
 * @property string $predikat
 * @property string $tanggal_mulai
 * @property string $tanggal_berakhir
 * @property string $penerbit
 * @property string $nomor
 * @property integer $id_penerbit
 * @property string $tanggal
 * @property string $file_doc
 * @property integer $is_verified
 *
 * The followings are the available model relations:
 * @property PenilikanPhpl[] $penilikanPhpls
 */
class SertifikasiPhpl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sertifikasi_phpl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_perusahaan', 'required'),
			array('id_perusahaan, nilai_kinerja, id_penerbit, is_verified', 'numerical', 'integerOnly'=>true),
			array('predikat, penerbit, nomor, file_doc', 'length', 'max'=>255),
			array('tanggal_mulai, tanggal_berakhir, tanggal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_perusahaan, nilai_kinerja, predikat, tanggal_mulai, tanggal_berakhir, penerbit, nomor, id_penerbit, tanggal, file_doc, is_verified', 'safe', 'on'=>'search'),
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
                       'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
			'penilikanPhpls' => array(self::HAS_MANY, 'PenilikanPhpl', 'id_sertifikat_phpl'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_perusahaan'=>Yii::t('app','Id Perusahaan'),
						'nilai_kinerja'=>Yii::t('app','Nilai Kinerja'),
						'predikat'=>Yii::t('app','Predikat'),
						'tanggal_mulai'=>Yii::t('app','Tanggal Mulai'),
						'tanggal_berakhir'=>Yii::t('app','Tanggal Berakhir'),
						'penerbit'=>Yii::t('app','Penerbit'),
						'nomor'=>Yii::t('app','Nomor'),
						'id_penerbit'=>Yii::t('app','Id Penerbit'),
						'tanggal'=>Yii::t('app','Tanggal'),
						'file_doc'=>Yii::t('app','File Doc'),
						'is_verified'=>Yii::t('app','Is Verified'),
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
		$criteria->compare('id_perusahaan',$this->id_perusahaan);
		$criteria->compare('nilai_kinerja',$this->nilai_kinerja);
		$criteria->compare('predikat',$this->predikat,true);
		$criteria->compare('tanggal_mulai',$this->tanggal_mulai,true);
		$criteria->compare('tanggal_berakhir',$this->tanggal_berakhir,true);
		$criteria->compare('penerbit',$this->penerbit,true);
		$criteria->compare('nomor',$this->nomor,true);
		$criteria->compare('id_penerbit',$this->id_penerbit);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('file_doc',$this->file_doc,true);
		$criteria->compare('is_verified',$this->is_verified);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SertifikasiPhpl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
