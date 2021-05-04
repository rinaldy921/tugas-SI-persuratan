<?php

/**
 * This is the model class for table "t_menu".
 *
 * The followings are the available columns in table 't_menu':
 * @property integer $id
 * @property string $title
 * @property string $link
 * @property integer $posisi
 * @property integer $parent
 * @property string $icon
 * @property string $deskripsi
 * @property integer $urutan
 */
class Menu extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('posisi, parent, urutan', 'numerical', 'integerOnly'=>true),
			array('title, link, icon, deskripsi', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, link, posisi, parent, icon, deskripsi, urutan', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'title'=>Yii::t('app','Title'),
						'link'=>Yii::t('app','Link'),
						'posisi'=>Yii::t('app','Posisi'),
						'parent'=>Yii::t('app','Parent'),
						'icon'=>Yii::t('app','Icon'),
						'deskripsi'=>Yii::t('app','Deskripsi'),
						'urutan'=>Yii::t('app','Urutan'),
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                
                $criteria->order = 'urutan ASC';
                
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('posisi',$this->posisi);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('deskripsi',$this->deskripsi,true);
		$criteria->compare('urutan',$this->urutan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
