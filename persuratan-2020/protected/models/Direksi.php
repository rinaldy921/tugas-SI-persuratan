<?php

/**
 * This is the model class for table "direksi".
 *
 * The followings are the available columns in table 'direksi':
 * @property integer $id_direksi
 * @property integer $perusahaan_id
 * @property string $nama_direksi
 * @property string $jabatan
 */
class Direksi extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'direksi';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('perusahaan_id, nama_direksi, jabatan', 'required'),
            array('perusahaan_id', 'numerical', 'integerOnly' => true),
            array('nama_direksi, jabatan', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_direksi, perusahaan_id, nama_direksi, jabatan, id_legalitas', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_direksi' => 'Id Direksi',
            'perusahaan_id' => 'Perusahaan',
            'nama_direksi' => 'Nama Direksi',
            'jabatan' => 'Jabatan',
            'id_legalitas' => "id_legalitas"
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

        $criteria->compare('id_direksi', $this->id_direksi);
        $criteria->compare('perusahaan_id', $this->perusahaan_id);
        $criteria->compare('nama_direksi', $this->nama_direksi, true);
        $criteria->compare('jabatan', $this->jabatan, true);
        $criteria->compare('id_legalitas', $this->id_legalitas, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Direksi the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getByPerusahaanId($perusahaanId)
    {
            $query = "SELECT DISTINCT nama_direksi, jabatan FROM direksi WHERE perusahaan_id=".$perusahaanId." ORDER BY jabatan DESC;";
        
            $result=Yii::app()->db->createCommand($query)->queryAll();
         
          
            return $result;
    }
    
}
