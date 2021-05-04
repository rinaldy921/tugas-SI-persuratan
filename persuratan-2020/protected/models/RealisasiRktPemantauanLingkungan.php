<?php

/**
 * This is the model class for table "realisasi_rkt_pemantauan_lingkungan".
 *
 * The followings are the available columns in table 'realisasi_rkt_pemantauan_lingkungan':
 * @property integer $id
 * @property integer $id_rkt_pemantauan_lingkungan
 * @property integer $id_bulan
 * @property string $tahun
 * @property string $kegiatan
 * @property string $keterangan
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property RktPemantauanLingkungan $idRktPemantauanLingkungan
 */
class RealisasiRktPemantauanLingkungan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id_rkt;
	public function tableName()
	{
		return 'realisasi_rkt_pemantauan_lingkungan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt_pemantauan_lingkungan, id_bulan, tahun, kegiatan, keterangan, created, updated', 'required'),
			array('id_rkt_pemantauan_lingkungan, id_bulan', 'numerical', 'integerOnly'=>true),
			array('tahun', 'length', 'max'=>4),
			array('kegiatan, keterangan', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt_pemantauan_lingkungan, id_bulan, tahun, kegiatan, keterangan, created, updated', 'safe', 'on'=>'search'),
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
			'idRktPemantauanLingkungan' => array(self::BELONGS_TO, 'RktPemantauanLingkungan', 'id_rkt_pemantauan_lingkungan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_rkt_pemantauan_lingkungan'=>Yii::t('app','Id Rkt Pemantauan Lingkungan'),
						'id_bulan'=>Yii::t('app','Id Bulan'),
						'tahun'=>Yii::t('app','Tahun'),
						'kegiatan'=>Yii::t('app','Kegiatan'),
						'keterangan'=>Yii::t('app','Keterangan'),
						'created'=>Yii::t('app','Created'),
						'updated'=>Yii::t('app','Updated'),
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
		$criteria->compare('id_rkt_pemantauan_lingkungan',$this->id_rkt_pemantauan_lingkungan);
		$criteria->compare('id_bulan',$this->id_bulan);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('kegiatan',$this->kegiatan,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RealisasiRktPemantauanLingkungan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchByRkt()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array('idRktPemantauanLingkungan');
		$criteria->compare('idRktPemantauanLingkungan.id_rkt',$this->id_rkt);
		$criteria->compare('t.id_bulan',$this->id_bulan);
		$criteria->compare('t.tahun',$this->tahun);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
