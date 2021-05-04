<?php

/**
 * This is the model class for table "rku_panen".
 *
 * The followings are the available columns in table 'rku_panen':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_blok
 * @property integer $tahun
 * @property integer $jumlah
 * @property integer $daur
 * @property integer $produksi
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property BlokSektor $idBlok
 * @property Rku $idRku
 */
class RkuPanen extends CActiveRecord {
    public $tahun_ke;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rku_panen';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rku', 'required'),
            array('id_rku, id_blok,id_kabupaten, daur,rkt_ke', 'numerical', 'integerOnly' => true),
            array('jumlah, produksi', 'numerical'),
            array('keterangan', 'length', 'max' => 100),
            array('tahun', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_rku, id_blok, tahun, jumlah, daur, produksi, keterangan', 'safe', 'on' => 'search'),
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
            'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
            'namaKabupaten' => array(self::BELONGS_TO, 'Kabupaten', 'id_kabupaten'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'id_rku' => Yii::t('app', 'Id Rku'),
            'id_blok' => Yii::t('app', 'Unit Kelestarian/Petak Kerja'),
            'tahun' => Yii::t('app', 'Tahun'),
            'jumlah' => Yii::t('app', 'Jumlah (Ha)'),
            'daur' => Yii::t('app', 'Daur'),
            'produksi' => Yii::t('app', 'Produksi (M3)'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'id_kabupaten'=>Yii::t('app','Kabupaten'),            
            'rkt_ke' => Yii::t('app', 'Blok Kerja Tahun Ke'),
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
        $criteria->order = "daur, tahun, id_blok";
        $criteria->compare('id', $this->id);
        $criteria->compare('id_rku', $this->id_rku);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('tahun', $this->tahun);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('produksi', $this->produksi);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('id_kabupaten',$this->id_kabupaten);
        $criteria->compare('rkt_ke',$this->rkt_ke);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchByRkt() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->order = "daur, tahun, id_blok";
        $criteria->compare('id', $this->id);
        $criteria->compare('id_rku', $this->id_rku);
        $criteria->compare('id_blok', $this->id_blok);
        $criteria->compare('tahun', $this->tahun);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->compare('daur', $this->daur);
        $criteria->compare('produksi', $this->produksi);
        $criteria->compare('keterangan', $this->keterangan, true);
        $criteria->compare('id_kabupaten',$this->id_kabupaten);
        $criteria->compare('rkt_ke',$this->rkt_ke);

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

    
     public function getKabupatenName($kabuaptenId)
    {
        $stat = Kabupaten::find()->where(["id_kabupaten"=>$kabuaptenId])->asArray()->one();
        if (is_array($stat)) {
                return $stat["nama"];
        } else {
                return "";
        }
    }
    
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RkuPanen the static model class
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
