<?php

/**
 * This is the model class for table "realisasi_rkt_panen_produksi".
 *
 * The followings are the available columns in table 'realisasi_rkt_panen_produksi':
 * @property integer $id
 * @property integer $id_rkt_panen_produksi
 * @property integer $id_bulan
 * @property string $tahun
 * @property string $realisasi
 * @property string $persentase
 * @property string $created
 * @property string $updated
 */
class RealisasiRktPanenLahan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $id_rkt;
	public $id_jenis_lahan;
	public $id_blok;
	public $sd_sekarang_produksi;
        public $sd_sekarang_luas;
	public $sd_bulan_lalu_produksi;
        public $sd_bulan_lalu_luas;
//        public $persentase_produksi;
//        public $persentase_luas;
        
	public function tableName()
	{
		return 'realisasi_rkt_panen_lahan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt_panen_lahan, id_bulan, tahun, realisasi_produksi, realisasi_luas, persentase_produksi,persentase_luas, created, updated', 'required'),
			array('id_rkt_panen_lahan, id_bulan', 'numerical', 'integerOnly'=>true),
			array('tahun', 'length', 'max'=>4),
			array('realisasi_produksi,realisasi_luas, persentase_produksi, persentase_luas', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt_panen_lahan, id_bulan, tahun, realisasi_produksi,realisasi_luas, persentase_produksi, persentase_luas, created, updated', 'safe', 'on'=>'search'),
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
			'idRktPanenLahan' => array(self::BELONGS_TO, 'RktPanenLahan', 'id_rkt_panen_lahan'),
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
						'id_rkt_panen_lahan'=>Yii::t('app','Id Rkt Panen Lahan'),
						'id_bulan'=>Yii::t('app','Id Bulan'),
						'tahun'=>Yii::t('app','Tahun'),
						'realisasi_produksi'=>Yii::t('app','Realisasi Produksi'),
						'realisasi_luas'=>Yii::t('app','Realisasi Luas'),
						'persentase_produksi'=>Yii::t('app','Persentase Produksi'),
						'persentase_luas'=>Yii::t('app','Persentase Luas'),
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
		$criteria->compare('id_rkt_panen_lahan',$this->id_rkt_panen_lahan);
		$criteria->compare('id_bulan',$this->id_bulan);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('realisasi_produksi',$this->realisasi_produksi,true);
		$criteria->compare('realisasi_luas',$this->realisasi_luas,true);
		$criteria->compare('persentase_produksi',$this->persentase_produksi,true);
		$criteria->compare('persentase_luas',$this->persentase_luas,true);
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
                        't.realisasi_luas',
			'COALESCE(SUM(bulan_lalu.realisasi_luas), 0) AS sd_bulan_lalu_luas',
			'(COALESCE(SUM(bulan_lalu.realisasi_luas), 0) + t.realisasi_luas) AS sd_sekarang_luas',
			'(COALESCE(SUM(bulan_lalu.persentase_luas), 0) + t.persentase_luas) AS persentase_luas',
                        't.realisasi_produksi',
                        'COALESCE(SUM(bulan_lalu.realisasi_produksi), 0) AS sd_bulan_lalu_produksi',
			'(COALESCE(SUM(bulan_lalu.realisasi_produksi), 0) + t.realisasi_produksi) AS sd_sekarang_produksi',
			'(COALESCE(SUM(bulan_lalu.persentase_produksi), 0) + t.persentase_produksi) AS persentase_produksi'
		);
		$criteria->with = array('idRktPanenLahan');
		$criteria->compare('idRktPanenLahan.id_rkt',$this->id_rkt);
		$criteria->compare('t.id_bulan',$this->id_bulan);
		$criteria->compare('t.tahun',$this->tahun);
		$criteria->join = 'LEFT JOIN '. $this->tableName() .' bulan_lalu ON
		 	bulan_lalu.id_rkt_panen_lahan = t.id_rkt_panen_lahan AND
			CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)';
		$criteria->group = 't.id_rkt_panen_lahan';
                
//                print_r($criteria); die();
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RealisasiRktPanenProduksi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTotal($records, $colName){
        $total = 0;
        foreach($records as $rec){
			if ($colName == 'jumlah_produksi' || $colName == 'jumlah_luas'){
				$total+=$rec->idRktPanenLahan->{$colName};
			}else {
				$total+=$rec->{$colName};
			}
		}
        return number_format($total,2,',','.');
    }

	public function getTotalPersenProduksi($records, $colName){
    	$totalJumlah = 0;
    	$total_rencana = 0;
		$idx = 0;
    	foreach($records as $rec){
			$total_rencana += $rec->idRktPanenLahan->jumlah_produksi;
			$totalJumlah += $rec->$colName;
			if($total_rencana > 0){
				$idx++;
			}
    	}
    	$subTotal = ($totalJumlah > 0 ? ((($totalJumlah / $idx) / $total_rencana) * 100) : 0);
		return $totalJumlah;
    }	
    
    public function getTotalPersenLuas($records, $colName){
    	$totalJumlah = 0;
    	$total_rencana = 0;
		$idx = 0;
    	foreach($records as $rec){
			$total_rencana += $rec->idRktPanenLahan->jumlah_luas;
			$totalJumlah += $rec->$colName;
			if($total_rencana > 0){
				$idx++;
			}
    	}
    	$subTotal = ($totalJumlah > 0 ? ((($totalJumlah / $idx) / $total_rencana) * 100) : 0);
		return $totalJumlah;
    }	

}
