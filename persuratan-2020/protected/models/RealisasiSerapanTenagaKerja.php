<?php

/**
 * This is the model class for table "realisasi_serapan_tenaga_kerja".
 *
 * The followings are the available columns in table 'realisasi_serapan_tenaga_kerja':
 * @property integer $id
 * @property integer $id_perusahaan
 * @property integer $id_rkt
 * @property string $tahun
 * @property integer $id_bulan
 * @property string $is_tenaga_kehutanan
 * @property string $is_tenaga_tetap
 * @property integer $id_pendidikan
 * @property integer $jumlah
 *
 * The followings are the available model relations:
 * @property Perusahaan $idPerusahaan
 * @property MasterBulan $idBulan
 * @property Rkt $idRkt
 * @property MasterPendidikan $idPendidikan
 */
class RealisasiSerapanTenagaKerja extends CActiveRecord {

    public $id_rkt;
    public $sd_sekarang;
    public $sd_bulan_lalu;
    public $bulan_lalu;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'realisasi_serapan_tenaga_kerja';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_perusahaan, id_bulan, is_tenaga_tetap', 'required'),
            array('id_perusahaan, id_rkt, id_bulan, id_pendidikan, jumlah', 'numerical', 'integerOnly' => true),
            array('tahun', 'length', 'max' => 4),
            array('is_tenaga_kehutanan, is_tenaga_tetap', 'length', 'max' => 1),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_perusahaan, id_rkt, tahun, id_bulan, is_tenaga_kehutanan, is_tenaga_tetap, id_pendidikan, jumlah', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idPerusahaan' => array(self::BELONGS_TO, 'Perusahaan', 'id_perusahaan'),
            'idBulan' => array(self::BELONGS_TO, 'MasterBulan', 'id_bulan'),
            'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
            'idPendidikan' => array(self::BELONGS_TO, 'MasterPendidikan', 'id_pendidikan'),
            'idKewarganegaraan' => array(self::BELONGS_TO, 'MasterJenisKewarganegaraan', 'id_jenis_kewarganegaraan')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => Yii::t('app', 'ID'),
            'id_perusahaan' => Yii::t('app', 'Id Perusahaan'),
            'id_rkt' => Yii::t('app', 'Id Rkt'),
            'tahun' => Yii::t('app', 'Tahun'),
            'id_bulan' => Yii::t('app', 'Id Bulan'),
            'is_tenaga_kehutanan' => Yii::t('app', 'Tenaga Kehutanan'),
            'is_tenaga_tetap' => Yii::t('app', 'Is Tenaga Tetap'),
            'id_pendidikan' => Yii::t('app', 'Pendidikan'),
            'jumlah' => Yii::t('app', 'Jumlah'),
            'id_jenis_kewarganegaraan' => 'Kewarganegaraan'
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
        $criteria->compare('id_perusahaan', $this->id_perusahaan);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('tahun', $this->tahun, true);
        $criteria->compare('id_bulan', $this->id_bulan);
        $criteria->compare('is_tenaga_kehutanan', $this->is_tenaga_kehutanan, true);
        $criteria->compare('is_tenaga_tetap', $this->is_tenaga_tetap, true);
        $criteria->compare('id_pendidikan', $this->id_pendidikan);
        $criteria->compare('id_jenis_kewarganegaraan', $this->id_jenis_kewarganegaraan);
        $criteria->compare('jumlah', $this->jumlah);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RealisasiSerapanTenagaKerja the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByRktTetap($tetap = 1) {
        $criteria = new CDbCriteria;
        $criteria->select = array(
            't.is_tenaga_kehutanan',
            't.is_tenaga_tetap',
            't.id_jenis_kewarganegaraan',
            't.jumlah',
            'IFNULL(SUM(bulan_lalu.jumlah), COALESCE( (
					SELECT SUM(b.jumlah)
					from
					realisasi_serapan_tenaga_kerja b
					where
					b.id_rkt = t.id_rkt AND
					b.is_tenaga_tetap = t.is_tenaga_tetap AND
					b.is_tenaga_kehutanan = t.is_tenaga_kehutanan AND
					b.id_jenis_kewarganegaraan = t.id_jenis_kewarganegaraan AND
					b.tahun = t.tahun AND
					b.id_bulan = (t.id_bulan-1)
				), 0)
			) as bulan_lalu',
        );
        $criteria->with = array('idRkt', 'idPendidikan', 'idKewarganegaraan');
        $criteria->compare('idRkt.id', $this->id_rkt);
        $criteria->compare('t.id_bulan', $this->id_bulan);
        $criteria->compare('t.tahun', $this->tahun);
        $criteria->compare('t.id_perusahaan', $this->id_perusahaan);
        $criteria->compare('t.is_tenaga_tetap', $tetap);
        $criteria->join = 'LEFT JOIN ' . $this->tableName() . ' bulan_lalu ON
		 	bulan_lalu.id_rkt = t.id_rkt AND
			bulan_lalu.is_tenaga_tetap = t.is_tenaga_tetap AND
			bulan_lalu.is_tenaga_kehutanan = t.is_tenaga_kehutanan AND
			bulan_lalu.id_pendidikan = t.id_pendidikan AND
			bulan_lalu.id_jenis_kewarganegaraan = t.id_jenis_kewarganegaraan AND
			bulan_lalu.tahun = t.tahun AND
			bulan_lalu.id_bulan = (t.id_bulan-1)
			';

        $criteria->group = 't.id_rkt, t.id_jenis_kewarganegaraan, t.is_tenaga_kehutanan, t.id_pendidikan ';
        $criteria->order = 't.id_jenis_kewarganegaraan ASC, t.is_tenaga_kehutanan, t.id_pendidikan';
//CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)
        // echo "<pre>";
        // var_dump($criteria);die();
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByRkt() {
        // $criteria=new CDbCriteria;
        // $criteria->select = array(
        // 	't.jumlah',
        // 	'COALESCE(SUM(bulan_lalu.jumlah), 0) AS sd_bulan_lalu',
        // );
        // $criteria->with = array('idRkt','idPendidikan');
        // $criteria->compare('idRkt.id',$this->id_rkt);
        // $criteria->compare('t.id_bulan',$this->id_bulan);
        // $criteria->compare('t.tahun',$this->tahun);
        // $criteria->compare('t.id_perusahaan',$this->id_perusahaan);
        // $criteria->join = 'LEFT JOIN '. $this->tableName() .' bulan_lalu ON
        //  	bulan_lalu.id_rkt = t.id_rkt AND
        // 	CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)';
        //
		//
		// $criteria->group = 't.id_rkt, t.id_pendidikan';
        //
		// echo "<pre>";
        // var_dump($criteria);die();
        // return new CActiveDataProvider($this, array(
        // 	'criteria'=>$criteria,
        // ));

        $model_pendidikan = MasterPendidikan::model()->findAll();
        $rawData = [];
        $index = 0;
        foreach ($model_pendidikan as $kp => $vp) {
            $i = 1;
            $sql = "
				SELECT
					p.pendidikan,
					t.jumlah as jumlah_" . $i . ",
					COALESCE(SUM(bulan_lalu.jumlah), 0) AS bulan_lalu_" . $i . "
				FROM
					realisasi_serapan_tenaga_kerja AS t
					INNER JOIN master_pendidikan AS p ON p.id_pendidikan = t.id_pendidikan
					LEFT JOIN realisasi_serapan_tenaga_kerja AS bulan_lalu ON
					bulan_lalu.id_rkt = t.id_rkt AND
					bulan_lalu.is_tenaga_tetap = t.is_tenaga_tetap AND
					bulan_lalu.is_tenaga_kehutanan = t.is_tenaga_kehutanan AND
					bulan_lalu.id_pendidikan = t.id_pendidikan AND
					CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)
				WHERE
					t.id_rkt 	          = :id_rkt AND
					t.id_perusahaan       = :id_perusahaan AND
				    t.tahun 		      = :tahun AND
				    t.id_bulan            = :bulan AND
					t.is_tenaga_tetap     = '1' AND
					t.is_tenaga_kehutanan = '1' AND
					t.id_pendidikan       = :id_pendidikan
				GROUP BY t.id_rkt, t.id_pendidikan
			";
            $query = Yii::app()->db->createCommand($sql);
            $query->params = array(
                ':id_rkt' => $this->id_rkt,
                ':id_perusahaan' => $this->id_perusahaan,
                ':tahun' => $this->tahun,
                ':bulan' => $this->id_bulan,
                ':id_pendidikan' => $vp->id_pendidikan
            );
            $row = $query->queryRow();
            $rawData[$index] = $row;
            $i++;

            $sql = "
				SELECT
					p.pendidikan,
					t.jumlah as jumlah_" . $i . ",
					COALESCE(SUM(bulan_lalu.jumlah), 0) AS bulan_lalu_" . $i . "
				FROM
					realisasi_serapan_tenaga_kerja AS t
					INNER JOIN master_pendidikan AS p ON p.id_pendidikan = t.id_pendidikan
					LEFT JOIN realisasi_serapan_tenaga_kerja AS bulan_lalu ON
					bulan_lalu.id_rkt = t.id_rkt AND
					bulan_lalu.is_tenaga_tetap = t.is_tenaga_tetap AND
					bulan_lalu.is_tenaga_kehutanan = t.is_tenaga_kehutanan AND
					bulan_lalu.id_pendidikan = t.id_pendidikan AND
					CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)
				WHERE
					t.id_rkt 	          = :id_rkt AND
					t.id_perusahaan       = :id_perusahaan AND
				    t.tahun 		      = :tahun AND
				    t.id_bulan            = :bulan AND
					t.is_tenaga_tetap     = '1' AND
					t.is_tenaga_kehutanan = '0' AND
					t.id_pendidikan       = :id_pendidikan
				GROUP BY t.id_rkt, t.id_pendidikan
			";
            $query = Yii::app()->db->createCommand($sql);
            $query->params = array(
                ':id_rkt' => $this->id_rkt,
                ':id_perusahaan' => $this->id_perusahaan,
                ':tahun' => $this->tahun,
                ':bulan' => $this->id_bulan,
                ':id_pendidikan' => $vp->id_pendidikan
            );
            $row = $query->queryRow();
            $rawData[$index]['jumlah_' . $i] = $row['jumlah_' . $i];
            $rawData[$index]['bulan_lalu_' . $i] = $row['bulan_lalu_' . $i];
            $i++;

            $sql = "
				SELECT
					p.pendidikan,
					t.jumlah as jumlah_" . $i . ",
					COALESCE(SUM(bulan_lalu.jumlah), 0) AS bulan_lalu_" . $i . "
				FROM
					realisasi_serapan_tenaga_kerja AS t
					INNER JOIN master_pendidikan AS p ON p.id_pendidikan = t.id_pendidikan
					LEFT JOIN realisasi_serapan_tenaga_kerja AS bulan_lalu ON
					bulan_lalu.id_rkt = t.id_rkt AND
					bulan_lalu.is_tenaga_tetap = t.is_tenaga_tetap AND
					bulan_lalu.is_tenaga_kehutanan = t.is_tenaga_kehutanan AND
					bulan_lalu.id_pendidikan = t.id_pendidikan AND
					CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)
				WHERE
					t.id_rkt 	          = :id_rkt AND
					t.id_perusahaan       = :id_perusahaan AND
				    t.tahun 		      = :tahun AND
				    t.id_bulan            = :bulan AND
					t.is_tenaga_tetap     = '0' AND
					t.is_tenaga_kehutanan = '1' AND
					t.id_pendidikan       = :id_pendidikan
				GROUP BY t.id_rkt, t.id_pendidikan
			";
            $query = Yii::app()->db->createCommand($sql);
            $query->params = array(
                ':id_rkt' => $this->id_rkt,
                ':id_perusahaan' => $this->id_perusahaan,
                ':tahun' => $this->tahun,
                ':bulan' => $this->id_bulan,
                ':id_pendidikan' => $vp->id_pendidikan
            );
            $row = $query->queryRow();
            $rawData[$index]['jumlah_' . $i] = $row['jumlah_' . $i];
            $rawData[$index]['bulan_lalu_' . $i] = $row['bulan_lalu_' . $i];
            $i++;

            $sql = "
				SELECT
					p.pendidikan,
					t.jumlah as jumlah_" . $i . ",
					COALESCE(SUM(bulan_lalu.jumlah), 0) AS bulan_lalu_" . $i . "
				FROM
					realisasi_serapan_tenaga_kerja AS t
					INNER JOIN master_pendidikan AS p ON p.id_pendidikan = t.id_pendidikan
					LEFT JOIN realisasi_serapan_tenaga_kerja AS bulan_lalu ON
					bulan_lalu.id_rkt = t.id_rkt AND
					bulan_lalu.is_tenaga_tetap = t.is_tenaga_tetap AND
					bulan_lalu.is_tenaga_kehutanan = t.is_tenaga_kehutanan AND
					bulan_lalu.id_pendidikan = t.id_pendidikan AND
					CAST(CONCAT(bulan_lalu.tahun,LPAD(bulan_lalu.id_bulan, 2, 0)) AS UNSIGNED) < CAST(CONCAT(t.tahun,LPAD(t.id_bulan, 2, 0)) AS UNSIGNED)
				WHERE
					t.id_rkt 	          = :id_rkt AND
					t.id_perusahaan       = :id_perusahaan AND
				    t.tahun 		      = :tahun AND
				    t.id_bulan            = :bulan AND
					t.is_tenaga_tetap     = '0' AND
					t.is_tenaga_kehutanan = '0' AND
					t.id_pendidikan       = :id_pendidikan
				GROUP BY t.id_rkt, t.id_pendidikan
			";
            $query = Yii::app()->db->createCommand($sql);
            $query->params = array(
                ':id_rkt' => $this->id_rkt,
                ':id_perusahaan' => $this->id_perusahaan,
                ':tahun' => $this->tahun,
                ':bulan' => $this->id_bulan,
                ':id_pendidikan' => $vp->id_pendidikan
            );
            $row = $query->queryRow();
            $rawData[$index]['jumlah_' . $i] = $row['jumlah_' . $i];
            $rawData[$index]['bulan_lalu_' . $i] = $row['bulan_lalu_' . $i];
            $i++;
            $index++;
        }

        // echo "<pre>";
        // print_r($rawData);
        // die();
        $provider = new CArrayDataProvider($rawData, array(
            'keyField' => 'pendidikan',
                // 'sort'=>array(
                //     'attributes'=>array(
                //          'id', 'username', 'email',
                //     ),
                // ),
                // 'pagination'=>array(
                //     'pageSize'=>10,
                // ),
        ));
        // var_dump($provider);die();
        return $provider;
    }

    public function getTotal($records, $colName, $istt) {
        $total = 0;
        // echo "<pre>";
        // print_r($records);

        foreach ($records as $rec) {
            if ($rec->is_tenaga_tetap == $istt) {
                if ($colName == 'jumlah') {
                    $total += $rec->jumlah;
                } else {
                    $total += $rec->$colName;
                }
            }
        }
        return number_format($total, 2, ',', '.');
    }

    public function getTotalPersen($records, $colName) {
        $totalJumlah = 0;
        $totalRealisasi = 0;
        $idx = 0;
        foreach ($records as $rec) {
            $totalJumlah += $rec->jumlah;
            $totalRealisasi += $rec->$colName;
            if ($rec->jumlah > 0) {
                $idx++;
            }
        }
        $subTotal = ($totalRealisasi > 0 ? ($totalRealisasi / $idx) : 0);
        return number_format($subTotal, 2);
    }

}
