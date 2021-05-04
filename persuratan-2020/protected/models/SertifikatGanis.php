<?php

/**
 * This is the model class for table "sertifikat_ganis".
 *
 * The followings are the available columns in table 'sertifikat_ganis':
 * @property integer $id
 * @property integer $id_iuphhk_tenaga_kerja
 * @property integer $id_jenis_tenaga_kerja
 * @property string $no_reg
 * @property string $no_sertifikat
 * @property string $tgl_awal_sertifikat
 * @property string $tgl_akhir_sertifikat
 *
 * The followings are the available model relations:
 * @property IuphhkTenagaKerja $idIuphhkTenagaKerja
 * @property MasterJenisGanis $idJenisTenagaKerja
 */
class SertifikatGanis extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
         
	public function tableName()
	{
		return 'sertifikat_ganis';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_iuphhk_tenaga_kerja, no_reg, no_sk, tgl_awal_sk,tgl_akhir_sk, id_bphp ', 'required'),
			array('id, id_iuphhk_tenaga_kerja, id_bphp, approval_status', 'numerical', 'integerOnly'=>true),
			array('no_reg, no_sk', 'length', 'max'=>50),
			array('tgl_sk, tgl_awal_sk, tgl_akhir_sk', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_iuphhk_tenaga_kerja, no_reg, no_sk, tgl_sk, tgl_awal_sk, tgl_akhir_sk, id_bphp, file_reg, file_sk', 'safe', 'on'=>'search'),
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
			'idIuphhkTenagaKerja' => array(self::BELONGS_TO, 'IuphhkTenagaKerja', 'id_iuphhk_tenaga_kerja'),
//			'idJenisTenagaKerja' => array(self::BELONGS_TO, 'MasterJenisGanis', 'id_jenis_tenaga_kerja'),
                        'idBphp' => array(self::BELONGS_TO, 'MasterBphp', 'id_bphp'),
                    );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_iuphhk_tenaga_kerja'=>Yii::t('app','Id Iuphhk Tenaga Kerja'),
						'no_reg'=>Yii::t('app','No Reg'),
						'no_sk'=>Yii::t('app','No SK'),
                                                'tgl_sk'=>Yii::t('app','Tanggal SK'),
						'tgl_awal_sk'=>Yii::t('app','Tgl Awal SK'),
						'tgl_akhir_sk'=>Yii::t('app','Tgl Akhir SK'),
                                                'id_bphp'=>Yii::t('app','Penerbit SK'), 
                                                'file_reg'=>Yii::t('app','File Reg'),
                                                'file_sk'=>Yii::t('app','File SK'),
                                                'approval_status'=>Yii::t('app','Status Persetujuan'),
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
		$criteria->compare('id_iuphhk_tenaga_kerja',$this->id_iuphhk_tenaga_kerja);
		$criteria->compare('no_reg',$this->no_reg,true);
                $criteria->compare('no_sk',$this->no_sk,true);
                $criteria->compare('tgl_sk',$this->tgl_sk,true);
		$criteria->compare('tgl_awal_sk',$this->tgl_awal_sk,true);
		$criteria->compare('tgl_akhir_sk',$this->tgl_akhir_sk,true);
                $criteria->compare('id_bphp',$this->id_bphp,true);
                $criteria->compare('file_reg',$this->file_reg,true);
                $criteria->compare('file_sk',$this->file_sk,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SertifikatGanis the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function searchUsulanGanis(){

            $criteria = new CDbCriteria;
            
            $criteria->condition = "approval_status = 0";
            
            $criteria->compare('id',$this->id);
            $criteria->compare('id_iuphhk_tenaga_kerja',$this->id_iuphhk_tenaga_kerja);
            $criteria->compare('no_reg',$this->no_reg,true);
            $criteria->compare('no_sk',$this->no_sk,true);
            $criteria->compare('tgl_sk',$this->tgl_sk,true);
            $criteria->compare('tgl_awal_sk',$this->tgl_awal_sk,true);
            $criteria->compare('tgl_akhir_sk',$this->tgl_akhir_sk,true);
            $criteria->compare('id_bphp',$this->id_bphp,true);
            $criteria->compare('file_reg',$this->file_reg,true);
            $criteria->compare('file_sk',$this->file_sk,true);
            $criteria->with = array('idIuphhkTenagaKerja','idBphp',
                'idIuphhkTenagaKerja.idJenisTenagaKerja',
                'idIuphhkTenagaKerja.idPerusahaan');
            $criteria->order = 'idPerusahaan.nama_perusahaan ASC';
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
//             $query = "SELECT s.id,
//                        IFNULL((SELECT p.nama_perusahaan FROM perusahaan p WHERE p.id_perusahaan = i.id_perusahaan),'')AS perusahaan,
//                        i.nama,
//                        i.id_jenis_tenaga_kerja,
//                        i.no_sertifikat,
//                        s.no_reg,
//                        s.file_reg,
//                        s.no_sk,
//                        s.file_sk,
//                        s.tgl_awal_sk,
//                        s.tgl_akhir_sk,
//                        s.id_bphp,
//                        s.approval_status,
//                        IFNULL((SELECT b.nama_bphp FROM master_bphp b WHERE b.id = s.id_bphp),'')AS bphp
//                        FROM iuphhk_tenaga_kerja i
//                        INNER JOIN sertifikat_ganis s
//                        ON s.id_iuphhk_tenaga_kerja = i.id AND s.id_bphp = ".$this->id_bphp.";";
//        
//             $result = Yii::app()->db->createCommand($query)->queryAll() ;
//             
//                $dataProvider=new CArrayDataProvider($result, array(
//                    'id'=>'rkt', //this is an identifier for the array data provider
//                    'sort'=>false,
//                    'keyField'=>'id', //this is what will be considered your key field
//                    'pagination'=>array(
//                        'pageSize'=>25, //eureka! you can configure your pagination from here
//                    ),
//                ));
//             return $dataProvider;
        
            
        }
        public function searchGanisSetujui(){

            $criteria = new CDbCriteria;
            
            $criteria->condition = "approval_status = 1";
            
            $criteria->compare('id',$this->id);
            $criteria->compare('id_iuphhk_tenaga_kerja',$this->id_iuphhk_tenaga_kerja);
            $criteria->compare('no_reg',$this->no_reg,true);
            $criteria->compare('no_sk',$this->no_sk,true);
            $criteria->compare('tgl_sk',$this->tgl_sk,true);
            $criteria->compare('tgl_awal_sk',$this->tgl_awal_sk,true);
            $criteria->compare('tgl_akhir_sk',$this->tgl_akhir_sk,true);
            $criteria->compare('id_bphp',$this->id_bphp,true);
            $criteria->compare('file_reg',$this->file_reg,true);
            $criteria->compare('file_sk',$this->file_sk,true);
            $criteria->with = array('idIuphhkTenagaKerja','idBphp',
                'idIuphhkTenagaKerja.idJenisTenagaKerja',
                'idIuphhkTenagaKerja.idPerusahaan');
            $criteria->order = 'idPerusahaan.nama_perusahaan ASC';
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));               
        }
        
        public function searchGanisTolak(){

            $criteria = new CDbCriteria;
            
            $criteria->condition = "approval_status = 2";
            
            $criteria->compare('id',$this->id);
            $criteria->compare('id_iuphhk_tenaga_kerja',$this->id_iuphhk_tenaga_kerja);
            $criteria->compare('no_reg',$this->no_reg,true);
            $criteria->compare('no_sk',$this->no_sk,true);
            $criteria->compare('tgl_sk',$this->tgl_sk,true);
            $criteria->compare('tgl_awal_sk',$this->tgl_awal_sk,true);
            $criteria->compare('tgl_akhir_sk',$this->tgl_akhir_sk,true);
            $criteria->compare('id_bphp',$this->id_bphp,true);
            $criteria->compare('file_reg',$this->file_reg,true);
            $criteria->compare('file_sk',$this->file_sk,true);
            $criteria->with = array('idIuphhkTenagaKerja','idBphp',
                'idIuphhkTenagaKerja.idJenisTenagaKerja',
                'idIuphhkTenagaKerja.idPerusahaan');
            $criteria->order = 'idPerusahaan.nama_perusahaan ASC';
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));               
        }
        
}
