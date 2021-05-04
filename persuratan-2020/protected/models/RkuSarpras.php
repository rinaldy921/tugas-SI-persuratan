<?php

/**
 * This is the model class for table "rku_sarpras".
 *
 * The followings are the available columns in table 'rku_sarpras':
 * @property integer $id
 * @property integer $id_rku
 * @property integer $id_jenis_sarpras
 * @property integer $jumlah
 * @property string $keterangan
 *
 * The followings are the available model relations:
 * @property Rku $idRku
 * @property MasterJenisSarpras $idJenisSarpras
 */
class RkuSarpras extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rku_sarpras';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rku', 'required'),
                        array('nama_sarpras', 'length', 'max'=>255),
			array('id_rku, id_jenis_sarpras, jumlah', 'numerical', 'integerOnly'=>true),
			array('keterangan', 'safe'),
                        // The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rku, id_jenis_sarpras, jumlah, keterangan', 'safe', 'on'=>'search'),
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
			'idJenisSarpras' => array(self::BELONGS_TO, 'MasterJenisSarpras', 'id_jenis_sarpras'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_rku' => 'Id Rku',
			'id_jenis_sarpras' => 'Id Jenis Sarpras',
                        'nama_sarpras' => 'Nama Sarpras',
			'jumlah' => 'Jumlah',
                        'keterangan' => 'Keterangan',
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
		$criteria->compare('id_jenis_sarpras',$this->id_jenis_sarpras);
		$criteria->compare('jumlah',$this->jumlah);
                $criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        return round($total, 2);
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RkuSarpras the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
