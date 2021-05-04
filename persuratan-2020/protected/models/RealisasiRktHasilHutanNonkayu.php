<?php

/**
 * This is the model class for table "realisasi_rkt_hasil_hutan_nonkayu".
 *
 * The followings are the available columns in table 'realisasi_rkt_hasil_hutan_nonkayu':
 * @property integer $id
 * @property integer $id_rkt_hasil_hutan_nonkayu
 * @property integer $id_bulan
 * @property string $tahun
 * @property integer $realisasi
 * @property string $persentase
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property RktHasilHutanNonkayu $idRktHasilHutanNonkayu
 * @property MasterBulan $idBulan
 */
class RealisasiRktHasilHutanNonkayu extends CActiveRecord
{
	public $id_rkt;
	public $sd_sekarang;
	public $sd_bulan_lalu;
	public $sektor;
	public $realisasi_bukan0;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'realisasi_rkt_hasil_hutan_nonkayu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt_hasil_hutan_nonkayu, id_bulan, realisasi', 'numerical', 'integerOnly'=>true),
			array('tahun', 'length', 'max'=>4),
			array('realisasi, persentase', 'numerical'),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt_hasil_hutan_nonkayu, id_bulan, tahun, realisasi, persentase, created, updated', 'safe', 'on'=>'search'),
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
			'idRktHasilHutanNonkayu' => array(self::BELONGS_TO, 'RktHasilHutanNonkayu', 'id_rkt_hasil_hutan_nonkayu'),
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
			'id_rkt_hasil_hutan_nonkayu'=>Yii::t('app','RKT Hasil Hutan Nonkayu'),
			'id_bulan'=>Yii::t('app','Bulan'),
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
		$criteria->compare('id_rkt_hasil_hutan_nonkayu',$this->id_rkt_hasil_hutan_nonkayu);
		$criteria->compare('id_bulan',$this->id_bulan);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByRkt()
	{
		$criteria = new CDbCriteria;
		$criteria->select = array(
			't.realisasi',
			'COALESCE(SUM(bulan_lalu.realisasi), 0) AS sd_bulan_lalu',
			'(COALESCE(SUM(bulan_lalu.realisasi), 0) + t.realisasi) AS sd_sekarang',
			'(COALESCE(SUM(bulan_lalu.persentase), 0) + t.persentase) AS persentase'
		);
		$criteria->with = array('idRktHasilHutanNonkayu');
		$criteria->compare('idRktHasilHutanNonkayu.id_rkt',$this->id_rkt);
		$criteria->compare('t.id_bulan',$this->id_bulan);
		$criteria->compare('t.tahun',$this->tahun);
		$criteria->join = 'LEFT JOIN realisasi_rkt_hasil_hutan_nonkayu bulan_lalu ON
			bulan_lalu.id_rkt_hasil_hutan_nonkayu = t.id_rkt_hasil_hutan_nonkayu AND
			CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)
			';
		if($this->realisasi_bukan0) {
			$criteria->addCondition('t.realisasi > 0','and');
		}
		$criteria->group = 't.id_rkt_hasil_hutan_nonkayu';
		// echo "<pre>";
		// print_r($this->realisasi_bukan0);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RealisasiRktHasilHutanNonkayu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTotal($records, $colName){
		$total = 0;
		foreach ($records as $rec){
			if($colName == 'jumlah'){
				$total += $rec->idRktHasilHutanNonkayu->jumlah;
			}else {
				$total += $rec->{$colName};
			}
		}
		return number_format($total,2,',','.');
	}

	public function getTotalPersen($records, $colName){
		$totalJumlah = 0;
		$total_rencana = 0;
		$idx = 0;
		foreach($records as $rec){
			$total_rencana += $rec->idRktHasilHutanNonkayu->jumlah;
			$totalJumlah += $rec->$colName;
			$idx++;
		}
		$subTotal = ($totalJumlah > 0 ? ((($totalJumlah / $idx) / $total_rencana) * 100) : 0);
		return number_format($subTotal,0,',','.');
	}
}
