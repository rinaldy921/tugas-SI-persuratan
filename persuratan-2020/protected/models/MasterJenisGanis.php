<?php

/**
 * This is the model class for table "master_jenis_ganis".
 *
 * The followings are the available columns in table 'master_jenis_ganis':
 * @property integer $id
 * @property string $nama_jenis
 * @property integer $val1
 * @property integer $val2
 * @property integer $val3
 * @property integer $val4
 * @property integer $val5
 *
 * The followings are the available model relations:
 * @property RktEvaluasiKeberhasilan[] $rktEvaluasiKeberhasilans
 * @property RktEvaluasiPantauOperasional[] $rktEvaluasiPantauOperasionals
 * @property RktGanis[] $rktGanises
 */
class MasterJenisGanis extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'master_jenis_ganis';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nama_jenis', 'required'),
            array('val1, val2, val3, val4, val5', 'numerical', 'integerOnly' => true),
            array('nama_jenis', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nama_jenis, val1, val2, val3, val4, val5', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rktEvaluasiKeberhasilans' => array(self::HAS_MANY, 'RktEvaluasiKeberhasilan', 'id_ganis'),
            'rktEvaluasiPantauOperasionals' => array(self::HAS_MANY, 'RktEvaluasiPantauOperasional', 'id_ganis'),
            'rktGanises' => array(self::HAS_MANY, 'RktGanis', 'id_ganis'),
            'rkuGanises' => array(self::HAS_MANY, 'RkuGanis', 'id_ganis'),
            'iuphhkTenagaKerjas' => array(self::HAS_MANY, 'IuphhkTenagaKerja', 'id_jenis_tenaga_kerja'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'nama_jenis' => Yii::t('app', 'Nama Jenis'),
            'val1' => Yii::t('app', 'Val1'),
            'val2' => Yii::t('app', 'Val2'),
            'val3' => Yii::t('app', 'Val3'),
            'val4' => Yii::t('app', 'Val4'),
            'val5' => Yii::t('app', 'Val5'),
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
        $criteria->compare('nama_jenis', $this->nama_jenis, true);
        $criteria->compare('val1', $this->val1);
        $criteria->compare('val2', $this->val2);
        $criteria->compare('val3', $this->val3);
        $criteria->compare('val4', $this->val4);
        $criteria->compare('val5', $this->val5);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MasterJenisGanis the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
