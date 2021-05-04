<?php

/**
 * This is the model class for table "rku_areal_kerja".
 *
 * The followings are the available columns in table 'rku_areal_kerja':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $daur
 * @property string $tahun
 * @property integer $id_jenis_produksi_lahan
 * @property double $jumlah
 * @property integer $id_blok
 *
 * The followings are the available model relations:
 * @property BlokSektor $idBlok
 * @property MasterJenisProduksiLahan $idJenisProduksiLahan
 * @property Rku $idRku
 */
class RkuArealKerja extends CActiveRecord {

    public $tahun_ke;
    public $blok;
    public $sektor;
    /**
     * @return string the associated database table name
     */
    
    public function tableName() {
        return 'rku_areal_kerja';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rku, daur, tahun, id_jenis_produksi_lahan, jumlah', 'required'),
            array('id_rku, daur, id_jenis_produksi_lahan, id_blok, rkt_ke', 'numerical', 'integerOnly' => true),
            array('jumlah', 'numerical'),
            array('tahun', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_rku, daur, tahun, id_jenis_produksi_lahan, jumlah, id_blok', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'idBlok' => array(self::BELONGS_TO, 'BlokSektor', 'id_blok'),
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
            'id_rku' => Yii::t('app', 'Id Rku'),
            'daur' => Yii::t('app', 'Daur'),
            'tahun' => Yii::t('app', 'Tahun'),
            'id_jenis_produksi_lahan' => Yii::t('app', 'Tata Ruang'),
            'jumlah' => Yii::t('app', 'Luas'),
            'id_blok' => Yii::t('app', 'Unit Kelestarian / Petak Kerja'),
            'blok' => 'Nama Petak Kerja',
            'sektor' => 'Nama Unit Kelestarian',
            'rkt_ke' => 'Blok Kerja Tahun Ke',
            'tahun_ke' => 'Blok Kerja Tahun Ke',
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
        $criteria->compare('id_rku', $this->id_rku);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('tahun', $this->tahun, true);
        $criteria->compare('id_jenis_produksi_lahan', $this->id_jenis_produksi_lahan);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('rkt_ke', $this->rkt_ke);
 
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchByRkuRkt($idRku, $rktKe){
        
        $offset = ($limit * ($start-1))+ $start;
        
        
            $query = "SELECT r.id,r.daur,r.tahun,r.jumlah,r.rkt_ke,
                        IFNULL((SELECT b.nama_blok FROM rku_blok b WHERE b.id=r.id_blok),'')AS blok,
                        IFNULL((SELECT s.nama_sektor FROM rku_sektor s WHERE s.id_sektor IN (SELECT b.id_sektor FROM rku_blok b WHERE b.id=r.id_blok)),'')AS sektor,
                        IFNULL((SELECT m.jenis_produksi FROM master_jenis_produksi_lahan m WHERE m.id = r.id_jenis_produksi_lahan),'')AS jenis
                         FROM rku_areal_kerja r WHERE r.id_rku=".$idRku." AND rkt_ke=".$rktKe;
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
        
            $dataProvider=new CArrayDataProvider($result, array(
                'id'=>'rku_areal_kerja', //this is an identifier for the array data provider
                'sort'=>false,
                'keyField'=>'id', //this is what will be considered your key field
                'pagination'=>array(
                    'pageSize'=>100, //eureka! you can configure your pagination from here
                ),
            ));
            
            
            return $dataProvider;
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
     * @return RkuArealKerja the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
