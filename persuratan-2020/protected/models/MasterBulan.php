<?php

/**
 * This is the model class for table "master_bulan".
 *
 * The followings are the available columns in table 'master_bulan':
 * @property integer $id
 * @property string $bulan
 *
 * The followings are the available model relations:
 * @property RealisasiRktArealKerja[] $realisasiRktArealKerjas
 * @property RealisasiRktArealNonProduktif[] $realisasiRktArealNonProduktifs
 * @property RealisasiRktArealProduktif[] $realisasiRktArealProduktifs
 * @property RealisasiRktBangunMitra[] $realisasiRktBangunMitras
 * @property RealisasiRktBibit[] $realisasiRktBibits
 * @property RealisasiRktBibitBak[] $realisasiRktBibitBaks
 * @property RealisasiRktDangir[] $realisasiRktDangirs
 * @property RealisasiRktGanis[] $realisasiRktGanises
 * @property RealisasiRktInfraMukim[] $realisasiRktInfraMukims
 * @property RealisasiRktInventarisasi[] $realisasiRktInventarisasis
 * @property RealisasiRktJarang[] $realisasiRktJarangs
 * @property RealisasiRktKawasanLindung[] $realisasiRktKawasanLindungs
 * @property RealisasiRktKerjasamaKoperasi[] $realisasiRktKerjasamaKoperasis
 * @property RealisasiRktLingkunganDalkar[] $realisasiRktLingkunganDalkars
 * @property RealisasiRktLingkunganDalmakit[] $realisasiRktLingkunganDalmakits
 * @property RealisasiRktLingkunganDungtan[] $realisasiRktLingkunganDungtans
 * @property RealisasiRktMasukGunaAlat[] $realisasiRktMasukGunaAlats
 * @property RealisasiRktPanenAreal[] $realisasiRktPanenAreals
 * @property RealisasiRktPanenArealBak[] $realisasiRktPanenArealBaks
 * @property RealisasiRktPanenVolumeSiapLahan[] $realisasiRktPanenVolumeSiapLahans
 * @property RealisasiRktPanenVolumeTanaman[] $realisasiRktPanenVolumeTanamen
 * @property RealisasiRktPasar[] $realisasiRktPasars
 * @property RealisasiRktPeningkatanSdm[] $realisasiRktPeningkatanSdms
 * @property RealisasiRktPwh[] $realisasiRktPwhs
 * @property RealisasiRktSarpras[] $realisasiRktSarprases
 * @property RealisasiRktSiapLahan[] $realisasiRktSiapLahans
 * @property RealisasiRktSulam[] $realisasiRktSulams
 * @property RealisasiRktTanam[] $realisasiRktTanams
 * @property RealisasiRktTataBatas[] $realisasiRktTataBatases
 */
class MasterBulan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'master_bulan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bulan', 'required'),
			array('bulan', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bulan', 'safe', 'on'=>'search'),
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
			'realisasiRktArealKerjas' => array(self::HAS_MANY, 'RealisasiRktArealKerja', 'id_bulan'),
			'realisasiRktArealNonProduktifs' => array(self::HAS_MANY, 'RealisasiRktArealNonProduktif', 'id_bulan'),
			'realisasiRktArealProduktifs' => array(self::HAS_MANY, 'RealisasiRktArealProduktif', 'id_bulan'),
			'realisasiRktBangunMitras' => array(self::HAS_MANY, 'RealisasiRktBangunMitra', 'id_bulan'),
			'realisasiRktBibits' => array(self::HAS_MANY, 'RealisasiRktBibit', 'id_bulan'),
			'realisasiRktBibitBaks' => array(self::HAS_MANY, 'RealisasiRktBibitBak', 'id_bulan'),
			'realisasiRktDangirs' => array(self::HAS_MANY, 'RealisasiRktDangir', 'id_bulan'),
			'realisasiRktGanises' => array(self::HAS_MANY, 'RealisasiRktGanis', 'id_bulan'),
			'realisasiRktInfraMukims' => array(self::HAS_MANY, 'RealisasiRktInfraMukim', 'id_bulan'),
			'realisasiRktInventarisasis' => array(self::HAS_MANY, 'RealisasiRktInventarisasi', 'id_bulan'),
			'realisasiRktJarangs' => array(self::HAS_MANY, 'RealisasiRktJarang', 'id_bulan'),
			'realisasiRktKawasanLindungs' => array(self::HAS_MANY, 'RealisasiRktKawasanLindung', 'id_bulan'),
			'realisasiRktKerjasamaKoperasis' => array(self::HAS_MANY, 'RealisasiRktKerjasamaKoperasi', 'id_bulan'),
			'realisasiRktLingkunganDalkars' => array(self::HAS_MANY, 'RealisasiRktLingkunganDalkar', 'id_bulan'),
			'realisasiRktLingkunganDalmakits' => array(self::HAS_MANY, 'RealisasiRktLingkunganDalmakit', 'id_bulan'),
			'realisasiRktLingkunganDungtans' => array(self::HAS_MANY, 'RealisasiRktLingkunganDungtan', 'id_bulan'),
			'realisasiRktMasukGunaAlats' => array(self::HAS_MANY, 'RealisasiRktMasukGunaAlat', 'id_bulan'),
			'realisasiRktPanenAreals' => array(self::HAS_MANY, 'RealisasiRktPanenAreal', 'id_bulan'),
			'realisasiRktPanenArealBaks' => array(self::HAS_MANY, 'RealisasiRktPanenArealBak', 'id_bulan'),
			'realisasiRktPanenVolumeSiapLahans' => array(self::HAS_MANY, 'RealisasiRktPanenVolumeSiapLahan', 'id_bulan'),
			'realisasiRktPanenVolumeTanamen' => array(self::HAS_MANY, 'RealisasiRktPanenVolumeTanaman', 'id_bulan'),
			'realisasiRktPasars' => array(self::HAS_MANY, 'RealisasiRktPasar', 'id_bulan'),
			'realisasiRktPeningkatanSdms' => array(self::HAS_MANY, 'RealisasiRktPeningkatanSdm', 'id_bulan'),
			'realisasiRktPwhs' => array(self::HAS_MANY, 'RealisasiRktPwh', 'id_bulan'),
			'realisasiRktSarprases' => array(self::HAS_MANY, 'RealisasiRktSarpras', 'id_bulan'),
			'realisasiRktSiapLahans' => array(self::HAS_MANY, 'RealisasiRktSiapLahan', 'id_bulan'),
			'realisasiRktSulams' => array(self::HAS_MANY, 'RealisasiRktSulam', 'id_bulan'),
			'realisasiRktTanams' => array(self::HAS_MANY, 'RealisasiRktTanam', 'id_bulan'),
			'realisasiRktTataBatases' => array(self::HAS_MANY, 'RealisasiRktTataBatas', 'id_bulan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'bulan'=>Yii::t('app','Bulan'),
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
		$criteria->compare('bulan',$this->bulan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MasterBulan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
           
        public function getListBulan()
        {
                $query = "SELECT r.* 
                                FROM master_bulan r ORDER BY r.id ASC;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

               
//                print_r("<pre>");
//        print_r($categorylist);
//        print_r("</pre>");        exit(1);
        
        
                return $result;
        }
}
