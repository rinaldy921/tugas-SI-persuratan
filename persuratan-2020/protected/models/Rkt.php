<?php

/**
 * This is the model class for table "rkt".
 *
 * The followings are the available columns in table 'rkt':
 * @property integer $id
 * @property integer $id_perusahaan
 * @property integer $id_rku
 * @property string $nomor_sk
 * @property string $tanggal_sk
 * @property string $tahun_mulai
 * @property string $tahun_sampai
 * @property integer $status
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property PenilaianKinerja[] $penilaianKinerjas
 * @property ProgresTataBatas[] $progresTataBatases
 * @property Perusahaan $idPerusahaan
 * @property Rku $idRku
 * @property RktArealKerja[] $rktArealKerjas
 * @property RktArealNonProduktif[] $rktArealNonProduktifs
 * @property RktArealProduktif[] $rktArealProduktifs
 * @property RktBangunMitra[] $rktBangunMitras
 * @property RktBibit[] $rktBibits
 * @property RktDangir[] $rktDangirs
 * @property RktEvaluasiKeberhasilan[] $rktEvaluasiKeberhasilans
 * @property RktEvaluasiPantauOperasional[] $rktEvaluasiPantauOperasionals
 * @property RktGanis[] $rktGanises
 * @property RktInfraMukim[] $rktInfraMukims
 * @property RktInventarisasi[] $rktInventarisasis
 * @property RktJarang[] $rktJarangs
 * @property RktKawasanLindung[] $rktKawasanLindungs
 * @property RktKerjasamaKoperasi[] $rktKerjasamaKoperasis
 * @property RktKonflikSosial[] $rktKonflikSosials
 * @property RktLingkunganDalkar[] $rktLingkunganDalkars
 * @property RktLingkunganDalmakit[] $rktLingkunganDalmakits
 * @property RktLingkunganDungtan[] $rktLingkunganDungtans
 * @property RktMasukGunaAlat[] $rktMasukGunaAlats
 * @property RktPanenVolumeSiapLahan[] $rktPanenVolumeSiapLahans
 * @property RktPanenVolumeTanaman[] $rktPanenVolumeTanamen
 * @property RktPasar[] $rktPasars
 * @property RktPemantauanLingkungan[] $rktPemantauanLingkungans
 * @property RktPeningkatanSdm[] $rktPeningkatanSdms
 * @property RktPwh[] $rktPwhs
 * @property RktSarpras[] $rktSarprases
 * @property RktSiapLahan[] $rktSiapLahans
 * @property RktSulam[] $rktSulams
 * @property RktTanam[] $rktTanams
 * @property RktTataBatas[] $rktTataBatases
 * @property SpasialRkt[] $spasialRkts
 */
class Rkt extends CActiveRecord
{
	public $keterangan;
        public $tahun_ke;
        public $provinsiId;
        public $_tahun;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt';
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

    
    public function scopes() {
        return array(
            'bytahun' => array('order' => 'tahun_mulai DESC'),
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
			array('nomor_sk, tanggal_sk, tahun_mulai, mulai_berlaku,akhir_berlaku', 'required'),
			array('tahun_mulai','ext.MyValidators.cekTahun','on'=>'create'),
			// array('mulai_berlaku','ext.MyValidators.cekMulai'),
			array('id_perusahaan, id_rku, status', 'numerical', 'integerOnly'=>true),
			array('nomor_sk', 'length', 'max'=>255),
			array('tahun_mulai', 'length', 'max'=>4),                    
			array('rkt_ke', 'length', 'max'=>10),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_perusahaan, id_rku, nomor_sk, tanggal_sk, tahun_mulai,  mulai_berlaku,akhir_berlaku, status, created_at, modified_at, file_doc, file_shp', 'safe', 'on'=>'search'),
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
			'penilaianKinerjas' => array(self::HAS_MANY, 'PenilaianKinerja', 'id_rkt'),
			'progresTataBatases' => array(self::HAS_MANY, 'ProgresTataBatas', 'id_rkt'),
			'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
			'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
			'rktArealKerjas' => array(self::HAS_MANY, 'RktArealKerja', 'id_rkt'),
			'rktArealNonProduktifs' => array(self::HAS_MANY, 'RktArealNonProduktif', 'id_rkt'),
			'rktArealProduktifs' => array(self::HAS_MANY, 'RktArealProduktif', 'id_rkt'),
			'rktBangunMitras' => array(self::HAS_MANY, 'RktBangunMitra', 'id_rkt'),
			'rktBibits' => array(self::HAS_MANY, 'RktBibit', 'id_rkt'),
			'rktDangirs' => array(self::HAS_MANY, 'RktDangir', 'id_rkt'),
			'rktEvaluasiKeberhasilans' => array(self::HAS_MANY, 'RktEvaluasiKeberhasilan', 'id_rkt'),
			'rktEvaluasiPantauOperasionals' => array(self::HAS_MANY, 'RktEvaluasiPantauOperasional', 'id_rkt'),
			'rktGanises' => array(self::HAS_MANY, 'RktGanis', 'id_rkt'),
			'rktInfraMukims' => array(self::HAS_MANY, 'RktInfraMukim', 'id_rkt'),
			'rktInventarisasis' => array(self::HAS_MANY, 'RktInventarisasi', 'id_rkt'),
			'rktJarangs' => array(self::HAS_MANY, 'RktJarang', 'id_rkt'),
			'rktKawasanLindungs' => array(self::HAS_MANY, 'RktKawasanLindung', 'id_rkt'),
			'rktKerjasamaKoperasis' => array(self::HAS_MANY, 'RktKerjasamaKoperasi', 'id_rkt'),
			'rktKonflikSosials' => array(self::HAS_MANY, 'RktKonflikSosial', 'id_rkt'),
			'rktLingkunganDalkars' => array(self::HAS_MANY, 'RktLingkunganDalkar', 'id_rkt'),
			'rktLingkunganDalmakits' => array(self::HAS_MANY, 'RktLingkunganDalmakit', 'id_rkt'),
			'rktLingkunganDungtans' => array(self::HAS_MANY, 'RktLingkunganDungtan', 'id_rkt'),
			'rktMasukGunaAlats' => array(self::HAS_MANY, 'RktMasukGunaAlat', 'id_rkt'),
			'rktPanenVolumeSiapLahans' => array(self::HAS_MANY, 'RktPanenVolumeSiapLahan', 'id_rkt'),
			'rktPanenVolumeTanamen' => array(self::HAS_MANY, 'RktPanenVolumeTanaman', 'id_rkt'),
			'rktPasars' => array(self::HAS_MANY, 'RktPasar', 'id_rkt'),
			'rktPemantauanLingkungans' => array(self::HAS_MANY, 'RktPemantauanLingkungan', 'id_rkt'),
			'rktPeningkatanSdms' => array(self::HAS_MANY, 'RktPeningkatanSdm', 'id_rkt'),
			'rktPwhs' => array(self::HAS_MANY, 'RktPwh', 'id_rkt'),
			'rktSarprases' => array(self::HAS_MANY, 'RktSarpras', 'id_rkt'),
			'rktSiapLahans' => array(self::HAS_MANY, 'RktSiapLahan', 'id_rkt'),
			'rktSulams' => array(self::HAS_MANY, 'RktSulam', 'id_rkt'),
			'rktTanams' => array(self::HAS_MANY, 'RktTanam', 'id_rkt'),
			'rktTataBatases' => array(self::HAS_MANY, 'RktTataBatas', 'id_rkt'),
			'spasialRkts' => array(self::HAS_MANY, 'SpasialRkt', 'id_rkt'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_perusahaan'=>Yii::t('app','Perusahaan'),
						'id_rku'=>Yii::t('app','Id Rku'),
						'nomor_sk'=>Yii::t('app','Nomor Sk'),
						'tanggal_sk'=>Yii::t('app','Tanggal Sk'),
						'tahun_mulai'=>Yii::t('app','Tahun'),
						'mulai_berlaku'=>Yii::t('app','Mulai Berlaku RKT'),
						'akhir_berlaku'=>Yii::t('app','Akhir Berlaku RKT'),
						'status'=>Yii::t('app','Status'),
						'created_at'=>Yii::t('app','Created At'),
						'modified_at'=>Yii::t('app','Modified At'),
                                                'rkt_ke' => Yii::t('app','RKT Ke'),
                                                'tahun_ke'=>Yii::t('app','RKT Tahun Ke'),    
                                                'file_doc' => "File Dokumen",
                                                'file_shp' => "File Peta",
                                                '_tahun' => "Pilih Tahun",
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
		$criteria->compare('id_rku',$this->id_rku);
		$criteria->compare('nomor_sk',$this->nomor_sk,true);
		$criteria->compare('tanggal_sk',$this->tanggal_sk,true);
		$criteria->compare('tahun_mulai',$this->tahun_mulai,true);
		$criteria->compare('mulai_berlaku',$this->mulai_berlaku,true);
		$criteria->compare('akhir_berlaku',$this->akhir_berlaku,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);                
		$criteria->compare('rkt_ke',$this->rkt_ke,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'tahun_mulai ASC'
			)
		));
	}

        
        public function searchByPropinsi()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->together = true; // ADDED THIS
                $criteria->with = array('idPerusahaan');
                $criteria->compare('id_perusahaan', $this->id_perusahaan, true);
                $criteria->compare('Perusahaan.provinsi', '62', true);
//                $criteria->select = array('nomor_sk,
//                                           tanggal_sk,
//                                           tahun_mulai,
//                                           mulai_berlaku,
//                                           akhir_berlaku, 
//                                           approval_status');
               // $criteria->condition = "perusahaan.id_perusahaan=:id_perusahaan AND 
                  //                      perusahaan.provinsi=:propinsi AND tahun_mulai=2018";
                //$criteria->params = array(':propinsi' => '62');
                $criteria->order = 'tahun_mulai ASC';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'tahun_mulai ASC'
			)
		));
	}
        
        
        
        
        public function searchRktToApproval(){
               
             $query = "SELECT r.id,r.nomor_sk,r.tanggal_sk,r.tahun_mulai,r.tahun_mulai as tahun_ke,r.mulai_berlaku,r.akhir_berlaku, 
                        r.approval_status,r.file_doc,r.file_shp, p.nama_perusahaan
                        FROM rkt r, perusahaan p
                        WHERE r.id_perusahaan = p.id_perusahaan AND p.provinsi=".$this->provinsiId."
                        AND r.tahun_mulai=".$this->tahun_ke." AND id_rev=0";
        
             $result = Yii::app()->db->createCommand($query)->queryAll() ;
             
                $dataProvider=new CArrayDataProvider($result, array(
                    'id'=>'rkt', //this is an identifier for the array data provider
                    'sort'=>false,
                    'keyField'=>'id', //this is what will be considered your key field
                    'pagination'=>array(
                        'pageSize'=>25, //eureka! you can configure your pagination from here
                    ),
                ));
             return $dataProvider;
        
            
        }
             
        
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rkt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function cekRev($id_rku, $id) {
		$m = 'Telah direvisi';
		$rkt = Rkt::model()->findAll(array('condition'=>'id_rku = '.$id_rku,'order'=>'id ASC'));
		if(!empty($rkt)) {
			foreach($rkt as $key => $data) {
				if($data->id == $id && $data->status == 1 || $data->id == $id && $data->status == 1 && $data->id_rev !== 0) {
					$m = 'Aktif';
				} elseif($data->id == $id && $data->status == 2 && $data->id_rev > 0) {
					$m = 'Revisi ke - '. ($key);
				} elseif($data->id == $id && $data->status == 2 && $data->id_rev == 0) {
					$m = 'Telah Direvisi';
				}
			}
		} else {
			$m = 'Aktif';
		}
		return $m;
	}

	public function listTahun($id_rku) {
		$arrays = CHtml::listData(Rkt::model()->findAll(array('select' => 'tahun_mulai', 'order' => 'tahun_mulai ASC', 'condition'=>'id_rku = '.$id_rku)), 'tahun_mulai', 'tahun_mulai');
		return $arrays;
	}
        
        public function monthByRKT() {
            $rkt = Rkt::model()->findAll(
                array(
                    'condition'=> 'id_perusahaan = '.Yii::app()->user->idPerusahaan(),
                    'order' =>'tahun_mulai DESC'
                )
            );
            
            //$bulan = MasterBulan::model()->findAll();
            
            foreach ($rkt as $idx => $val)
            {
                settype($val->tahun_mulai, 'string');
                $data[$val->tahun_mulai] = $this->setPeriodeBulan($val->mulai_berlaku, $val->akhir_berlaku);                
            }
            return $data;
        }
        
        public function setPeriodeBulan($startdate, $enddate) {
            $periode = [];
            
            $bulan      = MasterBulan::model()->findAll();
            $arrStart   = explode("-", $startdate);
            $arrEnd     = explode("-", $enddate);
            $tahunMulai = $arrStart[0];
            $bulanMulai = $arrStart[1];
            settype($bulanMulai, 'integer');
            $tahunBeres = $arrEnd[0];
            $bulanBeres = $arrEnd[1];
            settype($bulanBeres, 'integer');
            
            for($x1=$bulanMulai; $x1<=12; $x1++)
            {
                array_push($periode, [
                    'id_bulan' => $x1.'_'.$tahunMulai,                     
                    'bulan' => $this->getTextBulan($bulan, $x1).' '.$tahunMulai
                ]);
                //$periode[$x1] = ;
            }
                                        
            if($tahunMulai != $tahunBeres){
                for($x2=1; $x2<=$bulanBeres; $x2++)
                {
                    array_push($periode, [
                        'id_bulan' => $x2.'_'.$tahunBeres,                     
                        'bulan' => $this->getTextBulan($bulan, $x2).' '.$tahunBeres
                    ]);                
                    //$periode[$x2] = $this->getTextBulan($bulan, $x2).' '.$tahunBeres;
                }                
            }
            
            return $periode;
            //debug($periode);
            //echo $bulanMulai.' / '.$tahunMulai.' <hr />';
            //echo $bulanBeres.' / '.$tahunBeres.' <hr />';
        }
        
        
        public function getListTahunRkt(){
            $result =  Yii::$app->db->createCommand('SELECT  count(DISTINCT(tahun_mulai)) as tahun FROM rkt ORDER BY tahun_mulai ASC')
                       ->queryAll();
            
            return $result;
        }
        
        
        public function getListTahun(){
            $result =  Yii::app()->db->createCommand('SELECT  DISTINCT(tahun_mulai) as tahun FROM rkt ORDER BY tahun_mulai ASC')
                       ->queryAll();
            
            return $result;
        }
        
        
        public function getTextBulan($ARbulan, $intBulan) {
            foreach ($ARbulan as $idx => $value)
            {
                if($value->id == $intBulan) return $value->bulan;
            }
        }
        
        
        public function deleteByRkuId($idRku)
        {
            $this->getDbConnection()->createCommand('DELETE FROM rkt WHERE id_rku='.$idRku)->execute();
        }
        
        
        public function getLastRkt($idRku)
        {
                $criteria = new CDbCriteria;
                $criteria->order = 'id DESC';
                $criteria->addColumnCondition(array('id_rku' => $idRku));
                $model = Rkt::model()->find( $criteria );
                return $model;
        }
        
        
         public function getTahunByIdPerusahaan($idPerusahaan)
        {
                $query = "SELECT DISTINCT tahun_mulai,nomor_sk FROM rkt WHERE id_perusahaan=".$idPerusahaan."  ORDER BY tahun_mulai ASC";

                $categorylist=Yii::app()->db->createCommand($query)->queryAll();

                $category_array;
                foreach($categorylist as $data)
                {
                    $category_array[$data['tahun_mulai']]=$data['tahun_mulai']."  |  ".$data['nomor_sk'];
                }
                return $category_array;
        }
        
        
        public function getIDByIdPerusahaan($idPerusahaan)
        {
                $query = "SELECT DISTINCT id,tahun_mulai,nomor_sk FROM rkt WHERE id_perusahaan=".$idPerusahaan."  ORDER BY tahun_mulai ASC";

                $categorylist=Yii::app()->db->createCommand($query)->queryAll();

                $category_array;
                foreach($categorylist as $data)
                {
                    $category_array[$data['id']]=$data['tahun_mulai']."  |  ".$data['nomor_sk'];
                }
                return $category_array;
        }
        
        
        
           public function getByPerusahaanId($perusahaanId)
        {
                $query = "
                        SELECT r.tahun_mulai,r.nomor_sk, r.tanggal_sk
                        FROM rkt r WHERE id_perusahaan=".$perusahaanId." ORDER BY r.tahun_mulai ASC;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
        
        public function getLastRktByPerusahaanId($perusahaanId){
                $query = "SELECT * FROM rkt WHERE id_perusahaan=".$perusahaanId." ORDER BY tahun_mulai DESC LIMIT 1";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
        
        
           public function getRktList(){
                $query = "SELECT r.id, r.id_perusahaan,r.id_rku FROM rkt r ORDER BY id ASC;";

                $result=Yii::app()->db->createCommand($query)->queryAll();
                
                return $result;
        }  
        public function getRktListByTahun($tahun){
                $query = "SELECT r.id, r.id_perusahaan,r.id_rku FROM rkt r where r.tahun_mulai = ".$tahun." ORDER BY id ASC;";

                $result=Yii::app()->db->createCommand($query)->queryAll();
                
                return $result;
        }  
        
        
          public function getLastRKTByRkuId($rkuId)
        {
                $query = "select * from rkt where id_rku=".$rkuId." and id_rev=0 and status=1 order by tahun_mulai desc  limit 1;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
}
