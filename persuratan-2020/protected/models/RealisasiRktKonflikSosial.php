<?php

/**
 * This is the model class for table "realisasi_rkt_konflik_sosial".
 *
 * The followings are the available columns in table 'realisasi_rkt_konflik_sosial':
 * @property integer $id
 * @property integer $id_rkt_konflik_sosial
 * @property integer $id_bulan
 * @property string $tahun
 * @property string $persentase
 * @property string $penanganan
 * @property string $status
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property RktKonflikSosial $idRktKonflikSosial
 * @property MasterBulan $idBulan
 */
class RealisasiRktKonflikSosial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id_perusahaan, $tahun_mulai;
	public function tableName()
	{
		return 'realisasi_rkt_konflik_sosial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt_konflik_sosial, penanganan, status', 'required'),
			array('id_rkt_konflik_sosial, id_bulan', 'numerical', 'integerOnly'=>true),
			array('tahun', 'length', 'max'=>4),
			array('persentase', 'length', 'max'=>10),
			array('penanganan, status', 'length', 'max'=>255),
			#array('created, updated', 'safe'),

			array(
				'created',
				'default',
				'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false,
				'on'=>'insert'
			),
			array(
				'updated',
				'default',
				'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false,
				'on'=>'editable'
			),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt_konflik_sosial, id_bulan, tahun, persentase, penanganan, status', 'safe', 'on'=>'search'),
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
			'idRktKonflikSosial' => array(self::BELONGS_TO, 'RktKonflikSosial', 'id_rkt_konflik_sosial'),
			'idBulan' => array(self::BELONGS_TO, 'MasterBulan', 'id_bulan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_rkt_konflik_sosial'=>Yii::t('app','Jenis Konflik'),
						'id_bulan'=>Yii::t('app','Bulan'),
						'tahun'=>Yii::t('app','Tahun'),
						'persentase'=>Yii::t('app','Persentase'),
						'penanganan'=>Yii::t('app','Penanganan'),
						'status'=>Yii::t('app','Status'),
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
		$criteria->compare('id_rkt_konflik_sosial',$this->id_rkt_konflik_sosial);
		$criteria->compare('id_bulan',$this->id_bulan);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('persentase',$this->persentase,true);
		$criteria->compare('penanganan',$this->penanganan,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByRkt()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_rkt_konflik_sosial',$this->id_rkt_konflik_sosial);
		$criteria->compare('id_bulan',$this->id_bulan);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('persentase',$this->persentase,true);
		$criteria->compare('penanganan',$this->penanganan,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->join = "INNER JOIN rkt_konflik_sosial
			ON t.id_rkt_konflik_sosial = rkt_konflik_sosial.id";
		$criteria->join .= " INNER JOIN rkt
			ON rkt_konflik_sosial.id_rkt = rkt.id";
		$criteria->join .= " INNER JOIN master_bulan
			ON t.id_bulan = master_bulan.id";
		$criteria->compare('rkt.id_perusahaan',$this->id_perusahaan);
		$criteria->compare('rkt.tahun_mulai',$this->tahun_mulai);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RealisasiRktKonflikSosial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
