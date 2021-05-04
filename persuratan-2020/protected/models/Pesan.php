<?php

/**
 * This is the model class for table "t_pesan".
 *
 * The followings are the available columns in table 't_pesan':
 * @property integer $id
 * @property string $subyek
 * @property integer $perusahaan_id
 * @property string $isi
 * @property integer $status
 * @property string $tgl_kirim
 * @property integer $tipe
 */
class Pesan extends CActiveRecord
{
        public $penerima_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_pesan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, tipe, status_baca', 'numerical', 'integerOnly'=>true),
			array('subyek', 'length', 'max'=>150),
                        array('file_lampiran', 'length', 'max'=>255),
                        array('penerima', 'length', 'max'=>255),
			array('isi, tgl_kirim, tgl_ubah', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, subyek, perusahaan_id, isi, status, tgl_kirim, tipe', 'safe', 'on'=>'search'),
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
                    'idPenerima' => array(self::BELONGS_TO, 'AppUsers', 'penerima'),
		    'idPengirim' => array(self::BELONGS_TO, 'AppUsers', 'pengirim'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
						'id'=>Yii::t('app','ID'),
						'subyek'=>Yii::t('app','Subyek'),
						'penerima'=>Yii::t('app','Penerima'),
						'isi'=>Yii::t('app','Isi'),
						'status'=>Yii::t('app','Status Pengiriman'),
                                                'file_lampiran'=>Yii::t('app','Upload File Lampiran'),
						'tgl_kirim'=>Yii::t('app','Tgl Kirim'),
                                                'tgl_ubah'=>Yii::t('app','Tgl Ubah'),
						'tipe'=>Yii::t('app','Jenis Surat'),
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
		$criteria->compare('subyek',$this->subyek,true);
		$criteria->compare('penerima',$this->penerima);
		$criteria->compare('isi',$this->isi,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('tgl_kirim',$this->tgl_kirim,true);
		$criteria->compare('tipe',$this->tipe);
                $criteria->compare('pengirim',$this->pengirim);
                
                               
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        
         public function getInbox($penerima)
        {
                $query = "SELECT t.*,"
                        . "IFNULL((SELECT p.nama_user FROM app_users p WHERE p.id = t.pengirim),'')AS pengirimpesan"
                        . " FROM t_pesan t WHERE  t.penerima LIKE '%".$penerima."%'";

                $categorylist=Yii::app()->db->createCommand($query)->queryAll();
                
                $result;
                $index=0;
                
                foreach($categorylist as $data)
                {
                    $arrPenerima = explode(',', $data['penerima']);
                    foreach($arrPenerima as $p){
                        if($p == $penerima){
                            $result[$index]['id']=$data['id'];
                            $result[$index]['subyek']=$data['subyek'];
                            $result[$index]['isi']=$data['isi'];
                            $result[$index]['status_baca']=$data['status_baca'];
                            $result[$index]['tgl_kirim']=$data['tgl_kirim'];
                            //$result[$index]['tipe']=$data['tipe'];
                            if($data['tipe']==1){
                                $result[$index]['tipe'] = "Surat Himbauan";
                            }
                            elseif($data['tipe']==2){
                                $result[$index]['tipe'] = "Surat Peringatan";
                            }
                            else{
                                $result[$index]['tipe'] = "Surat Teguran";
                            }
                                
                            $result[$index]['pengirim']=$data['pengirimpesan'];
                            $result[$index]['file_lampiran']=$data['file_lampiran'];
                            $result[$index]['penerima']=$penerima;
                        }
                    }   
                    $index++;
                }
                
                
            $dataProvider=new CArrayDataProvider($result, array(
                'id'=>'iuphhk', //this is an identifier for the array data provider
                'sort'=>false,
                'keyField'=>'id', //this is what will be considered your key field
                'pagination'=>array(
                    'pageSize'=>30, //eureka! you can configure your pagination from here
                ),
            ));
            
            
               
          //     print_r("<pre>");print_r($dataProvider);print_r("</pre>"); die();
                 
                 
                return $dataProvider;
        }
        
        
        
        public function getOutbox($pengirim)
        {
            
                $query = "SELECT t.*,"
                        . "IFNULL((SELECT p.nama_user FROM app_users p WHERE p.id= t.pengirim),'')AS pengirimpesan"
                        . " FROM t_pesan t WHERE t.pengirim=".$pengirim;
                
  
                $categorylist=Yii::app()->db->createCommand($query)->queryAll();
                
                 
                $result;
                $index=0; $index2=0;
               
                 
                 
                foreach($categorylist as $data)
                {
                                $userPenerima = AppUsers::model()->findByAttributes(array('id_perusahaan'=>$data['penerima']));
                                 
                                
                                $result[$index]['id']=$data['id'];
                                $result[$index]['subyek']=$data['subyek'];
                                $result[$index]['isi']=$data['isi'];
                                $result[$index]['status_baca']=$data['status_baca'];
                                $result[$index]['tgl_kirim']=$data['tgl_kirim'];
                               // $result[$index]['tipe']=$data['tipe'];
                                
                                if($data['tipe']==1){
                                    $result[$index]['tipe'] = "Surat Himbauan";
                                }
                                elseif($data['tipe']==2){
                                    $result[$index]['tipe'] = "Surat Peringatan";
                                }
                                else{
                                    $result[$index]['tipe'] = "Surat Teguran";
                                }
                                
                                $result[$index]['pengirim']=$data['pengirimpesan'];
                                $result[$index]['file_lampiran']=$data['file_lampiran'];

                                $result[$index]['penerima']=$userPenerima->nama_user;
                             
                    $index++;
                }
                //   print_r("<pre>");print_r($result);print_r("</pre>"); die();
                              
                
                
                
            $dataProvider=new CArrayDataProvider($result, array(
                'id'=>'iuphhk', //this is an identifier for the array data provider
                'sort'=>false,
                'keyField'=>'id', //this is what will be considered your key field
                'pagination'=>array(
                    'pageSize'=>30, //eureka! you can configure your pagination from here
                ),
            ));
            
            
               
             //  print_r("<pre>");print_r($dataProvider);print_r("</pre>"); die();
                 
                 
                return $dataProvider;
        }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pesan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
         public function getDetail($idPesan)
        {
            
                $query = "SELECT 
                            IFNULL((SELECT u.nama_user FROM app_users u WHERE u.id=p.pengirim),'')AS namapengirim,
                            IFNULL((SELECT u.nama_user FROM app_users u WHERE u.id_perusahaan = p.penerima),'')AS namapenerima,
                            p.subyek,p.isi,p.tipe,ifnull((p.file_lampiran),'')as file_lampiran,p.status_baca, p.penerima, p.pengirim,
                            p.tgl_kirim
                            FROM t_pesan p
                            WHERE p.id =".$idPesan;
                
  
                $result=Yii::app()->db->createCommand($query)->queryAll();
                
                return $result['0'];
        
        }
}
