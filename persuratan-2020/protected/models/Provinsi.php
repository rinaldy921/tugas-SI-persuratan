<?php

/**
 * This is the model class for table "provinsi".
 *
 * The followings are the available columns in table 'provinsi':
 * @property string $id_provinsi
 * @property string $nama
 *
 * The followings are the available model relations:
 * @property Administrasi[] $administrasis
 * @property Administrasi[] $administrasis1
 * @property IuphhkAdmPemangkuanHutan[] $iuphhkAdmPemangkuanHutans
 * @property IuphhkAdmPemerintahan[] $iuphhkAdmPemerintahans
 * @property Kabupaten[] $kabupatens
 * @property Perusahaan[] $perusahaans
 * @property PerusahaanCabang[] $perusahaanCabangs
 */
class Provinsi extends CActiveRecord
{

	public $namaKab;
    public $tahun;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'provinsi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nama', 'required'),
			array('nama', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_provinsi, nama, order_idx', 'safe', 'on'=>'search'),
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
			'administrasis' => array(self::HAS_MANY, 'Administrasi', 'provinsi'),
			'administrasis1' => array(self::HAS_MANY, 'Administrasi', 'dinhut_prov'),
			'iuphhkAdmPemangkuanHutans' => array(self::HAS_MANY, 'IuphhkAdmPemangkuanHutan', 'dinhut_prov'),
			'iuphhkAdmPemerintahans' => array(self::HAS_MANY, 'IuphhkAdmPemerintahan', 'provinsi'),
			'kabupatenProvinsi' => array(self::HAS_MANY, 'Kabupaten', 'provinsi_id'),
			'perusahaanProvinsi' => array(self::HAS_MANY, 'Perusahaan', 'provinsi'),
			'perusahaanCabang' => array(self::HAS_MANY, 'PerusahaanCabang', 'provinsi'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id_provinsi'=>Yii::t('app','Provinsi'),
						'nama'=>Yii::t('app','Nama'),
                                                'order_idx'=>Yii::t('app','Urutan'),
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

		$criteria->compare('id_provinsi',$this->id_provinsi,true);
		$criteria->compare('nama',$this->nama,true);
                $criteria->compare('order_idx',$this->order_idx,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Provinsi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getProvinsi($sub = '') {
        $arrays = CHtml::listData(Provinsi::model()->findAll(array('select' => 'id_provinsi,nama')), 'id_provinsi', 'nama');
        return isset($arrays[$sub]) ? $arrays[$sub] : $arrays;
    }

    public function getKab($sub = '') {
        $arrays = CHtml::listData(Kabupaten::model()->findAll(array('select' => 'id,nama')), 'id', 'nama');
        return isset($arrays[$sub]) ? $arrays[$sub] : $arrays;
    }
    
    public function getByBphp($bphpId)
    {
            $query = "
                        SELECT p.id_provinsi,p.nama FROM provinsi p WHERE p.id_provinsi 
                        IN (SELECT w.id_provinsi FROM bphp_wilayah_kerja w WHERE id_master_bphp=".$bphpId.")";
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
         
            $category_array["0"]="All";
            foreach($categorylist as $data)
            {
                $category_array[$data['id_provinsi']]=$data['nama'];
            }
            return $category_array;
    }
    
    public function getListPropByBphp($bphpId)
    {
            $query = "SELECT p.id_provinsi FROM provinsi p WHERE p.id_provinsi 
                        IN (SELECT w.id_provinsi FROM bphp_wilayah_kerja w WHERE id_master_bphp=".$bphpId.")";
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
            
            
          
            $category_array; $i=0;
            foreach($categorylist as $data)
            {
                if($i == 0){
                    $category_array=$data['id_provinsi'];
                }else{
                     $category_array=$category_array.",".$data['id_provinsi'];
                }
                $i++;
            }
            
           // print_r($category_array);die();
           
            return $category_array;
    }
    
    
}
