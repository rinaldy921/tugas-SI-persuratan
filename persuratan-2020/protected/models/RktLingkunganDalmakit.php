<?php

/**
 * This is the model class for table "rkt_lingkungan_dalmakit".
 *
 * The followings are the available columns in table 'rkt_lingkungan_dalmakit':
 * @property integer $id
 * @property integer $id_rkt
 * @property double $jumlah
 * @property string $keterangan
 * @property double $realisasi
 *
 * The followings are the available model relations:
 * @property RealisasiRktLingkunganDalmakit[] $realisasiRktLingkunganDalmakits
 */
class RktLingkunganDalmakit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_lingkungan_dalmakit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, jumlah, rencana', 'required'),
			array('id_rkt', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			array('keterangan, rencana', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, jumlah, keterangan, realisasi, rencana, persentase', 'safe', 'on'=>'search'),
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
			'realisasiRktLingkunganDalmakits' => array(self::HAS_MANY, 'RealisasiRktLingkunganDalmakit', 'id_rkt_lingkungan_dalmakit'),
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
						'jumlah'=>Yii::t('app','Jumlah'),
						'keterangan'=>Yii::t('app','Keterangan'),
						'realisasi'=>Yii::t('app','Realisasi'),
						'rencana'=>Yii::t('app','Rencana'),
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
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('rencana',$this->rencana);
		$criteria->compare('persentase',$this->persentase);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktLingkunganDalmakit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
