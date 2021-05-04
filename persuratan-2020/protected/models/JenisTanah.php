<?php

/**
 * This is the model class for table "iuphhk_jenis_tanah".
 *
 * The followings are the available columns in table 'iuphhk_jenis_tanah':
 * @property string $id_tanah
 * @property integer $id_iuphkk
 * @property string $nama
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property Iuphhk $idIuphkk
 */
class JenisTanah extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'iuphhk_jenis_tanah';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nama', 'required'),
            array('id_iuphhk', 'numerical', 'integerOnly' => true),
            array('nama', 'length', 'max' => 100),
            array('keterangan', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_tanah, id_iuphhk, nama, keterangan', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idIuphhkTanah' => array(self::BELONGS_TO, 'Iuphhk', 'id_iuphhk'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_tanah' => 'Id Tanah',
            'id_iuphhk' => 'Id Iuphhk',
            'nama' => 'Jenis Tanah',
            'keterangan' => 'Keterangan',
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

        $criteria->compare('id_tanah', $this->id_tanah, true);
        $criteria->compare('id_iuphhk', $this->id_iuphhk);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('keterangan', $this->keterangan, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JenisTanah the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
