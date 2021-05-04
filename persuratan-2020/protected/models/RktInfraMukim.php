<?php

/**
 * This is the model class for table "rkt_infra_mukim".
 *
 * The followings are the available columns in table 'rkt_infra_mukim':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_infra_mukim
 * @property double $jumlah
 * @property double $realisasi
 * @property double $persentase
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property RealisasiRktInfraMukim[] $realisasiRktInfraMukims
 * @property MasterJenisInfraMukim $idInfraMukim
 * @property Rkt $idRkt
 */
class RktInfraMukim extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_infra_mukim';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, id_infra_mukim', 'required'),
			array('id_rkt, id_infra_mukim', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			array('keterangan','length', 'max'=>255),
			array('id_infra_mukim' , 'cekexist','on'=>'inputForm'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, id_infra_mukim, jumlah, keterangan, realisasi, persentase', 'safe', 'on'=>'search'),
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
			'realisasiRktInfraMukims' => array(self::HAS_MANY, 'RealisasiRktInfraMukim', 'id_rkt_infra_mukim'),
			'idInfraMukim' => array(self::BELONGS_TO, 'MasterJenisInfraMukim', 'id_infra_mukim'),
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
						'id_infra_mukim'=>Yii::t('app','Id Infra Mukim'),
						'jumlah'=>Yii::t('app','Jumlah'),
						'realisasi'=>Yii::t('app','Realisasi'),
						'persentase'=>Yii::t('app','Persentase'),
						'keterangan'=>Yii::t('app','Keterangan'),
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
		$criteria->compare('id_infra_mukim',$this->id_infra_mukim);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('keterangan',$this->keterangan);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktInfraMukim the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function cekexist()
	{
	    $model = self::findByAttributes(array('id_infra_mukim'=>$this->id_infra_mukim,'id_rkt'=>$this->id_rkt));
	    if ($model)
	         $this->addError('id_infra_mukim', 'Jenis Infrastruktur Pemukiman yang dipilih Sudah tersimpan sebelumnya, silahkan untuk mengupdate data bila diperlukan') ;
	}
}
