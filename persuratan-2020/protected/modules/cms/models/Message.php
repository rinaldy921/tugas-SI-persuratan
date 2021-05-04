<?php

/**
 * This is the model class for table "message".
 *
 * The followings are the available columns in table 'message':
 * @property string $id
 * @property integer $user_id
 * @property string $user_tujuan
 * @property string $judul
 * @property string $pesan
 * @property integer $status
 * @property string $tanggal
 * @property integer $isthreaded
 * @property integer $parent_id
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property SiteUsers $createdBy
 * @property SiteUsers $modifiedBy
 * @property SiteUsers $user
 */
class Message extends CActiveRecordNew {

    public $attr_prefix = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'message';
    }

    public function scopes() {
        return array(
            'All' => array(),
            'Unread' => array(
                'condition' => "t.status = 0",
                'order' => 'tanggal DESC'
            ),
            'Read' => array(
                'condition' => "t.status = 1",
                'order' => 'tanggal DESC'
            ),
            'Parent' => array(
                'condition' => "isthreaded = 0",
                'order' => 'tanggal DESC'
            ),
            'Child' => array(
                'condition' => "isthreaded = 1 AND parent_id IS NOT NULL",
                'order' => 'tanggal DESC'
            ),
            'OwnerIndex' => array(
                'condition' => "(t.user_id = " . Yii::app()->user->id . " OR FIND_IN_SET(" . Yii::app()->user->id . ", t.user_tujuan)) AND isthreaded = 0",
                'order' => 'tanggal DESC'
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
            array('user_tujuan, judul, pesan', 'required'),
            array('user_id, status, isthreaded, parent_id, created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('judul', 'length', 'max' => 255),
            array('pesan, tanggal, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, user_tujuan, judul, pesan, status, tanggal, isthreaded, parent_id, created_at, modified_at, created_by, modified_by', 'safe', 'on' => 'search'),
        );
    }

    public function hasNewChild($id) {
        return Message::model()->Child()->with('messageStatus')->count("messageStatus.user_id = " . Yii::app()->user->id . " AND parent_id = " . $id . " AND messageStatus.status = 0");
    }

    public function behaviors() {
        return array(
            'AuditLogBehavior' => array(
                'class' => 'application.components.AuditLogBehavior',
                'createAttribute' => $this->attr_prefix . 'created_by',
                'updateAttribute' => $this->attr_prefix . 'modified_by',
            ),
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
            'createdBy' => array(self::BELONGS_TO, 'SiteUsers', 'created_by'),
            'modifiedBy' => array(self::BELONGS_TO, 'SiteUsers', 'modified_by'),
            'user' => array(self::BELONGS_TO, 'SiteUsers', 'user_id'),
            'messageStatus' => array(self::HAS_ONE, 'MessageStatus', 'message_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'user_tujuan' => Yii::t('app', 'User Tujuan'),
            'judul' => Yii::t('app', 'Judul'),
            'pesan' => Yii::t('app', 'Pesan'),
            'status' => Yii::t('app', 'Status'),
            'tanggal' => Yii::t('app', 'Tanggal'),
            'isthreaded' => Yii::t('app', 'Isthreaded'),
            'parent_id' => Yii::t('app', 'Parent'),
            'created_at' => Yii::t('app', 'Dibuat'),
            'modified_at' => Yii::t('app', 'Diperbaharui'),
            'created_by' => Yii::t('app', 'Pembuat'),
            'modified_by' => Yii::t('app', 'Pembaharu'),
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
        $criteria->compare('t.user_tujuan', $this->user_tujuan, true);
        $criteria->compare('t.judul', $this->judul, true);
        $criteria->compare('t.pesan', $this->pesan, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.isthreaded', $this->isthreaded);
        $criteria->compare('t.parent_id', $this->parent_id);
        $criteria->compare('t.created_at', $this->created_at, true);
        $criteria->compare('t.modified_at', $this->modified_at, true);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.modified_by', $this->modified_by);
//		$criteria->compare('createdBy.colName',$this->rel_id,true);
//		$criteria->compare('modifiedBy.colName',$this->rel_id,true);
//		$criteria->compare('user.colName',$this->rel_id,true);
        $criteria->with = array('createdBy', 'modifiedBy', 'user', 'messageStatus');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Message the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
