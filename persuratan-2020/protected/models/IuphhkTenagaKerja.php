<?php

/**
 * This is the model class for table "iuphhk_tenaga_kerja".
 *
 * The followings are the available columns in table 'iuphhk_tenaga_kerja':
 * @property integer $id
 * @property integer $id_perusahaan
 * @property integer $id_jenis_tenaga_kerja
 * @property integer $id_kualifikasi
 * @property integer $id_pendidikan
 * @property string $nama
 * @property string $ktp
 * @property string $no_sertifikat
 * @property string $tgl_awal_sertifikat
 * @property string $tgl_akhir_sertifikat
 * @property string $is_aktif
 *
 * The followings are the available model relations:
 * @property Perusahaan $idPerusahaan
 * @property MasterKualifikasi $idKualifikasi
 * @property MasterPendidikan $idPendidikan
 */
class IuphhkTenagaKerja extends CActiveRecord
{
	public $Berlaku;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iuphhk_tenaga_kerja';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_perusahaan, id_pendidikan, nama, ktp, tgl_lahir, alamat, tgl_sertifikat', 'required'),
                    	//array('id_perusahaan,id_jenis_tenaga_kerja, id_pendidikan, nama, ktp, no_reg, tgl_lahir, alamat, tgl_awal_sertifikat, tgl_akhir_sertifikat, no_sertifikat', 'required'),
			array('id, id_perusahaan, id_jenis_tenaga_kerja, id_kualifikasi, id_pendidikan, ktp', 'numerical', 'integerOnly'=>true),
			array('nama, no_sertifikat, no_reg', 'length', 'max'=>50),
			array('is_aktif', 'length', 'max'=>1),
			array('tgl_awal_sertifikat, tgl_akhir_sertifikat, tgl_lahir, tgl_sertifikat, tgl_keluar', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_perusahaan, id_jenis_tenaga_kerja, id_kualifikasi, id_pendidikan, nama, ktp, no_sertifikat, tgl_awal_sertifikat, tgl_akhir_sertifikat, is_aktif, tgl_lahir, tgl_sertifikat, tgl_keluar, file_doc', 'safe', 'on'=>'search'),
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
			'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
			'idKualifikasi' => array(self::BELONGS_TO, 'MasterKualifikasi', 'id_kualifikasi'),
			'idPendidikan' => array(self::BELONGS_TO, 'MasterPendidikan', 'id_pendidikan'),
			'idJenisTenagaKerja'	=> array(self::BELONGS_TO, 'MasterJenisGanis', 'id_jenis_tenaga_kerja'),
                        'id' => array(self::HAS_MANY, 'SertifikatGanis', 'id_iuphhk_tenaga_kerja'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_perusahaan'=>Yii::t('app','Id Perusahaan'),
						'id_jenis_tenaga_kerja'=>Yii::t('app','Jenis Tenaga Teknis'),
						'id_kualifikasi'=>Yii::t('app','Kualifikasi'),
						'id_pendidikan'=>Yii::t('app','Pendidikan'),
						'nama'=>Yii::t('app','Nama'),
						'ktp'=>Yii::t('app','No. KTP'),
						'no_sertifikat'=>Yii::t('app','No Sertifikat'),
						'tgl_awal_sertifikat'=>Yii::t('app','Tgl Awal Sertifikat'),
						'tgl_akhir_sertifikat'=>Yii::t('app','Tgl Akhir Sertifikat'),
						'is_aktif'=>"Status",//Yii::t('app','Is Aktif'),
						'no_reg' => "Nomor Registrasi",
						'tempat_lahir' => "Tempat Lahir",
						"tgl_lahir" => "Tgl Lahir",
						"alamat" => "Alamat",
						'tgl_keluar' => "Tgl Keluar",
                                                "tgl_sertifikat" => "Tanggal Sertfikat",
                                                "file_doc" => "File Sertfikat" 
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
		$criteria->compare('id_perusahaan',$this->id_perusahaan);
		$criteria->compare('id_jenis_tenaga_kerja',$this->id_jenis_tenaga_kerja);
		$criteria->compare('id_kualifikasi',$this->id_kualifikasi);
		$criteria->compare('id_pendidikan',$this->id_pendidikan);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('tgl_lahir',$this->tgl_lahir,true);
		$criteria->compare('no_sertifikat',$this->no_sertifikat,true);
		$criteria->compare('tgl_awal_sertifikat',$this->tgl_awal_sertifikat,true);
		$criteria->compare('tgl_akhir_sertifikat',$this->tgl_akhir_sertifikat,true);
                $criteria->compare('tgl_sertifikat',$this->tgl_sertifikat,true);
		$criteria->compare('is_aktif',$this->is_aktif,true);
                $criteria->compare('file_doc',$this->file_doc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IuphhkTenagaKerja the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getDaftarRealisasiGanisByPerusahaanId($perusahaanId){
            $iuiphhk = Iuphhk::model()->find([
                        'condition' => "id_perusahaan = ".$perusahaanId
                    ]);  
            
//            $tahun = date('Y');
            $endDate = date('Y-m-d');
//            $endDate =  $tahun.'-12-31'; 
            //cek luas areal
            $divGanis='';
            $luasAreal = $iuiphhk->luas;
            if($luasAreal < 25000){
                $divGanis = 'val1';
            } else if($luasAreal >= 25000 && $luasAreal < 50000){
                $divGanis = 'val2';
            } else if($luasAreal >= 50000 && $luasAreal < 100000){
                $divGanis = 'val3';            
            } else if($luasAreal >= 100000 && $luasAreal < 200000){
                $divGanis = 'val4';
            } else if($luasAreal >= 200000){
                $divGanis = 'val5';
            }      
            
                $query = "SELECT g.id,g.nama_jenis,g.".$divGanis." as standar,g.deskripsi,
                            (SELECT COUNT(t.id)
                                FROM iuphhk_tenaga_kerja t
                                JOIN sertifikat_ganis s
                                ON t.id = s.id_iuphhk_tenaga_kerja 
                                WHERE t.id_perusahaan=".$perusahaanId." AND t.is_aktif='1' 
                                     AND s.approval_status=1
                                     AND t.id_jenis_tenaga_kerja = g.id
                                     AND '".$endDate."' BETWEEN s.tgl_awal_sk  AND s.tgl_akhir_sk
                                     )AS realisasi
                            FROM master_jenis_ganis g;";
        
               // print_r($query); die();
                
                $result=Yii::app()->db->createCommand($query)->queryAll();

                

                return $result;
        }
        
        
}
