<?php

/**
 * This is the model class for table "adendum_sk".
 *
 * The followings are the available columns in table 'adendum_sk':
 * @property integer $id_adendum
 * @property integer $id_iuphhk
 * @property string $nomor_adendum
 * @property string $tanggal
 * @property double $luas
 *
 * The followings are the available model relations:
 * @property Iuphhk $idIuphhk
 */
class AdendumSk extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'adendum_sk';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_iuphhk, nomor_adendum, tanggal, luas', 'required'),
            array('id_iuphhk', 'numerical', 'integerOnly' => true),
            array('luas', 'numerical'),
            array('nomor_adendum', 'length', 'max' => 50),
            array('tanggal', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_adendum, id_iuphhk, nomor_adendum, tanggal, luas', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idIuphhk' => array(self::BELONGS_TO, 'Iuphhk', 'id_iuphhk'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_adendum' => 'Id Adendum',
            'id_iuphhk' => 'Id Iuphhk',
            'nomor_adendum' => 'Nomor Adendum',
            'tanggal' => 'Tanggal',
            'luas' => 'Luas',
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

        $criteria->compare('id_adendum', $this->id_adendum);
        $criteria->compare('id_iuphhk', $this->id_iuphhk);
        $criteria->compare('nomor_adendum', $this->nomor_adendum, true);
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('luas', $this->luas);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AdendumSk the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
