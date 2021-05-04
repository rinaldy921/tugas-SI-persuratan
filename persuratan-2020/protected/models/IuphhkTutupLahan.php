<?php

/**
 * This is the model class for table "iuphhk_tutup_lahan".
 *
 * The followings are the available columns in table 'iuphhk_tutup_lahan':
 * @property integer $id
 * @property integer $id_iuphhk
 * @property integer $id_penutupan_lahan
 * @property double $hpt
 * @property double $hp
 * @property double $hpk
 * @property double $apl
 *
 * The followings are the available model relations:
 * @property Iuphhk $idIuphhk
 * @property MasterJenisTutupLahan $idPenutupanLahan
 */
class IuphhkTutupLahan extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'iuphhk_tutup_lahan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_iuphhk, id_penutupan_lahan', 'required'),
            array('id_iuphhk, id_penutupan_lahan', 'numerical', 'integerOnly' => true),
            array('hpt, hp, hpk, apl, hl, hsaw, ksa', 'numerical'),
			
			array('id_penutupan_lahan' , 'cekexist','on'=>'inputForm'),
			
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_iuphhk, id_penutupan_lahan, hpt, hp, hpk, apl, hl, hsaw, ksa', 'safe', 'on' => 'search'),
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
            'idPenutupanLahan' => array(self::BELONGS_TO, 'MasterJenisTutupLahan', 'id_penutupan_lahan'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'id_iuphhk' => Yii::t('app', 'Id Iuphhk'),
            'id_penutupan_lahan' => Yii::t('app', 'Penutupan Lahan'),
            'hpt' => Yii::t('app', 'HPT (ha)'),
            'hp' => Yii::t('app', 'HP (ha)'),
            'hpk' => Yii::t('app', 'HPK (ha)'),
            'apl' => Yii::t('app', 'APL (ha)'),
            'hl' => Yii::t('app', 'HL (ha)'),
            'hsaw' => Yii::t('app', 'HSAW (ha)'),
            'ksa' => Yii::t('app', 'KSA / KPA (ha)'),

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
        $criteria->compare('id_iuphhk', $this->id_iuphhk);
        $criteria->compare('id_penutupan_lahan', $this->id_penutupan_lahan);
        $criteria->compare('hpt', $this->hpt);
        $criteria->compare('hp', $this->hp);
        $criteria->compare('hpk', $this->hpk);
        $criteria->compare('apl', $this->apl);
        $criteria->compare('hl', $this->hl);
        $criteria->compare('hsaw', $this->hsaw);
        $criteria->compare('ksa', $this->hsaw);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return IuphhkTutupLahan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	
	public function cekexist()
	{
		
	    $model = self::findByAttributes(array('id_penutupan_lahan'=>$this->id_penutupan_lahan,'id_iuphhk'=>$this->id_iuphhk));
	    if ($model)
	         $this->addError('id_penutupan_lahan', 'Jenis Penutupan Lahan yang dipilih Sudah tersimpan sebelumnya, silahkan untuk mengupdate data bila diperlukan') ;

	}

}
