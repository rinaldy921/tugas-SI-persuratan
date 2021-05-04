<?php

/**
 * This is the model class for table "legalitas_perusahaan".
 *
 * The followings are the available columns in table 'legalitas_perusahaan':
 * @property integer $id_legalitas
 * @property integer $perusahaan_id
 * @property string $jenis_legalitas
 * @property string $notaris
 * @property string $nomor
 * @property string $tanggal
 * @property integer $perubahan_ke
 *
 * The followings are the available model relations:
 * @property Perusahaan $perusahaan
 */
class LegalitasPerusahaan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'legalitas_perusahaan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jenis_legalitas, notaris, nomor, tanggal, no_surat_kemenkumham, tgl_surat_kemenkumham', 'required'),
			array('perusahaan_id, perubahan_ke', 'numerical', 'integerOnly'=>true),
			array('jenis_legalitas', 'length', 'max'=>14),
			array('notaris', 'length', 'max'=>50),
			array('nomor', 'length', 'max'=>100),
			array('tanggal', 'safe'),
//                        array('pdf_surat_kemenkumham', 'file', 'types'=>'pdf', 'maxSize'=>1024 * 1024 * 2, 'tooLarge'=>'File has to be smaller than 2MB', 'allowEmpty'=>true),
//                        array('pdf_akte_legalitas', 'file', 'types'=>'pdf', 'maxSize'=>1024 * 1024 * 5, 'tooLarge'=>'File has to be smaller than 2MB', 'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_legalitas, perusahaan_id, jenis_legalitas, notaris, nomor, tanggal, perubahan_ke, pdf_surat_kemenkumham, pdf_akte_legalitas', 'safe', 'on'=>'search'),
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
			'perusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'perusahaan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_legalitas' => 'Id Legalitas',
			'perusahaan_id' => 'Perusahaan',
			'jenis_legalitas' => 'Jenis Legalitas',
			'notaris' => 'Notaris',
			'nomor' => 'Nomor Akte',
			'tanggal' => 'Tanggal',
			'perubahan_ke' => 'Perubahan Ke',
			'tgl_surat_kemenkumham' => "Tgl Surat Kemenkumham",
			'no_surat_kemenkumham'  => "Nomor Surat Kemenkumham",
			'pdf_surat_kemenkumham' => 'PDF Surat Kemenkumham',
			'pdf_akte_legalitas'   => 'PDF Akte Legalitas'
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

		$criteria->compare('id_legalitas',$this->id_legalitas);
		$criteria->compare('perusahaan_id',$this->perusahaan_id);
		$criteria->compare('jenis_legalitas',$this->jenis_legalitas,true);
		$criteria->compare('notaris',$this->notaris,true);
		$criteria->compare('nomor',$this->nomor,true);
		$criteria->compare('tanggal',$this->tanggal,true);
		$criteria->compare('perubahan_ke',$this->perubahan_ke);
		$criteria->compare('no_surat_kemenkumham',$this->no_surat_kemenkumham);
		$criteria->compare('tgl_surat_kemenkumham',$this->tgl_surat_kemenkumham);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LegalitasPerusahaan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
            public function getByPerusahaanId($perusahaanId)
        {
                $query = "SELECT * FROM legalitas_perusahaan WHERE perusahaan_id=".$perusahaanId." ORDER BY tanggal ASC";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
        
        
}
