<?php

/**
 * This is the model class for table "realisasi_rkt_areal_kerja".
 *
 * The followings are the available columns in table 'realisasi_rkt_areal_kerja':
 * @property integer $id
 * @property integer $id_rkt_areal_kerja
 * @property integer $id_bulan
 * @property string $tahun
 * @property string $realisasi
 * @property string $persentase
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property RktArealKerja $idRktArealKerja
 * @property MasterBulan $idBulan
 */
class RealisasiRktArealKerja extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id_rkt;
	public $sd_sekarang;
	public $sd_bulan_lalu;
	public function tableName()
	{
		return 'realisasi_rkt_areal_kerja';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt_areal_kerja, id_bulan, realisasi, persentase, created, updated', 'required'),
			array('id_rkt_areal_kerja, id_bulan', 'numerical', 'integerOnly'=>true),
			array('tahun', 'length', 'max'=>4),
			array('realisasi, persentase', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt_areal_kerja, id_bulan, tahun, realisasi, persentase, created, updated', 'safe', 'on'=>'search'),
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
			'idRktArealKerja' => array(self::BELONGS_TO, 'RktArealKerja', 'id_rkt_areal_kerja'),
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
						'id_rkt_areal_kerja'=>Yii::t('app','Id Rkt Areal Kerja'),
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
		$criteria->compare('id_rkt_areal_kerja',$this->id_rkt_areal_kerja);
		$criteria->compare('id_bulan',$this->id_bulan);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('realisasi',$this->realisasi,true);
		$criteria->compare('persentase',$this->persentase,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RealisasiRktArealKerja the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
		$criteria->with = array('idRktArealKerja');
		$criteria->compare('idRktArealKerja.id_rkt',$this->id_rkt);
		$criteria->compare('t.id_bulan',$this->id_bulan);
		$criteria->compare('t.tahun',$this->tahun);
		$criteria->join = 'LEFT JOIN '. $this->tableName() .' bulan_lalu ON
		 	bulan_lalu.id_rkt_areal_kerja = t.id_rkt_areal_kerja AND
			CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)';
		$criteria->group = 't.id_rkt_areal_kerja';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTotal($records, $colName){
        $total = 0;
        foreach ($records as $rec){
			if ($colName == 'jumlah'){
				$total+=$rec->idRktArealKerja->jumlah;
			}else{
				$total+=$rec->{$colName};
			}
		}
        return number_format($total,2,',','.');
    }

	public function getTotalPersen($records, $colName){
		$totalJumlah = 0;
    	$totalRealisasi = 0;
		$idx = 0;
    	foreach($records as $rec){
    		$totalJumlah += $rec->idRktArealKerja->jumlah;
    		$totalRealisasi +=$rec->$colName;
			if($rec->idRktArealKerja->jumlah > 0) {
				$idx++;
			}
    	}
    	$subTotal = ($totalRealisasi > 0 ? ($totalRealisasi / $idx) : 0);
    	return number_format($subTotal,2);
    }
    
    
        public function get4UpdateBulanByIdRkt($idRkt){
         $query = "SELECT r.id_bulan AS bulan,r.tahun,b.id_rkt 
                    FROM realisasi_rkt_areal_kerja r,rkt_areal_kerja b WHERE r.id_rkt_areal_kerja = b.id AND b.id_rkt = ".$idRkt."
                    GROUP BY r.id_bulan,r.tahun,b.id_rkt
                    ";

                $result=Yii::app()->db->createCommand($query)->queryAll();
                
                return $result;
        }    

}
