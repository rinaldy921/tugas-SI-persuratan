<?php

/**
 * This is the model class for table "rkt_panen_hhbk".
 *
 * The followings are the available columns in table 'rkt_panen_hhbk':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_hasil_hutan_nonkayu_silvikultur
 * @property double $luas
 * @property double $jumlah
 * @property string $tahun
 * @property integer $rkt_ke
 */
class RktPanenHhbk extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_panen_hhbk';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, id_hasil_hutan_nonkayu_silvikultur, tahun', 'required'),
			array('id_rkt, id_hasil_hutan_nonkayu_silvikultur, rkt_ke', 'numerical', 'integerOnly'=>true),
			array('luas, jumlah', 'numerical'),
			array('tahun', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, id_hasil_hutan_nonkayu_silvikultur, luas, jumlah, tahun, rkt_ke', 'safe', 'on'=>'search'),
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
						'id_rkt'=>Yii::t('app','Id Rkt'),
						'id_hasil_hutan_nonkayu_silvikultur'=>Yii::t('app','Id Hasil Hutan Nonkayu Silvikultur'),
						'luas'=>Yii::t('app','Luas'),
						'jumlah'=>Yii::t('app','Jumlah'),
						'tahun'=>Yii::t('app','Tahun'),
						'rkt_ke'=>Yii::t('app','Rkt Ke'),
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
		$criteria->compare('id_rkt',$this->id_rkt);
		$criteria->compare('id_hasil_hutan_nonkayu_silvikultur',$this->id_hasil_hutan_nonkayu_silvikultur);
		$criteria->compare('luas',$this->luas);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('rkt_ke',$this->rkt_ke);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        
        public function findRkuMatch() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "id != ''";

        
		$criteria->compare('id',$this->id);
		$criteria->compare('id_rkt',$this->id_rkt);
		$criteria->compare('id_hasil_hutan_nonkayu_silvikultur',$this->id_hasil_hutan_nonkayu_silvikultur);
		$criteria->compare('luas',$this->luas);
		$criteria->compare('jumlah',$this->jumlah);
		$criteria->compare('tahun',$this->tahun,true);
		$criteria->compare('rkt_ke',$this->rkt_ke);
        //$criteria->compare('jumlah', $this->jumlah);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktPanenHhbk the static model class
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
