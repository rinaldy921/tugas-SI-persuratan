<?php

/**
 * This is the model class for table "rkt_panen_areal".
 *
 * The followings are the available columns in table 'rkt_panen_areal':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_rku_tansil
 * @property integer $id_jenis_lahan
 * @property integer $id_produksi_lahan
 * @property integer $id_jenis_tanaman
 * @property integer $id_blok
 * @property double $jumlah
 * @property double $realisasi
 * @property double $persentase
 *
 * The followings are the available model relations:
 * @property RkuTanamanSilvikultur $idRkuTansil
 * @property BlokSektor $idBlok
 * @property MasterJenisLahan $idJenisLahan
 * @property MasterJenisProduksiLahan $idProduksiLahan
 * @property Rkt $idRkt
 * @property MasterJenisTanaman $idJenisTanaman
 */
class RktPanenAreal extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_panen_areal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, id_rku_tansil, id_jenis_lahan, id_produksi_lahan, id_jenis_tanaman', 'required'),
			array('id_rkt, id_rku_tansil, id_jenis_lahan, id_produksi_lahan, id_jenis_tanaman, id_blok', 'numerical', 'integerOnly'=>true),
			array('jumlah, realisasi, persentase', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, id_rku_tansil, id_jenis_lahan, id_produksi_lahan, id_jenis_tanaman, id_blok, jumlah, realisasi, persentase', 'safe', 'on'=>'search'),
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
			'idRkuTansil' => array(self::BELONGS_TO, 'RkuTanamanSilvikultur', 'id_rku_tansil'),
			'idBlok' => array(self::BELONGS_TO, 'BlokSektor', 'id_blok'),
			'idJenisLahan' => array(self::BELONGS_TO, 'MasterJenisLahan', 'id_jenis_lahan'),
			'idProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_produksi_lahan'),
			'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
			'idJenisTanaman' => array(self::BELONGS_TO, 'MasterJenisTanaman', 'id_jenis_tanaman'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_rkt'=>Yii::t('app','Id Rkt'),
						'id_rku_tansil'=>Yii::t('app','Id Rku Tansil'),
						'id_jenis_lahan'=>Yii::t('app','Jenis Lahan'),
						'id_produksi_lahan'=>Yii::t('app','Jenis Produksi Lahan'),
						'id_jenis_tanaman'=>Yii::t('app','Jenis Tanaman'),
						'id_blok'=>Yii::t('app','Blok'),
						'jumlah'=>Yii::t('app','Rencana (Ha)'),
						'realisasi'=>Yii::t('app','Realisasi (Ha)'),
						'persentase'=>Yii::t('app','Persentase (%)'),
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
		$criteria->compare('id_rku_tansil',$this->id_rku_tansil);
		$criteria->compare('id_jenis_lahan',$this->id_jenis_lahan);
		$criteria->compare('id_produksi_lahan',$this->id_produksi_lahan);
		$criteria->compare('id_jenis_tanaman',$this->id_jenis_tanaman);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('realisasi',$this->realisasi);
		$criteria->compare('persentase',$this->persentase);

		if(!is_null($this->id_blok)) {
			if(is_array($this->id_blok)) {
				$criteria->addInCondition('id_blok', $this->id_blok, 'AND');
			} else {
				$criteria->compare('id_blok',$this->id_blok);
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
			'sort' => array(
				'defaultOrder' => 'id_jenis_lahan, id_produksi_lahan, id_blok, id_jenis_tanaman ASC'
			)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktPanenAreal the static model class
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
}
