<?php

/**
 * This is the model class for table "rkt_pelihara".
 *
 * The followings are the available columns in table 'rkt_pelihara':
 * @property integer $id
 * @property integer $daur
 * @property integer $id_rkt
 * @property integer $id_jenis_pemeliharaan
 * @property integer $id_blok
 * @property integer $id_jenis_produksi_lahan
 * @property integer $id_jenis_lahan
 * @property double $jumlah
 * @property double $realisasi
 * @property double $persentase
 * @property integer $id_rku_pelihara
 * @property integer $id_rkt_form_alasan
 *
 * The followings are the available model relations:
 * @property BlokSektor $idBlok
 * @property MasterJenisLahan $idJenisLahan
 * @property MasterJenisPemeliharaan $idJenisPemeliharaan
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property Rkt $idRkt
 * @property RktFormAlasan $idRktFormAlasan
 * @property RkuPelihara $idRkuPelihara
 */
class RktPelihara extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $_tahun;
    public $_tata_ruang;
    public $_jenis_lahan;
    public $_jenis_pemeliharaan;
    public $_sektor;
    public $_blok;
    public $rkt_ke_new;

    public function tableName() {
        return 'rkt_pelihara';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rkt, id_jenis_pemeliharaan, id_jenis_produksi_lahan, id_jenis_lahan', 'required'),
            array('_tahun, _tata_ruang, _jenis_lahan, _blok, _sektor, _jenis_pemeliharaan, rkt_ke_new', 'safe'),
            array('daur, id_rkt, id_rkt_new, id_jenis_pemeliharaan, id_blok ,id_jenis_produksi_lahan, id_jenis_lahan, id_rku_pelihara, id_rkt_form_alasan, rkt_ke', 'numerical', 'integerOnly' => true),
            array('jumlah, realisasi, persentase', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, daur, id_rkt, id_jenis_pemeliharaan, id_blok, id_jenis_produksi_lahan, id_jenis_lahan, jumlah, realisasi, persentase, id_rku_pelihara, id_rkt_form_alasan', 'safe', 'on' => 'search'),
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
            'idJenisPemeliharaan' => array(self::BELONGS_TO, 'MasterJenisPemeliharaan', 'id_jenis_pemeliharaan'),
            'idJenisProduksiLahan' => array(self::BELONGS_TO, 'MasterJenisProduksiLahan', 'id_jenis_produksi_lahan'),
            'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
            'idRktNew' => array(self::BELONGS_TO, 'Rkt', 'id_rkt_new'),
            'idRktFormAlasan' => array(self::BELONGS_TO, 'RktFormAlasan', 'id_rkt_form_alasan'),
            'idRkuPelihara' => array(self::BELONGS_TO, 'RkuPelihara', 'id_rku_pelihara'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'daur' => Yii::t('app', 'Daur'),
            'id_rkt' => Yii::t('app', 'Id Rkt'),
            'id_rkt_new' => Yii::t('app', 'Id Rkt New'),
            'id_jenis_pemeliharaan' => Yii::t('app', 'Jenis Pemeliharaan'),
            'id_blok' => Yii::t('app', 'Blok'),
            'id_jenis_produksi_lahan' => Yii::t('app', 'Tata Ruang'),
            'id_jenis_lahan' => Yii::t('app', 'Jenis Lahan'),
            'jumlah' => Yii::t('app', 'Jumlah'),
            'realisasi' => Yii::t('app', 'Realisasi'),
            'persentase' => Yii::t('app', 'Persentase'),
            'id_rku_pelihara' => Yii::t('app', 'Id Rku Pelihara'),
            'id_rkt_form_alasan' => Yii::t('app', 'Id Rkt Form Alasan'),
            '_tahun' => Yii::t('app', 'Tahun'),
            '_tata_ruang' => Yii::t('app', 'Tata Ruang'),
            '_jenis_lahan' => Yii::t('app', 'Jenis Lahan'),
            '_sektor' => Yii::t('app', 'Unit Kelestarian'),
            '_blok' => Yii::t('app', 'Petak Kerja'),
            '_jenis_pemeliharaan' => Yii::t('app', 'Jenis Pemeliharaan'),
            'rkt_ke' => Yii::t('app', 'Blok Kerja Tahun Ke')  
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
        $criteria->order = 'daur, id_rkt, id_blok, id_jenis_pemeliharaan,id_jenis_produksi_lahan, id_jenis_lahan';
        
        $criteria->compare('id', $this->id);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_jenis_pemeliharaan', $this->id_jenis_pemeliharaan);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('id_jenis_lahan', $this->id_jenis_lahan);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('realisasi', $this->realisasi);
        $criteria->compare('persentase', $this->persentase);
        $criteria->compare('id_rku_pelihara', $this->id_rku_pelihara);
        $criteria->compare('id_rkt_form_alasan', $this->id_rkt_form_alasan);
        $criteria->compare('rkt_ke', $this->rkt_ke);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function findRkuDismatch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = 'id_jenis_pemeliharaan, daur, id_blok, id_jenis_produksi_lahan, id_jenis_lahan';
        
        $criteria->condition = "id_rku_pelihara IS NULL";
                
        $criteria->compare('id', $this->id);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_jenis_pemeliharaan', $this->id_jenis_pemeliharaan);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('id_jenis_lahan', $this->id_jenis_lahan);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('realisasi', $this->realisasi);
        $criteria->compare('persentase', $this->persentase);
//        $criteria->compare('id_rku_pelihara', $this->id_rku_pelihara);
        $criteria->compare('id_rkt_form_alasan', $this->id_rkt_form_alasan);
//        $criteria->compare('rkt_ke', $this->rkt_ke);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function findRkuMatch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = 'id_jenis_pemeliharaan, daur, id_blok, id_jenis_produksi_lahan, id_jenis_lahan';
        
        $criteria->condition = "id_rku_pelihara != ''";
                
        $criteria->compare('id', $this->id);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_jenis_pemeliharaan', $this->id_jenis_pemeliharaan);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('id_jenis_lahan', $this->id_jenis_lahan);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('realisasi', $this->realisasi);
        $criteria->compare('persentase', $this->persentase);
        $criteria->compare('id_rku_pelihara', $this->id_rku_pelihara);
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
     * @return RktPelihara the static model class
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
