<?php

/**
 * This is the model class for table "perusahaan".
 *
 * The followings are the available columns in table 'perusahaan':
 * @property integer $id_perusahaan
 * @property string $nama_perusahaan
 * @property string $alamat
 * @property string $provinsi
 * @property string $kabupaten
 * @property string $telepon
 * @property string $email
 * @property string $fax
 * @property integer $kode_pos
 * @property string $website
 * @property string $kontak
 * @property string $telepon_kontak
 * @property string $email_kontak
 *
 * The followings are the available model relations:
 * @property AppUsers[] $appUsers
 * @property Komisaris[] $komisarises
 * @property LegalitasPerusahaan[] $legalitasPerusahaans
 * @property Kabupaten $kabupaten0
 * @property Provinsi $provinsi0
 * @property PerusahaanCabang[] $perusahaanCabangs
 * @property TenagaKerja[] $tenagaKerjas
 */
class Perusahaan extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'perusahaan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nama_perusahaan', 'required', 'on' => 'insert'),
            array('nama_perusahaan, alamat, provinsi, kabupaten, telepon, npwp', 'required', 'on' => 'update'),
            array('kode_pos', 'numerical', 'integerOnly' => true),
            array('nama_perusahaan, telepon, email, fax, website, telepon_kontak, email_kontak', 'length', 'max' => 50),
            array('alamat, kontak', 'length', 'max' => 100),
            array('provinsi', 'length', 'max' => 2),
            array('kabupaten', 'length', 'max' => 4),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_perusahaan, nama_perusahaan, npwp, alamat, provinsi, kabupaten, telepon, email, fax, kode_pos, website, kontak, telepon_kontak, email_kontak', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'appUsers' => array(self::HAS_MANY, 'AppUsers', 'id_perusahaan'),
            'komisarises' => array(self::HAS_MANY, 'Komisaris', 'perusahaan_id'),
            'legalitasPerusahaans' => array(self::HAS_MANY, 'LegalitasPerusahaan', 'perusahaan_id'),
            'kabupatenFk' => array(self::BELONGS_TO, 'Kabupaten', 'kabupaten'),
            'provinsiFk' => array(self::BELONGS_TO, 'Provinsi', 'provinsi'),
            'perusahaanCabangs' => array(self::HAS_MANY, 'PerusahaanCabang', 'perusahaan_id'),
            'penilaianKinerjas' => array(self::HAS_MANY, 'PenilaianKinerja', 'id_perusahaan'),
            'tenagaKerjas' => array(self::HAS_MANY, 'TenagaKerja', 'perusahaan_id'),
            'iuphhks' => array(self::HAS_MANY, 'Iuphhk', 'id_perusahaan'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_perusahaan' => 'Perusahaan',
            'nama_perusahaan' => 'Nama Perusahaan',
            'npwp' => 'NPWP',
            'alamat' => 'Alamat',
            'provinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'telepon' => 'Telepon',
            'email' => 'Email',
            'fax' => 'Fax',
            'kode_pos' => 'Kode Pos',
            'website' => 'Website',
            'kontak' => 'PIC',
            'telepon_kontak' => 'Telepon PIC',
            'email_kontak' => 'Email PIC',
        );
    }
    
    	public function searchByIupkhh()
	{
                $query ="SELECT
                            p.id_perusahaan,
                            p.nama_perusahaan,
                            (select z.id_iuphhk from iuphhk z where z.id_perusahaan = p.id_perusahaan ORDER BY z.tanggal desc limit 1) as id_iuphhk,
                            (select z.nama_perusahaan from iuphhk z where z.id_perusahaan = p.id_perusahaan ORDER BY z.tanggal desc limit 1) as nama_iuphhk,
                            (select z.tanggal from iuphhk z where  z.id_perusahaan = p.id_perusahaan ORDER BY z.tanggal desc limit 1)as tgl_sk_iuphhk,
                            (select z.nomor from iuphhk z where  z.id_perusahaan = p.id_perusahaan ORDER BY z.tanggal desc limit 1) as nomor_sk_iuphhk,
                            IFNULL((select r.nama from provinsi r where r.id_provinsi = a.provinsi),0) as propinsi
                            FROM
                            perusahaan p
                            LEFT JOIN iuphhk_adm_pemerintahan a ON a.id_perusahaan = p.id_perusahaan
                            group by p.nama_perusahaan,a.provinsi
                            ORDER BY p.id_perusahaan asc";
                $result = Yii::app()->db->createCommand($query)->queryAll();
                
                //print_r($result);die();
                
                $dataProvider = new CArrayDataProvider($result, array(
                    'id'=>'perusahaan',
                    'pagination'=>array(
                        'pageSize'=>25,
                    )
                ));
                
                
                return $dataProvider;
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id_perusahaan', $this->id_perusahaan);
        $criteria->compare('nama_perusahaan', $this->nama_perusahaan, true);
        $criteria->compare('alamat', $this->alamat, true);
        $criteria->compare('npwp', $this->npwp, true);
        $criteria->compare('provinsi', $this->provinsi, true);
        $criteria->compare('kabupaten', $this->kabupaten, true);
        $criteria->compare('telepon', $this->telepon, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('kode_pos', $this->kode_pos);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('kontak', $this->kontak, true);
        $criteria->compare('telepon_kontak', $this->telepon_kontak, true);
        $criteria->compare('email_kontak', $this->email_kontak, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Perusahaan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    
    public function getByPropinsi($propinsiId)
    {
            $query = "SELECT p.id_perusahaan,p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan IN (SELECT i.id_perusahaan FROM iuphhk_adm_pemerintahan i WHERE i.provinsi=".$propinsiId.");";
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
         
            $category_array;
            foreach($categorylist as $data)
            {
                $category_array[$data['id_perusahaan']]=$data['nama_perusahaan'];
            }
            return $category_array;
    }
    
    public function getByBphp($bphpId)
    {
            $query = "
                        SELECT p.id_perusahaan,p.nama_perusahaan FROM perusahaan p WHERE p.provinsi 
                        IN (SELECT id_provinsi FROM bphp_wilayah_kerja WHERE id_master_bphp=".$bphpId.")";
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
         
            $category_array;
            foreach($categorylist as $data)
            {
                $category_array[$data['id_perusahaan']]=$data['nama_perusahaan'];
            }
            return $category_array;
    }
    
    public function getByIdPerusahaan($idPerusahaan)
    {
            $query = "
                        SELECT p.id_perusahaan,p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan=".$idPerusahaan;
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
         
            $category_array;
            foreach($categorylist as $data)
            {
                $category_array[$data['id_perusahaan']]=$data['nama_perusahaan'];
            }
            return $category_array;
    }
    
    
     public function getByAdmin()
    {
            $query = "SELECT p.id_perusahaan,p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan IN (SELECT i.id_perusahaan FROM iuphhk_adm_pemerintahan i);";
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
         
            $category_array;
            foreach($categorylist as $data)
            {
                $category_array[$data['id_perusahaan']]=$data['nama_perusahaan'];
            }
            return $category_array;
    }
    
}
