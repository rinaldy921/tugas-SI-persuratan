<?php

/**
 * This is the model class for table "message_status".
 *
 * The followings are the available columns in table 'message_status':
 * @property integer $id
 * @property string $message_id
 * @property integer $user_id
 * @property integer $status
 * @property string $read_at
 *
 * The followings are the available model relations:
 * @property Message $message
 * @property SiteUsers $user
 */
class MessageStatus extends CActiveRecordNew {

    public $attr_prefix = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'message_status';
    }

    public function scopes() {
        return array(
            'Unread' => array(
                'condition' => "messageStatus.status = 0",
            ),
            'Read' => array(
                'condition' => "messageStatus.status = 1",
            ),
            'OwnerIndex' => array(
                'condition' => "messageStatus.user_id = " . Yii::app()->user->id,
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
            array('message_id, user_id', 'required'),
            array('user_id, status', 'numerical', 'integerOnly' => true),
            array('message_id', 'length', 'max' => 20),
            array('read_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, message_id, user_id, status, read_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'message' => array(self::BELONGS_TO, 'Message', 'message_id'),
            'user' => array(self::BELONGS_TO, 'SiteUsers', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'message_id' => Yii::t('app', 'Message'),
            'user_id' => Yii::t('app', 'Pengguna'),
            'status' => Yii::t('app', 'Status'),
            'read_at' => Yii::t('app', 'Dibaca'),
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.message_id', $this->message_id, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.read_at', $this->read_at, true);
//		$criteria->compare('message.colName',$this->rel_id,true);
//		$criteria->compare('user.colName',$this->rel_id,true);
        $criteria->with = array('message', 'user');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MessageStatus the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
