<?php

/**
 * This is the model class for table "realisasi_rkt_pelihara".
 *
 * The followings are the available columns in table 'realisasi_rkt_pelihara':
 * @property integer $id
 * @property integer $id_rkt_pelihara
 * @property integer $id_bulan
 * @property string $tahun
 * @property double $realisasi
 * @property double $persentase
 * @property string $created
 * @property string $updated
 */
class RealisasiRktPelihara extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id_rkt;
	public $id_jenis_lahan;
	public $id_blok;
	public $sd_sekarang;
	public $sd_bulan_lalu;
	public function tableName()
	{
		return 'realisasi_rkt_pelihara';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt_pelihara, id_bulan, tahun, realisasi, persentase, created, updated', 'required'),
			array('id_rkt_pelihara, id_bulan', 'numerical', 'integerOnly'=>true),
			array('realisasi, persentase', 'numerical'),
			array('tahun', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt_pelihara, id_bulan, tahun, realisasi, persentase, created, updated', 'safe', 'on'=>'search'),
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
			'idRktPelihara' => array(self::BELONGS_TO, 'RktPelihara', 'id_rkt_pelihara'),
			'idBulan' => array(self::BELONGS_TO, 'MasterBulan', 'id_bulan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_rkt_pelihara'=>Yii::t('app','Id Rkt Pelihara'),
						'id_bulan'=>Yii::t('app','Id Bulan'),
						'tahun'=>Yii::t('app','Tahun'),
						'realisasi'=>Yii::t('app','Realisasi'),
						'persentase'=>Yii::t('app','Persentase'),
						'created'=>Yii::t('app','Created'),
						'updated'=>Yii::t('app','Updated'),
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
		$criteria->compare('id_rkt_pelihara',$this->id_rkt_pelihara);
		$criteria->compare('id_bulan',$this->id_bulan);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByRkt()
	{
		$criteria=new CDbCriteria;
		$criteria->select = array(
			't.realisasi',
			'COALESCE(SUM(bulan_lalu.realisasi), 0) AS sd_bulan_lalu',
			'(COALESCE(SUM(bulan_lalu.realisasi), 0) + t.realisasi) AS sd_sekarang',
			'(COALESCE(SUM(bulan_lalu.persentase), 0) + t.persentase) AS persentase'
		);
		$criteria->with = array('idRktPelihara');
		$criteria->compare('idRktPelihara.id_rkt',$this->id_rkt);
		$criteria->compare('t.id_bulan',$this->id_bulan);
		$criteria->compare('t.tahun',$this->tahun);
		$criteria->join = 'LEFT JOIN '. $this->tableName() .' bulan_lalu ON
		 	bulan_lalu.id_rkt_pelihara = t.id_rkt_pelihara AND
			CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)';
		$criteria->group = 't.id_rkt_pelihara';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RealisasiRktPelihara the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		public function getTotal($records, $colName){
        $total = 0;
        foreach($records as $rec){
			if ($colName == 'jumlah'){
				$total+=$rec->idRktPelihara->{$colName};
			}else {
				$total+=$rec->{$colName};
			}
		}
        return number_format($total,2,',','.');
    }

	public function getTotalPersen($records, $colName){
    	$totalJumlah = 0;
    	$total_rencana = 0;
		$idx = 0;
    	foreach($records as $rec){
			$total_rencana += $rec->idRktPelihara->jumlah;
			$totalJumlah += $rec->$colName;
			if($total_rencana > 0){
				$idx++;
			}
    	}
    	$subTotal = ($totalJumlah > 0 ? ((($totalJumlah / $idx) / $total_rencana) * 100) : 0);
		return $totalJumlah;
    }
    
    
    
        public function getByRktAndBulan($rktId,$idBulan)
    {
        $idBulan = $idBulan+1;
        
            $query = "SELECT b.id,b.daur,b.id_blok,
                        IFNULL((SELECT s.nama_sektor FROM rku_sektor s WHERE s.id_sektor = (SELECT bl.id_sektor FROM rku_blok bl WHERE bl.id=b.id_blok)),0)AS sektor,
                        IFNULL((SELECT rb.nama_blok FROM rku_blok rb WHERE rb.id = b.id_blok),0)AS blok,
                        IFNULL((SELECT m.jenis_produksi FROM master_jenis_produksi_lahan m WHERE m.id = b.id_jenis_produksi_lahan),0)AS jenisproduksilahan,
                        IFNULL((SELECT m.jenis_lahan FROM master_jenis_lahan m WHERE m.id = b.id_jenis_lahan),0)AS jenislahan,
                        IFNULL((SELECT m.jenis_pemeliharaan FROM master_jenis_pemeliharaan m WHERE m.id = b.id_jenis_pemeliharaan),0)AS jenispelihara,
                        b.jumlah AS target,
                        IFNULL((SELECT SUM(r.realisasi) FROM realisasi_rkt_pelihara r WHERE r.id_rkt_pelihara=b.id AND r.id_bulan < ".$idBulan."),0)AS realisasi
                        FROM rkt_pelihara b WHERE b.id_rkt=".$rktId;

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
    
    
     public function get4UpdateBulanByIdRkt($idRkt){
         $query = "SELECT r.id_bulan AS bulan,r.tahun,b.id_rkt 
                    FROM realisasi_rkt_pelihara r,rkt_pelihara b WHERE r.id_rkt_pelihara = b.id AND b.id_rkt = ".$idRkt."
                    GROUP BY r.id_bulan,r.tahun,b.id_rkt;	
                    ";

                $result=Yii::app()->db->createCommand($query)->queryAll();
                
                return $result;
        }    
    
    
}
