<?php

/**
 * This is the model class for table "iuphhk_laporan_keuangan".
 *
 * The followings are the available columns in table 'iuphhk_laporan_keuangan':
 * @property integer $id
 * @property integer $id_perusahaan
 * @property string $tahun
 * @property double $nilai_perolehan
 * @property double $nilai_buku
 * @property double $total_aset
 */
class IuphhkLaporanKeuangan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'iuphhk_laporan_keuangan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_perusahaan', 'numerical', 'integerOnly'=>true),
			array('nilai_perolehan, nilai_buku, total_aset', 'numerical'),
			array('tahun', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_perusahaan, tahun, nilai_perolehan, nilai_buku, total_aset', 'safe', 'on'=>'search'),
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
						'id_perusahaan'=>Yii::t('app','Id Perusahaan'),
						'tahun'=>Yii::t('app','Tahun'),
						'nilai_perolehan'=>Yii::t('app','Nilai Perolehan'),
						'nilai_buku'=>Yii::t('app','Nilai Buku'),
						'total_aset'=>Yii::t('app','Total Aset'),
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
		$criteria->compare('nilai_perolehan',$this->nilai_perolehan);
		$criteria->compare('nilai_buku',$this->nilai_buku);
		$criteria->compare('total_aset',$this->total_aset);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return IuphhkLaporanKeuangan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function getByPerusahaan($idPerusahaan)
        {
                $query = "SELECT * FROM iuphhk_laporan_keuangan WHERE id_perusahaan=".$idPerusahaan."  ORDER BY tahun DESC LIMIT 1 ";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                if(isset($result)){
                    $result = $result['0'];
                }

                return $result;
        }
        
}
