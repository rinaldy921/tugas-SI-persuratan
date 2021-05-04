<?php

/**
 * This is the model class for table "rku_kawasan_lindung".
 *
 * The followings are the available columns in table 'rku_kawasan_lindung':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_jenis_kawasan_lindung
 * @property double $jumlah
 *
 * The followings are the available model relations:
 * @property MasterJenisKawasanLindung $idJenisKawasanLindung
 * @property Rku $idRku
 */
class RkuKawasanLindung extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rku_kawasan_lindung';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rku, id_jenis_kawasan_lindung', 'required'),
            array('id_rku, id_jenis_kawasan_lindung', 'numerical', 'integerOnly' => true),
            array('jumlah', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_rku, id_jenis_kawasan_lindung, jumlah', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idJenisKawasanLindung' => array(self::BELONGS_TO, 'MasterJenisKawasanLindung', 'id_jenis_kawasan_lindung'),
            'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'id_rku' => 'Id Rku',
            'id_jenis_kawasan_lindung' => 'Jenis Kawasan Lindung',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('id_rku', $this->id_rku);
        $criteria->compare('id_jenis_kawasan_lindung', $this->id_jenis_kawasan_lindung);
        $criteria->compare('jumlah', $this->jumlah);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RkuKawasanLindung the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        return Yii::app()->numberFormatter->formatDecimal($total);
    }
    
    
     public function getTotalByRkuId($rkuId)
        {
                $query = "SELECT SUM(k.jumlah)as jumlah,
                            IFNULL((SELECT j.nama_jenis FROM master_jenis_kawasan_lindung j WHERE j.id=k.id_jenis_kawasan_lindung),'-')AS jenis,
                            IFNULL((SELECT SUM(jumlah) FROM rku_areal_produktif f WHERE f.id_rku = k.id_rku),0)AS efektif, 
                            IFNULL((SELECT SUM(jumlah) FROM rku_areal_non_produktif f WHERE f.id_rku = k.id_rku),0)AS nonefektif
                            FROM rku_kawasan_lindung k WHERE k.id_rku=".$rkuId.";";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }

}
