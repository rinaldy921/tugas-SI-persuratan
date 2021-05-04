<?php

/**
 * This is the model class for table "stok_tanaman".
 *
 * The followings are the available columns in table 'stok_tanaman':
 * @property string $id
 * @property string $tahun_tanam
 * @property integer $sektor_id
 * @property integer $blok_id
 * @property double $jumlah_luas
 * @property integer $jenis_lahan
 * @property integer $id_perusahaan
 */
class StokTanaman extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stok_tanaman';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sektor_id, blok_id, jenis_lahan, id_perusahaan', 'numerical', 'integerOnly'=>true),
			array('jumlah_luas', 'numerical'),
			array('tahun_tanam', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tahun_tanam, sektor_id, blok_id, jumlah_luas, jenis_lahan, id_perusahaan', 'safe', 'on'=>'search'),
		);
	}

	/**
        * @return array relational rules.
        */
       public function relations() {
           // NOTE: you may need to adjust the relation name and the related
           // class name for the relations automatically generated below.
           return array(
               'idBlok' => array(self::BELONGS_TO, 'RkuBlok', 'blok_id'),            
               'idSektor' => array(self::BELONGS_TO, 'RkuSektor', 'sektor_id'),            
               
           );
       }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'tahun_tanam'=>Yii::t('app','Tahun Tanam'),
						'sektor_id'=>Yii::t('app','Unit Kelestarian'),
						'blok_id'=>Yii::t('app','Petak Kerja'),
						'jumlah_luas'=>Yii::t('app','Jumlah Luas (Ha)'),
						'jenis_lahan'=>Yii::t('app','Jenis Lahan'),
						'id_perusahaan'=>Yii::t('app','Id Perusahaan'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('tahun_tanam',$this->tahun_tanam,true);
		$criteria->compare('sektor_id',$this->sektor_id);
		$criteria->compare('blok_id',$this->blok_id);
		$criteria->compare('jumlah_luas',$this->jumlah_luas);
		$criteria->compare('jenis_lahan',$this->jenis_lahan);
		$criteria->compare('id_perusahaan',$this->id_perusahaan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StokTanaman the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
