<?php

/**
 * This is the model class for table "notifikasi".
 *
 * The followings are the available columns in table 'notifikasi':
 * @property string $id
 * @property integer $user_id
 * @property string $isi
 * @property integer $status
 * @property string $tanggal
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property SiteUsers $user
 */
class Notifikasi extends CActiveRecordNew {

    public $attr_prefix = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'notifikasi';
    }

    public function scopes() {
        return array(
            'All' => array(),
            'Unread' => array(
                'condition' => "status = 0",
                'order' => 'created_at DESC'
            ),
            'Read' => array(
                'condition' => "status = 1",
                'order' => 'created_at DESC'
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, status', 'numerical', 'integerOnly' => true),
            array('isi, tanggal, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, isi, status, tanggal, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => $this->attr_prefix . 'created_at',
                'updateAttribute' => $this->attr_prefix . 'modified_at',
                'setUpdateOnCreate' => true,
            )
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'SiteUsers', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'isi' => Yii::t('app', 'Isi'),
            'status' => Yii::t('app', 'Status'),
            'tanggal' => Yii::t('app', 'Tanggal'),
            'created_at' => Yii::t('app', 'Dibuat'),
            'modified_at' => Yii::t('app', 'Diperbaharui'),
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

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.isi', $this->isi, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.created_at', $this->created_at, true);
        $criteria->compare('t.modified_at', $this->modified_at, true);
        $criteria->with = array('user');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Notifikasi the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
