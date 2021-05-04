<?php

/**
 * This is the model class for table "kriteria".
 *
 * The followings are the available columns in table 'kriteria':
 * @property integer $id
 * @property integer $id_aspek
 * @property string $nama_kriteria
 * @property integer $bobot
 *
 * The followings are the available model relations:
 * @property Aspek $idAspek
 */
class Kriteria extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'kriteria';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_aspek, bobot', 'numerical', 'integerOnly' => true),
            array('nama_kriteria', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_aspek, nama_kriteria, bobot', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idAspek' => array(self::BELONGS_TO, 'Aspek', 'id_aspek'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'id_aspek' => 'Id Aspek',
            'nama_kriteria' => 'Nama Kriteria',
            'bobot' => 'Bobot',
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
//        $criteria->with = array('idAspek');

        $criteria->compare('id', $this->id);
        $criteria->compare('id_aspek', $this->id_aspek);
        $criteria->compare('nama_kriteria', $this->nama_kriteria, true);
        $criteria->compare('bobot', $this->bobot);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => false,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Kriteria the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
