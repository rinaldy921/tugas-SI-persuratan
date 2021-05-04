<?php

/**
 * This is the model class for table "progres_tata_batas".
 *
 * The followings are the available columns in table 'progres_tata_batas':
 * @property integer $id
 * @property integer $id_perusahaan
 * @property string $tahun
 * @property integer $id_progres_tata_batas
 * @property string $keterangan
 * @property string $tanggal
 *
 * The followings are the available model relations:
 * @property Perusahaan $idPerusahaan
 * @property MasterProgresTataBatas $idProgresTataBatas
 */
class ProgresTataBatas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'progres_tata_batas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_perusahaan, id_progres_tata_batas', 'required'),
			array('id_perusahaan, id_progres_tata_batas, id_ket_progres_tata_batas', 'numerical', 'integerOnly'=>true),
			array('tahun', 'length', 'max'=>4),
			array('keterangan, nomor', 'length', 'max'=>255),
			array('tanggal', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_perusahaan, tahun, id_progres_tata_batas, keterangan, tanggal, id_ket_progres_tata_batas, file_doc', 'safe', 'on'=>'search'),
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
                        'idKetProgres' => array(self::BELONGS_TO, 'MasterKetProgresTataBatas', 'id_ket_progres_tata_batas'),
			'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
			'idProgresTataBatas' => array(self::BELONGS_TO, 'MasterProgresTataBatas', 'id_progres_tata_batas'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'id_perusahaan'=>Yii::t('app','Id Perusahaan'),
						'tahun'=>Yii::t('app','Tahun'),
						'id_progres_tata_batas'=>Yii::t('app','Progres Tata Batas'),
						'keterangan'=>Yii::t('app','Keterangan'),
						'tanggal'=>Yii::t('app','Tanggal'),
                                                'id_ket_progres_tata_batas'=>Yii::t('app','Progres Tata Batas'),
                                                'nomor'=>Yii::t('app','Nomor'),
//                                                'id_jenis'=>Yii::t('app','Jenis Batas'),
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
		$criteria->compare('id_perusahaan',$this->id_perusahaan);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('id_progres_tata_batas',$this->id_progres_tata_batas);
//                $criteria->compare('id_jenis',$this->id_jenis);
		$criteria->compare('keterangan',$this->keterangan,true);
		$criteria->compare('tanggal',$this->tanggal,true);
                $criteria->compare('id_ket_progres_tata_batas',$this->id_ket_progres_tata_batas,true);
                $criteria->compare('nomor',$this->nomor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProgresTataBatas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        
         public function getByPerusahaanId($perusahaanId)
        {
                $query = "SELECT p.*,IFNULL((SELECT s.nama_progres_tata_batas FROM master_progres_tata_batas s WHERE s.id_progres_tata_batas = p.id_progres_tata_batas),'-')AS progress 
                        FROM progres_tata_batas p WHERE id_perusahaan=".$perusahaanId."  ORDER BY id_progres_tata_batas DESC LIMIT 1;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
    
    
}
