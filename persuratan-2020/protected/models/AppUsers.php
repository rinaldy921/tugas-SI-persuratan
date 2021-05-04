<?php

/**
 * This is the model class for table "app_users".
 *
 * The followings are the available columns in table 'app_users':
 * @property integer $id
 * @property integer $id_role
 * @property integer $id_perusahaan
 * @property string $nama_user
 * @property string $username
 * @property string $password
 * @property string $last_login
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Perusahaan $idPerusahaan
 * @property AppRole $idRole
 */
class AppUsers extends CActiveRecord {

    public $password_repeat;
    public $new_password;
    public $old_password;
    public $jenis_form;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'app_users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_role, nama_user, username', 'required'),
            array('id_perusahaan','cekidot'),
            array('password', 'required', 'on' => 'insert'),
            array('id_role, id_perusahaan', 'numerical', 'integerOnly' => true),
            array('nama_user, no_hp', 'length', 'max' => 100),
            array('username', 'length', 'max' => 50),
            array('password, old_password', 'length', 'max' => 255),
            array('password_repeat', 'compare', 'compareAttribute' => 'password', 'on'=>'update'),
            array('username', 'ECompositeUniqueValidator', 'attributeNames' => 'username'),

            array('old_password', 'required', 'on' => 'updatePass'),
            array('old_password', 'validOldPass', 'on' => 'updatePass'),
            array('password_repeat', 'compare', 'compareAttribute' => 'new_password', 'on'=>'updatePass'),

            array('created_at', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => FALSE, 'on' => 'insert'),
            array('modified_at', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => FALSE, 'on' => 'update'),
            array('new_password, id_bphp, id_propinsi', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_bphp, id_propinsi, id, id_role, id_perusahaan, nama_user, username, password, last_login, created_at, modified_at', 'safe', 'on' => 'search'),
        );
    }

    public function cekidot($attribute, $params)
    {
        if ($this->id_role == '2') {
            $ev = CValidator::createValidator('required', $this, $attribute, $params);
            $ev->validate($this);
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
            'idRole' => array(self::BELONGS_TO, 'AppRole', 'id_role'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'id_role' => 'Role',
            'id_perusahaan' => 'Nama Perusahaan',
            'nama_user' => 'Nama Perusahaan/User',
            'username' => 'Username',
            'password' => 'Password',
            'new_password' => 'Password Baru',
            'old_password' => 'Password Lama',
            'password_repeat' => Yii::t('view', 'Ulangi Password'),
            'last_login' => 'Last Login',
            'created_at' => 'Created At',
            'modified_at' => 'Modified At',
            'id_bphp' => 'BPHP',
            'id_propinsi' => 'Dishut Provinsi',
            'no_hp' => 'No Hp',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('id_role', $this->id_role);
        $criteria->compare('id_perusahaan', $this->id_perusahaan);
        $criteria->compare('nama_user', $this->nama_user, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('last_login', $this->last_login, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('no_hp', $this->no_hp, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AppUsers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave(){
        if ($this->isNewRecord) {
            $this->password = $this->hashPassword($this->password);
        }else{
            if($this->scenario != 'updatePass'){
                if($this->scenario == 'updateProfile'){
                    //do nothin
                    return parent::beforeSave();
                }
                elseif(!$this->password == NULL && !empty($this->password)){
                    $this->password = $this->hashPassword($this->password);
                }else {
                    $this->password = $this->old_password;
                    
                }
            }else{
                $this->password = $this->hashPassword($this->password_repeat);
            }
        }
        return parent::beforeSave();
    }

    public function validatePassword($password) {
        return CPasswordHelper::verifyPassword($password, $this->password);
    }

    /**
     * Generates the password hash.
     * @param string password
     * @return string hash
     */
    public static function hashPassword($password) {
        return CPasswordHelper::hashPassword($password);
    }

    public function lastLoginByParams($params){
        $record = AppUsers::model()->findByAttributes($params);
        $_last_login = date('Y-m-d');
        if(!empty($record->last_login) && strlen($record->last_login)){
            $_last_login = $record->last_login;
        }
        $last_login = new DateTime($_last_login);
        $date_login = new DateTime(date('Y-m-d'));
        $interval = date_diff($last_login, $date_login);
        return array(
            'last_login'=>$_last_login,
            'interval'=>$interval
        );
    }

    public function validOldPass($attribute, $params)
    {
        if(!$this->validatePassword($this->$attribute)){
            $this->addError($attribute, 'Password tidak sama dengan password sebelumya');
        }
    }
   
    
     public function getByAdmin()
    {
            $query = "SELECT s.id_perusahaan, s.nama_user FROM app_users s WHERE s.id_perusahaan IN (SELECT distinct p.id_perusahaan FROM iuphhk_adm_pemerintahan p)";
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
         
            $category_array;
            foreach($categorylist as $data)
            {
                $category_array[$data['id_perusahaan']]=$data['nama_user'];
            }
            return $category_array;
    }
    
    
    
    public function getByPropinsi($propinsiId)
    {
            $query = "SELECT s.id_perusahaan, s.nama_user FROM app_users s WHERE s.id_perusahaan IN (SELECT p.id_perusahaan FROM iuphhk_adm_pemerintahan p WHERE p.provinsi=".$propinsiId.")";
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
         
            $category_array;
            foreach($categorylist as $data)
            {
                $category_array[$data['id_perusahaan']]=$data['nama_user'];
            }
            return $category_array;
    }
    
    public function getByBphp($bphpId)
    {
            $query = "
                        SELECT s.id_perusahaan, s.nama_user FROM app_users s WHERE s.id_perusahaan IN (SELECT p.id_perusahaan FROM iuphhk_adm_pemerintahan p WHERE p.provinsi 
                        IN (SELECT id_provinsi FROM bphp_wilayah_kerja WHERE id_master_bphp=".$bphpId."))";
        
            $categorylist=Yii::app()->db->createCommand($query)->queryAll();
         
            $category_array;
            foreach($categorylist as $data)
            {
                $category_array[$data['id_perusahaan']]=$data['nama_user'];
            }
            return $category_array;
    }
    

}
