<?php

/** 
 * This is the model class for table "rku_blok". 
 * 
 * The followings are the available columns in table 'rku_blok': 
 * @property integer $id
 * @property string $nama_blok
 * @property string $desc
 * @property integer $id_sektor
 * @property integer $id_rku
 * @property integer $id_kabupaten
 */ 
class RkuBlok extends CActiveRecord
{ 
    /** 
     * @return string the associated database table name 
     */ 
    public function tableName() 
    { 
        return 'rku_blok'; 
    } 

    /** 
     * @return array validation rules for model attributes. 
     */ 
    public function rules() 
    { 
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array( 
            array('id_sektor, id_rku, id_kabupaten', 'numerical', 'integerOnly'=>true),
            array('nama_blok', 'length', 'max'=>255),
            array('desc', 'safe'),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, nama_blok, desc, id_sektor, id_rku, id_kabupaten', 'safe', 'on'=>'search'), 
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
            'namaSektor' => array(self::BELONGS_TO, 'RkuSektor', 'id_sektor'),
            'namaKabupaten' => array(self::BELONGS_TO, 'Kabupaten', 'id_kabupaten'),		
        ); 
    } 

    /** 
     * @return array customized attribute labels (name=>label) 
     */ 
    public function attributeLabels() 
    { 
        return array( 
                        'id'=>Yii::t('app','ID'),
                        'nama_blok'=>Yii::t('app','Nama Petak Kerja'),
                        'desc'=>Yii::t('app','Keterangan'),
                        'id_sektor'=>Yii::t('app','Sektor'),
                        'id_rku'=>Yii::t('app','Id Rku'),
                        'id_kabupaten'=>Yii::t('app','Kabupaten'),
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
        $rkuId = Yii::app()->session['rku_id'];

        $criteria->compare('id',$this->id);
        $criteria->compare('nama_blok',$this->nama_blok,true);
        $criteria->compare('desc',$this->desc,true);
        $criteria->compare('id_sektor',$this->id_sektor);
        $criteria->compare('id_rku',$this->id_rku);
        $criteria->compare('id_rku',$rkuId);
        $criteria->compare('id_kabupaten',$this->id_kabupaten);
 
        return new CActiveDataProvider($this, array( 
            'criteria'=>$criteria, 
        )); 
    } 

    public function deleteByRkuId($idRku)
    {
        $this->getDbConnection()->createCommand('DELETE FROM rku_blok WHERE id_rku='.$idRku)->execute();
    }

    public function deleteBySektorId($idSektor)
    {
        $this->getDbConnection()->createCommand('DELETE FROM rku_blok WHERE id_sektor='.$idSektor)->execute();
    }
    
    public function getSektorName($sektorId)
    {
        $stat = RkuSektor::find()->where(["id"=>$sektorId])->asArray()->one();
        if (is_array($stat)) {
                return $stat["nama_sektor"];
        } else {
                return "";
        }
    }
    
    
     public function getKabupatenName($kabuaptenId)
    {
        $stat = Kabupaten::find()->where(["id_kabupaten"=>$kabuaptenId])->asArray()->one();
        if (is_array($stat)) {
                return $stat["nama"];
        } else {
                return "";
        }
    }
    /** 
     * Returns the static model of the specified AR class. 
     * Please note that you should have this exact method in all your CActiveRecord descendants! 
     * @param string $className active record class name. 
     * @return RkuBlok the static model class 
     */ 
    public static function model($className=__CLASS__) 
    { 
        return parent::model($className); 
    } 
} 