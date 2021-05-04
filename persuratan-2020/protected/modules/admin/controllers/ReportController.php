<?php

class ReportController extends Controller{
 
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
              'actions' => array('index', 'view','datapokok','pilihrku','monevikk','viewmonevikk', 'getidtahunrkt','absensirealisasi',
                                    'pilihrkt','rku','rkt','profil','pilihdaftar','pilihkinerja', 'absensirealisasi', 'tampilabsen',
                                'kinerja','daftar','rkt','gettahunrku','gettahunrkt','getbulanrkt','rktprasyarat','rktlingkungan','rktsosial','neracaht','nrciuphhk'),
              'users' => array(Yii::app()->user->adminRole()),
          ),
          array('allow', // allow all users to perform 'index' and 'view' actions
              'actions' => array('datapokok','pilihrku', 'getidtahunrkt','absensirealisasi','tampilabsen',
                                    'pilihrkt','rku','rkt','profil','pilihdaftar','pilihkinerja',
                                'kinerja','daftar','rkt','gettahunrku','gettahunrkt','getbulanrkt','rktprasyarat','rktlingkungan','rktsosial','neracaht','nrciuphhk'),
              'users' => array(Yii::app()->user->perusahaanRole()),
          ),
          array('allow', // allow authenticated user to perform 'create' and 'update' actions
              'actions' => array('create', 'update','test','indexPrint','print','profil','rku'),
              'users' => array(Yii::app()->user->adminRole()),
          ),
          array('allow', // allow admin user to perform 'admin' and 'delete' actions
              'actions' => array('admin', 'delete'),
              'users' => array(Yii::app()->user->adminRole()),
          ),
          array('deny', // deny all users
              'users' => array('*'),
          ),
      );
  }

  public function actionGettahunrku(){
      $idPerusahaan = $_POST['idPerusahaan'];
      $listTahun='';
       $status="success";
      
      if(isset($idPerusahaan)){
          $listTahun = Rku::model()->getTahunByIdPerusahaan($idPerusahaan);
      }
      if(sizeof($listTahun)<1){
          $status = "tidak_ada_data";
      }
      
       $data = array(
            'header' => "Sukses",
            'message' => "Data Berhasil disimpan",
            'status' => $status,
            'listTahun' => $listTahun
        );
        echo json_encode($data);
        die();
  }
  
  
  
    public function actionGettahunrkt(){
      $idPerusahaan = $_POST['idPerusahaan'];
      $listTahun='';
      $status="success";
      
      if(isset($idPerusahaan)){
          $listTahun = Rkt::model()->getTahunByIdPerusahaan($idPerusahaan);
      }
      if(sizeof($listTahun)<1){
          $status = "tidak_ada_data";
      }
      
      
      
       $data = array(
            'header' => "Sukses",
            'message' => "Data Berhasil disimpan",
            'status' => $status,
            'listTahun' => $listTahun
        );
        echo json_encode($data);
        die();
  }
  
  
     public function actionGetidtahunrkt(){
      $idPerusahaan = $_POST['idPerusahaan'];
      $listTahun='';
      $status="success";
      
      if(isset($idPerusahaan)){
          $listTahun = Rkt::model()->getIDByIdPerusahaan($idPerusahaan);
      }
      if(sizeof($listTahun)<1){
          $status = "tidak_ada_data";
      }
      
      
      
       $data = array(
            'header' => "Sukses",
            'message' => "Data Berhasil disimpan",
            'status' => $status,
            'listTahun' => $listTahun
        );
        echo json_encode($data);
        die();
  }
  
  
  
  
   public function actionGetbulanrkt(){
      $idPerusahaan = $_POST['idPerusahaan'];
      
      $tahun =$_POST['tahun'];
      
    //  $tahun = $_POST['tahun'];
      $listBulan=''; $rkt='';
      $status="success";
      
      if(isset($idPerusahaan)){
          $rkt = Rkt::model()->findByAttributes(array('tahun_mulai'=>$tahun, 'id_perusahaan'=>$idPerusahaan));
          
          if(isset($rkt)){
              
              
              //init update bulan
//              $rBibit = RealisasiRktBibit::model()->get4UpdateBulanByIdRkt($rkt->id);
//              $rArealKerja = RealisasiRktArealKerja::model()->get4UpdateBulanByIdRkt($rkt->id);
//              
//              $this->cekUpdateBulan($rBibit);
//              $this->cekUpdateBulan($rArealKerja);
              
              //get Bulan by RKT
                $listBulan = RktBulan::model()->getByRktId($rkt->id);
          }
      }      
      
       $data = array(
            'header' => "Sukses",
            'message' => "Data Berhasil disimpan",
            'status' => $status,
            'listBulan' => $listBulan
        );
        echo json_encode($data);
        die();
  }
  
  public function cekUpdateBulan($objList){
      foreach($objList as $item){
          
          $objBulan = RktBulan::model()->findByAttributes(array('id_rkt'=>$item['id_rkt'],'tahun'=>$item['tahun'],'bulan'=>$item['bulan']));
      
          if(sizeof($objBulan)==0){
              $newObjBulan = new RktBulan();
              $newObjBulan->id_rkt = $item['id_rkt'];
              $newObjBulan->tahun = $item['tahun'];
              $newObjBulan->bulan = $item['bulan'];
              
                  $newObjBulan->save();
              
//              print_r("<pre>");
//              print_r(sizeof($objBulan));
//              print_r("</pre>");
//                die();
          }
      }
  }
  
  
  
  public function actionTest()
  {
  //
  // get a reference to the path of PHPExcel classes 
  $phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');

  // Turn off our amazing library autoload 
  spl_autoload_unregister(array('YiiBase','autoload'));        

  //
  // making use of our reference, include the main class
  // when we do this, phpExcel has its own autoload registration
  // procedure (PHPExcel_Autoloader::Register();)
  include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

  // Create new PHPExcel object
  $objPHPExcel = new PHPExcel();

  // Set properties
  $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
  ->setLastModifiedBy("Maarten Balliauw")
  ->setTitle("PDF Test Document")
  ->setSubject("PDF Test Document")
  ->setDescription("Test document for PDF, generated using PHP classes.")
  ->setKeywords("pdf php")
  ->setCategory("Test result file");


  // Add some data
  $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A1', 'Hello')
      ->setCellValue('B2', 'world!')
      ->setCellValue('C1', 'Hello')
      ->setCellValue('D2', 'world!');

  // Miscellaneous glyphs, UTF-8
  $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A4', 'Miscellaneous glyphs')
      ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

  // Rename sheet
  $objPHPExcel->getActiveSheet()->setTitle('Simple');

  // Set active sheet index to the first sheet, 
  // so Excel opens this as the first sheet
  $objPHPExcel->setActiveSheetIndex(0);

  // Redirect output to a client’s web browser (Excel2007)
  header('Content-Type: application/pdf');
  header('Content-Disposition: attachment;filename="01simple.pdf"');
  header('Cache-Control: max-age=0');

  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
  $objWriter->save('php://output');
  Yii::app()->end();

  // 
  // Once we have finished using the library, give back the 
  // power to Yii... 
  spl_autoload_register(array('YiiBase','autoload'));
  }
  
  
  public function actionDatapokok(){
      
      $model = new Perusahaan();
      $model->unsetAttributes();  // clear any default values
        
      
      $this->render('datapokok',array(
          'model' => $model,
      ));
  }
  
  
   public function actionMonevikk(){
      
      $model = new RktBulan();
      $model->unsetAttributes();  // clear any default values
        
      
      $this->render('monevikk',array(
          'model' => $model,
      ));
  }
  
  
  public function actionNeracaht(){
      $model = new Rku();
      $model->unsetAttributes();  // clear any default values
        
      
      $this->render('nrc_ht',array(
          'model' => $model,
      ));
  }
  
  
  
  public function actionNrciuphhk($idperusahaan,$tahun){
      $this->layout = "//layouts/report";
      $perusahaan = Perusahaan::model()->findByPk($idperusahaan);
      $iuphhk = Iuphhk::model()->getByPerusahaan($idperusahaan);
      $rku = Rku::model()->findAllByAttributes(array('id_perusahaan'=>$idperusahaan,'tahun_mulai'=>$tahun));
       
      
        
      $arealProduktif = RktArealProduktif::model()->getRealiasiTanamByRkuId($idperusahaan);
      
//    print_r("<pre>");
//        print_r($arealProduktif);  
//        print_r("</pre>");
      
      
      $this->render('nrciuphhk',array(
          'perusahaan'=> $perusahaan,
          'iuphhk' =>  $iuphhk,
          'rku' => $rku,
          'arealProduktif' => $arealProduktif,
      ));
  }
  
  
  public function actionAbsensirealisasi(){
      $model = new Rku();
      $model->unsetAttributes();  // clear any default values
        
      
      $this->render('absenrealisasi',array(
          'model' => $model,
      ));
  }
  
  
  
  public function actionTampilabsen($idperusahaan,$idRkt){
      $this->layout = "//layouts/report";
      $perusahaan = Perusahaan::model()->findByPk($idperusahaan);
      $iuphhk = Iuphhk::model()->getByPerusahaan($idperusahaan);
      $rku = Rku::model()->findAllByAttributes(array('id_perusahaan'=>$idperusahaan,'tahun_mulai'=>$tahun));
      
      $rkt = Rkt::model()->findByPk($idRkt);
      
      $listbulan = RktBulan::model()->getList4Absen($idRkt);  
      
//    print_r("<pre>");
//        print_r($arealProduktif);  
//        print_r("</pre>");
      
      
      $this->render('absensi',array(
          'perusahaan'=> $perusahaan,
          'iuphhk' =>  $iuphhk,
          'rku' => $rku,
          'rkt' => $rkt,
          'listbulan' => $listbulan,
      ));
  }
  
  
  
  
   public function actionPilihrku(){
      
      $model = new Rku();
      $model->unsetAttributes();  // clear any default values
        
      
      $this->render('pilih_rku',array(
          'model' => $model,
      ));
  }
  
    public function actionPilihrkt(){
      
      $model = new RealisasiRktBibit();
      $modelRkt = new Rkt();
      $model->unsetAttributes();  // clear any default values
      $modelRkt->unsetAttributes();
      $bulan=0;  
      
      $this->render('pilih_rkt',array(
          'model' => $modelRkt,
          'modelRealisasi' =>$model
      ));
  }
  
  
  
  
  public function actionPilihdaftar(){
      
      $model = new BphpWilayahKerja();
      $model->unsetAttributes();  // clear any default values
        
      
      $this->render('pilih_daftar',array(
          'model' => $model,
      ));
  }
  
  
  
   public function actionPilihkinerja(){
      
        
        $model = new BphpWilayahKerja();
        $model->unsetAttributes();  // clear any default values
        
//        $listTahun = Rku::model()->getTahun();
//        
//        $listPropinsi = CHtml::listData(Provinsi::model()->findAllByAttributes($condition), 'id_provinsi', 'nama');

        $this->render('pilih_kinerja',array(
            'model' => $model,
//            'listTahun' => $listTahun,
//            'listPropinsi' => $listPropinsi,
        ));
  }
  

  public function actionIndexPrint($id){
    $this->layout = '//layouts/main-fancy';

    $model = Iuphhk::model()->findByPk($id);
    $rku = Rku::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '.$model->id_perusahaan));
    $permodalan = Permodalan::model()->find(array('condition'=>'id_perusahaan='.$model->id_perusahaan));
    $investasi = Investasi::model()->find(array('condition'=>'id_perusahaan='.$model->id_perusahaan));
    $admPemerintahan = AdmPemerintahan::model()->find(array('condition'=>'id_iuphhk='.$id));
    $admKehutanan = AdmPemangkuanHutan::model()->find(array('condition'=>'id_iuphhk='.$id));
//    print_r($admKehutanan);exit(1);

    if(isset($_POST['Print'])) {
      // if (Yii::app()->request->isAjaxRequest) {
        $params = array();
        $params['iup'] = $model;
        $params['modal']= $permodalan;
        $params['investasi'] = $investasi;
        $params['admPemerintahan'] = $admPemerintahan;
        $params['admKehutanan'] = $admKehutanan;
        
        //$params['perusahaan'] = Perusahaan::model()->findByPk($model->id_perusahaan);

        if(!empty($rku) && isset($_POST['Print']['rku'])) {
          $p = $_POST['Print']['rku'];
          $params['rku'] = $rku;
          if(isset($p['allRku'])) $params['rkuAll'] = $p['allRku'];
          if(isset($p['companyProfile'])) $params['companyProfile'] = $p['companyProfile'];
          if(isset($p['dataUmum'])) $params['rkuLegalitas'] = $p['dataUmum'];
          if(isset($p['silvi'])) $params['rkuSilvi'] = $p['silvi'];
          if(isset($p['prasyarat'])) $params['rkuPrasyarat'] = $p['prasyarat'];
          if(isset($p['kelProd'])) $params['rkuKelProd'] = $p['kelProd'];
          if(isset($p['kelLing'])) $params['rkuKelLing'] = $p['kelLing'];
          if(isset($p['kelSos'])) $params['rkuKelSos'] = $p['kelSos'];
        }

        if(isset($_POST['Print']['rkt'])) {
          $r = array();
          foreach($_POST['Print']['rkt'] as $rkt) {
            $r[] = $rkt;
          }
          $params['rkt'] = $r;
        }

        $this->layout = false;
        // $model = Iuphhk::model()->findByPk($id);

        // $rku = Rku::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '.$model->id_perusahaan));
        // if(empty($rku)) {
        //   $message = Yii::t('app', 'Data RKU belum tersedia.');
        //     Yii::app()->user->setFlash('notice', $message);
        //     $this->redirect(array('//admin/rku/' . $id));
        // }
        // $rkt = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku = '. $rku->id_rku));

        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        
        // $stylesheet = file_get_contents(Yii::getPathOfAlias('nipz') . '/bootstrap.min.css');
        // $stylesheet .= file_get_contents(Yii::getPathOfAlias('webroot') . '/statics/css/print.css');
        // $mPDF1->WriteHTML($stylesheet,1);
        $mPDF1->WriteHTML($this->render('print', array(
          'params' => $params,
          'rku' => $rku,
          //   'rkt' => $rkt
        ), true));
        // $mPDF1->SetHTMLHeader($this->renderPartial('header',null,true),'O',true);
        // $mPDF1->SetHTMLHeader($this->renderPartial('header',null,true),'E',true);
        // $mPDF1->WriteHTML('', 2, false, true);
        $nama_file = $this->titleize($this->sluggish($model->nomor)).'.pdf';
        $mPDF1->Output($nama_file, EYiiPdf::OUTPUT_TO_DOWNLOAD);
      // }
    }

    $this->render('index',array(
      'model' => $model,
      'rku' => $rku,
    ));
  }
  
  public function actionKinerja($propinsi, $tahun) {
      
      
//        debug($propinsi);
//        die('test');
        
        $this->layout = "//layouts/report";
        
        $model = RumusPenilaianKinerja::getRekapAdmin($propinsi, $tahun);
        $namaPropinsi = Provinsi::model()->findByPk($propinsi);
        
//         print_r("<pre>");print_r($model);print_r("</pre>"); die();
        
        
        $result;
        
        if(sizeof($model) > 0){
            
            $i=0;
            foreach($model as $item){
                $result[$i] = $item;
                
                if($item['rkt_start'] == ''){
                     $rkt_start = $tahun.'-01-01';
                     $rkt_end =  $tahun.'-12-31'; 
                }
                else{
                     $rkt_start = $item['rkt_start'];
                     $rkt_end = $item['rkt_end']; 
                }
                
                $Ganis = RumusPenilaianKinerja::getNilaiGanisBersertifikat($item['id_perusahaan'], $tahun, $rkt_start, $rkt_end);
                $Penanaman = RumusPenilaianKinerja::getNilaiRealisasiPenanaman($item['id_perusahaan'], $tahun);
//                 print_r("<pre>");print_r($Ganis);print_r("</pre>"); die();
                
                
                $result[$i]['ganis_nilai'] = $Ganis['nilai'];
                $result[$i]['ganis_kriteria'] = $Ganis['kriteria'];
                $result[$i]['penanaman_rencana'] = $Penanaman['rencana'];
                $result[$i]['penanaman_realisasi'] = $Penanaman['realisasi'];
                $result[$i]['penanaman_persentase'] = $Penanaman['persentase'];
                
                $i++;
            }
        }
//            print_r("<pre>");print_r($result);print_r("</pre>");
//                    die();
        
       
        
        $data = new CArrayDataProvider($result, array(
            'pagination' => false
        ));

       //print_r("<pre>");print_r($model);print_r("</pre>");die();
        
        $this->render('kinerja', array(
            'model' => $data,
            'tahun' => $tahun,
            'propinsi' => $namaPropinsi->nama
        ));
    }
  
  public function actionViewmonevikk($tahun){
       $this->layout = "//layouts/report";
        $model; $propinsi;
        $listProp;
        $role = Yii::app()->user->findUser()->id_role;
        $userBphp = Yii::app()->user->findUser()->id_bphp;

        $model = Iuphhk::model()->findIUPHHKAktif($tahun);
       
        $this->render('viewmonevikk', array(
            'model' => $model
        ));
  }
  
  
  public function actionProfil($id){
      $this->layout = "//layouts/report";
      $perusahaan = Perusahaan::model()->findByPk($id);
      
      
      $investasi;
      $admPemerintahan;
      $permodalan;
      $pemangkuanHutan;
      $cabang = new PerusahaanCabang();
      
     
      
      if(isset($perusahaan)){
          $tinvestasi = Investasi::model()->findAllByAttributes(array('id_perusahaan'=>$perusahaan->id_perusahaan));
          $tadmPemerintahan = AdmPemerintahan::model()->findAllByAttributes(array('id_perusahaan'=>$perusahaan->id_perusahaan));
          
         
          $iuphhk = Iuphhk::model()->getPerusahaan($perusahaan->id_perusahaan);
          $iuphhkAktif = Iuphhk::model()->getActive($perusahaan->id_perusahaan);
          
          $adendum = Iuphhk::model()->getAdendum($iuphhk['id_iuphhk'], $perusahaan->id_perusahaan);
          
          $lapKeuangan = IuphhkLaporanKeuangan::model()->getByPerusahaan($perusahaan->id_perusahaan);
          
          
          $tPemangkuanHutan = AdmPemangkuanHutan::model()->findAllByAttributes(array('id_iuphhk'=>$iuphhkAktif['id_iuphhk']));
          
          
          //print_r("<pre>");print_r($iuphhk);print_r("</pre>");die();
          
          
          $tpermodalan = Permodalan::model()->findAllByAttributes(array('id_perusahaan'=>$perusahaan->id_perusahaan));
          $tcabang = PerusahaanCabang::model()->findAllByAttributes(array('perusahaan_id'=>$perusahaan->id_perusahaan));
          $komisaris = Komisaris::model()->getByPerusahaanId($perusahaan->id_perusahaan);
          $direksi = Direksi::model()->getByPerusahaanId($perusahaan->id_perusahaan);
          $tTataBatas = ProgresTataBatas::model()->getByPerusahaanId($perusahaan->id_perusahaan);
          $legalitas = LegalitasPerusahaan::model()->getByPerusahaanId($perusahaan->id_perusahaan);
          $tRku = Rku::model()->getByPerusahaanId($perusahaan->id_perusahaan);
          
     
          if(isset($tcabang)){
              $cabang = $tcabang;
          }else{
              $cabang->alamat = '-';
          }
          
          if(isset($tPemangkuanHutan)){
              $pemangkuanHutan = $tPemangkuanHutan['0'];
          }
          
          if(isset($tadmPemerintahan)){
              $admPemerintahan = $tadmPemerintahan['0'];
          }
          if(isset($tinvestasi)){
              $investasi = $tinvestasi['0'];
          }
          
          if(isset($tpermodalan)){
              $permodalan = $tpermodalan['0'];
          }
          
          if(isset($tTataBatas)){
              $tataBatas = $tTataBatas['0'];
          }
          
           if(isset($tRku['0'])){
              $rku = $tRku['0'];
              
              
              $lindung = RkuKawasanLindung::model()->getTotalByRkuId($rku['id_rku']);
              $efektif = RkuArealProduktif::model()->getTotalByRkuId($rku['id_rku']);
              $tanamanSilvikultur = RkuTanamanSilvikultur::model()->getDetilTanamanSilvikultur($rku['id_rku']);
              $silvikultur = RkuSistemSilvikultur::model()->getByRkuId($rku['id_rku']);
              $rkt = Rkt::model()->getByPerusahaanId($perusahaan->id_perusahaan);
              $phpl = SertifikasiPhpl::model()->getByPerusahaanId($perusahaan->id_perusahaan);
              $vlk = SertifikasiVlk::model()->getByPerusahaanId($perusahaan->id_perusahaan); 
              $daftarGanis = IuphhkTenagaKerja::model()->getDaftarRealisasiGanisByPerusahaanId($perusahaan->id_perusahaan);
              
//              $daftarAlat = RealisasiRktMasukGunaAlat::model()->getDaftarRktAndRealisasi($perusahaan->id_perusahaan);
               //print_r("<pre>");print_r($daftarGanis);print_r("</pre>");die();
              
              if(isset($lindung)){
                  $lindung = $lindung['0'];
              }
              
              if(isset($silvikultur)){
                  $silvikultur = $silvikultur['0'];
              }
              
              if(isset($phpl)){
                  $phpl = $phpl['0'];
              }
              
              if(isset($vlk)){
                  $vlk = $vlk['0'];
              }
              
          }
         // print_r("<pre>");print_r($lindung);print_r("</pre>");die();
          
      }
  
      
      $this->render('profil',array(
            'iuphhk' => $iuphhk,
            'perusahaan' => $perusahaan,    
            'investasi' => $investasi,
            'admPemerintahan' => $admPemerintahan,
            'permodalan' => $permodalan,
            'pemangkuanHutan' => $pemangkuanHutan,
            'cabang' => $cabang,
            'komisaris'=> $komisaris,
            'direksi' => $direksi,
            'tataBatas' => $tataBatas,
            'legalitas' => $legalitas,
            'rku' => $rku,
            'lindung' => $lindung,
            'efektif' => $efektif,
            'silvikultur' => $silvikultur,
            'rkt' => $rkt,
            'phpl' => $phpl,
            'vlk' => $vlk,
            'daftarGanis' => $daftarGanis,
            'daftarAlat' => $daftarAlat,
            'adendum'=> $adendum,
            'lapKeuangan' => $lapKeuangan,
            'tanamanSilvikultur'=>$tanamanSilvikultur,
          
    ));
  }
  
  public function actionRku($id,$tahun){      
       $this->layout = "//layouts/report";
       $rku;
       
       //print_r($tmpTahun['0']);die();
       
        $perusahaan = Perusahaan::model()->findByPk($id);
        $trku = Rku::model()->findAllByAttributes(array('id_perusahaan'=>$perusahaan->id_perusahaan,'tahun_mulai'=>$tahun));
       
        if(sizeof($trku) != 0){
                $rku = $trku['0'];
                
                //sistem silvikultur
                $silvikultur = new RkuSistemSilvikultur('search');
                $silvikultur->unsetAttributes();  // clear any default values
                $silvikultur->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Jenis Tanaman
                $jenistanaman = new RkuTanamanSilvikultur('search');
                $jenistanaman->unsetAttributes();
                $jenistanaman->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Jenis Tanaman
                $jenishhbk = new RkuHasilHutanNonkayuSilvikultur('search');
                $jenishhbk->unsetAttributes();
                $jenishhbk->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );     
                
                // Organisasi dan Tenaga Kerja
                $tenagakerja = new RkuSerapanTenagaKerja('search');
                $tenagakerja->unsetAttributes();
                $tenagakerja->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );  
                
                // Tata Batas
                $tatabatas = new RkuTataBatas('search');
                $tatabatas->unsetAttributes();
                $tatabatas->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Kawasan Lindung
                $kawasanlindung = new RkuKawasanLindung('search');
                $kawasanlindung->unsetAttributes();
                $kawasanlindung->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Areal Tidak Efektif
                $arealnonefektif = new RkuArealNonProduktif('search');
                $arealnonefektif->unsetAttributes();
                $arealnonefektif->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Areal Efektif
                $arealefektif = new RkuArealProduktif('search');
                $arealefektif->unsetAttributes();
                $arealefektif->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Penataan Areal Kerja
                $arealkerja = new RkuArealKerja('search');
                $arealkerja->unsetAttributes();
                $arealkerja->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Pemasukan dan Penggunaan Peralatan
                $peralatan = new RkuPeralatan('search');
                $peralatan->unsetAttributes();
                $peralatan->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Pengadaan Sarpras
                $sarpras = new RkuSarpras('search');
                $sarpras->unsetAttributes();
                $sarpras->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );
                
                // Pembukaan Wilayah Hutan
                $pwh = new RkuPwh('search');
                $pwh->unsetAttributes();
                $pwh->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );                
       
                //pembibitan
                $bibit = new RkuBibit('search');
                $bibit->unsetAttributes();  // clear any default values
                $bibit->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );

                //Penyiapan lahan
                $siapLahan = new RkuPenyiapanLahan('search');
                $siapLahan->unsetAttributes();  
                $siapLahan->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );

                //Penanaman
                $penanaman = new RkuTanam('search');
                $penanaman->unsetAttributes();  // clear any default values
                $penanaman->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );

                //Pelihara
                $pemeliharaan = new RkuPelihara('search');
                $pemeliharaan->unsetAttributes();  // clear any default values
                $pemeliharaan->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );

                //KAYU
                $panen = new RkuPanen('search');
                $panen->unsetAttributes();  // clear any default values
                $panen->attributes = array(
                    'id_rku' => $rku->id_rku,
//                    'tahun' => $tahun,
                );

                //HHBK
                $hhbk = new RkuHasilHutanNonkayu('search');
                $hhbk->unsetAttributes();  // clear any default values
                $hhbk->attributes = array(
                    'id_rku' => $rku->id_rku, 
//                    'tahun' => $tahun,
                    );

                $pasar = new RkuPasar('search');
                $pasar->unsetAttributes();  // clear any default values
                $pasar->attributes = array(
                    'id_rku' => $rku->id_rku, 
//                    'tahun' => $tahun,
                    );


                $pasarhhbk = new RkuPasarHhbk('search');
                $pasarhhbk->unsetAttributes();  // clear any default values
                $pasarhhbk->attributes = array(
                    'id_rku' => $rku->id_rku, 
//                    'tahun' => $tahun,
                    );
                
                $perlindungan = new RkuPerlindunganHutan('search');
                $perlindungan->unsetAttributes();  // clear any default values
                $perlindungan->attributes = array(
                    'id_rku' => $rku->id_rku, 
//                    'tahun' => $tahun,
                    );
                
                $pemantauan = new RkuPemantauanLingkungan('search');
                $pemantauan->unsetAttributes();  // clear any default values
                $pemantauan->attributes = array(
                    'id_rku' => $rku->id_rku, 
//                    'tahun' => $tahun,
                    );
                
                $fungsos = new RkuFungsos('search');
                $fungsos->unsetAttributes();  // clear any default values
                $fungsos->attributes = array(
                    'id_rku' => $rku->id_rku, 
//                    'tahun' => $tahun,
                    );



                $sqlSektor = "SELECT * FROM rku_sektor WHERE id_rku=:id_rku AND id_perusahaan=:id_perusahaan ORDER BY nama_sektor ASC";

                $query2 = Yii::app()->db->createCommand($sqlSektor);
                $query2->params = array(
                    ':id_perusahaan' => $perusahaan->id_perusahaan,
                    ':id_rku' => $rku->id_rku,
                );

                $row2 = $query2->queryAll();


                $modelSektor = new CArrayDataProvider($row2, array(
                    'pagination' => array(
                        'pageSize' => 50,
                    ),
                ));

                // =================================================================================
                $sql = "

                SELECT
                    b.id,
                    b.nama_blok,
                    b.id_rku,
                    b.desc,
                    s.id_sektor,
                    s.nama_sektor,
                    s.desc
                FROM 
                    rku_blok b 
                INNER JOIN 
                    rku_sektor s ON b.id_sektor = s.id_sektor 
                WHERE 
                    b.id_rku=:id_rku AND b.id_rku = s.id_rku AND s.id_perusahaan=:id_perusahaan
                ORDER BY s.nama_sektor,b.nama_blok ASC 
                ";


                $query = Yii::app()->db->createCommand($sql);
                $query->params = array(
                    ':id_perusahaan' => $perusahaan->id_perusahaan,
                    ':id_rku' => $rku->id_rku,
                );

                $row = $query->queryAll();




                $modelblok = new CArrayDataProvider($row, array(
                    'pagination' => array(
                        'pageSize' => 50,
                    ),
                ));

                $this->render('rku',array(
                         'status'=>'1',
                         'perusahaan' => $perusahaan,
                         'model' => $rku, 
                         'modelblok' => $modelblok,
                         'modelsektor' => $modelSektor,
                         'modelbibit' => $bibit,
                         'modelsiaplahan' => $siapLahan,
                         'modeltanam' => $penanaman,
                         'modelpelihara' => $pemeliharaan,
                         'modelpanenkayu' => $panen,
                         'modelhhbk'=>$hhbk,
                         'modelpasar'=>$pasar,
                         'modelpasarhhbk'=>$pasarhhbk,
                         'modelsilvikultur'=>$silvikultur,
                         'modeljenistanaman'=>$jenistanaman,
                         'modeljenishhbk'=>$jenishhbk,
                         'modeltenagakerja'=>$tenagakerja,
                         'modeltatabatas'=>$tatabatas,
                         'modelkawasanlindung'=>$kawasanlindung,
                         'modelarealnonefektif'=>$arealnonefektif,
                         'modelarealefektif'=>$arealefektif,
                         'modelarealkerja'=>$arealkerja,
                         'modelperalatan'=>$peralatan,
                         'modelsarpras'=>$sarpras,
                         'modelpwh'=>$pwh,
                         'modelperlindungan'=>$perlindungan,
                         'modelpemantauan'=>$pemantauan,
                         'modelfungsos'=>$fungsos,
                 ));
        }
        else{
            $nama = $perusahaan->nama_perusahaan;
            $msg = 'Data RKU Tahun :'.$tahun.', Dari '.$nama. ' Tidak Di Temukan';
            
            $this->render('rku',array(
                         'status' => '0',
                         'msg' => $msg, 
                 ));
        }
  }
  
  public function actionRkt($id,$tahun,$bulan){      
       $this->layout = "//layouts/report";
       $rkt;
       
        $perusahaan = Perusahaan::model()->findByPk($id);
        $trkt = Rkt::model()->findAllByAttributes(array('id_perusahaan'=>$perusahaan->id_perusahaan,'tahun_mulai'=>$tahun));
       
        if(sizeof($trkt) != 0){
                $rkt = $trkt['0'];
       
                // Organisasi dan Tenaga Kerja
//                $tenagakerja = RealisasiRktSerapanTenagaKerja::model()->getByRktAndBulan($rkt->id,$bulan);
                
                // Tata Batas
//                $tatabatas = RealisasiRktTataBatas::model()->getByRktAndBulan($rkt->id,$bulan);
                                
                //pembibitan
                $bibit = RealisasiRktBibit::model()->getByRktAndBulan($rkt->id,$bulan);
              

                //Penyiapan lahan
                $siapLahan = RealisasiRktSiapLahan::model()->getByRktAndBulan($rkt->id,$bulan);


                //Penanaman
                $penanaman = RealisasiRktTanam::model()->getByRktAndBulan($rkt->id, $bulan);
                
                
                //Pelihara
                $pemeliharaan = RealisasiRktPelihara::model()->getByRktAndBulan($rkt->id, $bulan);
           

                //KAYU
                $panen = RealisasiRktPanenProduksi::model()->getByRktAndBulan($rkt->id, $bulan);


                //HHBK
                $hhbk = RealisasiRktPanenHhbk::model()->getByRktAndBulan($rkt->id, $bulan);
               

                $pasar = RealisasiRktPasar::model()->getByRktAndBulan($rkt->id, $bulan);



                $pasarhhbk = RealisasiRktPasarHhbk::model()->getByRktAndBulan($rkt->id, $bulan);
      



                $this->render('rkt_report',array(
                        'status'=>'1',
                         'perusahaan' => $perusahaan,
                         'model' => $rkt, 
//                         'modeltenagakerja' => $tenagakerja,
//                         'modeltatabatas' => $tatabatas,
                         'modelbibit' => $bibit,
                         'modelsiaplahan' => $siapLahan,
                         'modeltanam' => $penanaman,
                         'modelpelihara' => $pemeliharaan,
                         'modelpanenkayu' => $panen,
                         'modelhhbk'=>$hhbk,
                         'modelpasar'=>$pasar,
                         'modelpasarhhbk'=>$pasarhhbk,
                         'tahun' => $tahun,
                         'bulan' => $bulan,
                 ));
        }
        else{
            $nama = $perusahaan->nama_perusahaan;
            $msg = 'Data RKT Tahun :'.$tahun.', Dari '.$nama. ' Tidak Di Temukan';
            
            $this->render('rkt_report',array(
                         'status' => '0',
                         'msg' => $msg, 
                 ));
        }
  }
  
  
  
  public function actionRktprasyarat($id,$tahun,$bulan){      
       $this->layout = "//layouts/report";
       $rkt;
       
        $perusahaan = Perusahaan::model()->findByPk($id);
        $trkt = Rkt::model()->findAllByAttributes(array('id_perusahaan'=>$perusahaan->id_perusahaan,'tahun_mulai'=>$tahun));
       
        if(sizeof($trkt) != 0){
                $rkt = $trkt['0'];
                
                // Organisasi dan Tenaga Kerja
                $modelSerapan = new RealisasiRktSerapanTenagaKerja();
                $modelSerapan->unsetAttributes();
                
                $modelSerapan->id_rkt = $rkt->id;
                $modelSerapan->id_bulan = $bulan;
                $modelSerapan->tahun = $tahun;
                
                 // Tata Batas
                $modelTataBatas = new RealisasiRktTataBatas;
                $modelTataBatas->unsetAttributes();
                $modelTataBatas->id_rkt = $rkt->id;
                $modelTataBatas->id_bulan = $bulan;
                $modelTataBatas->tahun = $tahun;
                
                // kawasan lindung
                $modelLindung = new RealisasiRktKawasanLindung;
                $modelLindung->unsetAttributes();
                $modelLindung->id_rkt = $rkt->id;
                $modelLindung->id_bulan = $bulan;
                $modelLindung->tahun = $tahun;
                
                //areal non produktif
                $modelArealNon = new RealisasiRktArealNonProduktif;
                $modelArealNon->unsetAttributes();
                $modelArealNon->id_rkt = $rkt->id;
                $modelArealNon->id_bulan = $bulan;
                $modelArealNon->tahun = $tahun;
             
                
                //Areal produktif
                $modelArealProduktif = new RealisasiRktArealProduktif;
                $modelArealProduktif->unsetAttributes();
                $modelArealProduktif->id_rkt = $rkt->id;
                $modelArealProduktif->id_bulan = $bulan;
                $modelArealProduktif->tahun = $tahun;
            
            
                //areal kerja
                $modelArealKerja = new RealisasiRktArealKerja;
                $modelArealKerja->unsetAttributes();
                $modelArealKerja->id_rkt = $rkt->id;
                $modelArealKerja->id_bulan = $bulan;
                $modelArealKerja->tahun = $tahun;
            
                //pwh
                $modelPWH = new RealisasiRktPwh;
                $modelPWH->unsetAttributes();
                $modelPWH->id_rkt = $rkt->id;
                $modelPWH->id_bulan = $bulan;
                $modelPWH->tahun = $tahun;
            
                //masuk guna alat
                $modelAlat = new RealisasiRktMasukGunaAlat;
                $modelAlat->unsetAttributes();
                $modelAlat->id_rkt = $rkt->id;
                $modelAlat->id_bulan = $bulan;
                $modelAlat->tahun = $tahun;
            
                
                //sarpras
                $modelSarpras = new RealisasiRktSarpras;
                $modelSarpras->unsetAttributes();
                $modelSarpras->id_rkt = $rkt->id;
                $modelSarpras->id_bulan = $bulan;
                $modelSarpras->tahun = $tahun;
            
            
                $this->render('rkt_prasyarat',array(
                        'status'=>'1',
                         'perusahaan' => $perusahaan,
                         'model' => $rkt, 
                         'modelSerapan' => $modelSerapan,
                         'modelTataBatas' => $modelTataBatas,
                         'modelLindung' => $modelLindung,
                         'modelArealNon' => $modelArealNon,
                         'modelArealProduktif' =>$modelArealProduktif,
                         'modelArealKerja' => $modelArealKerja,
                         'modelPWH' => $modelPWH,
                         'modelAlat' => $modelAlat,
                         'modelSarpras' => $modelSarpras,
                         'tahun' => $tahun,
                         'bulan' => $bulan,
                 ));
        }
        else{
            $nama = $perusahaan->nama_perusahaan;
            $msg = 'Data RKT Tahun :'.$tahun.', Dari '.$nama. ' Tidak Di Temukan';
            
            $this->render('rkt_report',array(
                         'status' => '0',
                         'msg' => $msg, 
                 ));
        }
  }
  
  
  public function actionRktlingkungan($id,$tahun,$bulan){      
       $this->layout = "//layouts/report";
       $rkt;
       
        $perusahaan = Perusahaan::model()->findByPk($id);
        $trkt = Rkt::model()->findAllByAttributes(array('id_perusahaan'=>$perusahaan->id_perusahaan,'tahun_mulai'=>$tahun));
       
        if(sizeof($trkt) != 0){
                $rkt = $trkt['0'];
                
                // Organisasi dan Tenaga Kerja
                $modelDungtan = new RealisasiRktLingkunganDungtan;
                $modelDungtan->unsetAttributes();
                $modelDungtan->id_rkt = $rkt->id;
                $modelDungtan->id_bulan = $bulan;
                $modelDungtan->tahun = $tahun;
                
                // hama 
                $modelHama = new RealisasiRktLingkunganDalmakit;
                $modelHama->unsetAttributes();
                $modelHama->id_rkt = $rkt->id;
                $modelHama->id_bulan = $bulan;
                $modelHama->tahun = $tahun;
            
                //kebakaran
                $modelBakar = new RealisasiRktLingkunganDalkar;
                $modelBakar->unsetAttributes();
                $modelBakar->id_rkt = $rkt->id;
                $modelBakar->id_bulan = $bulan;
                $modelBakar->tahun = $tahun;
                
                $this->render('rkt_lingkungan',array(
                        'status'=>'1',
                         'perusahaan' => $perusahaan,
                         'model' => $rkt, 
                         'modelDungtan' => $modelDungtan,
                         'modelHama' => $modelHama,
                         'modelBakar' => $modelBakar,
                         'tahun' => $tahun,
                         'bulan' => $bulan,
                 ));
        }
        else{
            $nama = $perusahaan->nama_perusahaan;
            $msg = 'Data RKT Tahun :'.$tahun.', Dari '.$nama. ' Tidak Di Temukan';
            
            $this->render('rkt_report',array(
                         'status' => '0',
                         'msg' => $msg, 
                 ));
        }
  }
  
  
  
  
  public function actionRktsosial($id,$tahun,$bulan){      
       $this->layout = "//layouts/report";
       $rkt;
       
        $perusahaan = Perusahaan::model()->findByPk($id);
        $trkt = Rkt::model()->findAllByAttributes(array('id_perusahaan'=>$perusahaan->id_perusahaan,'tahun_mulai'=>$tahun));
       
        if(sizeof($trkt) != 0){
                $rkt = $trkt['0'];
                
                // Infrastruktur Pemukiman
                $modelInfra = new RealisasiRktInfraMukim;
                $modelInfra->unsetAttributes();
                $modelInfra->id_rkt = $rkt->id;
                $modelInfra->id_bulan = $bulan;
                $modelInfra->tahun = $tahun;
            
                // Peningkatan SDM
                $modelSDM = new RealisasiRktPeningkatanSdm;
                $modelSDM->unsetAttributes();
                $modelSDM->id_rkt = $rkt->id;
                $modelSDM->id_bulan = $bulan;
                $modelSDM->tahun = $tahun;
            
               // koperasi
                $modelKoperasi = new RealisasiRktKerjasamaKoperasi;
                $modelKoperasi->unsetAttributes();
                $modelKoperasi->id_rkt = $rkt->id;
                $modelKoperasi->id_bulan = $bulan;
                $modelKoperasi->tahun = $tahun;
            
                // Kemitraan Usaha
                $modelMitra = new RealisasiRktBangunMitra;
                $modelMitra->unsetAttributes();                   
                $modelMitra->id_rkt = $rkt->id;
                $modelMitra->id_bulan = $bulan;
                $modelMitra->tahun = $tahun;
                
                // konflik sosial
                $md;
                $modelKonflik = new RealisasiRktKonflikSosial;
                $modelKonflik->unsetAttributes();  
                 
                if(isset($rkt)){
			$idRkt = $rkt->id;
			$md = RktKonflikSosial::model()->findAllByAttributes(array(
				'id_rkt'=>$idRkt
                 	));  
                 } 
                 if(sizeof($md)> 0){   
                    $modelKonflik->id_rkt_konflik_sosial = $md['0']->id;
                    $modelKonflik->id_bulan = $bulan;
                    $modelKonflik->tahun = $tahun;
                 }
                
                
                $this->render('rkt_sosial',array(
                        'status'=>'1',
                         'perusahaan' => $perusahaan,
                         'model' => $rkt, 
                         'modelInfra' => $modelInfra,
                         'modelSDM' => $modelSDM,
                         'modelKoperasi' => $modelKoperasi,
                         'modelMitra' => $modelMitra,
                         'modelRealisasi' => $modelKonflik,
                         'tahun' => $tahun,
                         'bulan' => $bulan,
                 ));
        }
        else{
            $nama = $perusahaan->nama_perusahaan;
            $msg = 'Data RKT Tahun :'.$tahun.', Dari '.$nama. ' Tidak Di Temukan';
            
            $this->render('rkt_report',array(
                         'status' => '0',
                         'msg' => $msg, 
                 ));
        }
  }
  
  
  
  
    public function actionDaftar($idpropinsi){
        $this->layout = "//layouts/report";
        $model; $propinsi;
        $listProp;
        $role = Yii::app()->user->findUser()->id_role;
        $userBphp = Yii::app()->user->findUser()->id_bphp;

        if($idpropinsi == "0" && $role == 3){
            //$propinsi = Provinsi::model()->getListPropByBphp($userBphp);
            
            $model = Iuphhk::model()->findByBphp($userBphp);
        }
        else{
            $model = Iuphhk::model()->findByPropinsi($idpropinsi);
        }
        
//        print_r("<pre>");print_r($model);print_r("<pre>");die();
        $propinsi = Provinsi::model()->findByPk($idpropinsi); 
         
        $this->render('daftar_iuphhk', array(
            'model' => $model,
            'propinsi' => $propinsi->nama,
        ));
    }
  
  
  
  
  
  
  
  

  public function actionPrint($params) {
    $this->layout = "//layouts/main-print";
    // $model = Iuphhk::model()->findByPk($id);

    // $rku = Rku::model()->find(array('condition'=>'status = 1 AND id_perusahaan = '.$model->id_perusahaan));
    // if(empty($rku)) {
    //   $message = Yii::t('app', 'Data RKU belum tersedia.');
    //     Yii::app()->user->setFlash('notice', $message);
    //     $this->redirect(array('//admin/rku/' . $id));
    // }
    // $rkt = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku = '. $rku->id_rku));

    $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
    
    $stylesheet = file_get_contents(Yii::getPathOfAlias('nipz') . '/bootstrap.min.css');
    $stylesheet .= file_get_contents(Yii::getPathOfAlias('webroot') . '/statics/css/print.css');
    $mPDF1->WriteHTML($stylesheet,1);
    $mPDF1->WriteHTML($this->renderPartial('print', array(
      'params' => $params,
      // 'rku' => $rku,
      //   'rkt' => $rkt
    ), true), 2);
    // $mPDF1->SetHTMLFooter('{PAGENO} / {nb}');
    // $mPDF1->SetHTMLHeader($this->renderPartial('header',null,true),'O',true);
    // $mPDF1->SetHTMLHeader($this->renderPartial('header',null,true),'E',true);
    // $mPDF1->WriteHTML('', 2, false, true);
    $nama_file = $this->titleize($this->sluggish($model->nomor)).'.pdf';
    $mPDF1->Output($nama_file, EYiiPdf::OUTPUT_TO_DOWNLOAD);
  }

  function titleize($word) {
    $output = ucwords(str_replace('_', ' ', preg_replace('/_id$/', '', $word)));
    return ucwords($output);
  }

  protected function sluggish($teks) {
    $text = (strlen($teks) >= 226) ? substr($teks, 0, 225) : $teks;
    return trim(strtolower(preg_replace('/([^\pL\pN])+/u', '-', trim(strtr(str_replace('\'', '', $text), array(
        'Ǎ' => 'A', 'А' => 'A', 'Ā' => 'A', 'Ă' => 'A', 'Ą' => 'A', 'Å' => 'A',
        'Ǻ' => 'A', 'Ä' => 'Ae', 'Á' => 'A', 'À' => 'A', 'Ã' => 'A', 'Â' => 'A',
        'Æ' => 'AE', 'Ǽ' => 'AE', 'Б' => 'B', 'Ç' => 'C', 'Ć' => 'C', 'Ĉ' => 'C',
        'Č' => 'C', 'Ċ' => 'C', 'Ц' => 'C', 'Ч' => 'Ch', 'Ð' => 'Dj', 'Đ' => 'Dj',
        'Ď' => 'Dj', 'Д' => 'Dj', 'É' => 'E', 'Ę' => 'E', 'Ё' => 'E', 'Ė' => 'E',
        'Ê' => 'E', 'Ě' => 'E', 'Ē' => 'E', 'È' => 'E', 'Е' => 'E', 'Э' => 'E',
        'Ë' => 'E', 'Ĕ' => 'E', 'Ф' => 'F', 'Г' => 'G', 'Ģ' => 'G', 'Ġ' => 'G',
        'Ĝ' => 'G', 'Ğ' => 'G', 'Х' => 'H', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ï' => 'I',
        'Ĭ' => 'I', 'İ' => 'I', 'Į' => 'I', 'Ī' => 'I', 'Í' => 'I', 'Ì' => 'I',
        'И' => 'I', 'Ǐ' => 'I', 'Ĩ' => 'I', 'Î' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J',
        'Й' => 'J', 'Я' => 'Ja', 'Ю' => 'Ju', 'К' => 'K', 'Ķ' => 'K', 'Ĺ' => 'L',
        'Л' => 'L', 'Ł' => 'L', 'Ŀ' => 'L', 'Ļ' => 'L', 'Ľ' => 'L', 'М' => 'M',
        'Н' => 'N', 'Ń' => 'N', 'Ñ' => 'N', 'Ņ' => 'N', 'Ň' => 'N', 'Ō' => 'O',
        'О' => 'O', 'Ǿ' => 'O', 'Ǒ' => 'O', 'Ơ' => 'O', 'Ŏ' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ö' => 'Oe', 'Õ' => 'O', 'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O',
        'Œ' => 'OE', 'П' => 'P', 'Ŗ' => 'R', 'Р' => 'R', 'Ř' => 'R', 'Ŕ' => 'R',
        'Ŝ' => 'S', 'Ş' => 'S', 'Š' => 'S', 'Ș' => 'S', 'Ś' => 'S', 'С' => 'S',
        'Ш' => 'Sh', 'Щ' => 'Shch', 'Ť' => 'T', 'Ŧ' => 'T', 'Ţ' => 'T', 'Ț' => 'T',
        'Т' => 'T', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
        'Ū' => 'U', 'Ǜ' => 'U', 'Ǚ' => 'U', 'Ù' => 'U', 'Ú' => 'U', 'Ü' => 'Ue',
        'Ǘ' => 'U', 'Ǖ' => 'U', 'У' => 'U', 'Ư' => 'U', 'Ǔ' => 'U', 'Û' => 'U',
        'В' => 'V', 'Ŵ' => 'W', 'Ы' => 'Y', 'Ŷ' => 'Y', 'Ý' => 'Y', 'Ÿ' => 'Y',
        'Ź' => 'Z', 'З' => 'Z', 'Ż' => 'Z', 'Ž' => 'Z', 'Ж' => 'Zh', 'á' => 'a',
        'ă' => 'a', 'â' => 'a', 'à' => 'a', 'ā' => 'a', 'ǻ' => 'a', 'å' => 'a',
        'ä' => 'ae', 'ą' => 'a', 'ǎ' => 'a', 'ã' => 'a', 'а' => 'a', 'ª' => 'a',
        'æ' => 'ae', 'ǽ' => 'ae', 'б' => 'b', 'č' => 'c', 'ç' => 'c', 'ц' => 'c',
        'ċ' => 'c', 'ĉ' => 'c', 'ć' => 'c', 'ч' => 'ch', 'ð' => 'dj', 'ď' => 'dj',
        'д' => 'dj', 'đ' => 'dj', 'э' => 'e', 'é' => 'e', 'ё' => 'e', 'ë' => 'e',
        'ê' => 'e', 'е' => 'e', 'ĕ' => 'e', 'è' => 'e', 'ę' => 'e', 'ě' => 'e',
        'ė' => 'e', 'ē' => 'e', 'ƒ' => 'f', 'ф' => 'f', 'ġ' => 'g', 'ĝ' => 'g',
        'ğ' => 'g', 'г' => 'g', 'ģ' => 'g', 'х' => 'h', 'ĥ' => 'h', 'ħ' => 'h',
        'ǐ' => 'i', 'ĭ' => 'i', 'и' => 'i', 'ī' => 'i', 'ĩ' => 'i', 'į' => 'i',
        'ı' => 'i', 'ì' => 'i', 'î' => 'i', 'í' => 'i', 'ï' => 'i', 'ĳ' => 'ij',
        'ĵ' => 'j', 'й' => 'j', 'я' => 'ja', 'ю' => 'ju', 'ķ' => 'k', 'к' => 'k',
        'ľ' => 'l', 'ł' => 'l', 'ŀ' => 'l', 'ĺ' => 'l', 'ļ' => 'l', 'л' => 'l',
        'м' => 'm', 'ņ' => 'n', 'ñ' => 'n', 'ń' => 'n', 'н' => 'n', 'ň' => 'n',
        'ŉ' => 'n', 'ó' => 'o', 'ò' => 'o', 'ǒ' => 'o', 'ő' => 'o', 'о' => 'o',
        'ō' => 'o', 'º' => 'o', 'ơ' => 'o', 'ŏ' => 'o', 'ô' => 'o', 'ö' => 'oe',
        'õ' => 'o', 'ø' => 'o', 'ǿ' => 'o', 'œ' => 'oe', 'п' => 'p', 'р' => 'r',
        'ř' => 'r', 'ŕ' => 'r', 'ŗ' => 'r', 'ſ' => 's', 'ŝ' => 's', 'ș' => 's',
        'š' => 's', 'ś' => 's', 'с' => 's', 'ş' => 's', 'ш' => 'sh', 'щ' => 'shch',
        'ß' => 'ss', 'ţ' => 't', 'т' => 't', 'ŧ' => 't', 'ť' => 't', 'ț' => 't',
        'у' => 'u', 'ǘ' => 'u', 'ŭ' => 'u', 'û' => 'u', 'ú' => 'u', 'ų' => 'u',
        'ù' => 'u', 'ű' => 'u', 'ů' => 'u', 'ư' => 'u', 'ū' => 'u', 'ǚ' => 'u',
        'ǜ' => 'u', 'ǔ' => 'u', 'ǖ' => 'u', 'ũ' => 'u', 'ü' => 'ue', 'в' => 'v',
        'ŵ' => 'w', 'ы' => 'y', 'ÿ' => 'y', 'ý' => 'y', 'ŷ' => 'y', 'ź' => 'z',
        'ž' => 'z', 'з' => 'z', 'ż' => 'z', 'ж' => 'zh'
            ))))), '-');
  }

  public function cariRkt($id, $apa = '') {
    $rkt = Rkt::model()->find(array('condition'=>'status=1 AND id = '.$id));

    switch($apa) {
      case 'ganis':
        $modelGanis = new RktGanis;
        $modelGanis->unsetAttributes();
        if (isset($_GET['RktGanis']))
            $modelGanis->attributes = $_GET['RktGanis'];
        $modelGanis->id_rkt = $rkt->id;
        return $modelGanis;
        break;

      case 'tatabatas':
        $modelTataBatas = new RktTataBatas;
        $modelTataBatas->unsetAttributes();
        if (isset($_GET['RktTataBatas']))
            $modelTataBatas->attributes = $_GET['RktTataBatas'];
        $modelTataBatas->id_rkt = $rkt->id;
        return $modelTataBatas;
        break;

      case 'kawasan':
        $modelKawasan = new RktKawasanLindung;
        $modelKawasan->unsetAttributes();
        if (isset($_GET['RktKawasanLindung']))
            $modelKawasan->attributes = $_GET['RktKawasanLindung'];
        $modelKawasan->id_rkt = $rkt->id;
        return $modelKawasan;
        break;

      case 'arealNonProduktif':
        $modelArealNonProduktif = new RktArealNonProduktif;
        $modelArealNonProduktif->unsetAttributes();
        if (isset($_GET['RktArealNonProduktif']))
            $modelArealNonProduktif->attributes = $_GET['RktArealNonProduktif'];
        $modelArealNonProduktif->id_rkt = $rkt->id;
        return $modelArealNonProduktif;
        break;

      case 'arealProduktif':
        $modelArealProduktif = new RktArealProduktif('search');
        $modelArealProduktif->unsetAttributes();
        if (isset($_GET['RktArealProduktif']))
            $modelArealProduktif->attributes = $_GET['RktArealProduktif'];
        $modelArealProduktif->id_rkt = $rkt->id;
        return $modelArealProduktif;
        break;

      case 'arealKerja':
        $modelArealKerja = new RktArealKerja;
        $modelArealKerja->unsetAttributes();
        if (isset($_GET['RktArealKerja']))
            $modelArealKerja->attributes = $_GET['RktArealKerja'];
        $modelArealKerja->id_rkt = $rkt->id;
        return $modelArealKerja;
        break;

      case 'pwh':
        $modelPwh = new RktPwh;
        $modelPwh->unsetAttributes();
        if (isset($_GET['RktPwh']))
            $modelPwh->attributes = $_GET['RktPwh'];
        $modelPwh->id_rkt = $rkt->id;
        return $modelPwh;
        break;

      case 'masukGunaAlat':
        $modelMasukGunaAlat = new RktMasukGunaAlat('search');
        $modelMasukGunaAlat->unsetAttributes();
        if (isset($_GET['RktMasukGunaAlat']))
            $modelMasukGunaAlat->attributes = $_GET['RktMasukGunaAlat'];
        $modelMasukGunaAlat->id_rkt = $rkt->id;
        return $modelMasukGunaAlat;
        break;

      case 'sarpras':
        $modelBangunSarpras = new RktSarpras;
        $modelBangunSarpras->unsetAttributes();
        if (isset($_GET['RktSarpras']))
            $modelBangunSarpras->attributes = $_GET['RktSarpras'];
        $modelBangunSarpras->id_rkt = $rkt->id;
        return $modelBangunSarpras;
        break;

      case 'bibit':
        $modelBibit = new RktBibit;
        $modelBibit->unsetAttributes();
        if (isset($_GET['RktBibit']))
            $modelBibit->attributes = $_GET['RktBibit'];
        $modelBibit->id_rkt = $rkt->id;
        return $modelBibit;
        break;

      case 'siapLahan':
        $modelSiapLahan = new RktSiapLahan;
        $modelSiapLahan->unsetAttributes();
        if (isset($_GET['RktSiapLahan']))
            $modelSiapLahan->attributes = $_GET['RktSiapLahan'];
        $modelSiapLahan->id_rkt = $rkt->id;
        return $modelSiapLahan;
        break;

      case 'tanam':
        $modelTanam = new RktTanam;
        $modelTanam->unsetAttributes();
        if (isset($_GET['RktTanam']))
            $modelTanam->attributes = $_GET['RktTanam'];
        $modelTanam->id_rkt = $rkt->id;
        return $modelTanam;
        break;

      case 'sulam':
        $modelSulam = new RktSulam;
        $modelSulam->unsetAttributes();
        if (isset($_GET['RktSulam']))
            $modelSulam->attributes = $_GET['RktSulam'];
        $modelSulam->id_rkt = $rkt->id;
        return $modelSulam;
        break;

      case 'jarang':
        $modelJarang = new RktJarang;
        $modelJarang->unsetAttributes();
        if (isset($_GET['RktJarang']))
            $modelJarang->attributes = $_GET['RktJarang'];
        $modelJarang->id_rkt = $rkt->id;
        return $modelJarang;
        break;

      case 'dangir':
        $modelDangir = new RktDangir;
        $modelDangir->unsetAttributes();
        if (isset($_GET['RktDangir']))
            $modelDangir->attributes = $_GET['RktDangir'];
        $modelDangir->id_rkt = $rkt->id;
        return $modelDangir;
        break;

      case 'panenAreal':
        $modelPanenAreal = new RktPanenAreal;
        $modelPanenAreal->unsetAttributes();
        if (isset($_GET['RktPanenAreal']))
            $modelPanenAreal->attributes = $_GET['RktPanenAreal'];
        $modelPanenAreal->id_rkt = $rkt->id;
        return $modelPanenAreal;
        break;

      case 'panenTanaman':
        $modelPanenTanaman = new RktPanenVolumeTanaman;
        $modelPanenTanaman->unsetAttributes();
        if (isset($_GET['RktPanenVolumeTanaman']))
            $modelPanenTanaman->attributes = $_GET['RktPanenVolumeTanaman'];
        $modelPanenTanaman->id_rkt = $rkt->id;
        return $modelPanenTanaman;
        break;

      case 'panenLahan':
        $modelPanenSiapLahan = new RktPanenVolumeSiapLahan;
        $modelPanenSiapLahan->unsetAttributes();
        if (isset($_GET['RktPanenVolumeSiapLahan']))
            $modelPanenSiapLahan->attributes = $_GET['RktPanenVolumeSiapLahan'];
        $modelPanenSiapLahan->id_rkt = $rkt->id;
        return $modelPanenSiapLahan;
        break;

      case 'pasar':
        $modelPasar = new RktPasar;
        $modelPasar->unsetAttributes();
        if (isset($_GET['RktPasar']))
            $modelPasar->attributes = $_GET['RktPasar'];
        $modelPasar->id_rkt = $rkt->id;
        return $modelPasar;
        break;

      case 'dungtan':
        $dungtan = RktLingkunganDungtan::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        if (empty($dungtan))
            $dungtan = new RktLingkunganDungtan;
        return $dungtan;
        break;

      case 'dalmakit':
        $dalmakit = RktLingkunganDalmakit::model()->find(array('condition' => 'id_rkt = ' . $rkt->id));
        if (empty($dalmakit))
            $dalmakit = new RktLingkunganDalmakit;
        return $dalmakit;
        break;

      case 'dalkar':
        $modelDalkar = new RktLingkunganDalkar;
        $modelDalkar->unsetAttributes();
        if (isset($_GET['RktLingkunganDalkar']))
            $modelDalkar->attributes = $_GET['RktLingkunganDalkar'];
        $modelDalkar->id_rkt = $rkt->id;
        return $modelDalkar;
        break;

      case 'pantau':
        $modelPantau = new RktPemantauanLingkungan;
        $modelPantau->unsetAttributes();
        if (isset($_GET['RktPemantauanLingkungan']))
            $modelPantau->attributes = $_GET['RktPemantauanLingkungan'];
        $modelPantau->id_rkt = $rkt->id;
        return $modelPantau;
        break;

      case 'inframukim':
        $modelInfraMukim = new RktInfraMukim;
        $modelInfraMukim->unsetAttributes();
        if (isset($_GET['RktInfraMukim']))
            $modelInfraMukim->attributes = $_GET['RktInfraMukim'];
        $modelInfraMukim->id_rkt = $rkt->id;
        return $modelInfraMukim;
        break;

      case 'sdm':
        $modelSdm = new RktPeningkatanSdm;
        $modelSdm->unsetAttributes();
        if (isset($_GET['RktPeningkatanSdm']))
            $modelSdm->attributes = $_GET['RktPeningkatanSdm'];
        $modelSdm->id_rkt = $rkt->id;
        return $modelSdm;
        break;

      case 'konflik':
        $modelKonflikSosial = new RktKonflikSosial;
        $modelKonflikSosial->unsetAttributes();
        if (isset($_GET['RktKonflikSosial']))
            $modelKonflikSosial->attributes = $_GET['RktKonflikSosial'];
        $modelKonflikSosial->id_rkt = $rkt->id;
        return $modelKonflikSosial;
        break;
    
      case 'kerjasama':
        $kerjasama = RktKerjasamaKoperasi::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
        if(empty($kerjasama))
            $kerjasama = new RktKerjasamaKoperasi;
        return $kerjasama;
        break;
      
      case 'bangunmitra':
        $bangunMitra = RktBangunMitra::model()->find(array('condition'=>'id_rkt = '.$rkt->id ));
        if(empty($bangunMitra))
            $bangunMitra = new RktBangunMitra;
        return $bangunMitra;
        break;
    }
  }
}