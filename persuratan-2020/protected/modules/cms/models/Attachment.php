<?php

/**
 * This is the model class for table "attachment".
 *
 * The followings are the available columns in table 'attachment':
 * @property string $id
 * @property string $Keterangan
 * @property integer $post_id
 * @property integer $publikasi_id
 * @property string $File_Name
 * @property string $File_Type
 * @property string $File_Path
 * @property integer $File_Size
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Post $post
 * @property Publikasi $publikasi
 * @property SiteUsers $createdBy
 * @property SiteUsers $modifiedBy
 */
class Attachment extends CActiveRecordNew {

    public $attr_prefix = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'attachment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('post_id, publikasi_id, File_Size, created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('Keterangan', 'length', 'max' => 1000),
            array('File_Name, File_Type, File_Path', 'length', 'max' => 255),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, Keterangan, post_id, publikasi_id, File_Name, File_Type, File_Path, File_Size, created_at, modified_at, created_by, modified_by', 'safe', 'on' => 'search'),
        );
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
            'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
            'publikasi' => array(self::BELONGS_TO, 'Publikasi', 'publikasi_id'),
            'createdBy' => array(self::BELONGS_TO, 'SiteUsers', 'created_by'),
            'modifiedBy' => array(self::BELONGS_TO, 'SiteUsers', 'modified_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'Keterangan' => Yii::t('app', 'Keterangan'),
            'post_id' => Yii::t('app', 'Post'),
            'publikasi_id' => Yii::t('app', 'Publikasi'),
            'File_Name' => Yii::t('app', 'File Name'),
            'File_Type' => Yii::t('app', 'File Type'),
            'File_Path' => Yii::t('app', 'File Path'),
            'File_Size' => Yii::t('app', 'File Size'),
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
        $criteria->compare('t.Keterangan', $this->Keterangan, true);
        $criteria->compare('t.post_id', $this->post_id);
        $criteria->compare('t.publikasi_id', $this->publikasi_id);
        $criteria->compare('t.File_Name', $this->File_Name, true);
        $criteria->compare('t.File_Type', $this->File_Type, true);
        $criteria->compare('t.File_Path', $this->File_Path, true);
        $criteria->compare('t.File_Size', $this->File_Size);
        $criteria->compare('t.created_at', $this->created_at, true);
        $criteria->compare('t.modified_at', $this->modified_at, true);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.modified_by', $this->modified_by);
//		$criteria->compare('post.colName',$this->rel_id,true);
//		$criteria->compare('publikasi.colName',$this->rel_id,true);
//		$criteria->compare('createdBy.colName',$this->rel_id,true);
//		$criteria->compare('modifiedBy.colName',$this->rel_id,true);
        $criteria->with = array('post', 'publikasi', 'createdBy', 'modifiedBy');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Attachment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
