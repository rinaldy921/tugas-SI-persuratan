<?php

class ReallingkunganController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    
    public function actionIndex() {

        $periodeModel = new FormPeriodeRealisasiPrasyarat();
                
        $this->render('index', array(
            'periodeModel' => $periodeModel,
        ));
        
    }
    
    
}