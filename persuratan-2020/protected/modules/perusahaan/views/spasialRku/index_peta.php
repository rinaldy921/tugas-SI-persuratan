<?php
$tmpl_checkbox_iup = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="iupTile(%d);"> 
        %s
    </label>
</div>
EOT;
$tmpl_checkbox_tb = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="tbTile(%d);"> 
        %s
    </label>
</div>
EOT;
$tmpl_checkbox_rku = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="rkuTile(%d);"> 
        %s
    </label>
</div>
EOT;
$tmpl_checkbox_rkt = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="rktTile(%d);"> 
        %s
    </label>
</div>
EOT;
$baseurl = Yii::app()->request->baseUrl;
$d_iup = array();
$d_tb = array();
$d_rku = array();
$d_rkt = array();
$out_iup = '';
$out_tb = '';
$out_rku = '';
$out_rkt = '';
if(!empty($spasialIup)) {
    // $spasial = SpasialRku::model()->find(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
    $criteria_iup = array(
        'condition' => "Model = 'PetaIUP' AND Model_id = ".$spasialIup->id_iup,
        'order' => 'Model_id',
        'select' => 'File_Name,Model_id'
    );
    $map_iup = Attachment::model()->findAll($criteria_iup);
    if ($map_iup) {
        $i = 0;
        foreach ($map_iup as $miup) {
            $eks_iup = end(explode('/',$miup->File_Name));
            $eks_iup1 = explode('.', $eks_iup);
            // if($eks_iup1 == $eks_iup1) {
            //     break;
            // }
            if($eks_iup1[1] == 'shp') {
                $i++;
                $d_iup[] = $eks_iup1[0];
                $judul2 = 'Peta Kawasan';
                $out_iup .= sprintf($tmpl_checkbox_iup, $i, ($i - 1), $judul2) . "\n";
            }
        }
    }
}
if(!empty($spasialTb)) {
    // $spasial = SpasialRku::model()->find(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
    $criteria_tb = array(
        'condition' => "Model = 'PetaTB' AND Model_id = ".$spasialTb->id_iup,
        'order' => 'Model_id',
        'select' => 'File_Name,Model_id'
    );
    $map_tb = Attachment::model()->findAll($criteria_tb);
    if ($map_tb) {
        $i = 0;
        foreach ($map_tb as $mtb) {
            $eks_tb = end(explode('/',$mtb->File_Name));
            $eks_tb1 = explode('.', $eks_tb);
            // $d_tb[] = $eks_tb1[0];
            // if($eks_tb1 == $eks_tb1) {
            //     break;
            // }
            if($eks_tb1[1] == 'shp') {
                $i++;
                $d_tb[] = $eks_tb1[0];
                $judul2 = 'Peta Tata Batas';
                $out_tb .= sprintf($tmpl_checkbox_tb, $i, ($i - 1), $judul2) . "\n";
            }
        }
    }
}
if(!empty($spasial)) {
    // $spasial = SpasialRku::model()->find(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
    $criteria_rku = array(
        'condition' => "Model = 'PetaRKU' AND Model_id = ".$spasial->id_rku,
        'order' => 'Model_id',
        'select' => 'File_Name,Model_id'
    );
    $map_rku = Attachment::model()->findAll($criteria_rku);
    if ($map_rku) {
        $i = 0;
        foreach ($map_rku as $mrku) {
            $eks_rku = end(explode('/',$mrku->File_Name));
            $eks_rku1 = explode('.', $eks_rku);
            // $d_rku[] = $eks_rku1[0];
            // if($eks_rku1 == $eks_rku1) {
            //     break;
            // }
            if($eks_rku1[1] == 'shp') {
                $i++;
                $map_path_rku = $eks_rku1[0];
                $d_rku[] = $map_path_rku;
                $judul2 = 'Peta RKU';
                $out_rku .= sprintf($tmpl_checkbox_rku, $i, ($i - 1), $judul2) . "\n";
            }
        }
    }
}
if(!empty($spasialRkt)) {
    foreach($spasialRkt as $sprkt) {
        $id_sprkt[] = $sprkt->id_rkt;
    }
    $criteria_rkt = array(
        'condition' => "Model = 'PetaRKT' AND Model_id IN(".implode(',',$id_sprkt).')',
        'order' => 'Model_id',
        'select' => 'File_Name,Model_id'
    );
    $map_rkt = Attachment::model()->findAll($criteria_rkt);
    if ($map_rkt) {
        $i = 0;
        foreach ($map_rkt as $mrkt) {
            $eks_rkt = end(explode('/',$mrkt->File_Name));
            $eks_rkt1 = explode('.', $eks_rkt);
            // if($eks_rkt1 == $eks_rkt1) {
            //     break;
            // }
            if($eks_rkt1[1] == 'shp') {
                $tahun_rkt = Rkt::model()->find(array('condition'=>'id = '.$mrkt->Model_id));
                $i++;
                $d_rkt[] = $eks_rkt1[0];
                $judul2 = $this->titleize('RKT '.$tahun_rkt->tahun_mulai);
                $out_rkt .= sprintf($tmpl_checkbox_rkt, $i, ($i - 1), $judul2) . "\n";
            }
        }
    }
}

$this->breadcrumbs=array(
    'Peta'=>array('index'),
    'Manage',
);

?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <!--        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>-->
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/data_perusahaan_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="nipz-map col-md-9">
    <h4 class="page-header">Peta</h4>
    <a class="btn btn-primary" href="<?php echo $this->createUrl('updateIup',array('id'=>$spasialIup->id));?>">Update Peta Kawasan/IUP</a>
    <?php if(!empty($spasialTb)) : ?>
        <a class="btn btn-primary" href="<?php echo $this->createUrl('updateTb',array('id'=>$spasialTb->id));?>">Update Peta Tata Batas</a>
    <?php else: ?>
        <a class="btn btn-primary" href="<?php echo $this->createUrl('createTb');?>">Buat Peta Tata Batas</a>
    <?php endif; ?>
    <?php if(!empty($spasial) && !empty($map_rku)) : ?>
        <a class="btn btn-primary" href="<?php echo $this->createUrl('update',array('id'=>$spasial->id));?>">Update Peta RKU</a>
        <a class="btn btn-primary" href="<?php echo $this->createUrl('//perusahaan/spasialRkt',array('id'=>$spasial->id_rku));?>"><?php echo !empty($spasialRkt) ? 'Update Peta RKT': 'Buat Peta RKT' ; ?></a>
    <?php else: ?>
        <a class="btn btn-primary" href="<?php echo $this->createUrl('create');?>">Buat Peta RKU</a>
        <?php if(!empty($spasial)): ?>
            <a class="btn btn-primary" href="<?php echo $this->createUrl('//perusahaan/spasialRkt',array('id'=>$spasial->id_rku));?>"><?php echo !empty($spasialRkt) ? 'Update Peta RKT': 'Buat Peta RKT' ; ?></a>
        <?php endif; ?>
    <?php endif; ?>
    <div class="clearfix" style="margin-bottom:25px"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
            <div id="progress-nipz" class="pull-right">
                <img src=""/>
                <span class="label label-primary"> Loading layer...</span>
                <p class="label label-danger" style="display:none;">There was an error when loading layer. Contact web administrator.</p>
            </div>
            <div class="panel nipz-hide">
                <div class="panel-heading" role="button" data-toggle="collapse" href="#kolapz" aria-expanded="true" aria-controls="kolapz">
                    <a>
                        <strong>
                            <i class="glyphicon glyphicon-menu-hamburger"></i> 
                            <?php echo Yii::t('app', 'Layer Menu'); ?>
                        </strong>
                    </a>
                </div>
                <div id="kolapz" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heding">
                    <div class="panel-body">
                        <div class="form-group">
                            <!-- <p>
                                <a href="javascript:showAllLayer();"><?php //echo Yii::t('app', 'Show All Layer'); ?></a>
                            </p> -->
                            <p>
                                <a href="javascript:fit();"><?php echo Yii::t('app', 'Fit to Layer'); ?></a>
                            </p>
                        </div>
                            <fieldset>
                                <legend><?php echo Yii::t('app', 'Data Peta'); ?></legend>
                                <?php if (!empty($out_iup)) { ?>
                                    <?php echo $out_iup; ?>
                                <?php } ?>

                                <?php if (!empty($out_tb)) { ?>
                                    <?php echo $out_tb; ?>
                                <?php } ?>

                                <?php if (!empty($out_rku)) { ?>
                                    <?php echo $out_rku; ?>
                                <?php } ?>

                                <?php if (!empty($out_rkt)) : ?>
                                    <fieldset>
                                        <legend><?php echo Yii::t('app', 'Peta RKT'); ?></legend>
                                        <?php echo $out_rkt; ?>
                                    </fieldset>
                                <?php endif; ?>
                            </fieldset>
                        
                        <fieldset>
                            <legend><?php echo Yii::t('app', 'Google Map Type'); ?></legend>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="jenis" onclick="gmap.setMapTypeId(google.maps.MapTypeId.HYBRID);" checked> 
                                    <?php echo Yii::t('app', 'Hybrid'); ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="jenis" onclick="gmap.setMapTypeId(google.maps.MapTypeId.SATELLITE);"> 
                                    <?php echo Yii::t('app', 'Satellite'); ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="jenis" onclick="gmap.setMapTypeId(google.maps.MapTypeId.ROADMAP);"> 
                                    <?php echo Yii::t('app', 'Roadmap'); ?>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="jenis" onclick="gmap.setMapTypeId(google.maps.MapTypeId.TERRAIN);"> 
                                    <?php echo Yii::t('app', 'Terrain'); ?>
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div id="map" class="map">
        <div id="gmap" class="fill"></div>
        <div id="olmap" class="fill"></div>
    </div>

    <div id="popup2" class="ol-popup">
        <h3 class="popover-title">
            <?php echo Yii::t('app', 'Peta Dasar'); ?> 
            <a href="#" id="popup-closer" class="ol-popup-closer"><i class="glyphicon glyphicon-remove"></i></a>
        </h3>
        <div id="popup-content">
            <?php
            // echo sprintf($popup_default, Yii::t('app', 'Desa/Kel.'), '', Yii::t('app', 'Kecamatan'), '', Yii::t('app', 'Kab./Kota'), '', Yii::t('app', 'Zona'), '', Yii::t('app', 'KDB'), '', Yii::t('app', 'KDH'), '', Yii::t('app', 'Penataan Ruang'), '');
            ?>
            <ul class="nav nav-justified" style="margin-top: 5px;">
                <li>
                    <a id="nipz-select" class="btn btn-sm btn-primary">
                        <?php echo Yii::t('app', 'Lihat Informasi'); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScriptFile('//maps.google.com/maps/api/js?key=AIzaSyA-tvXL21kOk59L65zZhoDhzoK2fSc2_eQ&signed_in=true&v=3&sensor=false&libraries=places');
Yii::app()->openlayers->registerAssets();
Yii::app()->clientScript->registerScript('global_kml_file', "var iup = ".CJSON::encode($d_iup).";\nvar tb = ".CJSON::encode($d_tb).";\nvar rkt = ".CJSON::encode($d_rkt).";\nvar rku = " . CJSON::encode($d_rku) . ";\nvar wmsSourceIup = [];\nvar wmsSourceTb = [];\nvar wmsSourceRkt = [];\nvar wmsSource = [];\nvar rek_permohonan_info = [];\nvar rek_permohonan = [];\nvar permohonan = [];\nvar hasil_identifikasi = [];", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/statics/js/sprintf.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/statics/js/main.min.js', CClientScript::POS_END);
$js_code = "";
$urlGeo = Yii::app()->params->geoServerUrl.Yii::app()->params->namaWorkspace.'/wms';
$geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
// var_dump($d_rku);die;
$urlzzz = $geoserver->getCapabilities(Yii::app()->params->namaWorkspace,'text/xml', $d_iup);
// $string = trim(preg_replace('/\s+/', ' ', $urlzzz));
$js_code .= <<<EOT
view.setCenter([12941706.133019758,-74113.31276709272]);
view.setZoom(5);
olMapDiv.parentNode.removeChild(olMapDiv);
var tiledIup = [];
var tiledTb = [];
var tiledRkt = [];
var tiled = [];
// var Extent;
// RKU
if(iup.length > 0) {
    for(var i = 0; i < iup.length;i++) {
        // var format = 'image/png';

        wmsSourceIup[i] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            // 'FORMAT': format, 
            // 'VERSION': '1.1.1',
            // tiled: true,
            STYLES: 'RKT',
            LAYERS: 'hti:'+iup[i]
          },
          serverType: 'geoserver'
        });

        tiledIup[i] = new ol.layer.Tile({
            source: wmsSourceIup[i]
          });

        tiledIup[i].getSource().on('tileloadstart', function(event) {
            //replace with your custom action
            $('.fill').css('background-color','rgba(0,0,0,0.7)');
            $('#progress-nipz').css('display','block').fadeIn(50);
            $('#progress-nipz').find('img').attr('src','{$baseurl}/img/ajax-loader.gif');
            // progress.addLoading();
        });

        tiledIup[i].getSource().on('tileloadend', function(event) {
            $('#progress-nipz').css('display','none').fadeOut(50);
            $('.fill').css('background-color','');
            // progress.addLoading();
        });
        tiledIup[i].getSource().on('tileloaderror', function(event) {
            $('.fill').css('background-color','rgba(0,0,0,0.7)');
            $('#progress-nipz').find('img').remove();
            $('#progress-nipz').find('span').remove();
            $('#progress-nipz').find('p').css({display:'block',fontSize:'13px',padding:'5px'});
            $('#progress-nipz').css('right','29%');
            // $('#progress-nipz').append('<p>There was an error when loading layer. Please fix it.</p>');
            // progress.addLoading();
        });

        map.addLayer(tiledIup[i]);
    }
}

if(tb.length > 0) {
    // alert('yes');
    for(var i = 0; i < tb.length;i++) {
        var format = 'image/png';

        wmsSourceTb[i] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            'FORMAT': format, 
                   // 'VERSION': '1.1.1',
                   // tiled: true,
                // STYLES: 'RKT',
                LAYERS: 'hti:'+tb[i]
          },
          serverType: 'geoserver'
        });

        tiledTb[i] = new ol.layer.Tile({
            source: wmsSourceTb[i]
          });

        map.addLayer(tiledTb[i]);
    }
}

if(rku.length > 0) {
    // alert('yes');
    for(var i = 0; i < rku.length;i++) {
        // var format = 'image/png';

        wmsSource[i] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            // 'FORMAT': format, 
            // 'VERSION': '1.1.1',
            // tiled: true,
            STYLES: 'RKT',
            LAYERS: 'hti:'+rku[i]
          },
          serverType: 'geoserver'
        });

        tiled[i] = new ol.layer.Tile({
            source: wmsSource[i]
          });

        // tiled[i].getSource().on('tileloadstart', function(event) {
        //     //replace with your custom action
        //     $('.fill').css('background-color','rgba(0,0,0,0.7)');
        //     $('#progress-nipz').css('display','block').fadeIn(50);
        //     $('#progress-nipz').find('img').attr('src','{$baseurl}/img/ajax-loader.gif');
        //     // progress.addLoading();
        // });

        // tiled[i].getSource().on('tileloadend', function(event) {
        //     $('#progress-nipz').css('display','none').fadeOut(50);
        //     $('.fill').css('background-color','');
        //     // progress.addLoading();
        // });
        // tiled[i].getSource().on('tileloaderror', function(event) {
        //     $('.fill').css('background-color','rgba(0,0,0,0.7)');
        //     $('#progress-nipz').find('img').remove();
        //     $('#progress-nipz').find('span').remove();
        //     $('#progress-nipz').find('p').css({display:'block',fontSize:'13px',padding:'5px'});
        //     $('#progress-nipz').css('right','29%');
        //     // $('#progress-nipz').append('<p>There was an error when loading layer. Please fix it.</p>');
        //     // progress.addLoading();
        // });

        map.addLayer(tiled[i]);
    }
}

if(rkt.length > 0) {
    // alert('yes');
    for(var i = 0; i < rkt.length;i++) {
        var format = 'image/png';

        wmsSourceRkt[i] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            'FORMAT': format, 
                   // 'VERSION': '1.1.1',
                   // tiled: true,
                // STYLES: 'RKT',
                LAYERS: 'hti:'+rkt[i]
          },
          serverType: 'geoserver'
        });

        tiledRkt[i] = new ol.layer.Tile({
            source: wmsSourceRkt[i]
          });

        map.addLayer(tiledRkt[i]);
    }
}

var parser = {$urlzzz};
if(parser.hasOwnProperty('error')) {
    $('.fill').css('background-color','rgba(0,0,0,0.7)');
    alert(parser.error);
} else if(isEmpty(parser)) {
    $('.nipz-map').empty();
    alert('Peta tidak ditemukan. Silahkan upload data peta terlebih dahulu.');
    window.location="{$this->createUrl("createIup")}";
} else if(parser.hasOwnProperty('minx')) {
    var tes = [parseFloat(parser.minx[0]),parseFloat(parser.miny[0]),parseFloat(parser.maxx[0]),parseFloat(parser.maxy[0])];
    var hi = ol.extent.getCenter(tes);
    // var h = getCenterOfExtent(tes);

    view.setCenter(ol.proj.transform(hi, 'EPSG:4326', 'EPSG:3857'));
    view.setZoom(10);
} else {
    alert(parser.toSource());
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}

map.on('singleclick', function (evt) {
    // alert(evt.coordinate);
    $('#kolapz').collapse('hide');
});

function getCenterOfExtent(Extent){
    var X = Extent[0] + (Extent[2]-Extent[0])/2;
    var Y = Extent[1] + (Extent[3]-Extent[1])/2;
    return [parseFloat(X), parseFloat(Y)];
}
function fit() {
    view.setCenter(ol.proj.transform(hi, 'EPSG:4326', 'EPSG:3857'));
    view.setZoom(11);
}
EOT;

Yii::app()->clientScript->registerScript('gmap_inisiasi', $js_code, CClientScript::POS_END);