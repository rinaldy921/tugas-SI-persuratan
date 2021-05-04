<?php

/**
 * This is the model class for table "iuphhk".
 *
 * The followings are the available columns in table 'iuphhk':
 * @property integer $id_iuphhk
 * @property integer $id_perusahaan
 * @property string $nomor
 * @property string $tanggal
 * @property double $luas
 * @property string $bt
 * @property string $ls
 *
 * The followings are the available model relations:
 * @property AdendumSk[] $adendumSks
 * @property Administrasi[] $administrasis
 * @property Perusahaan $idPerusahaan
 */
class Iuphhk extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $nama_badan;
    public $nama_provinsi;
    public $blok;
    public $sektor;
    public $statusCheck;
    public $id_prop_adm;
    public $search_by;
    //public $id_provinsi;

    public function tableName() {
        return 'iuphhk';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_perusahaan, luas, nama_perusahaan, nomor, tanggal, tgl_start, tgl_end', 'required'),
            // array('blok', 'required', 'on'=>'insert'),
            // array('blok', 'numerical', 'on'=>'nipz'),
            array('id_perusahaan, status, blok', 'numerical', 'integerOnly' => true),
            array('luas, investasi_rupiah, investasi_dolar', 'numerical'),
            array('nomor', 'length', 'max' => 50),
            array('tanggal', 'safe'),
            //array('file_doc', 'file', 'maxSize'=>1024 * 1024 * 2, 'tooLarge'=>'File has to be smaller than 2MB' , 'allowEmpty'=>true, 'on'=>array('insert','update')), // this will allow empty field when page is update (remember here i create scenario update)
            //array('file_doc', 'file', 'maxSize'=>1024 * 1024 * 2, 'tooLarge'=>'File has to be smaller than 2MB'), // this will allow empty field when page is update (remember here i create scenario update)
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_iuphhk, id_perusahaan, nama_perusahaan, file_doc, blok, nama_badan, nomor, tanggal, luas, status, investasi_rupiah, investasi_dolar', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'adendumSks' => array(self::HAS_MANY, 'AdendumSk', 'id_iuphhk'),
            'administrasis' => array(self::HAS_MANY, 'Administrasi', 'id_iuphhk'),
            'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
            'admPemerintahan' => array(self::BELONGS_TO, 'AdmPemerintahan', 'id_iuphhk'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_iuphhk' => 'Id Iuphhk',
            'id_perusahaan' => 'Nama Perusahaan',
            'nomor' => 'Nomor SK',
            'tanggal' => 'Tanggal SK',
            'luas' => 'Luas Lahan',
            'statusCheck' => 'Ceklis Bila Ada Sektor',
            'blok' => 'Jumlah Blok',
            'sektor' => 'Jumlah Sektor',
            'investasi_rupiah' => "Investasi Rupiah",
            'investasi_dolar' => "Investasi Dolar",
            'tgl_start' => "Tgl Berlaku Awal",
            'tgl_end' => "Tgl Berlaku Akhir",
            "tgl_dicabut" => "Tgl Dicabut",
            'keterangan_dicabut' => "Keterangan Dicabut",
            "no_sk_pencabutan" => "No SK Pencabutan",
            'nama_perusahaan' => "Nama Perusahaan",
            'file_doc' => "File SK",
            'id_parent' => "ID Parent",
            'search_by' => 'Nama Perusahaan',
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
     */public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('idPerusahaan');
        $criteria->compare('id_iuphhk', $this->id_iuphhk);
        $criteria->compare('t.id_perusahaan', $this->id_perusahaan);
        $criteria->compare('idPerusahaan.nama_perusahaan', $this->nama_badan, true);
        $criteria->compare('nomor', $this->nomor, true);
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('luas', $this->luas);
        $criteria->compare('nama_perusahaan', $this->nama_perusahaan);
        $criteria->compare('file_doc', $this->file_doc);
        $criteria->compare('investasi_rupiah', $this->investasi_rupiah);
        $criteria->compare('investasi_dolar', $this->investasi_dolar);
        $criteria->compare('id_parent', $this->id_parent);
        $criteria->compare('admPemerintahan.provinsi', $idPropinsi);
        
        
        $criteria->group = 'idPerusahaan.id_perusahaan';

        $criteria->compare('status', $this->status);
        
        $userLogin = Yii::app()->user->findUser();
//         debug($userLogin->id_propinsi); die();
         
         
         
        if(Yii::app()->user->type == 3){
            $criteria->condition = 'EXISTS(
            	SELECT 1 FROM perusahaan x
            	INNER JOIN bphp_wilayah_kerja wil
            		ON wil.id_provinsi = x.provinsi
            		AND wil.id_master_bphp = :id_master_bphp
            	WHERE wil.id_provinsi = idPerusahaan.provinsi
            )';
            $criteria->params = array(
                ':id_master_bphp'=>Yii::app()->user->id_bphp
            );

        }
        
       
        
        else if(Yii::app()->user->type == 4){
            $criteria->condition = 'EXISTS(
            	SELECT 1 FROM perusahaan x
            	INNER JOIN bphp_wilayah_kerja wil
            		ON wil.id_provinsi = x.provinsi
            		AND wil.id_provinsi = :id_provinsi
            	WHERE wil.id_provinsi = idPerusahaan.provinsi
            )';
            $criteria->params = array(
                ':id_provinsi'=>$userLogin->id_propinsi
            );

        }
        
        
//        debug($criteria);die();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'nama_badan' => array(
                        'asc' => 'idPerusahaan.nama_perusahaan',
                        'desc' => 'idPerusahaan.nama_perusahaan DESC',
                    ),
                    '*',
                ),
                'multiSort' => true,
            ),
        ));
    }
    
    
    public function findByPropinsi($idPropinsi) {
        $condition="";
        if($idPropinsi != "0"){
            $condition = " WHERE w.provinsi = ".$idPropinsi." ";
        }
        
        
        $query = "SELECT i.id_iuphhk,i.status,
                        IFNULL((SELECT p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan=i.id_perusahaan),'')AS namaperusahaan,
                        IFNULL((SELECT p.nama FROM provinsi p WHERE p.id_provinsi = w.provinsi),'')AS propinsi,
                        IFNULL((SELECT p.nama FROM kabupaten p WHERE p.id_kabupaten = w.kabupaten),'')AS kabupaten
                        ,i.nomor,i.id_perusahaan, i.tanggal, i.luas, i.tgl_start,i.tgl_end,i.is_dicabut,i.file_doc
                FROM iuphhk i INNER JOIN iuphhk_adm_pemerintahan w
                        ON i.id_iuphhk = w.id_iuphhk
                ".$condition."
                GROUP BY i.id_iuphhk
                ORDER BY namaperusahaan ASC";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
        
            $dataProvider=new CArrayDataProvider($result, array(
                'id'=>'iuphhk', //this is an identifier for the array data provider
                'sort'=>false,
                'keyField'=>'id', //this is what will be considered your key field
                'pagination'=>array(
                    'pageSize'=>30, //eureka! you can configure your pagination from here
                ),
            ));
            
            
            return $dataProvider;
    }
    
    
    public function findByBphp($idbphp) {
        $query = "SELECT i.id_iuphhk,i.status,
                        IFNULL((SELECT p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan=i.id_perusahaan),'')AS namaperusahaan,
                        IFNULL((SELECT p.nama FROM provinsi p WHERE p.id_provinsi = w.provinsi),'')AS propinsi,
                        IFNULL((SELECT p.nama FROM kabupaten p WHERE p.id_kabupaten = w.kabupaten),'')AS kabupaten
                        ,i.nomor,i.id_perusahaan, i.tanggal, i.luas, i.tgl_start,i.tgl_end,i.is_dicabut,i.file_doc
                FROM iuphhk i INNER JOIN iuphhk_adm_pemerintahan w
                        ON i.id_iuphhk = w.id_iuphhk
                WHERE w.provinsi IN (SELECT b.id_provinsi FROM bphp_wilayah_kerja b WHERE b.id_master_bphp=".$idbphp.") 
                GROUP BY i.id_iuphhk
                ORDER BY propinsi,namaperusahaan ASC";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
        
            $dataProvider=new CArrayDataProvider($result, array(
                'id'=>'iuphhk', //this is an identifier for the array data provider
                'sort'=>false,
                'keyField'=>'id', //this is what will be considered your key field
                'pagination'=>array(
                    'pageSize'=>30, //eureka! you can configure your pagination from here
                ),
            ));
            
            
            return $dataProvider;
    }
    
     public function findIUPHHKAktif($tahun) {
        $query = "SELECT i.id_iuphhk,i.status,
                        IFNULL((SELECT p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan=i.id_perusahaan),'')AS namaperusahaan,
                        IFNULL((SELECT p.nama FROM provinsi p WHERE p.id_provinsi = w.provinsi),'')AS propinsi,
                        IFNULL((SELECT p.nama FROM kabupaten p WHERE p.id_kabupaten = w.kabupaten),'')AS kabupaten
                        ,i.nomor,i.id_perusahaan, i.tanggal, i.luas, i.tgl_start,i.tgl_end,i.is_dicabut,i.file_doc
                FROM iuphhk i INNER JOIN iuphhk_adm_pemerintahan w
                        ON i.id_iuphhk = w.id_iuphhk
                WHERE w.provinsi IN (SELECT b.id_provinsi FROM bphp_wilayah_kerja b WHERE i.id_perusahaan in (select r.id_perusahaan from rkt r where r.tahun_mulai =".$tahun.")) 
                GROUP BY i.id_iuphhk
                ORDER BY propinsi,namaperusahaan ASC";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
        
            $dataProvider=new CArrayDataProvider($result, array(
                'id'=>'iuphhk', //this is an identifier for the array data provider
                'sort'=>false,
                'keyField'=>'id', //this is what will be considered your key field
                'pagination'=>array(
                    'pageSize'=>30, //eureka! you can configure your pagination from here
                ),
            ));
            
            
            return $dataProvider;
    }
    
    
    
//    public function findByPusat() {
//        $criteria = new CDbCriteria;
//        $criteria->with = array('idPerusahaan',
//                                'admPemerintahan');
////                                'admPemerintahan.provinsi0'
//        $criteria->together = TRUE;
////        $criteria->condition="idPerusahaan.id_perusahaan=:id_perusahaan AND
////                               admPemerintahan.id_perusahaan=:id_perusahaan";
////        $criteria->params= array (':id_perusahaan'=>id_perusahaan);
////        $criteria->order='provinsi0.order_idx ASC';
//        $criteria->group = 'idPerusahaan.id_perusahaan';
//       
//        
//        return new CActiveDataProvider($this, array(
//        'criteria'=>$criteria,
//        ));
//    }
    
    

    public function findByPusat($search_by='') {
        $customPage=20;
        
        if($search_by!=''){ $customPage=1000; }
        
        $query = "SELECT i.id_iuphhk,i.status,
                        IFNULL((SELECT p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan=i.id_perusahaan),'')AS namaperusahaan,
                        IFNULL((SELECT p.nama FROM provinsi p WHERE p.id_provinsi = w.provinsi),'')AS propinsi,
                        IFNULL((SELECT p.nama FROM kabupaten p WHERE p.id_kabupaten = w.kabupaten),'')AS kabupaten
                        ,i.nomor,i.id_perusahaan, i.tanggal, i.luas, i.tgl_start,i.tgl_end,i.is_dicabut,i.file_doc
                        FROM iuphhk i INNER JOIN iuphhk_adm_pemerintahan w
                        ON i.id_iuphhk = w.id_iuphhk
                        WHERE i.id_perusahaan IN (SELECT pr.id_perusahaan FROM perusahaan pr WHERE pr.nama_perusahaan LIKE '%".$search_by."%' )
                GROUP BY i.id_iuphhk
                ORDER BY propinsi,namaperusahaan ASC";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
        
            $dataProvider=new CArrayDataProvider($result, array(
                'id'=>'iuphhk', //this is an identifier for the array data provider
                'sort'=>false,
                'keyField'=>'id', //this is what will be considered your key field
                'pagination'=>array(
                    'pageSize'=>$customPage, //eureka! you can configure your pagination from here
                ),
            ));
            
            
            return $dataProvider;
    }
    
       public function findByMonevWilayah($roleId) {
        $query = "SELECT i.id_iuphhk,i.status,
                        IFNULL((SELECT p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan=i.id_perusahaan),'')AS namaperusahaan,
                        IFNULL((SELECT p.nama FROM provinsi p WHERE p.id_provinsi = w.provinsi),'')AS propinsi,
                        IFNULL((SELECT p.nama FROM kabupaten p WHERE p.id_kabupaten = w.kabupaten),'')AS kabupaten
                        ,i.nomor,i.id_perusahaan, i.tanggal, i.luas, i.tgl_start,i.tgl_end,i.is_dicabut,i.file_doc
                FROM iuphhk i INNER JOIN iuphhk_adm_pemerintahan w
                        ON i.id_iuphhk = w.id_iuphhk
                WHERE i.id_perusahaan IN (SELECT r.id_perusahaan FROM pantau_perusahaan_role r WHERE r.role_id=".$roleId.")
                GROUP BY i.id_iuphhk
                ORDER BY propinsi,namaperusahaan ASC";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
        
            $dataProvider=new CArrayDataProvider($result, array(
                'id'=>'iuphhk', //this is an identifier for the array data provider
                'sort'=>false,
                'keyField'=>'id', //this is what will be considered your key field
                'pagination'=>array(
                    'pageSize'=>30, //eureka! you can configure your pagination from here
                ),
            ));
            
            
            return $dataProvider;
    }
    
    
    
    
    public function searchrevisi()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

        $criteria->compare('nomor', $this->nomor, true);
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('luas', $this->luas);
        $criteria->compare('nama_perusahaan', $this->nama_perusahaan);
        $criteria->compare('file_doc', $this->file_doc);
        $criteria->compare('investasi_rupiah', $this->investasi_rupiah);
        $criteria->compare('investasi_dolar', $this->investasi_dolar);
        $criteria->compare('id_parent', $this->id_parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Iuphhk the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    
     public function getPerusahaan($idIuphhk)
    {
            $query = "SELECT * FROM iuphhk WHERE id_perusahaan=".$idIuphhk." ORDER BY tanggal ASC  LIMIT 1 ";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
            
            if(isset($result)){
                $result = $result['0'];
            }
          
            return $result;
    }
    
    
    public function getByPerusahaan($idPerusahaan)
    {
            $query = "SELECT * FROM iuphhk WHERE id_perusahaan=".$idPerusahaan." ORDER BY tanggal ASC  LIMIT 1 ";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
            
            if(isset($result)){
                $result = $result['0'];
            }
          
            return $result;
    }
    
    
     public function getActive($idPerusahaan)
    {
            $query = "SELECT * FROM iuphhk WHERE id_perusahaan=".$idPerusahaan." ORDER BY tanggal DESC LIMIT 1 ";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
            
            if(isset($result)){
                $result = $result['0'];
            }
          
            return $result;
    }
    
    public function getAdendum($idIuphhk, $idPerusahaan)
    {
            $query = "SELECT * FROM iuphhk WHERE id_perusahaan = ".$idPerusahaan." AND id_parent=".$idIuphhk." ORDER BY tanggal ASC";
            $result=Yii::app()->db->createCommand($query)->queryAll();
            
            return $result;
    }

}
