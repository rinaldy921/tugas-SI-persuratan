<?php

class PetaController extends Controller {

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
                'actions' => array('index', 'view', 'prov', 'filterProv','kab'),
                'users' => array(Yii::app()->user->adminRole()),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
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

    public function actionIndex() {
        if (Yii::app()->request->isAjaxRequest) {
            if(isset($_POST['Provinsi'])) {

$tmpl_panel_rkt = <<<EOT
<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse%d" aria-expanded="true" aria-controls="collapseOne">
                <strong>%s</strong>
            </a>
        </h4>
    </div>
    <div id="collapse%d" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            %s
        </div>
    </div>
</div>
EOT;

$tmpl_checkbox_rkt = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="rktTile(%d);" checked="checked"> 
        <a href="#" onclick="zoom('%s','rkt');return false;">%s<br>(%s)</a>
    </label>
</div>
EOT;
$tmpl_checkbox_iup = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="iupTile(%d);" checked="checked"> 
        <a href="#" onclick="zoom('%s','iup');return false;">%s</a>
    </label>
</div>
EOT;
$tmpl_checkbox_tb = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="tbTile(%d);" checked="checked"> 
        <a href="#" onclick="zoom('%s','tb');return false;">%s</a>
    </label>
</div>
EOT;

                $post = $_POST['Provinsi'];
                $condition = '';
                $conditionRkt = '';
                $conIup = '';
                $with = '';
                $withRkt = '';
                $modelPer = 'Perusahaan';
                $modelRku = 'Rku';
                $id_per = array();

                if(isset($post['perusahaanProvinsi']) && !empty($post['perusahaanProvinsi'])) {
                    $condition .= 'idPerusahaan.id_perusahaan = '.$post['perusahaanProvinsi'];
                    $conIup .= 'id_perusahaan = '.$post['perusahaanProvinsi'];
                    $with .= 'idPerusahaan';
                }

                if(isset($post['nama']) && !empty($post['nama'])) {
                    // $modelz .='Perusahaan';
                    $adm = AdmPemerintahan::model()->findAll(array('condition'=>'provinsi = '.$post['nama']));
                    if($adm) {
                        foreach($adm as $a) {
                            $id_per[] = $a->idIuphhk->id_perusahaan;
                        }
                    } else {
                        $id_per = array('0');
                    }
                    // var_dump($adm);die;
                    $condition .= !empty($post['perusahaanProvinsi']) ? ' AND idPerusahaan.id_perusahaan IN('.implode(',',$id_per).')' : 'idPerusahaan.id_perusahaan IN('.implode(',',$id_per).')';
                    $conIup .= !empty($post['perusahaanProvinsi']) ? " AND id_perusahaan IN (".implode(',',$id_per).")" : "id_perusahaan IN (".implode(',',$id_per).")";
                    $with .= !empty($with) ? '' : 'idPerusahaan';
                }
                if(isset($post['namaKab']) && !empty($post['namaKab'])) {
                    if(isset($post['nama']) && !empty($post['nama'])) {
                        $id_per = array();
                    }
                    $adm = AdmPemerintahan::model()->findAll(array('condition'=>(isset($post['nama']) && !empty($post['nama'])) ? 'provinsi = '.$post['nama'].' AND kabupaten = '.$post['namaKab'] : 'kabupaten = '.$post['namaKab']));
                    if($adm) {
                        foreach($adm as $a) {
                            $id_per[] = $a->idIuphhk->id_perusahaan;
                        }
                    } else {
                        $id_per = array('0');
                    }
                    // var_dump($id_per);die;
                    $condition = '';
                    $conIup = '';
                    $condition .= 'idPerusahaan.id_perusahaan IN('.implode(',',$id_per).')';
                    $conIup .= 'id_perusahaan IN ('.implode(',',$id_per).')';
                    $with .= !empty($with) ? '' : 'idPerusahaan';
                }
                if(isset($post['tahun']) && !empty($post['tahun'])) {
                    if(!empty($post['nama']) || !empty($post['namaKab']))
                        $condition .= ' AND tahun_mulai <= '.$post['tahun'].' AND '.$post['tahun'].' <= tahun_sampai';
                    else
                        $condition .= 'tahun_mulai <= '.$post['tahun'].' AND '.$post['tahun'].' <= tahun_sampai';
                    // $with .= !empty($with) ? '' : 'idPerusahaan';
                }
                if(!empty($post['nama']) || !empty($post['namaKab']) || !empty($post['tahun']) || !empty($post['perusahaanProvinsi'])) {
                    $condition .= ' AND status = 1';
                } else {
                    $condition .= 'status = 1';
                }

                $criteria = array(
                    'condition'=>$condition,
                    'with'=>$with
                );

                $critIup = array(
                    'condition'=>$conIup
                );
                // var_dump($critIup);die;
                $iup = Iuphhk::model()->findAll($critIup);
                // var_dump($iup);die;

                $rku = $modelRku::model()->findAll($criteria);

                if(!empty($iup)) {
                    foreach($iup as $key => $val) {
                        $miup = Attachment::model()->findAll(array('condition'=>"Model = 'PetaIUP' AND Model_id = ". $val->id_iuphhk));
                        $mtb = Attachment::model()->findAll(array('condition'=>"Model = 'PetaTB' AND Model_id = ". $val->id_iuphhk));
                        $i = 0;
                        if($miup) {
                            $d_iup = array();
                            $out_iup = '';
                            foreach($miup as $kiy => $mm) {
                                $eks_iup = end(explode('/',$mm->File_Name));
                                $eks_iup1 = explode('.', $eks_iup);
                                // $namaIup = $eks_iup1[0];
                                if($eks_iup1[1] == 'shp') {
                                    $nama_perusahaan_iup = SpasialIup::model()->find('id_iup = '.$mm->Model_id);
                                    $i++;
                                    $map_path_iup = $eks_iup1[0];
                                    $d_iup[] = $map_path_iup;
                                    $judul_iup = $this->titleize($nama_perusahaan_iup->idPerusahaan->nama_perusahaan);
                                    // $no_sk_rkt = $nama_perusahaan_rkt->idRkt->nomor_sk;
                                    $out_iup .= sprintf($tmpl_checkbox_iup, $i, ($i - 1), $map_path_iup, $judul_iup) . "\n";
                                }
                            }
                            $dataIup[] = array('map' => $d_iup,'content'=>$out_iup);
                            $gabung['iup'] = $dataIup;
                        } else {
                            $dataIup[] = array('nama'=>'Hasil tidak ditemukan');
                            $gabung['iup'] = $dataIup;
                        }

                        $y = 0;
                        if($mtb) {
                            $d_tb = array();
                            $out_tb = '';
                            foreach($mtb as $kk => $mz) {
                                $eks_tb = end(explode('/',$mz->File_Name));
                                $eks_tb1 = explode('.', $eks_tb);
                                // $namaIup = $eks_iup1[0];
                                if($eks_tb1[1] == 'shp') {
                                    $nama_perusahaan_tb = SpasialIup::model()->find('id_iup = '.$mz->Model_id);
                                    $y++;
                                    $map_path_tb = $eks_tb1[0];
                                    $d_tb[] = $map_path_tb;
                                    $judul_tb = $this->titleize($nama_perusahaan_tb->idPerusahaan->nama_perusahaan);
                                    // $no_sk_rkt = $nama_perusahaan_rkt->idRkt->nomor_sk;
                                    $out_tb .= sprintf($tmpl_checkbox_tb, $y, ($y - 1), $map_path_tb, $judul_tb) . "\n";
                                }
                            }
                            $dataTb[] = array('map' => $d_tb,'content'=>$out_tb);
                            $gabung['tb'] = $dataTb;
                        } else {
                            $dataTb[] = array('nama'=>'Hasil tidak ditemukan');
                            $gabung['tb'] = $dataTb;
                        }
                    }
                } else {
                    $dataIup = array('iup'=>array(array('nama'=> 'Hasil tidak ditemukan')),'tb'=>array(array('nama'=>'Hasil tidak ditemukan')));
                }
                if(!empty($rku)) {
                    // $data = array();
                    foreach($rku as $key => $rk) {
                        $mrku = Attachment::model()->findAll(array('condition'=>"Model = 'PetaRKU' AND Model_id = ". $rk->id_rku));
                        $namaRku = null;
                        $namaRkt = null;
                        if($mrku) {
                            foreach($mrku as $kunci => $mrkuz) {
                                if($kunci === 0){
                                    if($mrkuz->Model == 'PetaRKU') {
                                        $eks = end(explode('/',$mrkuz->File_Name));
                                        $eks1 = explode('.', $eks);
                                        $namaRku = $eks1[0];

                                        $conditionRkt = '';

                                        if(isset($post['tahun']) && !empty($post['tahun'])) {
                                            $conditionRkt .= 'id_rku = '.$mrkuz->Model_id.' AND status = 1 AND tahun_mulai = '.$post['tahun'];
                                        } else {
                                            $conditionRkt .= 'id_rku = '.$mrkuz->Model_id.' AND status = 1';
                                        }

                                        $out_rkt = '';
                                        $tmpl_rkt = '';
                                        $d_rkt = array();
                                        $model_rkt = SpasialRkt::model()->with(array('idRkt'=>array('select'=>'distinct idRkt.tahun_mulai', 'condition'=>$conditionRkt, 'order'=>'idRkt.tahun_mulai ASC')))->findAll();
                                        // var_dump($model_rkt);die;
                                        if($model_rkt) {
                                            $j = 0;
                                            $i = 0;
                                            foreach($model_rkt as $mdrkt) {

                                                $out_rkt = '';
                                                $tahun = $mdrkt->idRkt->tahun_mulai;
                                                // echo $tahun.'<br>';die;
                                                // var_dump($tahun);die;
                                                $j++;

                                                $m2rkt = Rkt::model()->findAll(array('condition'=>'tahun_mulai = '. $tahun));

                                                if($m2rkt) {
                                                    $rkt_id = array();
                                                    foreach($m2rkt as $m2rkt_id) {
                                                        $rkt_id[] = $m2rkt_id->id;
                                                    }

                                                    $criteria_rkt = array(
                                                        'condition' => "Model = 'PetaRKT' AND Model_id IN(" . implode(',', $rkt_id) . ")",
                                                        'order' => 'Model_id',
                                                        'select' => 'File_Name,Model_id'
                                                    );
                                                    $map_rkt = Attachment::model()->findAll($criteria_rkt);
                                                    // var_dump($map_rkt);die;
                                                    if($map_rkt) {
                                                        foreach($map_rkt as $mrkt) {
                                                            $eks_rkt = end(explode('/', $mrkt->File_Name));
                                                            $eks_rkt1 = explode('.', $eks_rkt);
                                                            if($eks_rkt1[1] == 'shp') {
                                                                $nama_perusahaan_rkt = SpasialRkt::model()->find('id_rkt = '.$mrkt->Model_id);
                                                                $i++;
                                                                $file_info_rkt = pathinfo(Yii::app()->params->uploadPath. '/SPASIAL' . $mrkt->File_Name);
                                                                $map_path_rkt = $eks_rkt1[0];
                                                                $d_rkt[] = $map_path_rkt;
                                                                $judul_rkt = $this->titleize($nama_perusahaan_rkt->idPerusahaan->nama_perusahaan);
                                                                $no_sk_rkt = $nama_perusahaan_rkt->idRkt->nomor_sk;
                                                                $out_rkt .= sprintf($tmpl_checkbox_rkt, $i, ($i - 1), $map_path_rkt, $judul_rkt,$no_sk_rkt) . "\n";
                                                            }
                                                        }
                                                    }
                                                }
                                                $tmpl_rkt .= sprintf($tmpl_panel_rkt, $j, $tahun, $j, $out_rkt) ."\n";
                                                // echo $tmpl_rkt;die;
                                                $dataRkt[] = array('map'=>$d_rkt,'content'=>$tmpl_rkt);
                                                $gabung['rkt'] = $dataRkt;

                                            }
                                        } else {
                                            $dataRkt[] = array('nama'=>'Hasil tidak ditemukan');
                                            $gabung['rkt'] = $dataRkt;
                                        }
                                    }
                                }
                            }
                            $dataRku[] = array('key'=>$key,'nama' => $rk->idPerusahaan->nama_perusahaan,'map'=>$namaRku);
                            $gabung['rku'] = $dataRku;
                        } else {
                            $dataRku[] = array('nama'=>'Hasil tidak ditemukan');
                            $gabung['rku'] = $dataRku;

                            $dataRkt[] = array('nama'=>'Hasil tidak ditemukan');
                            $gabung['rkt'] = $dataRkt;
                        }
                    }
                    $data = array('iup'=>$gabung['iup'],'rkt'=>$gabung['rkt'],'rku'=>$gabung['rku'],'tb'=>$gabung['tb']);
                    echo CJSON::encode($data);
                    Yii::app()->end();
                } else {
                    $data = array('rku'=>array(array('nama'=> 'Hasil tidak ditemukan')),'rkt'=>array(array('nama'=> 'Hasil tidak ditemukan')));
                    if(empty($iup)) {
                        $data = array_merge($data,$dataIup);
                    } else {
                        $data = array_merge($data,$dataIup);
                    }
                    echo CJSON::encode($data);
                    Yii::app()->end();
                }
            }
        }

        $this->render('index', array(
            // 'model'=>$model
        ));
    }

    public function actionProv() {
        
            $id = ($_POST['id'] == '') ? 0 : $_POST['id'];
            // var_dump($id);die;
            // $kab = Kabupaten::model()->findAll(array('condition'=>'provinsi_id = '.$id));
            // $test = CHtml::listData($kab, 'id_kabupaten','nama');
            // foreach($test as $value=>$name)
            // {
            //     echo CHtml::tag('option',
            //                array('value'=>$value),CHtml::encode($name),true);
            // }

        $this->layout = false;
        if (Yii::app()->request->isAjaxRequest) {
            $kab = Kabupaten::model()->findAll(array('select' => 'id_kabupaten, nama', 'condition' => "t.provinsi_id = $id"));
            $adm = AdmPemerintahan::model()->findAll(array('condition'=>'provinsi = '.$id));
            $id_iup = array('0');
            if($adm) {
                foreach($adm as $a) {
                    $id_iup[] = $a->idIuphhk->id_perusahaan;
                }
            }
            $perusahaan = Perusahaan::model()->findAll(array('select'=>'id_perusahaan, nama_perusahaan', 'condition'=>(isset($id_iup)) ? "id_perusahaan IN(".implode(',',$id_iup).")" : ''));
            if($_POST['id'] == '') {
                $perusahaan = Perusahaan::model()->findAll();
            }
            $data = array();
            $kabz = array();
            $perz = array();
            foreach ($kab as $d) {
                $kabz[] = array('id' => $d->id_kabupaten, 'text' => $d->nama);
                $gabung['kabupaten'] = $kabz;
            }
            foreach($perusahaan as $p) {
                $perz[] = array('id' => $p->id_perusahaan, 'text' => $p->nama_perusahaan);
                $gabung['perusahaan'] = $perz;
            }
            $data = array('kabupaten'=>$kabz,'perusahaan'=>$perz);
            // var_dump($data);die;
            echo CJSON::encode($data);
        }
        
    }

    public function actionKab()
    {
        $id = (isset($_POST['id']) && $_POST['id'] !== '') ? $_POST['id'] : 0;
        $idProv = isset($_POST['idProv']) ? $_POST['idProv'] : 0;
        if($id !== 0) {
            $adm = AdmPemerintahan::model()->findAll(array('condition'=>'provinsi = '.$idProv.' AND kabupaten = '.$id));
        } else {
            $adm = AdmPemerintahan::model()->findAll(array('condition'=>'provinsi = '.$idProv));
        }
        $id_per = array('0');
        if($adm) {
            foreach($adm as $a) {
                $id_per[] = $a->idIuphhk->id_perusahaan;
            }
        }
        $data = array();
        $perz = array();
        $perusahaan = Perusahaan::model()->findAll(array('select'=>'id_perusahaan, nama_perusahaan', 'condition'=>(isset($id_per)) ? "id_perusahaan IN(".implode(',',$id_per).")" : ''));
        foreach($perusahaan as $p) {
            $perz[] = array('id' => $p->id_perusahaan, 'text' => $p->nama_perusahaan);
            $gabung['perusahaan'] = $perz;
        }
        $data = array('perusahaan'=>$perz);
        echo CJSON::encode($data);
    }

    public function actionFilterProv() {
        $get = $_GET['idProv'];
        if($get != '') {
            $id = $_GET['idProv'];
            echo 'here';die;
            $perusahaan = Perusahaan::model()->findAll(array('condition'=>'provinsi = '.$id));
        } else {
            $perusahaan = Perusahaan::model()->findAll();
        }
        // var_dump(count($perusahaan));die;
        // $id = ($_GET['idProv'] == '') ? 0 : $_GET['idProv'];

        $data = array();
        
        if(count($perusahaan) > 0) {
            foreach($perusahaan as $key => $per) {
                $mrku = Attachment::model()->findAll(array('condition'=>"Model_id = ". $per->id));
                foreach($mrku as $mrkuz) {
                    if($mrkuz->Model == 'PetaRKU') {
                        $eks = end(explode('/',$mrkuz->File_Name));
                        $eks1 = explode('.', $eks);
                    }
                    if($mrkuz->Model == 'PetaRKT') {
                        $eks2 = end(explode('/',$mrkuz->File_Name));
                        $eks12 = explode('.', $eks2);
                    }
                    // break;
                }

                // $mrkt = Attachment::model()->find(array('condition'=>"Model = 'PetaRKT' AND Model_id = ". $per->id));
                // $eks2 = end(explode('/',$mrkt->File_Name));
                // $eks12 = explode('.', $eks2);
                $data[] = array('status'=>'success','key'=>$key,'nama' => $per->nama_perusahaan,'map'=>$eks1[0],'mapRkt'=>$eks12[0]);
                // echo '
                // <div class="checkbox check-nip">
                //     <label>
                //         <input type="checkbox" name="list[]" id="list'.$key.'" onclick="rkuTile('.$key.');" checked="checked"> 
                //         '.$per->nama_perusahaan.'
                //     </label>
                // </div>
                // ';
            }
            echo CJSON::encode($data);
        } else {
            $data[] = array('status'=>'success','nama'=> 'Hasil tidak ditemukan');
            echo CJSON::encode($data);
        }
    }

    function titleize($word) {
        $output = ucwords(str_replace('_', ' ', preg_replace('/_id$/', '', $word)));
        return ucwords($output);
    }
}