<?php

/**
 * This is the model class for table "rkt_areal_produktif".
 *
 * The followings are the available columns in table 'rkt_areal_produktif':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_blok
 * @property integer $id_jenis_produksi_lahan
 * @property double $jumlah
 * @property double $realisasi
 *
 * The followings are the available model relations:
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property BlokSektor $idBlok
 * @property Rkt $idRkt
 */
class RktArealProduktif extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_areal_produktif';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, id_jenis_produksi_lahan', 'required'),
			array('id_rkt, id_jenis_produksi_lahan', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			array('id_jenis_produksi_lahan' , 'cekexist','on'=>'inputForm'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, id_jenis_produksi_lahan, jumlah, realisasi, persentase', 'safe', 'on'=>'search'),
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
			'idJenisProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
			// 'idBlok' => array(self::BELONGS_TO, 'BlokSektor', 'id_blok'),
			'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_rkt' => 'Id Rkt',
			// 'id_blok' => 'Blok',
			'id_jenis_produksi_lahan' => 'Jenis Produksi Lahan',
			'jumlah' => 'Rencana (Ha)',
			'realisasi' => 'Realisasi (Ha)',
			'persentase' => 'Persentase (%)',
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
		$criteria->compare('id_rkt',$this->id_rkt);
		// $criteria->compare('id_blok',$this->id_blok);
		$criteria->compare('id_jenis_produksi_lahan',$this->id_jenis_produksi_lahan);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktArealProduktif the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        return number_format($total,2,',','.');
    }

    public function getTotalPersen($records, $colName) {
    	$totalJumlah = 0;
    	$totalRealisasi = 0;
    	foreach($records as $rec) {
    		$totalJumlah += $rec->jumlah;
    		$totalRealisasi +=$rec->realisasi;
    	}
    	$subTotal = $totalRealisasi > 0 ? ($totalRealisasi / $totalJumlah) * 100 : 0 ;
    	return number_format($subTotal,2,',','.');
    }

    public function cekexist()
	{
		
	    $model = self::findByAttributes(array('id_jenis_produksi_lahan'=>$this->id_jenis_produksi_lahan,'id_rkt'=>$this->id_rkt));
	    if ($model)
	         $this->addError('id_jenis_produksi_lahan', 'Jenis Produksi Lahan yang dipilih Sudah tersimpan sebelumnya, silahkan untuk mengupdate data bila diperlukan') ;

	}
        
        
         public function getRealiasiTanamByRkuId($idPerusahaan)
        {
                $query = "select r.id, r.tahun_mulai as tahun,
                                                    ifnull((select sum(a.jumlah) from rku_areal_produktif as a where a.id_rku =  r.id_rku),0) as efektif,
                                                    (YEAR(CURDATE()) - r.tahun_mulai) as umur,
                                                    sum(t.jumlah) as jmlRkt, 
                                                    sum(t.realisasi) as jmlRealisasi,
                                                    ifnull((select sum(s.jumlah_luas) from stok_tanaman s where s.tahun_tanam = r.tahun_mulai and s.id_perusahaan = 7),0)as stokluas, 
                                        sum(jumlah_luas) as luasProduksi
                            from rkt as r, rkt_tanam as t, rkt_panen_produksi as p 
                            where  r.id_rku in (select id_rku from rku where id_perusahaan =".$idPerusahaan.") and t.id_rkt = r.id and t.id_rkt = p.id_rkt
                            group by r.id, efektif, r.tahun_mulai, umur;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
        
        

}
