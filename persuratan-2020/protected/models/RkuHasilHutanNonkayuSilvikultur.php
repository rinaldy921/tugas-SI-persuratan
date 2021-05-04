<?php

/**
 * This is the model class for table "rku_hasil_hutan_nonkayu_silvikultur".
 *
 * The followings are the available columns in table 'rku_hasil_hutan_nonkayu_silvikultur':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_jenis_produksi_lahan
 * @property integer $id_hasil_hutan_nonkayu
 * @property integer $id_satuan_volume_nonkayu
 *
 * The followings are the available model relations:
 * @property Rku $idRku
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property MasterHasilHutanNonkayu $idHasilHutanNonkayu
 * @property SatuanVolumeNonkayu $idSatuanVolumeNonkayu
 */
class RkuHasilHutanNonkayuSilvikultur extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_hasil_hutan_nonkayu_silvikultur';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, id_jenis_produksi_lahan, id_hasil_hutan_nonkayu, id_satuan_volume_nonkayu', 'required'),
			array('id_rku, id_jenis_produksi_lahan, id_hasil_hutan_nonkayu, id_satuan_volume_nonkayu', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, id_jenis_produksi_lahan, id_hasil_hutan_nonkayu, id_satuan_volume_nonkayu', 'safe', 'on'=>'search'),
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
			'idJenisProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
			'idHasilHutanNonkayu' => array(self::BELONGS_TO, 'MasterHasilHutanNonkayu', 'id_hasil_hutan_nonkayu'),
			'idSatuanVolumeNonkayu' => array(self::BELONGS_TO, 'SatuanVolumeNonkayu', 'id_satuan_volume_nonkayu'),
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
						'id_jenis_produksi_lahan'=>Yii::t('app','Id Jenis Produksi Lahan'),
						'id_hasil_hutan_nonkayu'=>Yii::t('app','Id Hasil Hutan Nonkayu'),
						'id_satuan_volume_nonkayu'=>Yii::t('app','Id Satuan Volume Nonkayu'),
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
		$criteria->compare('id_jenis_produksi_lahan',$this->id_jenis_produksi_lahan);
		$criteria->compare('id_hasil_hutan_nonkayu',$this->id_hasil_hutan_nonkayu);
		$criteria->compare('id_satuan_volume_nonkayu',$this->id_satuan_volume_nonkayu);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuHasilHutanNonkayuSilvikultur the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
