<?php

/**
 * This is the model class for table "publikasi".
 *
 * The followings are the available columns in table 'publikasi':
 * @property integer $id
 * @property string $Judul
 * @property string $Kategori
 * @property string $Deskripsi
 * @property string $Cover
 * @property string $slug
 * @property string $published
 * @property string $created_at
 * @property string $modified_at
 * @property integer $created_by
 * @property integer $modified_by
 *
 * The followings are the available model relations:
 * @property Attachment[] $attachments
 * @property SiteUsers $createdBy
 * @property SiteUsers $modifiedBy
 */
class Publikasi extends CActiveRecordNew {

    public $attr_prefix = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'publikasi';
    }

    public function scopes() {
        return array(
            'All' => array(),
            'Galeri' => array(
                'condition' => "t.Kategori = 'Album' AND t.published = 1",
                'order' => 't.created_at DESC'
            ),
            'Hukum' => array(
                'condition' => "t.Kategori = 'Produk Hukum' AND t.published = 1",
                'order' => 't.created_at DESC'
            ),
            'RandomGaleri' => array(
                'condition' => "t.Kategori = 'Album' AND t.published = 1",
                'order' => 'RAND()'
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
            array('Judul, Deskripsi', 'required'),
            array('created_by, modified_by, published', 'numerical', 'integerOnly' => true),
            array('Judul, slug', 'length', 'max' => 255),
            array('Cover', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
            array('Kategori', 'length', 'max' => 12),
            array('Deskripsi, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, Judul, Kategori, Deskripsi, Cover, slug, published, created_at, modified_at, created_by, modified_by', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors() {
        return array(
            'AuditLogBehavior' => array(
                'class' => 'application.components.AuditLogBehavior',
                'createAttribute' => $this->attr_prefix . 'created_by',
                'updateAttribute' => $this->attr_prefix . 'modified_by',
                'slugAttribute' => 'Judul',
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
            'attachments' => array(self::HAS_MANY, 'Attachment', 'publikasi_id'),
            'createdBy' => array(self::BELONGS_TO, 'SiteUsers', 'created_by'),
            'modifiedBy' => array(self::BELONGS_TO, 'SiteUsers', 'modified_by'),
        );
    }

    public function listAttachment($attachs, $type = 'publikasi') {
        $out = array();
        $i = 1;
        foreach ($attachs as $d) {
            $out[] = ($type == 'album') ? $i++ . ". " . CHtml::link($d->File_Name, Yii::app()->baseUrl . $d->File_Path, array('data-lightbox' => 'image-1', 'title' => $d->Keterangan)) : $i++ . ". " . CHtml::link($d->File_Name, Yii::app()->baseUrl . $d->File_Path);
        }
        return implode("\n", $out);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'Judul' => Yii::t('app', 'Judul'),
            'Kategori' => Yii::t('app', 'Kategori'),
            'Deskripsi' => Yii::t('app', 'Deskripsi'),
            'Cover' => Yii::t('app', 'Cover'),
            'slug' => Yii::t('app', 'Slug'),
            'published' => Yii::t('app', 'Status Publikasi'),
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.Judul', $this->Judul, true);
        $criteria->compare('t.Kategori', $this->Kategori, true);
        $criteria->compare('t.Deskripsi', $this->Deskripsi, true);
        $criteria->compare('t.Cover', $this->Cover, true);
        $criteria->compare('t.slug', $this->slug, true);
        $criteria->compare('t.published', $this->published);
        $criteria->compare('t.created_at', $this->created_at, true);
        $criteria->compare('t.modified_at', $this->modified_at, true);
        $criteria->compare('t.created_by', $this->created_by);
        $criteria->compare('t.modified_by', $this->modified_by);
//		$criteria->compare('attachments.colName',$this->rel_id,true);
//		$criteria->compare('createdBy.colName',$this->rel_id,true);
//		$criteria->compare('modifiedBy.colName',$this->rel_id,true);
        $criteria->with = array('attachments', 'createdBy', 'modifiedBy');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Publikasi the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
