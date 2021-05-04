<?php

/**
 * This is the model class for table "rku_pasar_hhbk".
 *
 * The followings are the available columns in table 'rku_pasar_hhbk':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_hasil_hutan_nonkayu_silvikultur
 * @property integer $id_jenis_pasar
 * @property string $tahun
 * @property double $jumlah
 */
class RkuPasarHhbk extends CActiveRecord
{
        public $tahun_ke;
	public $nama_hhbk, $satuan, $jumlah_not_null;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_pasar_hhbk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku, id_hasil_hutan_nonkayu_silvikultur, id_jenis_pasar, tahun, jumlah', 'required'),
			array('id_rku, id_hasil_hutan_nonkayu_silvikultur, id_jenis_pasar, rkt_ke', 'numerical', 'integerOnly'=>true),
			array('jumlah', 'numerical'),
			//array('tahun', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, id_hasil_hutan_nonkayu_silvikultur, id_jenis_pasar, tahun, jumlah', 'safe', 'on'=>'search'),
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
			'idJenisPasar' => array(self::BELONGS_TO, 'MasterJenisPemasaran', 'id_jenis_pasar'),
                        'idRku' => array(self::BELONGS_TO, 'Rku', 'id_rku'),
                        'idHasilHutanNonkayuSilvikultur' => array(self::BELONGS_TO, 'RkuHasilHutanNonkayuSilvikultur', 'id_hasil_hutan_nonkayu_silvikultur'),

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
						'id_hasil_hutan_nonkayu_silvikultur'=>Yii::t('app','Id Hasil Hutan Nonkayu Silvikultur'),
						'id_jenis_pasar'=>Yii::t('app','Id Jenis Pasar'),
						'tahun'=>Yii::t('app','Tahun'),
						'jumlah'=>Yii::t('app','Jumlah'),
                                                'rkt_ke' => Yii::t('app', 'Blok Kerja Tahun Ke'),
                                                'tahun_ke' => Yii::t('app', 'Blok Kerja Tahun Ke'),
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
                $criteria->order = "rkt_ke, tahun";
		$criteria->compare('id',$this->id);
		$criteria->compare('id_rku',$this->id_rku);
		$criteria->compare('id_hasil_hutan_nonkayu_silvikultur',$this->id_hasil_hutan_nonkayu_silvikultur);
		$criteria->compare('id_jenis_pasar',$this->id_jenis_pasar);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('jumlah',$this->jumlah);
                $criteria->compare('rkt_ke',$this->rkt_ke);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuPasarHhbk the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        return round($total, 2);
    }
}
