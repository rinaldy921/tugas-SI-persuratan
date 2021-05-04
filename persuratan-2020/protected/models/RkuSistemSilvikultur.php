<?php

/**
 * This is the model class for table "rku_sistem_silvikultur".
 *
 * The followings are the available columns in table 'rku_sistem_silvikultur':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_jenis_silvikultur
 * @property string $sistem_silvikultur
 * @property double $jumlah
 *
 * The followings are the available model relations:
 * @property MasterJenisSilvikultur $idJenisSilvikultur
 * @property Rku $idRku
 */
class RkuSistemSilvikultur extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_sistem_silvikultur';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, id_jenis_silvikultur', 'required'),
			array('id_rku, id_jenis_silvikultur', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			array('sistem_silvikultur', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, id_jenis_silvikultur, sistem_silvikultur, jumlah', 'safe', 'on'=>'search'),
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
			'idJenisSilvikultur' => array(self::BELONGS_TO, 'MasterJenisSilvikultur', 'id_jenis_silvikultur'),
			'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_rku'=>Yii::t('app','Id Rku'),
						'id_jenis_silvikultur'=>Yii::t('app','Jenis Sistem Silvikultur'),
						'sistem_silvikultur'=>Yii::t('app','Sistem Silvikultur'),
						'jumlah'=>Yii::t('app','Luas (Ha)'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('id_rku',$this->id_rku);
		$criteria->compare('id_jenis_silvikultur',$this->id_jenis_silvikultur);
		$criteria->compare('sistem_silvikultur',$this->sistem_silvikultur,true);
		$criteria->compare('jumlah',$this->jumlah);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuSistemSilvikultur the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getByRkuId($rkuId)
        {
                $query = "SELECT id,jumlah,
                            IFNULL((SELECT m.jenis_silvikultur FROM master_jenis_silvikultur m WHERE m.id=r.id_jenis_silvikultur),'')AS jenis 
                            FROM rku_sistem_silvikultur r WHERE r.id_rku=".$rkuId.";";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
}
