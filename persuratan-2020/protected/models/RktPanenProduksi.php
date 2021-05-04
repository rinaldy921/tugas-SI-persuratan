<?php

/**
 * This is the model class for table "rkt_panen_produksi".
 *
 * The followings are the available columns in table 'rkt_panen_produksi':
 * @property integer $id
 * @property integer $daur
 * @property integer $id_rkt
 * @property integer $id_blok
 * @property integer $id_jenis_produksi_lahan
 * @property integer $id_jenis_lahan
 * @property integer $jumlah_luas
 * @property integer $realisasi_luas
 * @property double $persentase_luas
 * @property integer $jumlah_produksi
 * @property integer $realisasi_produksi
 * @property double $persentase_produksi
 * @property integer $id_rku_panen
 * @property integer $id_rkt_form_alasan
 *
 * The followings are the available model relations:
 * @property BlokSektor $idBlok
 * @property MasterJenisLahan $idJenisLahan
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property Rkt $idRkt
 * @property RktFormAlasan $idRktFormAlasan
 * @property RkuPanen $idRkuPanen
 */
class RktPanenProduksi extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
       
    public $_tahun;
    public $_tata_ruang;
    public $_jenis_lahan;
    public $_sektor;
    public $_blok;
    public $namaKabupaten;
    public $rkt_ke_new;

    
    public function tableName() {
        return 'rkt_panen_produksi';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rkt, id_jenis_produksi_lahan, id_jenis_lahan', 'required'),
            array('_tahun, _tata_ruang, _jenis_lahan, _blok, _sektor, namaKabupaten, rkt_ke_new', 'safe'),
            array('daur, id_rkt, id_blok, id_jenis_produksi_lahan,rkt_ke, id_jenis_lahan, realisasi_luas, realisasi_produksi, id_rku_panen, id_rkt_form_alasan, id_kabupaten', 'numerical', 'integerOnly' => true),
            array(' jumlah_luas, jumlah_produksi, persentase_luas, persentase_produksi', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, daur, id_rkt, id_blok, id_jenis_produksi_lahan, id_jenis_lahan, jumlah_luas, realisasi_luas, persentase_luas, jumlah_produksi, realisasi_produksi, persentase_produksi, id_rku_panen, id_rkt_form_alasan', 'safe', 'on' => 'search'),
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
            'idJenisLahan' => array(self::BELONGS_TO, 'MasterJenisLahan', 'id_jenis_lahan'),
            'idJenisProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
            'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
            'idRktFormAlasan' => array(self::BELONGS_TO, 'RktFormAlasan', 'id_rkt_form_alasan'),
            'idRkuPanen' => array(self::BELONGS_TO, 'RkuPanen', 'id_rku_panen'),
            'idKabupaten' => array(self::BELONGS_TO, 'Kabupaten', 'id_kabupaten'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'daur' => Yii::t('app', 'Daur'),
            'id_rkt' => Yii::t('app', 'RKT'),
            'id_blok' => Yii::t('app', 'Lokasi Sektor / Blok'),
            'id_jenis_produksi_lahan' => Yii::t('app', 'Tata Ruang'),
            'id_jenis_lahan' => Yii::t('app', 'Jenis Lahan'),
            'jumlah_luas' => Yii::t('app', 'Luas (Ha)'),
            'realisasi_luas' => Yii::t('app', 'Realisasi Luas'),
            'persentase_luas' => Yii::t('app', 'Persentase Luas'),
            'jumlah_produksi' => Yii::t('app', 'Produksi (M3)'),
            'realisasi_produksi' => Yii::t('app', 'Realisasi Produksi'),
            'persentase_produksi' => Yii::t('app', 'Persentase Produksi'),
            'id_rku_panen' => Yii::t('app', 'Id Rku Panen'),
            'id_rkt_form_alasan' => Yii::t('app', 'Id Rkt Form Alasan'),
            '_tahun' => Yii::t('app', 'Tahun'),
            '_tata_ruang' => Yii::t('app', 'Tata Ruang'),
            '_jenis_lahan' => Yii::t('app', 'Jenis Lahan'),
            '_sektor' => Yii::t('app', 'Unit Kelestarian'),
            '_blok' => Yii::t('app', 'Petak Kerja'),           
            'rkt_ke' => Yii::t('app', 'Blok Kerja Tahun Ke'),
            'id_kabupaten' => Yii::t('app', 'Kabupaten'),  
            'namaKabupaten' => Yii::t('app', 'Kabupaten'),
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
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('id_jenis_lahan', $this->id_jenis_lahan);
        $criteria->compare('jumlah_luas', $this->jumlah_luas);
        $criteria->compare('realisasi_luas', $this->realisasi_luas);
        $criteria->compare('persentase_luas', $this->persentase_luas);
        $criteria->compare('jumlah_produksi', $this->jumlah_produksi);
        $criteria->compare('realisasi_produksi', $this->realisasi_produksi);
        $criteria->compare('persentase_produksi', $this->persentase_produksi);
        $criteria->compare('id_rku_panen', $this->id_rku_panen);
        $criteria->compare('id_kabupaten',$this->id_kabupaten);
        $criteria->compare('id_rkt_form_alasan', $this->id_rkt_form_alasan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function findRkuDismatch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "id_rku_panen IS NULL";

        $criteria->compare('id', $this->id);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('id_jenis_lahan', $this->id_jenis_lahan);
        $criteria->compare('jumlah_luas', $this->jumlah_luas);
        $criteria->compare('realisasi_luas', $this->realisasi_luas);
        $criteria->compare('persentase_luas', $this->persentase_luas);
        $criteria->compare('jumlah_produksi', $this->jumlah_produksi);
        $criteria->compare('realisasi_produksi', $this->realisasi_produksi);
        $criteria->compare('persentase_produksi', $this->persentase_produksi);
        $criteria->compare('id_rku_panen', $this->id_rku_panen);
        $criteria->compare('id_kabupaten',$this->id_kabupaten);
        $criteria->compare('id_rkt_form_alasan', $this->id_rkt_form_alasan);
        //$criteria->compare('jumlah', $this->jumlah);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function findRkuMatch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "id_rku_panen != ''";

        $criteria->compare('id', $this->id);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('id_jenis_lahan', $this->id_jenis_lahan);
        $criteria->compare('jumlah_luas', $this->jumlah_luas);
        $criteria->compare('realisasi_luas', $this->realisasi_luas);
        $criteria->compare('persentase_luas', $this->persentase_luas);
        $criteria->compare('jumlah_produksi', $this->jumlah_produksi);
        $criteria->compare('realisasi_produksi', $this->realisasi_produksi);
        $criteria->compare('persentase_produksi', $this->persentase_produksi);
        $criteria->compare('id_rku_panen', $this->id_rku_panen);
        $criteria->compare('id_kabupaten',$this->id_kabupaten);
        $criteria->compare('id_rkt_form_alasan', $this->id_rkt_form_alasan);
        //$criteria->compare('jumlah', $this->jumlah);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RktPanenProduksi the static model class
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