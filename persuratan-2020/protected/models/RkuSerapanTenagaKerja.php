<?php

/**
 * This is the model class for table "rku_serapan_tenaga_kerja".
 *
 * The followings are the available columns in table 'rku_serapan_tenaga_kerja':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $tahun
 * @property string $is_tenaga_kehutanan
 * @property string $is_tenaga_tetap
 * @property integer $id_pendidikan
 * @property integer $id_jenis_kewarganegaraan
 * @property integer $jumlah
 *
 * The followings are the available model relations:
 * @property MasterJenisKewarganegaraan $idJenisKewarganegaraan
 * @property MasterPendidikan $idPendidikan
 * @property Rku $idRku
 */
class RkuSerapanTenagaKerja extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rku_serapan_tenaga_kerja';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // array('id_rku, tahun', 'required'),
            array('id_rku', 'required'),
            array('id_rku, tahun, id_pendidikan, id_jenis_kewarganegaraan, jumlah', 'numerical', 'integerOnly' => true),
            array('is_tenaga_kehutanan, is_tenaga_tetap', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_rku, tahun, is_tenaga_kehutanan, is_tenaga_tetap, id_pendidikan, id_jenis_kewarganegaraan, jumlah', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idJenisKewarganegaraan' => array(self::BELONGS_TO, 'MasterJenisKewarganegaraan', 'id_jenis_kewarganegaraan'),
            'idPendidikan' => array(self::BELONGS_TO, 'MasterPendidikan', 'id_pendidikan'),
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
            'tahun' => Yii::t('app', 'Tahun'),
            'is_tenaga_kehutanan' => Yii::t('app', 'Jenis Tenaga Profesional'),
            'is_tenaga_tetap' => Yii::t('app', 'Jenis Kontrak Kerja'),
            'id_pendidikan' => Yii::t('app', 'Pendidikan'),
            'id_jenis_kewarganegaraan' => Yii::t('app', 'Jenis Kewarganegaraan'),
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
        $criteria->order = "tahun, is_tenaga_kehutanan, is_tenaga_tetap";
        $criteria->compare('id', $this->id);
        $criteria->compare('id_rku', $this->id_rku);
        $criteria->compare('tahun', $this->tahun);
        $criteria->compare('is_tenaga_kehutanan', $this->is_tenaga_kehutanan, true);
        $criteria->compare('is_tenaga_tetap', $this->is_tenaga_tetap, true);
        $criteria->compare('id_pendidikan', $this->id_pendidikan);
        $criteria->compare('id_jenis_kewarganegaraan', $this->id_jenis_kewarganegaraan);
        $criteria->compare('jumlah', $this->jumlah);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
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
     * @return RkuSerapanTenagaKerja the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
