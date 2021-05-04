<?php

/**
 * This is the model class for table "perusahaan_cabang".
 *
 * The followings are the available columns in table 'perusahaan_cabang':
 * @property string $id_cabang
 * @property integer $perusahaan_id
 * @property string $nama_cabang
 * @property string $alamat
 * @property string $provinsi
 * @property string $kabupaten
 * @property string $kode_pos
 * @property string $telepon
 * @property string $email
 * @property string $website
 * @property string $kontak
 * @property string $telepon_kontak
 * @property string $email_kontak
 *
 * The followings are the available model relations:
 * @property Kabupaten $kabupaten0
 * @property Perusahaan $perusahaan
 * @property Provinsi $provinsi0
 */
class PerusahaanCabang extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'perusahaan_cabang';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('perusahaan_id, nama_cabang, alamat, provinsi, kabupaten', 'required'),
            array('perusahaan_id', 'numerical', 'integerOnly' => true),
            array('nama_cabang, telepon, email, website, kontak, telepon_kontak, email_kontak', 'length', 'max' => 50),
            array('alamat', 'length', 'max' => 100),
            array('provinsi', 'length', 'max' => 2),
            array('kabupaten', 'length', 'max' => 4),
            array('kode_pos', 'length', 'max' => 7),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id_cabang, perusahaan_id, nama_cabang, alamat, provinsi, kabupaten, kode_pos, telepon, email, website, kontak, telepon_kontak, email_kontak', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'kabupatenCabang' => array(self::BELONGS_TO, 'Kabupaten', 'kabupaten'),
            'perusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'perusahaan_id'),
            'provinsiCabang' => array(self::BELONGS_TO, 'Provinsi', 'provinsi'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id_cabang' => 'Id Cabang',
            'perusahaan_id' => 'Perusahaan',
            'nama_cabang' => 'Nama Cabang',
            'alamat' => 'Alamat',
            'provinsi' => 'Provinsi',
            'kabupaten' => 'Kabupaten',
            'kode_pos' => 'Kode Pos',
            'telepon' => 'Telepon',
            'email' => 'Email',
            'website' => 'Website',
            'kontak' => 'PIC',
            'telepon_kontak' => 'Telepon PIC',
            'email_kontak' => 'Email PIC',
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

        $criteria->compare('id_cabang', $this->id_cabang, true);
        $criteria->compare('perusahaan_id', $this->perusahaan_id);
        $criteria->compare('nama_cabang', $this->nama_cabang, true);
        $criteria->compare('alamat', $this->alamat, true);
        $criteria->compare('provinsi', $this->provinsi, true);
        $criteria->compare('kabupaten', $this->kabupaten, true);
        $criteria->compare('kode_pos', $this->kode_pos, true);
        $criteria->compare('telepon', $this->telepon, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('kontak', $this->kontak, true);
        $criteria->compare('telepon_kontak', $this->telepon_kontak, true);
        $criteria->compare('email_kontak', $this->email_kontak, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PerusahaanCabang the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
