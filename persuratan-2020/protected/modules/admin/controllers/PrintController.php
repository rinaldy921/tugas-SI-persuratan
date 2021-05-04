<?php

class PrintController extends Controller{
 
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
              'actions' => array('index', 'view'),
              'users' => array(Yii::app()->user->adminRole()),
          ),
          array('allow', // allow authenticated user to perform 'create' and 'update' actions
              'actions' => array('create', 'update','test','indexPrint','print'),
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