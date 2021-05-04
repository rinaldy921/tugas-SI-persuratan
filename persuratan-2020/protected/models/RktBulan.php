<?php

/**
 * This is the model class for table "rkt_bulan".
 *
 * The followings are the available columns in table 'rkt_bulan':
 * @property integer $id
 * @property integer $id_rkt
 * @property integer $bulan
 * @property integer $tahun
 */
class RktBulan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rkt_bulan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_rkt, bulan, tahun', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_rkt, bulan, tahun', 'safe', 'on'=>'search'),
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
						'id_rkt'=>Yii::t('app','Id Rkt'),
						'bulan'=>Yii::t('app','Bulan'),
						'tahun'=>Yii::t('app','Tahun Mulai'),
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
		$criteria->compare('bulan',$this->bulan);
		$criteria->compare('tahun',$this->tahun);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RktBulan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
         public function getByRktId($rktId)
        {
                $query = "SELECT r.*,IFNULL((SELECT m.bulan FROM master_bulan m WHERE m.id=r.bulan),0)AS namaBulan 
                                FROM rkt_bulan r WHERE r.id_rkt=".$rktId." ORDER BY r.tahun, r.bulan ASC;";

                $categorylist=Yii::app()->db->createCommand($query)->queryAll();

                $result;
                foreach($categorylist as $data)
                {
                    $result[$data['bulan']] = $data['tahun'].' | '.$data['namaBulan'];
                }
                return $result;
        }
        
        public function getListBulanByRktId($rktId)
        {
                $query = "SELECT r.* ,
                                ifnull((select b.bulan from master_bulan as b where b.id=r.bulan),'')as namabulan,
                                ifnull((select k.nomor_sk from rkt as k where k.id=r.id_rkt),'')as rkt
                                FROM rkt_bulan r WHERE r.id_rkt=".$rktId." ORDER BY r.tahun, r.bulan ASC;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

        
                return $result;
        }
        
        
        public function getList4Absen($rktId)
        {
                $query = "SELECT r.*,
                            ifnull((select b.bulan from rkt_bulan as b where b.bulan=r.id and id_rkt=".$rktId." ),'0')as bulanlaporan,
                            ifnull((select b.status from rkt_bulan as b where b.bulan=r.id and id_rkt=".$rktId." ),'0')as statuslaporan
                            FROM master_bulan r ORDER BY r.id ASC;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

        
                return $result;
        }
        
         public function updateStatusApproval($rktId, $bulan)
        {
                $query = "UPDATE rkt_bulan set status=1 where id_rkt=".$rktId." AND bulan=".$bulan;

                $result=Yii::app()->db->createCommand($query)->execute();;

//                print_r($result);
//                                exit(1);
                
                return $result;
        } 
        
        public function getMaxBulanByRktId($rktId)
        {
                $query = "SELECT max(bulan)as bulan FROM rkt_bulan WHERE id_rkt=".$rktId." ORDER BY tahun, bulan ASC;";

                $result=Yii::app()->db->createCommand($query)->queryAll();

                return $result;
        }
        
        public function isExistBulanByRktId($rktId,$tahun,$bulan){
                $query = "SELECT COUNT(id)as isexist FROM rkt_bulan WHERE id_rkt=".$rktId." AND bulan=".$bulan." AND tahun=".$tahun.";";

                $isExist = Yii::app()->db->createCommand($query)->queryAll();
                
//                    print_r($isExist);
//                                exit(1);
                
                                
                if($isExist){
                    $isExist = $isExist['0'];
                    if($isExist['isexist'] > 0){
                       return 1; 
                    }
                    else {
                        return 0;
                    }
                }else {
                    return 0;
                }
        }
        
        public function getByRktTahunAndBulan($rktId, $tahun, $bulan){
            $query = "SELECT * FROM rkt_bulan WHERE id_rkt=".$rktId." AND bulan=".$bulan." AND tahun=".$tahun.";";

            $tmpResult = Yii::app()->db->createCommand($query)->queryAll();
            $result=null;
            
            if($tmpResult){
                $result=$tmpResult['0'];
            }
                
            return $result;
        }
        
        public function updateRktBulan($rktId, $tahun, $bulan){
                if($this->isExistBulanByRktId($rktId, $tahun, $bulan) == 0){
                        $mRktBulan = new RktBulan();
                        $mRktBulan->bulan = $bulan;
                        $mRktBulan->tahun = $tahun;
                        $mRktBulan->id_rkt = $rktId;
                        $mRktBulan->status = 0;
                        $mRktBulan->save();                        
                }            
                
        }
}
