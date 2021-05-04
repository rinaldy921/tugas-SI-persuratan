<?php

/**
 * This is the model class for table "rku_sektor".
 *
 * The followings are the available columns in table 'rku_sektor':
 * @property integer $id
 * @property string $nama_sektor
 * @property integer $id_rku
 * @property string $desc
 * @property integer $id_perusahaan
 */
class RkuSektor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_sektor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, id_perusahaan', 'numerical', 'integerOnly'=>true),
			array('nama_sektor', 'length', 'max'=>255),
			array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_sektor, nama_sektor, id_rku, desc, id_perusahaan', 'safe', 'on'=>'search'),
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
						'id_sektor'=>Yii::t('app','ID'),
						'nama_sektor'=>Yii::t('app','Nama Unit Kelestarian'),
						'id_rku'=>Yii::t('app','RKU'),
                                                'id_rev'=>Yii::t('app','ID Revisi'),
						'desc'=>Yii::t('app','Keterangan'),
						'id_perusahaan'=>Yii::t('app','Nama Perusahaan'),
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
                $idPerusahaan = Yii::app()->user->idPerusahaan();
                
                
		$criteria->compare('id_sektor',$this->id_sektor);
		$criteria->compare('nama_sektor',$this->nama_sektor,true);
		$criteria->compare('id_rku',$this->id_rku);
		$criteria->compare('id_rku',$rkuId);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('id_perusahaan',$this->id_perusahaan);
                $criteria->compare('id_perusahaan',$idPerusahaan);
                $criteria->compare('id_rev',$this->id_rev);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
        public function deleteByRkuId($idRku)
        {
            $this->getDbConnection()->createCommand('DELETE FROM rku_sektor WHERE id_rku='.$idRku)->execute();
        }
        
        
        
        public function getIdByIdRev($idRev,$idRku){
            return $this->getDbConnection()->createCommand('SELECT * FROM rku_sektor WHERE id_rev='.$idRev." AND id_rku=".$idRku." LIMIT 1")->execute();
        }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuSektor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
