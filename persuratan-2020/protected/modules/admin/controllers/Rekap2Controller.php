<?php

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
          'actions' => array('index', 'view', 'test'),
          'users' => array(Yii::app()->user->adminRole()),
      ),
      array('deny', // deny all users
          'users' => array('*'),
      ),
    );
  }

  public function actionTest($tahun = '',$provinsi = '')
  {
    //
    // get a reference to the path of PHPExcel classes 
    $phpExcelPath = Yii::getPathOfAlias('ext.PHPExcel.Classes');
    $template = Yii::getPathOfAlias('files');

    // Turn off our amazing library autoload
    spl_autoload_unregister(array('YiiBase','autoload'));

    //
    // making use of our reference, include the main class
    // when we do this, phpExcel has its own autoload registration
    // procedure (PHPExcel_Autoloader::Register();)
    include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

    spl_autoload_register( array( 'YiiBase', 'autoload' ) );

    $objReader = PHPExcel_IOFactory::createReader('Excel2007');

    // Create new PHPExcel object
    // $objPHPExcel = new PHPExcel();
    $objPHPExcel = $objReader->load($template."/template_rekap.xlsx");

    // Set properties
    // $objPHPExcel->getProperties()->setCreator('tes')
    // ->setLastModifiedBy('tes')
    // ->setTitle("Rekap Kinerja")
    // ->setSubject("Rekap Kinerja")
    // ->setDescription("Rekap Kinerja")
    // ->setKeywords("rekap")
    // ->setCategory("Rekap");

    $alignStyle = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      )
    );

    $fontStyle = array(
      // 'name'      => 'Arial',
      'bold'      => TRUE,
      'size'      => 16,
      // 'italic'    => FALSE,
      // 'underline' => PHPExcel_Style_Font::UNDERLINE_DOUBLE,
      // 'strike'    => FALSE,
      // 'color'     => array(
          // 'rgb' => '808080'
      // )
    );

    $borderStyle = array(
      'borders' => array(
        'outline' => array(
          'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
          'color' => array('argb' => '0000000'),
        ),
        'inside' => array(
          'style' => PHPExcel_Style_Border::BORDER_THIN,
          'color' => array('argb' => '0000000'),
        )
      ),
    );


    // // // Add some data
    // $objPHPExcel->setActiveSheetIndex(0)
    //   ->setCellValue('A1','Rekap Kinerja Tahun '.$tahun)
    //   ->mergeCells('A1:D2')
    //   ->setCellValue('A4', 'No.')
    //   ->setCellValue('B4', 'Nama Perusahaan')
    //   ->setCellValue('C4', 'Nomor SK IUPHHK')
    //   ->setCellValue('D4', 'Luas Areal (Ha)')
    //   ->setCellValue('E4', 'Penanaman')
    //   ->setCellValue('N4', 'Produksi')
    //   ->setCellValue('O4', 'Nilai Kinerja');

    // $objPHPExcel->getActiveSheet()->getStyle('A1:D2')->applyFromArray($alignStyle);
    // $objPHPExcel->getActiveSheet()->getStyle('A1:D2')->getFont()->applyFromArray($fontStyle);
    // $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);

    $objPHPExcel->getActiveSheet()->setCellValue('A1','Rekap Kinerja Tahun : '.$tahun);


    $idx = 7;
    if(!empty($tahun)) {
      // echo 'here';die;
      $rku = Rku::model()->findAll(array('condition'=>'status = 1'));
      if(!empty($rku)) {
        foreach($rku as $data) {
          $id_rku[] = $data->id_rku;
        }
        
        $rkt = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku IN('.implode(",",$id_rku).')'));
        if(!empty($rkt)) {
          foreach($rkt as $data) {
            $id_rkt[] = $data->id;
            $kinerja = PenilaianKinerja::model()->find(array(
                'condition' => 'id_rkt=' . $data->id
            ));
            // var_dump($kinerja);die;
            if (!isset($kinerja)) {
                $this->generateReport($data->id_perusahaan, $data);
                $kinerja = PenilaianKinerja::model()->find(array(
                    'condition' => 'id_rkt=' . $data->id
                ));
            } else {
                $kinerja = $this->updateReport($kinerja, $data);
            }
          }
        }

      }

      if(isset($id_rku) && isset($id_rkt) && empty($provinsi)) {
        $condition = 'id_rkt IN('.implode(",",$id_rkt).') AND tahun = '.$tahun;
      } elseif(isset($id_rku) && isset($id_rkt) &&
        !empty($provinsi)) 
      {
        $adm = AdmPemerintahan::model()->findAll(array('condition'=>'provinsi = '.$provinsi));
        if(!empty($adm)) {
          foreach($adm as $ad) {
            $id_per[] = $ad->idIuphhk->idPerusahaan->id_perusahaan;
          }
          $condition = 'id_rkt IN('.implode(",",$id_rkt).') AND tahun = '.$tahun .' AND id_perusahaan IN('.implode(",",$id_per).')';
        } else {
          $condition = 'id_perusahaan = 0';
        }
      } else {
        $condition = 'tahun = '.$tahun.' AND id_perusahaan = 0';
      }

      // $quez = PenilaianKinerja::model()->findAll(array('condition'=>$condition));



      $kinerja = PenilaianKinerja::model()->findAll(array('condition'=>$condition));
      $count = 6+count($kinerja);
      if(empty($kinerja)) {
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A7','Tidak ada data')
        ->mergeCells('A7:Q7');
        $objPHPExcel->getActiveSheet()->getStyle('A7:Q7')->applyFromArray($alignStyle);
      } else {
        foreach($kinerja as $key => $k) {
          $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$idx, $key+1)
            ->setCellValue('B'.$idx, $k->idPerusahaan->nama_perusahaan)
            ->setCellValue('C'.$idx, $k->idPerusahaan->iuphhks[0]->nomor)
            ->setCellValue('D'.$idx, number_format($k->idPerusahaan->iuphhks[0]->luas,2,",","."))
            ->setCellValue('E'.$idx, $k->getTanaman($k->id_rkt,"tapok"))
            ->setCellValue('F'.$idx, $k->getTotalRencana($k->id_rkt,"tapok","jumlah"))
            ->setCellValue('G'.$idx, $k->getTotalRencana($k->id_rkt,"tapok","realisasi"))
            ->setCellValue('H'.$idx, $k->getTanaman($k->id_rkt,"tanggul"))
            ->setCellValue('I'.$idx, $k->getTotalRencana($k->id_rkt,"tanggul","jumlah"))
            ->setCellValue('J'.$idx, $k->getTotalRencana($k->id_rkt,"tanggul","realisasi"))
            ->setCellValue('K'.$idx, $k->getTanaman($k->id_rkt,"tadup"))
            ->setCellValue('L'.$idx, $k->getTotalRencana($k->id_rkt,"tadup","jumlah"))
            ->setCellValue('M'.$idx, $k->getTotalRencana($k->id_rkt,"tadup","realisasi"))
            ->setCellValue('N'.$idx, $k->getProduksiTanaman($k->id_rkt))
            ->setCellValue('O'.$idx, $k->getRencanaProduksi($k->id_rkt,"jumlah"))
            ->setCellValue('P'.$idx, $k->getRencanaProduksi($k->id_rkt,"realisasi"))
            ->setCellValue('Q'.$idx, $k->getKinerja($k->id_perusahaan,$k->id_rkt));
          $objPHPExcel->getActiveSheet()->getStyle('Q'.$idx)->applyFromArray($alignStyle);
          ++$idx;
        }
      }
      $objPHPExcel->getActiveSheet()->getStyle('A7:Q'.$objPHPExcel->getActiveSheet()->getHighestRow())->applyFromArray($borderStyle);
      // $objPHPExcel->getActiveSheet()->getStyle('E1:E'.$objPHPExcel->getActiveSheet()->getHighestRow())
      //   ->getAlignment()->setWrapText(true);
      $objPHPExcel->getActiveSheet()->setSelectedCells('A1');
      // $objPHPExcel->getActiveSheet()->getStyle('A4:D4')->applyFromArray($borderStyle);
    } else {
      // echo 'kosong';die;
      $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A7','Tidak ada data')
        ->mergeCells('A7:Q7')
        ->getStyle('A7:Q7')->applyFromArray($borderStyle);
      $objPHPExcel->getActiveSheet()->getStyle('A7:Q7')->applyFromArray($alignStyle);
      $objPHPExcel->getActiveSheet()->getStyle('A7:Q7')->applyFromArray($borderStyle);
    }

    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Rekap Kinerja');

    // Set active sheet index to the first sheet, 
    // so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rekap_kinerja_tahun_'.$tahun.'.xlsx"');
    // header('Cache-Control: max-age=0');

    // // We'll be outputting an excel file
    //   header('Content-type: application/vnd.ms-excel');

    //   // It will be called file.xls
    //   header('Content-Disposition: attachment; filename="file.xls"');

    //   // Write file to the browser
    //   $objWriter->save('php://output');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    Yii::app()->end();

    // 
    // Once we have finished using the library, give back the 
    // power to Yii... 
    // spl_autoload_register(array('YiiBase','autoload'));
  }

  public function actionIndex() {
    $rku = Rku::model()->findAll(array('condition'=>'status = 1'));
    $rkt = Rkt::model()->findAll(array('condition'=>'status = 1'));
    if(empty($rku)) {
      $message = Yii::t('app', 'Tidak ada data RKU ditemukan.');
      Yii::app()->user->setFlash('error', $message);
      $this->redirect(array('//admin/'));
    }
    $que = array();
    $tahun = null;
    $data = new CArrayDataProvider($que,array(
        // 'keyField'=>false,
        'pagination'=>false
    ));
    if(isset($_POST['Provinsi']) && $_POST['Provinsi']['tahun'] !== '' ) {
        // var_dump($_POST['Filter']['tahun']);die;
        $rku = Rku::model()->findAll(array('condition'=>'status = 1'));
        if(!empty($rku)) {
          foreach($rku as $data) {
            $id_rku[] = $data->id_rku;
          }
          
          $rkt = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku IN('.implode(",",$id_rku).')'));
          if(!empty($rkt)) {
            foreach($rkt as $data) {
              $id_rkt[] = $data->id;
              $kinerja = PenilaianKinerja::model()->find(array(
                  'condition' => 'id_rkt=' . $data->id
              ));
              // var_dump($kinerja);die;
              if (!isset($kinerja)) {
                  $this->generateReport($data->id_perusahaan, $data);
                  $kinerja = PenilaianKinerja::model()->find(array(
                      'condition' => 'id_rkt=' . $data->id
                  ));
              } else {
                  $kinerja = $this->updateReport($kinerja, $data);
              }
            }
          }

        }

        if(isset($id_rku) && isset($id_rkt) && $_POST['Provinsi']['provinsi'] == '') {
          $condition = 'id_rkt IN('.implode(",",$id_rkt).') AND tahun = '.$_POST['Provinsi']['tahun'];
        } elseif(isset($id_rku) && isset($id_rkt) &&
          isset($_POST['Provinsi']['provinsi']) && 
          $_POST['Provinsi']['provinsi'] !== '') 
        {
          $adm = AdmPemerintahan::model()->findAll(array('condition'=>'provinsi = '.$_POST['Provinsi']['provinsi']));
          if(!empty($adm)) {
            foreach($adm as $ad) {
              $id_per[] = $ad->idIuphhk->idPerusahaan->id_perusahaan;
            }
            $condition = 'id_rkt IN('.implode(",",$id_rkt).') AND tahun = '.$_POST['Provinsi']['tahun'] .' AND id_perusahaan IN('.implode(",",$id_per).')';
          } else {
            $condition = 'id_perusahaan = 0';
          }
        } else {
          $condition = 'tahun = '.$_POST['Provinsi']['tahun'].' AND id_perusahaan = 0';
        }

        $quez = PenilaianKinerja::model()->findAll(array('condition'=>$condition));
        $tahun = $_POST['Provinsi']['tahun'];


        $data = new CArrayDataProvider($quez,array(
            // 'keyField'=>array('tahun'),
            // 'sort'=>array(
            //     'attributes'=>array(
            //          'tahun',
            //     ),
            // ),
            'pagination'=>false
        ));
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('index2',array(
              'model'=>$data,
              'tahun'=>$tahun
            ));
            Yii::app()->end();
        }
    }

    if(isset($_POST['Provinsi']) && $_POST['Provinsi']['tahun'] == '' ) {
      $que = array();
      $tahun = null;
      $data = new CArrayDataProvider($que,array(
          // 'keyField'=>false,
          'pagination'=>false
      ));

      if (Yii::app()->request->isAjaxRequest) {
          $this->renderPartial('index2',array(
            'model'=>$data,
            'tahun'=>$tahun
          ));
          Yii::app()->end();
      }
    }


    $this->render('index', array(
        'model' => $data,
        'tahun' => $tahun
    ));
  }
}