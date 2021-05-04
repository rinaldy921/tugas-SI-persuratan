<?php

/**
 * This is the model class for table "rkt_pasar".
 *
 * The followings are the available columns in table 'rkt_pasar':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $id_pemasaran
 * @property integer $jumlah
 * @property double $realisasi
 * @property double $persentase
 * @property integer $daur
 *
 * The followings are the available model relations:
 * @property RealisasiRktPasar[] $realisasiRktPasars
 * @property MasterJenisPemasaran $idPemasaran
 * @property Rkt $idRkt
 */
class RktPasar extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $_tahun;    
    public $_jenis_pemasaran;
    
    public function tableName() {
        return 'rkt_pasar';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rkt, id_pemasaran', 'required'),
            array('_tahun, _jenis_pemasaran', 'safe'),
            array('id_rkt, id_pemasaran, daur, rkt_ke', 'numerical', 'integerOnly' => true),
            array('jumlah, realisasi, persentase', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_rkt, id_pemasaran, jumlah, realisasi, persentase, daur, rkt_ke', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'realisasiRktPasars' => array(self::HAS_MANY, 'RealisasiRktPasar', 'id_rkt_pasar'),
            'idPemasaran' => array(self::BELONGS_TO, 'MasterJenisPemasaran', 'id_pemasaran'),
            'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'id_rkt' => Yii::t('app', 'Id Rkt'),
            'id_pemasaran' => Yii::t('app', 'Jenis Pemasaran'),
            'jumlah' => Yii::t('app', 'Jumlah'),
            'realisasi' => Yii::t('app', 'Realisasi'),
            'persentase' => Yii::t('app', 'Persentase'),
            'daur' => Yii::t('app', 'Daur'),
            '_tahun' => Yii::t('app', 'Tahun'),
            '_jenis_pemasaran' => Yii::t('app', 'Jenis Pemasaran'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('id_pemasaran', $this->id_pemasaran);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('realisasi', $this->realisasi);
        $criteria->compare('persentase', $this->persentase);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('rkt_ke', $this->rkt_ke);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RktPasar the static model class
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
