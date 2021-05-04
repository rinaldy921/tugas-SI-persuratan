<?php

/**
 * This is the model class for table "rku_areal_produktif".
 *
 * The followings are the available columns in table 'rku_areal_produktif':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_jenis_produksi_lahan
 * @property double $jumlah
 *
 * The followings are the available model relations:
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property Rku $idRku
 */
class RkuArealProduktif extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_areal_produktif';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, id_jenis_produksi_lahan', 'required'),
			array('id_rku, id_jenis_produksi_lahan', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, id_jenis_produksi_lahan, jumlah', 'safe', 'on'=>'search'),
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
			'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_rku' => 'Id Rku',
			'id_jenis_produksi_lahan' => 'Areal Efektif',
			'jumlah' => 'Jumlah',
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
		$criteria->compare('id_rku',$this->id_rku);
		$criteria->compare('id_jenis_produksi_lahan',$this->id_jenis_produksi_lahan);
		$criteria->compare('jumlah',$this->jumlah);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        return round($total, 2);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuArealProduktif the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getTotalByRkuId($rkuId)
        {
                $query = "
                            SELECT f.id,
                            IFNULL((SELECT m.jenis_produksi FROM master_jenis_produksi_lahan m WHERE m.id=f.id_jenis_produksi_lahan ),'-')AS jenis,
                            f.jumlah,
                            IFNULL((SELECT SUM(p.jumlah) FROM rku_areal_produktif p WHERE p.id_rku = f.id_rku),0)AS efektif, 
                            IFNULL((SELECT SUM(p.jumlah) FROM rku_areal_non_produktif p WHERE p.id_rku = f.id_rku),0)AS nonefektif,
                            IFNULL((SELECT SUM(p.jumlah) FROM rku_kawasan_lindung p WHERE p.id_rku = f.id_rku),0)AS lindung
                             FROM rku_areal_produktif f WHERE f.id_rku=".$rkuId.";";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
        
        public function getArealEfektifByRkuId($rkuId)
        {
                $query = "
                            select 	p.id_rku, 
                                        sum(p.jumlah) as efektif,
                                        t.tahun, 
                                (YEAR(CURDATE()) - t.tahun) as umur,
                                sum(t.jumlah)as rkutanam
                        from rku_areal_produktif as p, rku_tanam as t
                        where p.id_rku = t.id_rku and t.id_rku = ".$rkuId."
                        group by p.id_rku, t.tahun, umur;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
}
