<?php

/**
 * This is the model class for table "penilaian_kinerja".
 *
 * The followings are the available columns in table 'penilaian_kinerja':
 * @property string $id
 * @property integer $id_perusahaan
 * @property integer $id_rkt
 * @property string $tahun
 * @property integer $aspek_1
 * @property integer $aspek_2
 * @property integer $aspek_3
 * @property integer $aspek_4
 * @property integer $aspek_5
 * @property integer $aspek_6
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Perusahaan $idPerusahaan
 * @property Rkt $idRkt
 */
class PenilaianKinerja extends CActiveRecord {

    public $nilai_kinerja;
    public $nama_badan;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'penilaian_kinerja';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_perusahaan, id_rkt, aspek_1, aspek_2, aspek_3, aspek_4, aspek_5, aspek_6', 'numerical', 'integerOnly' => true),
            array('tahun', 'length', 'max' => 4),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_perusahaan, id_rkt, tahun, aspek_1, aspek_2, aspek_3, aspek_4, aspek_5, aspek_6, created_at, modified_at', 'safe', 'on' => 'search'),
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
            'idRkt' => array(self::BELONGS_TO, 'Rkt', 'id_rkt'),
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
            'aspek_1' => 'Proses Tata Batas',
            'aspek_2' => 'Persetujuan Rencana Kerja Usaha',
            'aspek_3' => 'Pengesahan RKT/BKT',
            'aspek_4' => 'Ketersediaan Tenaga Teknis Bersertifikat',
            'aspek_5' => 'Realisasi Penanaman',
            'aspek_6' => 'PHPL/SVLK',
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
            'nilai_kinerja' => Yii::t('app', 'Nilai Kinerja'),
            'nama_badan' => 'Nama Perusahaan'
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('id_perusahaan', $this->id_perusahaan);
        $criteria->compare('id_rkt', $this->id_rkt);
        $criteria->compare('tahun', $this->tahun, true);
        $criteria->compare('aspek_1', $this->aspek_1);
        $criteria->compare('aspek_2', $this->aspek_2);
        $criteria->compare('aspek_3', $this->aspek_3);
        $criteria->compare('aspek_4', $this->aspek_4);
        $criteria->compare('aspek_5', $this->aspek_5);
        $criteria->compare('aspek_6', $this->aspek_6);
        $criteria->compare('nilai_kinerja', $this->getKinerja($this->id_perusahaan));
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('modified_at', $this->modified_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination'=>false
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PenilaianKinerja the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getKinerja($id, $id_rkt) {
        $kinerja = PenilaianKinerja::model()->find(array(
            'condition' => 'id_perusahaan=' . $id . ' AND id_rkt = '. $id_rkt
        ));
        return $this->grade($kinerja);
    }

    private function total($id) {
        $model_1 = Kriteria::model()->findByPk($id->aspek_1);
        $model_2 = Kriteria::model()->findByPk($id->aspek_2);
        $model_3 = Kriteria::model()->findByPk($id->aspek_3);
        $model_4 = Kriteria::model()->findByPk($id->aspek_4);
        $model_5 = Kriteria::model()->findByPk($id->aspek_5);
        $model_6 = Kriteria::model()->findByPk($id->aspek_6);

        $total = $model_1->bobot + $model_2->bobot + $model_3->bobot + $model_4->bobot + $model_5->bobot + $model_6->bobot;
        return $total;
    }

    private function grade($id) {
        $nilai = $this->total($id);
        if ($nilai >= 76 AND $nilai <= 100) {
            $mark = 'A';
        } elseif ($nilai >= 50 AND $nilai <= 75) {
            $mark = 'B';
        } elseif ($nilai >= 21 AND $nilai <= 49) {
            $mark = 'C';
        } else {
            $mark = 'D';
        }
        return $mark;
    }

    public function getTanaman($id,$produksiLahan = 'tapok') {
        switch ($produksiLahan) {
            case 'tapok':
                $condition = 'jenis_produksi = "Tanaman Pokok"';
                break;
            case 'tanggul':
                $condition = 'jenis_produksi = "Tanaman Unggulan"';
                break;
            case 'tadup':
                $condition = 'jenis_produksi = "Tanaman Kehidupan"';
                break;
        }
        $prodl = MasterJenisProduksiLahan::model()->find(array('condition'=>$condition));
        $model = RktTanam::model()->findAll(array('group'=>'id_jenis_tanaman','condition'=>'id_rkt = '.$id.' AND id_produksi_lahan = '.$prodl->id));
        if($model) {
            foreach($model as $md) {
                $nama[] = $md->idJenisTanaman->nama_tanaman;
            }
            $hasil = implode(", ",$nama);
        } else {
            $hasil = "-";
        }
        return $hasil;
    }

    // public function getTotalRencana($records, $colName) {
    //     $totalJumlah = 0;
    //     $totalRealisasi = 0;
    //     foreach($records as $rec) {
    //         $totalJumlah += $rec->jumlah;
    //         $totalRealisasi +=$rec->realisasi;
    //     }

    //     $subTotal = $totalRealisasi > 0 ? ($totalRealisasi / $totalJumlah) * 100 : 0 ;
    //     return number_format($subTotal,2,',','.');
    // }

    public function getTotal($records, $colName) {
        $total = 0;
        foreach ($records as $rec)
            $total+=$rec->{$colName};
        // var_dump($total);die;
        return number_format($total,2,",",".");
    }

    public function getTotalRencana($id, $produksiLahan = 'tapok',$col) {
        switch ($produksiLahan) {
            case 'tapok':
                $condition = 'jenis_produksi = "Tanaman Pokok"';
                break;
            case 'tanggul':
                $condition = 'jenis_produksi = "Tanaman Unggulan"';
                break;
            case 'tadup':
                $condition = 'jenis_produksi = "Tanaman Kehidupan"';
                break;
        }
        $prodl = MasterJenisProduksiLahan::model()->find(array('condition'=>$condition));
        $model = RktTanam::model()->findAll(array('condition'=>'id_rkt = '.$id.' AND id_produksi_lahan = '.$prodl->id));
        // var_dump($model);die;
        if($model) {
            $hasil = $this->getTotal($model, $col);
        } else {
            $hasil = '-';
        } 
        return $hasil;
    }

    public function getRencanaProduksi($id, $col) {
        // switch ($produksiLahan) {
        //     case 'tapok':
        //         $condition = 'jenis_produksi = "Tanaman Pokok"';
        //         break;
        //     case 'tanggul':
        //         $condition = 'jenis_produksi = "Tanaman Unggulan"';
        //         break;
        //     case 'tadup':
        //         $condition = 'jenis_produksi = "Tanaman Kehidupan"';
        //         break;
        // }
        // $prodl = MasterJenisProduksiLahan::model()->find(array('condition'=>$condition));
        $model = RktPanenVolumeTanaman::model()->findAll(array('condition'=>'id_rkt = '.$id));
        // var_dump($model);die;
        if($model) {
            $hasil = $this->getTotal($model, $col);
        } else {
            $hasil = '-';
        } 
        return $hasil;
    }

    public function getProduksiTanaman($id) {
        $model = RktPanenVolumeTanaman::model()->findAll(array('group'=>'id_jenis_tanaman','condition'=>'id_rkt = '.$id));
        if($model) {
            foreach($model as $md) {
                $nama[] = $md->idJenisTanaman->nama_tanaman;
            }
            $hasil = implode(", ",$nama);
        } else {
            $hasil = "-";
        }
        return $hasil;
    }
}
