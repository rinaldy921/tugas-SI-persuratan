<?php

/**
 * This is the model class for table "rku_bibit_new".
 *
 * The followings are the available columns in table 'rku_bibit_new':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_tanaman_silvikultur
 * @property string $tahun
 * @property integer $jumlah
 *
 * The followings are the available model relations:
 * @property Rku $idRku
 * @property RkuTanamanSilvikultur $idTanamanSilvikultur
 */
class RkuBibitNew extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rku_bibit_new';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_rku, id_tanaman_silvikultur, tahun', 'required'),
            array('id_rku, id_tanaman_silvikultur, jumlah', 'numerical', 'integerOnly' => true),
            array('tahun', 'length', 'max' => 4),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_rku, id_tanaman_silvikultur, tahun, jumlah', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
            'idTanamanSilvikultur' => array(self::BELONGS_TO, 'RkuTanamanSilvikultur', 'id_tanaman_silvikultur'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'id_rku' => Yii::t('app', 'Id Rku'),
            'id_tanaman_silvikultur' => Yii::t('app', 'Id Tanaman Silvikultur'),
            'tahun' => Yii::t('app', 'Tahun'),
            'jumlah' => Yii::t('app', 'Jumlah'),
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
        $criteria->with = 'idTanamanSilvikultur';

        $criteria->compare('id', $this->id);
        $criteria->compare('t.id_rku', $this->id_rku);
        $criteria->compare('id_tanaman_silvikultur', $this->id_tanaman_silvikultur);
        $criteria->compare('tahun', $this->tahun, true);
        $criteria->compare('jumlah', $this->jumlah);
        $criteria->order = 'tahun ASC, idTanamanSilvikultur.id_jenis_produksi_lahan ASC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RkuBibitNew the static model class
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