<?php

/**
 * This is the model class for table "rku".
 *
 * The followings are the available columns in table 'rku':
 * @property integer $id_rku
 * @property integer $id_perusahaan
 * @property string $nomor_sk
 * @property string $tgl_sk
 * @property string $tahun_mulai
 * @property string $tahun_sampai
 * @property string $mulai_berlaku
 * @property string $akhir_berlaku
 * @property integer $id_kelas_perusahaan
 * @property integer $status
 * @property integer $id_rev
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property PenilaianKinerja[] $penilaianKinerjas
 * @property Rkt[] $rkts
 * @property Perusahaan $idPerusahaan
 * @property RkuAlatDamkar[] $rkuAlatDamkars
 * @property RkuArealKerja[] $rkuArealKerjas
 * @property RkuArealNonProduktif[] $rkuArealNonProduktifs
 * @property RkuArealProduktif[] $rkuArealProduktifs
 * @property RkuBibit[] $rkuBibits
 * @property RkuBibitNew[] $rkuBibitNews
 * @property RkuGanis[] $rkuGanises
 * @property RkuHamaPenyakit[] $rkuHamaPenyakits
 * @property RkuInfraMukim[] $rkuInfraMukims
 * @property RkuKawasanLindung[] $rkuKawasanLindungs
 * @property RkuKelembagaan[] $rkuKelembagaans
 * @property RkuPanen[] $rkuPanens
 * @property RkuPasar[] $rkuPasars
 * @property RkuPelihara[] $rkuPeliharas
 * @property RkuPemantauanLingkungan[] $rkuPemantauanLingkungans
 * @property RkuPenyiapanLahan[] $rkuPenyiapanLahans
 * @property RkuPeralatan[] $rkuPeralatans
 * @property RkuPerambahanHutan[] $rkuPerambahanHutans
 * @property RkuPotensiProduksi[] $rkuPotensiProduksis
 * @property RkuPwh[] $rkuPwhs
 * @property RkuSarpras[] $rkuSarprases
 * @property RkuSiapLahan[] $rkuSiapLahans
 * @property RkuSistemSilvikultur[] $rkuSistemSilvikulturs
 * @property RkuTanam[] $rkuTanams
 * @property RkuTanamanSilvikultur[] $rkuTanamanSilvikulturs
 * @property RkuTataBatas[] $rkuTataBatases
 * @property RkuTeknikPemadaman[] $rkuTeknikPemadamen
 * @property SpasialRku[] $spasialRkus
 */
class Rku extends CActiveRecord
{
	public $checkbox = 1;
	public $blok;
        public $sektor;
        public $kabupaten;
        public $namaSektor;
        public $statusCheck;
        public $idblok;
        public $idsektor;
        public $idRktCopy;
        public $_tahun;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku';
	}

	public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => 'modified_at',
                'setUpdateOnCreate' => true,
            ),
        );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nomor_sk, tgl_sk, tahun_mulai, tahun_sampai, mulai_berlaku, akhir_berlaku, id_kelas_perusahaan', 'required'),
			array('id_perusahaan, id_kelas_perusahaan, status, edit_status, id_rev', 'numerical', 'integerOnly'=>true),
			array('nomor_sk', 'length', 'max'=>255),
			array('tahun_mulai, tahun_sampai', 'length', 'max'=>4),
			array('created_at, modified_at, checkbox', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_rku, id_perusahaan, nomor_sk, tgl_sk, tahun_mulai, tahun_sampai, mulai_berlaku, akhir_berlaku, id_kelas_perusahaan, status, id_rev, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'penilaianKinerjas' => array(self::HAS_MANY, 'PenilaianKinerja', 'idKelasPerusahaan_rku'),
			'rkts' => array(self::HAS_MANY, 'Rkt', 'id_rku'),
			'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
			'idKelasPerusahaan' => array(self::BELONGS_TO, 'MasterKelasPerusahaan', 'id_kelas_perusahaan'),
			'rkuAlatDamkars' => array(self::HAS_MANY, 'RkuAlatDamkar', 'id_rku'),
			'rkuArealKerjas' => array(self::HAS_MANY, 'RkuArealKerja', 'id_rku'),
			'rkuArealNonProduktifs' => array(self::HAS_MANY, 'RkuArealNonProduktif', 'id_rku'),
			'rkuArealProduktifs' => array(self::HAS_MANY, 'RkuArealProduktif', 'id_rku'),
			'rkuBibits' => array(self::HAS_MANY, 'RkuBibit', 'id_rku'),
			'rkuBibitNews' => array(self::HAS_MANY, 'RkuBibitNew', 'id_rku'),
			'rkuGanises' => array(self::HAS_MANY, 'RkuGanis', 'id_rku'),
			'rkuHamaPenyakits' => array(self::HAS_MANY, 'RkuHamaPenyakit', 'id_rku'),
			'rkuInfraMukims' => array(self::HAS_MANY, 'RkuInfraMukim', 'id_rku'),
			'rkuKawasanLindungs' => array(self::HAS_MANY, 'RkuKawasanLindung', 'id_rku'),
			'rkuKelembagaans' => array(self::HAS_MANY, 'RkuKelembagaan', 'id_rku'),
			'rkuPanens' => array(self::HAS_MANY, 'RkuPanen', 'id_rku'),
			'rkuPasars' => array(self::HAS_MANY, 'RkuPasar', 'id_rku'),
			'rkuPeliharas' => array(self::HAS_MANY, 'RkuPelihara', 'id_rku'),
			'rkuPemantauanLingkungans' => array(self::HAS_MANY, 'RkuPemantauanLingkungan', 'id_rku'),
			'rkuPenyiapanLahans' => array(self::HAS_MANY, 'RkuPenyiapanLahan', 'id_rku'),
			'rkuPeralatans' => array(self::HAS_MANY, 'RkuPeralatan', 'id_rku'),
			'rkuPerambahanHutans' => array(self::HAS_MANY, 'RkuPerambahanHutan', 'id_rku'),
			'rkuPotensiProduksis' => array(self::HAS_MANY, 'RkuPotensiProduksi', 'id_rku'),
			'rkuPwhs' => array(self::HAS_MANY, 'RkuPwh', 'id_rku'),
			'rkuSarprases' => array(self::HAS_MANY, 'RkuSarpras', 'id_rku'),
			'rkuSiapLahans' => array(self::HAS_MANY, 'RkuSiapLahan', 'id_rku'),
			'rkuSistemSilvikulturs' => array(self::HAS_MANY, 'RkuSistemSilvikultur', 'id_rku'),
			'rkuTanams' => array(self::HAS_MANY, 'RkuTanam', 'id_rku'),
			'rkuTanamanSilvikulturs' => array(self::HAS_MANY, 'RkuTanamanSilvikultur', 'id_rku'),
			'rkuTataBatases' => array(self::HAS_MANY, 'RkuTataBatas', 'id_rku'),
			'rkuTeknikPemadamen' => array(self::HAS_MANY, 'RkuTeknikPemadaman', 'id_rku'),
			'spasialRkus' => array(self::HAS_MANY, 'SpasialRku', 'id_rku'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id_rku'=>Yii::t('app','Id Rku'),
						'id_perusahaan'=>Yii::t('app','Perusahaan'),
						'nomor_sk'=>Yii::t('app','Nomor SK'),
						'tgl_sk'=>Yii::t('app','Tanggal SK'),
						'tahun_mulai'=>Yii::t('app','Tahun Mulai'),
						'tahun_sampai'=>Yii::t('app','Tahun Sampai'),
						'mulai_berlaku'=>Yii::t('app','Mulai Berlaku RKU'),
						'akhir_berlaku'=>Yii::t('app','Akhir Berlaku RKU'),
						'id_kelas_perusahaan'=>Yii::t('app','Kelas Perusahaan'),
						'status'=>Yii::t('app','Status'),
						'id_rev'=>Yii::t('app','Id Rev'),
						'created_at'=>Yii::t('app','Created At'),
						'modified_at'=>Yii::t('app','Modified At'),
						'statusCheck' => 'Ceklis Bila Ada Sektor',
                                    'edit_status' => 'Edit Status',
			            'blok' => 'Nama Petak Kerja',
			            'sektor' => 'Nama Unit Kelestarian',
                                    'idsektor' => 'ID Sektor',
                                    'idblok' => 'ID Blok',
                                    'namaSektor' => 'Nama Unit Kelestarian',
                                    'kabupaten' => 'Nama Kabupaten',
                                    'idRktCopy' => 'RKT COPY',
						'file_doc' => "File Dokumen",
                                                'file_shp' => "File Peta",
                                                '_tahun'=> 'Pilih Tahun',
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

		$criteria->compare('id_rku',$this->id_rku);
		$criteria->compare('id_perusahaan',$this->id_perusahaan);
		$criteria->compare('nomor_sk',$this->nomor_sk,true);
		$criteria->compare('tgl_sk',$this->tgl_sk,true);
		$criteria->compare('tahun_mulai',$this->tahun_mulai,true);
		$criteria->compare('tahun_sampai',$this->tahun_sampai,true);
		$criteria->compare('mulai_berlaku',$this->mulai_berlaku,true);
		$criteria->compare('akhir_berlaku',$this->akhir_berlaku,true);
		$criteria->compare('id_kelas_perusahaan',$this->id_kelas_perusahaan);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('id_rev',$this->id_rev);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rku the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function cekRev($idPer,$id) {
		$m = 'Telah direvisi';
		$rku = Rku::model()->findAll(array('condition'=>'id_perusahaan = '.$idPer,'order'=>'id_rku ASC'));
		if(!empty($rku)) {
			foreach($rku as $key => $data) {
				if($data->id_rku == $id && $data->status == 1 || $data->id_rku == $id && $data->status == 1 && $data->id_rev !== 0) {
					$m = 'Aktif';
				} elseif($data->id_rku == $id && $data->status == 2 && $data->id_rev > 0) {
					$m = 'Revisi ke - '. ($key);
				} elseif($data->id_rku == $id && $data->status == 2 && $data->id_rev == 0) {
					$m = 'Telah Direvisi';
				} elseif($data->id_rku == $id && $data->status == 3) {
					$m = "Telah Berakhir";
				}
			}
		} else {
			$m = 'Aktif';
		}
		return $m;
	}
        
        protected function cekModifStatus($idPer,$id) {
		$m = 'Closed';
		$rku = Rku::model()->findAll(array('condition'=>'id_perusahaan = '.$idPer,'order'=>'id_rku ASC'));
		if(!empty($rku)) {
			foreach($rku as $key => $data) {
				if($data->id_rku == $id && $data->edit_status == 1) {
					$m = 'Sedang Di Input';
				} elseif($data->id_rku == $id && $data->status == 0 ) {
					$m = 'Closed';
				} 
			}
		} else {
			$m = 'Aktif';
		}
		return $m;
	}
        
        
        public function getTahunByIdPerusahaan($idPerusahaan)
        {
                $query = "SELECT DISTINCT tahun_mulai,nomor_sk FROM rku WHERE id_perusahaan=".$idPerusahaan."  ORDER BY tahun_mulai ASC";

                $categorylist=Yii::app()->db->createCommand($query)->queryAll();

                $category_array;
                foreach($categorylist as $data)
                {
                    $category_array[$data['tahun_mulai']]=$data['tahun_mulai']."  |  ".$data['nomor_sk'];
                }
                return $category_array;
        }
        
        
        public function getTahun()
        {
                $query = "SELECT DISTINCT tahun_mulai FROM rku ORDER BY tahun_mulai ASC";

                $categorylist=Yii::app()->db->createCommand($query)->queryAll();

                $category_array;
                foreach($categorylist as $data)
                {
                    $category_array[$data['tahun_mulai']]=$data['tahun_mulai'];
                }
                return $category_array;
        }
        
        
         public function getByPerusahaanId($perusahaanId)
        {
                $query = "SELECT r.id_rku,r.nomor_sk,r.tgl_sk,r.tahun_mulai,r.tahun_sampai,
                            IFNULL((SELECT m.nama_kelas_perusahaan FROM master_kelas_perusahaan m WHERE m.id_kelas_perusahaan = r.id_kelas_perusahaan),0)AS kelas 
                            FROM rku r WHERE r.id_perusahaan=".$perusahaanId." ORDER BY tahun_mulai DESC LIMIT 1;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
        
        
        
        
        
}