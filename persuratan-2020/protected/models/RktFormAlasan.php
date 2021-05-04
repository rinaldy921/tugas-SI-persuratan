<?php

/**
 * This is the model class for table "rkt_form_alasan".
 *
 * The followings are the available columns in table 'rkt_form_alasan':
 * @property integer $id
 * @property string $no_surat
 * @property string $tanggal
 * @property string $keterangan
 * @property string $file
 *
 * The followings are the available model relations:
 * @property RktBibit[] $rktBibits
 */
class RktFormAlasan extends CActiveRecord
{
        public $tahun_ke;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_form_alasan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no_surat, tanggal, keterangan', 'required'),
			array('no_surat, keterangan', 'length', 'max'=>50),
			array('file', 'length', 'max'=>255),
                        array('id_rku, rkt_ke', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, no_surat, tanggal, keterangan, file', 'safe', 'on'=>'search'),
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
			'rktBibits' => array(self::HAS_MANY, 'RktBibit', 'id_rkt_form_alasan'),
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
						'no_surat'=>Yii::t('app','No Surat'),
						'tanggal'=>Yii::t('app','Tanggal'),
						'keterangan'=>Yii::t('app','Keterangan'),
						'file'=>Yii::t('app','File'),
                                                'id_rku'=>Yii::t('app','ID RKU'),
                                                'rkt_ke'=>Yii::t('app','Blok RKT Tahun Ke')
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
		$criteria->compare('no_surat',$this->no_surat,true);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('file',$this->file,true);
                $criteria->compare('rkt_ke',$this->rkt_ke);
                $criteria->compare('id_rku',$this->id_rku);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktFormAlasan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
