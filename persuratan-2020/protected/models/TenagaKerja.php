<?php

/**
 * This is the model class for table "tenaga_kerja".
 *
 * The followings are the available columns in table 'tenaga_kerja':
 * @property integer $id
 * @property integer $perusahaan_id
 * @property string $kategori
 * @property integer $sarjana
 * @property integer $menengah
 * @property integer $asing
 * @property integer $bersertifikat
 *
 * The followings are the available model relations:
 * @property Perusahaan $perusahaan
 */
class TenagaKerja extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tenaga_kerja';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('perusahaan_id, sarjana, menengah, asing, bersertifikat', 'numerical', 'integerOnly'=>true),
			array('kategori', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, perusahaan_id, kategori, sarjana, menengah, asing, bersertifikat', 'safe', 'on'=>'search'),
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
			'perusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'perusahaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'perusahaan_id' => 'Perusahaan',
			'kategori' => 'Kategori',
			'sarjana' => 'Sarjana',
			'menengah' => 'Menengah',
			'asing' => 'Asing',
			'bersertifikat' => 'Bersertifikat',
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
		$criteria->compare('perusahaan_id',$this->perusahaan_id);
		$criteria->compare('kategori',$this->kategori,true);
		$criteria->compare('sarjana',$this->sarjana);
		$criteria->compare('menengah',$this->menengah);
		$criteria->compare('asing',$this->asing);
		$criteria->compare('bersertifikat',$this->bersertifikat);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TenagaKerja the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public static function getDaftarRealisasiGanisByPerusahaanId($perusahaanId){
            $iuiphhk = Iuphhk::model()->find([
                        'condition' => "id_perusahaan = ".$perusahaanId
                    ]);  
            
            $tahun = date('Y');
            $endDate =  $tahun.'-12-31'; 
            //cek luas areal
            $divGanis='';
            $luasAreal = $iuiphhk->luas;
            if($luasAreal < 25000){
                $divGanis = 'val1';
            } else if($luasAreal >= 25000 && $luasIzin < 50000){
                $divGanis = 'val2';
            } else if($luasAreal >= 50000 && $luasIzin < 100000){
                $divGanis = 'val3';            
            } else if($luasAreal >= 100000 && $luasIzin < 200000){
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
