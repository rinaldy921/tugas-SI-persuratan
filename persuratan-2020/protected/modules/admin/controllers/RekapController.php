<?php

//error_reporting(E_ALL);

class RekapController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'test', 'export'),
                'users' => array(Yii::app()->user->adminRole()),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionExport($tahun = '', $provinsi = '') {


        require_once 'libraries/PHPExcel.php';

        $model = RumusPenilaianKinerja::getRekapAdmin($provinsi, $tahun);
        //debug($model);
        $excel = new PHPExcel();

        $export = new ExcellHelper($excel, 'Rekap Kinerja Perusahaan');

        $excel->getActiveSheet()->mergeCells('B1:AA2');

        $export->customColumn([
            'B1' => 'Rekap Kinerja Perusahaan Tahun ' . $tahun
        ]);

        $excel->getActiveSheet()->mergeCells('B3:B5');
        $export->customColumn([
            'B3' => 'No'
        ]);

        $excel->getActiveSheet()->mergeCells('C3:C5');
        $export->customColumn([
            'C3' => 'Nama Perusahaan'
        ]);

        $excel->getActiveSheet()->mergeCells('D3:D5');
        $export->customColumn([
            'D3' => 'Provinsi'
        ]);

        $excel->getActiveSheet()->mergeCells('E3:E5');
        $export->customColumn([
            'E3' => 'Investasi'
        ]);

        $excel->getActiveSheet()->mergeCells('F3:F5');
        $export->customColumn([
            'F3' => 'Tenaga Kerja'
        ]);
        
        $excel->getActiveSheet()->mergeCells('G3:H4');
        $export->customColumn([
            'G3' => 'SK Izin'
        ]);
        
        $excel->getActiveSheet()->mergeCells('I3:J4');
        $export->customColumn([
            'I3' => 'Progres Tata Batas'
        ]);

        $excel->getActiveSheet()->mergeCells('K3:L4');
        $export->customColumn([
            'K3' => 'SK RKU'
        ]);


        $excel->getActiveSheet()->mergeCells('M3:T3');
        $export->customColumn([
            'M3' => 'RKT'
        ]);


        $excel->getActiveSheet()->mergeCells('M4:N4');
        $export->customColumn([
            'M4' => 'SK'
        ]);


        $excel->getActiveSheet()->mergeCells('O4:Q4');
        $export->customColumn([
            'O4' => 'Produksi'
        ]);

        $excel->getActiveSheet()->mergeCells('R4:T4');
        $export->customColumn([
            'R4' => 'Penanaman'
        ]);


        $excel->getActiveSheet()->mergeCells('U3:W4');
        $export->customColumn([
            'U3' => 'Sertifikasi PHPL'
        ]);

        $excel->getActiveSheet()->mergeCells('X3:Z4');
        $export->customColumn([
            'X3' => 'Sertifikasi VLK'
        ]);

        $excel->getActiveSheet()->mergeCells('AA3:AA5');
        $export->customColumn([
            'AA3' => 'Evaluasi Kinerja'
        ]);

        $styleHead = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('bold' => true, 'size' => 20)
        );
        $excel->getActiveSheet()->getStyle("B1")->applyFromArray($styleHead);

        $style1 = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),
            'font' => array('bold' => true)
        );
        $excel->getActiveSheet()->getStyle("B3:AA5")->applyFromArray($style1);

        $excel->getActiveSheet()->freezePane('A6');        

        $export->setRows([
            'col' => 'B', 'row' => 5], $model, [
            'nama_perusahaan' => 'Nama Perusahaan',
            'provinsi' => 'Provinsi',
            'investasi' => 'Investasi',
            'jml_naker' => 'Tenaga Kerja',
            'no_sk_izin' => 'Nomor SK',
            'luas_izin' => 'Luas',
            'tanggal_tb' => 'Tanggal',
            'progres_tb' => 'Progres',    
            'sk_rku' => 'No.SK',
            'tgl_sk_rku' => 'Tgl SK',
            'no_sk_rkt' => 'No.SK',
            'tgl_sk_rkt' => 'Tgl.SK',
            'target_produksi' => 'Target',
            'realisasi_produksi' => 'Realisasi',
            'persentase_produksi' => 'Persentase',
            'target_penanaman' => 'Target',
            'realisasi_penanaman' => 'Realisasi',
            'persentase_penanaman' => 'Persentase',
            'tahun_phpl' => 'Tahun',
            'predikat_phpl' => 'Predikat',
            'berakhir_phpl' => 'Berakhir',
            'tahun_vlk' => 'Tahun',
            'predikat_vlk' => 'Predikat',
            'berakhir_vlk' => 'Berakhir',
            'evaluasi' => 'Evaluasi Kinerja',
        ]);
        /* $export->addTotalColumn($rows, 4, [
          'J' => 'tot_debet',
          'K' => 'tot_kredit'
          ]); */
        //debug($export);

        $export->doExport('Laporan Kinerja Perusahaan ' . $tahun . '.xls');
        //exit();
        //die('test');
        Yii::app()->end();

        //spl_autoload_register(array('YiiBase','autoload'));
    }

    public function actionIndex() {
        if (isset($_POST['Provinsi']) && $_POST['Provinsi']['tahun'] !== '') {
            $provinsi = $_POST['Provinsi']['provinsi'];
            $tahun = $_POST['Provinsi']['tahun'];
        } else {
            $provinsi = '';
            $tahun = date('Y');
        }
        $model = RumusPenilaianKinerja::getRekapAdmin($provinsi, $tahun);
        //debug($model);
        //die('test');
        $data = new CArrayDataProvider($model, array(
            // 'keyField'=>false,
            'pagination' => false
        ));
        //debug($data);
        //$tahun = date('Y');



        /*
          if (isset($_POST['Provinsi']) && $_POST['Provinsi']['tahun'] == '') {
          $que = array();
          $tahun = null;
          $data = new CArrayDataProvider($que, array(
          // 'keyField'=>false,
          'pagination' => false
          ));

          if (Yii::app()->request->isAjaxRequest) {
          $this->renderPartial('index2', array(
          'model' => $data,
          'tahun' => $tahun
          ));
          Yii::app()->end();
          }
          }
         */

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('index2', array(
                'model' => $data,
                'tahun' => $tahun
            ));
            Yii::app()->end();
        }

        $this->render('index', array(
            'model' => $data,
            '_tahun' => $tahun,
            '_provinsi' => $provinsi
        ));
    }

}
