<?php

/**
 * This is the model class for table "iuphhk_topografi".
 *
 * The followings are the available columns in table 'iuphhk_topografi':
 * @property integer $id_topografi
 * @property integer $id_iuphhk
 * @property double $datar
 * @property double $landai
 * @property double $agak_curam
 * @property double $curam
 * @property double $sangat_curam
 * @property double $ketinggian
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Iuphhk $idIuphhk
 */
class Topografi extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'iuphhk_topografi';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('datar, landai, agak_curam, curam, sangat_curam, ketinggian', 'required'),
            array('id_iuphhk', 'numerical', 'integerOnly' => true),
            array('datar, landai, agak_curam, curam, sangat_curam, ketinggian', 'numerical'),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_topografi, id_iuphhk, datar, landai, agak_curam, curam, sangat_curam, ketinggian, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'id_topografi' => 'Id Topografi',
            'id_iuphhk' => 'Id Iuphhk',
            'datar' => 'Datar',
            'landai' => 'Landai',
            'agak_curam' => 'Agak Curam',
            'curam' => 'Curam',
            'sangat_curam' => 'Sangat Curam',
            'ketinggian' => 'Ketinggian',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
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

        $criteria->compare('id_topografi', $this->id_topografi);
        $criteria->compare('id_iuphhk', $this->id_iuphhk);
        $criteria->compare('datar', $this->datar);
        $criteria->compare('landai', $this->landai);
        $criteria->compare('agak_curam', $this->agak_curam);
        $criteria->compare('curam', $this->curam);
        $criteria->compare('sangat_curam', $this->sangat_curam);
        $criteria->compare('ketinggian', $this->ketinggian);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Topografi the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
