<?php

/**
 * This is the model class for table "rku_tanaman_silvikultur".
 *
 * The followings are the available columns in table 'rku_tanaman_silvikultur':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_jenis_produksi_lahan
 * @property integer $id_jenis_tanaman
 * @property integer $daur
 * @property integer $id_jarak_tanam
 * @property string $jarak_tanam
 *
 * The followings are the available model relations:
 * @property RktBibit[] $rktBibits
 * @property RktPanenAreal[] $rktPanenAreals
 * @property RktPanenVolumeTanaman[] $rktPanenVolumeTanamen
 * @property RktTanam[] $rktTanams
 * @property RkuBibitNew[] $rkuBibitNews
 * @property RkuPanen[] $rkuPanens
 * @property RkuPelihara[] $rkuPeliharas
 * @property RkuPenyiapanLahan[] $rkuPenyiapanLahans
 * @property RkuTanam[] $rkuTanams
 * @property MasterJarakTanam $idJarakTanam
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property MasterJenisTanaman $idJenisTanaman
 * @property Rku $idRku
 */
class RkuTanamanSilvikultur extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_tanaman_silvikultur';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, id_jenis_produksi_lahan, id_jenis_tanaman, daur, jarak_tanam', 'required'),
			array('id_rku, id_jenis_produksi_lahan, id_jenis_tanaman, daur, id_jarak_tanam', 'numerical', 'integerOnly'=>true),
			array('jarak_tanam', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, id_jenis_produksi_lahan, id_jenis_tanaman, daur, id_jarak_tanam, jarak_tanam', 'safe', 'on'=>'search'),
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
			'rktBibits' => array(self::HAS_MANY, 'RktBibit', 'id_rku_tansil'),
			'rktPanenAreals' => array(self::HAS_MANY, 'RktPanenAreal', 'id_rku_tansil'),
			'rktPanenVolumeTanamen' => array(self::HAS_MANY, 'RktPanenVolumeTanaman', 'id_rku_tansil'),
			'rktTanams' => array(self::HAS_MANY, 'RktTanam', 'id_rku_tansil'),
			'rkuBibitNews' => array(self::HAS_MANY, 'RkuBibitNew', 'id_tanaman_silvikultur'),
			'rkuPanens' => array(self::HAS_MANY, 'RkuPanen', 'id_tanaman_silvikultur'),
			'rkuPeliharas' => array(self::HAS_MANY, 'RkuPelihara', 'id_tanaman_silvikultur'),
			'rkuPenyiapanLahans' => array(self::HAS_MANY, 'RkuPenyiapanLahan', 'id_tanaman_silvikultur'),
			'rkuTanams' => array(self::HAS_MANY, 'RkuTanam', 'id_tanaman_silvikultur'),
			'idJarakTanam' => array(self::BELONGS_TO, 'MasterJarakTanam', 'id_jarak_tanam'),
			'idJenisProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
			'idJenisTanaman' => array(self::BELONGS_TO, 'MasterJenisTanaman', 'id_jenis_tanaman'),
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
						'id_jenis_produksi_lahan'=>Yii::t('app','Tata Ruang'),
						'id_jenis_tanaman'=>Yii::t('app','Jenis Tanaman'),
						'daur'=>Yii::t('app','Daur'),
						'id_jarak_tanam'=>Yii::t('app','Id Jarak Tanam'),
						'jarak_tanam'=>Yii::t('app','Jarak Tanam'),
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
		$criteria->compare('id_jenis_tanaman',$this->id_jenis_tanaman);
		$criteria->compare('daur',$this->daur);
		$criteria->compare('id_jarak_tanam',$this->id_jarak_tanam);
		$criteria->compare('jarak_tanam',$this->jarak_tanam,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuTanamanSilvikultur the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function getDetilTanamanSilvikultur($rkuId)
        {
            $query = "SELECT r.id,
                    IFNULL((SELECT m.jenis_produksi FROM master_jenis_produksi_lahan m WHERE m.id=r.id_jenis_produksi_lahan),0)AS jenis,
                    IFNULL((SELECT m.nama_tanaman FROM master_jenis_tanaman m WHERE m.id = r.id_jenis_tanaman),0)AS tanaman,
                    r.jarak_tanam 
                    FROM rku_tanaman_silvikultur r WHERE id_rku=".$rkuId." ORDER BY r.id_jenis_produksi_lahan ASC
                    ;";
        
            $result = Yii::app()->db->createCommand($query)->queryAll();
            
            return $result;
        }
}
