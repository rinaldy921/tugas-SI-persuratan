<?php

/**
 * This is the model class for table "rkt_areal_kerja".
 *
 * The followings are the available columns in table 'rkt_areal_kerja':
 * @property integer $id
 * @property integer $id_blok
 * @property integer $id_rkt
 * @property integer $id_jenis_produksi_lahan
 * @property double $jumlah
 * @property double $realisasi
 * @property double $persentase
 * @property integer $daur
 * @property integer $id_rku_areal_kerja
 * @property integer $id_rkt_form_alasan
 */
class RktArealKerja extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $_tahun;
    public $_tata_ruang;
    public $_sektor;
    public $_blok;
    public $rkt_ke_new;

    public function tableName() {
        return 'rkt_areal_kerja';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_blok, id_rkt, id_jenis_produksi_lahan', 'required'),
            array('_tahun, _tata_ruang, _blok, _sektor, rkt_ke_new', 'safe'),
            array('id_blok, id_rkt, id_rkt_new, id_jenis_produksi_lahan, daur, id_rku_areal_kerja, id_rkt_form_alasan, rkt_ke', 'numerical', 'integerOnly' => true),
            array('jumlah, realisasi, persentase', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_blok, id_rkt, id_jenis_produksi_lahan, jumlah, realisasi, persentase, daur, id_rku_areal_kerja, id_rkt_form_alasan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idBlok' => array(self::BELONGS_TO, 'RkuBlok', 'id_blok'),
            'idJenisProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
            'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
            'idRkuArealKerja' => array(self::BELONGS_TO, 'RkuArealKerja', 'id_rku_areal_kerja'),
            'idRktFormAlasan' => array(self::BELONGS_TO, 'RktFormAlasan', 'id_rkt_form_alasan'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'id_blok' => Yii::t('app', 'Lokasi Sektor / Blok'),
            'id_rkt' => Yii::t('app', 'Id Rkt'),
             'id_rkt_new' => Yii::t('app', 'Id Rkt New'),
            'id_jenis_produksi_lahan' => Yii::t('app', 'Tata Ruang'),
            'jumlah' => Yii::t('app', 'Luas (Ha)'),
            'realisasi' => Yii::t('app', 'Realisasi'),
            'persentase' => Yii::t('app', 'Persentase'),
            'daur' => Yii::t('app', 'Daur'),
            'id_rku_areal_kerja' => Yii::t('app', 'Id Rku Areal Kerja'),
            'id_rkt_form_alasan' => Yii::t('app', 'Id Rkt Form Alasan'),
            '_tahun' => Yii::t('app', 'Tahun'),
            '_tata_ruang' => Yii::t('app', 'Tata Ruang'),
            '_sektor' => Yii::t('app', 'Sektor'),
            '_blok' => Yii::t('app', 'Blok'),
            'rkt_ke' => Yii::t('app', 'Blok RKT Tahun Ke')
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

        $criteria->compare('id', $this->id);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('realisasi', $this->realisasi);
        $criteria->compare('persentase', $this->persentase);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rku_areal_kerja', $this->id_rku_areal_kerja);
        $criteria->compare('id_rkt_form_alasan', $this->id_rkt_form_alasan);
        $criteria->compare('rkt_ke', $this->rkt_ke);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function findRkuDismatch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "id_rku_areal_kerja IS NULL";

        $criteria->compare('id', $this->id);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('realisasi', $this->realisasi);
        $criteria->compare('persentase', $this->persentase);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rku_areal_kerja', $this->id_rku_areal_kerja);
        $criteria->compare('id_rkt_form_alasan', $this->id_rkt_form_alasan);
        //$criteria->compare('rkt_ke', $this->rkt_ke);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function findRkuMatch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "id_rku_areal_kerja != ''";

        $criteria->compare('id', $this->id);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('realisasi', $this->realisasi);
        $criteria->compare('persentase', $this->persentase);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rku_areal_kerja', $this->id_rku_areal_kerja);
        $criteria->compare('id_rkt_form_alasan', $this->id_rkt_form_alasan);
        $criteria->compare('rkt_ke', $this->rkt_ke);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RktArealKerja the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total += $rec->{$colName};
        return number_format($total, 2, ',', '.');
    }

    public function getTotalPersen($records, $colName) {
        $totalJumlah = 0;
        $totalRealisasi = 0;
        foreach ($records as $rec) {
            $totalJumlah += $rec->jumlah;
            $totalRealisasi += $rec->realisasi;
        }

        $subTotal = $totalRealisasi > 0 ? ($totalRealisasi / $totalJumlah) * 100 : 0;
        return number_format($subTotal, 2, ',', '.');
    }

}
