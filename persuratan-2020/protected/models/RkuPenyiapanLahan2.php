<?php

/**
 * This is the model class for table "rku_penyiapan_lahan".
 *
 * The followings are the available columns in table 'rku_penyiapan_lahan':
 * @property string $id
 * @property integer $id_rku
 * @property integer $id_tanaman_silvikultur
 * @property integer $id_jenis_lahan
 * @property integer $tahun
 * @property double $jumlah
 *
 * The followings are the available model relations:
 * @property MasterJenisLahan $idJenisLahan
 * @property Rku $idRku
 * @property RkuTanamanSilvikultur $idTanamanSilvikultur
 */
class RkuPenyiapanLahan2 extends CActiveRecord {

    public $jumlah_not_null = false;
    public $sektor, $blok;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rku_penyiapan_lahan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rku, id_jenis_lahan, tahun', 'required'),
            array('id_rku, daur, id_jenis_lahan, tahun', 'numerical', 'integerOnly' => true),
            array('jumlah', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_rku, id_jenis_lahan, tahun, jumlah', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idJenisLahan' => array(self::BELONGS_TO, 'MasterJenisLahan', 'id_jenis_lahan'),
            'idProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
            'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
            // 'idTanamanSilvikultur' => array(self::BELONGS_TO, 'RkuTanamanSilvikultur', 'id_tanaman_silvikultur'),
            'idBlok' => array(self::BELONGS_TO, 'BlokSektor', 'id_blok'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'id_rku' => Yii::t('app', 'Id Rku'),
            'id_jenis_produksi_lahan' => Yii::t('app', 'Tata Ruang'),
            'id_jenis_lahan' => Yii::t('app', 'Jenis Lahan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'jumlah' => Yii::t('app', 'Jumlah'),
            'id_blok' => "Lokasi Sektor / Blok"
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = "daur, tahun, id_blok, id_jenis_produksi_lahan, id_jenis_lahan";
        // $criteria->with = 'idTanamanSilvikultur';
        $criteria->compare('id', $this->id, true);
        $criteria->compare('t.id_rku', $this->id_rku);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('id_jenis_lahan', $this->id_jenis_lahan);
        $criteria->compare('tahun', $this->tahun);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->order = 'tahun ASC, id_jenis_lahan ASC';

        //jumlah_not_null
        if($this->jumlah_not_null) {
			$criteria->condition=' (TRIM(jumlah) != "" AND jumlah != 0) AND t.id_rku = "'.$this->id_rku.'" ';
		}

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=> false
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RkuPenyiapanLahan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        return round($total, 2);
    }

}
