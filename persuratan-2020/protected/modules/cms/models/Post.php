<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property integer $id
 * @property string $Judul
 * @property string $Deskripsi
 * @property string $Isi
 * @property string $Kategori
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
class Post extends CActiveRecord {

    public $attr_prefix = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'post';
    }

    public function scopes() {
        return array(
            'All' => array(),
            'Berita' => array(
                'condition' => "t.Kategori = 'berita' AND t.published = 1",
                'order' => 't.created_at DESC',
            ),
            'Page' => array(
                'condition' => "t.Kategori = 'page'",
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
            array('Judul, Isi', 'required'),
            array('published', 'numerical', 'integerOnly' => true),
            array('Judul, slug', 'length', 'max' => 255),
            array('Cover', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
            array('Deskripsi', 'length', 'max' => 2500),
            array('Kategori', 'length', 'max' => 60),
            array('Isi, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, Judul, Deskripsi, Isi, Kategori, Cover, slug, published, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors() {
        return array(
            // 'AuditLogBehavior' => array(
            //     'class' => 'application.components.AuditLogBehavior',
            //     'createAttribute' => $this->attr_prefix . 'created_by',
            //     'updateAttribute' => $this->attr_prefix . 'modified_by',
            //     'slugAttribute' => 'Judul',
            // ),
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
            // 'attachments' => array(self::HAS_MANY, 'Attachment', 'post_id'),
            // 'createdBy' => array(self::BELONGS_TO, 'SiteUsers', 'created_by'),
            // 'modifiedBy' => array(self::BELONGS_TO, 'SiteUsers', 'modified_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'Judul' => Yii::t('app', 'Judul'),
            'Deskripsi' => Yii::t('app', 'Deskripsi'),
            'Isi' => Yii::t('app', 'Isi'),
            'Kategori' => Yii::t('app', 'Kategori'),
            'Cover' => Yii::t('app', 'Cover'),
            'slug' => Yii::t('app', 'Slug'),
            'published' => Yii::t('app', 'Status Publikasi'),
            'created_at' => Yii::t('app', 'Dibuat'),
            'modified_at' => Yii::t('app', 'Diperbaharui'),
            // 'created_by' => Yii::t('app', 'Pembuat'),
            // 'modified_by' => Yii::t('app', 'Pembaharu'),
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
        $criteria->compare('t.Deskripsi', $this->Deskripsi, true);
        $criteria->compare('t.Isi', $this->Isi, true);
        $criteria->compare('t.Kategori', $this->Kategori, true);
        $criteria->compare('t.Cover', $this->Cover, true);
        $criteria->compare('t.slug', $this->slug, true);
        $criteria->compare('t.published', $this->published);
        $criteria->compare('t.created_at', $this->created_at, true);
        $criteria->compare('t.modified_at', $this->modified_at, true);
        // $criteria->compare('t.created_by', $this->created_by);
        // $criteria->compare('t.modified_by', $this->modified_by);
//		$criteria->compare('attachments.colName',$this->rel_id,true);
//		$criteria->compare('createdBy.colName',$this->rel_id,true);
//		$criteria->compare('modifiedBy.colName',$this->rel_id,true);
        // $criteria->with = array('attachments', 'createdBy', 'modifiedBy');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function wp_trim($str, $width = 60, $break = "|") {
        $formatted = '';
        $position = -1;
        $prev_position = 0;
        $last_line = -1;
        while ($position = mb_stripos($str, " ", ++$position, 'utf-8')) {
            if ($position > $last_line + $width + 1) {
                $formatted.= mb_substr($str, $last_line + 1, $prev_position - $last_line - 1, 'utf-8') . $break;
                $last_line = $prev_position;
            }
            $prev_position = $position;
        }
        $formatted.= mb_substr($str, $last_line + 1, mb_strlen($str), 'utf-8');
        $words = explode('|', $formatted);
        return (count($words) > 1) ? trim($words[0]) . " ..." : trim($words[0]);
    } 

}
