<?php

/**
 * This is the model class for table "rku_tumpangsari".
 *
 * The followings are the available columns in table 'rku_tumpangsari':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_jenis_tanaman
 * @property integer $id_jenis_lahan
 * @property integer $id_blok
 * @property integer $tahun
 * @property double $jumlah
 * @property integer $daur
 * @property integer $rkt_ke
 *
 * The followings are the available model relations:
 * @property Rku $idRku
 */
class RkuTumpangsari extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_tumpangsari';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, tahun', 'required'),
			array('id_rku, id_jenis_tanaman, id_jenis_lahan, id_blok, tahun, daur, rkt_ke', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, id_jenis_tanaman, id_jenis_lahan, id_blok, tahun, jumlah, daur, rkt_ke', 'safe', 'on'=>'search'),
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
						'id'=>Yii::t('app','ID'),
						'id_rku'=>Yii::t('app','Id Rku'),
						'id_jenis_tanaman'=>Yii::t('app','Id Jenis Tanaman'),
						'id_jenis_lahan'=>Yii::t('app','Id Jenis Lahan'),
						'id_blok'=>Yii::t('app','Id Blok'),
						'tahun'=>Yii::t('app','Tahun'),
						'jumlah'=>Yii::t('app','Jumlah'),
						'daur'=>Yii::t('app','Daur'),
						'rkt_ke'=>Yii::t('app','Rkt Ke'),
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
		$criteria->compare('id_jenis_tanaman',$this->id_jenis_tanaman);
		$criteria->compare('id_jenis_lahan',$this->id_jenis_lahan);
		$criteria->compare('id_blok',$this->id_blok);
		$criteria->compare('tahun',$this->tahun);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('daur',$this->daur);
		$criteria->compare('rkt_ke',$this->rkt_ke);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuTumpangsari the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
