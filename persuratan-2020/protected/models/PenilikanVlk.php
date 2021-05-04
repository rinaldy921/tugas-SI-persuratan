<?php

/**
 * This is the model class for table "penilikan_vlk".
 *
 * The followings are the available columns in table 'penilikan_vlk':
 * @property integer $id
 * @property integer $id_sertifikat_vlk
 * @property integer $id_penerbit
 * @property string $nomor
 * @property integer $penilikan_ke
 * @property string $tgl_penetapan
 * @property string $predikat
 * @property string $dinyatakan
 *
 * The followings are the available model relations:
 * @property MasterPenerbit $idPenerbit
 * @property SertifikasiVlk $idSertifikatVlk
 */
class PenilikanVlk extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penilikan_vlk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_sertifikat_vlk, id_penerbit, nomor, penilikan_ke, tgl_penetapan, predikat', 'required'),
			array('id_sertifikat_vlk, penilikan_ke', 'numerical', 'integerOnly'=>true),
			array('nomor, predikat, dinyatakan', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_sertifikat_vlk, id_penerbit, nomor, penilikan_ke, tgl_penetapan, predikat, dinyatakan', 'safe', 'on'=>'search'),
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
			'idPenerbit' => array(self::BELONGS_TO, 'MasterPenerbit', 'id_penerbit'),
			'idSertifikatVlk' => array(self::BELONGS_TO, 'SertifikasiVlk', 'id_sertifikat_vlk'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_sertifikat_vlk'=>Yii::t('app','Id Sertifikat Vlk'),
						'id_penerbit'=>Yii::t('app','Penerbit'),
						'nomor'=>Yii::t('app','Nomor'),
						'penilikan_ke'=>Yii::t('app','Penilikan Ke'),
						'tgl_penetapan'=>Yii::t('app','Tgl Penetapan'),
						'predikat'=>"Keputusan",//Yii::t('app','Predikat'),
						'dinyatakan'=>Yii::t('app','Dinyatakan'),
						'file_doc' => "File Dokumen"
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
		$criteria->compare('id_sertifikat_vlk',$this->id_sertifikat_vlk);
		$criteria->compare('id_penerbit',$this->id_penerbit);
		$criteria->compare('nomor',$this->nomor,true);
		$criteria->compare('penilikan_ke',$this->penilikan_ke);
		$criteria->compare('tgl_penetapan',$this->tgl_penetapan,true);
		$criteria->compare('predikat',$this->predikat,true);
		$criteria->compare('dinyatakan',$this->dinyatakan,true);
		$criteria->compare('file_doc',$this->file_doc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PenilikanVlk the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
