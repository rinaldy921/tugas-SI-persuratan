<?php

namespace app\controllers;

use Yii;
use app\models\SuratKeluar;
use app\models\SuratKeluarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers;

use linslin\yii2\curl;


/**
 * SuratKeluarController implements the CRUD actions for SuratKeluar model.
 */
class SuratKeluarController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SuratKeluar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SuratKeluarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SuratKeluar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SuratKeluar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SuratKeluar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $postData = Yii::$app->request->post();
            $nomorAgenda = $postData['SuratKeluar']['no_agenda'];
            $tanggalSuratKeluar = $postData['SuratKeluar']['tanggal_surat_keluar'];
          

            $connection = yii::$app->db;
            $command = $connection->createCommand('SELECT * FROM surat_masuk WHERE no_agenda =' ."$nomorAgenda");
            $field = $command->queryAll();                   
            
            $nomorSurat = $field[0]['no_surat'];
            $tanggalSuratMasuk = $field[0]['tanggal_surat'];
            $idStaff = $field[0]['id_staf'];
           

            $keluar = date_create($tanggalSuratKeluar);
            $masuk  = date_create($tanggalSuratMasuk);
            $diff   = date_diff($keluar,$masuk);
            $lamaWaktu = $diff->days;
            
           
            $dataPostAPI = 'http://3.0.88.176:5000/calculate?hari='."$lamaWaktu".'&'.'nip='."$idStaff";
        
            $curl = new curl\Curl();
            $response = $curl->setOption(
                CURLOPT_POSTFIELDS, 
                http_build_query(array()
            ))
            ->post($dataPostAPI);
           
            $decodeResponAPI = json_decode($response, true);
            
            $stafProcess = $decodeResponAPI['result']['hari'];
            $nip   = $decodeResponAPI['result']['nip'];
            $predict = $decodeResponAPI['result']['predict'];
          
            $queryUpdate    = "UPDATE staf_pengolah SET kinerja=".$predict.", lama_proses=".$lamaWaktu. " WHERE id_staf=".$idStaff;

          
            Yii::$app->db->createCommand($queryUpdate)
            ->execute();
            
            return $this->redirect(['view', 'id' => $model->no_surat_keluar]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SuratKeluar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->no_surat_keluar]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SuratKeluar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SuratKeluar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SuratKeluar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SuratKeluar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
