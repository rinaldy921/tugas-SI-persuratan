<?php

/**
 * This is the model class for table "rku_bibit".
 *
 * The followings are the available columns in table 'rku_bibit':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $daur
 * @property integer $tahun
 * @property integer $id_blok
 * @property integer $id_jenis_produksi_lahan
 * @property integer $id_jenis_lahan
 * @property integer $jumlah
 *
 * The followings are the available model relations:
 * @property BlokSektor $idBlok
 * @property MasterJenisLahan $idJenisLahan
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property Rku $idRku
 */
class RkuBibit extends CActiveRecord {
      public $tahun_ke;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rku_bibit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rku, tahun, id_blok, id_jenis_produksi_lahan', 'required'),
            array('id_rku, daur, id_blok, id_jenis_produksi_lahan, jumlah, rkt_ke', 'numerical', 'integerOnly' => true),
            array('tahun', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_rku, daur, tahun, id_blok, id_jenis_produksi_lahan, jumlah', 'safe', 'on' => 'search'),
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
            'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'id_rku' => Yii::t('app', 'RKU'),
            'daur' => Yii::t('app', 'Daur'),
            'tahun' => Yii::t('app', 'Tahun'),
            'id_blok' => Yii::t('app', 'Unit Kelestarian/Petak Kerja'),
            'id_jenis_produksi_lahan' => Yii::t('app', 'Tata Ruang'),            
            'jumlah' => Yii::t('app', 'Jumlah (Batang)'),
            'rkt_ke' => Yii::t('app', 'RKT Ke'),
            'tahun_ke' => Yii::t('app', 'Blok Kerja Tahun Ke'),
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
        $criteria->order = "daur, tahun, id_blok, id_jenis_produksi_lahan";
        
        $criteria->compare('id', $this->id);
        $criteria->compare('id_rku', $this->id_rku);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('tahun', $this->tahun);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('rkt_ke', $this->rkt_ke);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        
        $criteria->compare('jumlah', $this->jumlah);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchByRkt() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = "daur, tahun, id_blok, id_jenis_produksi_lahan";
        
        $criteria->compare('id', $this->id);
        $criteria->compare('id_rku', $this->id_rku);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('tahun', $this->tahun);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('rkt_ke', $this->rkt_ke);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        
        $criteria->compare('jumlah', $this->jumlah);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                //'currentPage' => Yii::app()->user->getState('Registrasi_page', 0),
                'pageSize'=>100,
            ),
//                    'sort'=>array(
//                        'defaultOrder'=>'create_at DESC',
//                    ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RkuBibit the static model class
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
