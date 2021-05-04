<?php
$this->breadcrumbs=array(
    'Peta'=>array('index'),
    'Manage',
);
$baseurl = Yii::app()->request->baseUrl;
$modelPropinsi = new Provinsi;

$tmpl_checkbox_iup = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="iupTile(%d);"> 
        <a href="#" onclick="zoom('%s','iup');return false;">%s</a>
    </label>
</div>
EOT;

$tmpl_checkbox_tb = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="tbTile(%d);"> 
        <a href="#" onclick="zoom('%s','tb');return false;">%s</a>
    </label>
</div>
EOT;

$tmpl_checkbox_rku = <<<EOT
<div class="checkbox check-nip">
    <label>
        <input type="checkbox" name="list[]" id="list%d" onclick="rkuTile(%d);"> 
        <a href="#" onclick="zoom('%s','rku');return false;">%s</a>
    </label>
</div>
EOT;

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
        <input type="checkbox" name="list[]" id="list%d" onclick="rktTile(%d);"> 
        <a href="#" onclick="zoom('%s','rkt');return false;">%s<br>(%s)</a>
    </label>
</div>
EOT;

// Peta Kawasan
$out_iup = '';
$d_iup = array();
$iup = Iuphhk::model()->findAll();
if($iup) {
    foreach($iup as $iupp) {
        $id_iup[] = $iupp->id_iuphhk;
    }

    $criteria_iup = array(
        'condition' => "Model = 'PetaIUP' AND Model_id IN(" . implode(',', $id_iup) . ")",
        'order' => 'Model_id',
        'select' => 'File_Name,Model_id'
    );
    $map_iup = Attachment::model()->findAll($criteria_iup);
    if($map_iup) {
        $i = 0;
        foreach ($map_iup as $miup) {
            $eks_iup = end(explode('/',$miup->File_Name));
            $eks_iup1 = explode('.', $eks_iup);
            if($eks_iup1[1] == 'shp') {
                $nama_perusahaan_iup = SpasialIup::model()->find('id_iup = '.$miup->Model_id);
                // var_dump($nama_perusahaan_rku);die;
                $i++;
                $map_path_iup = $eks_iup1[0];
                // $map_path2 = Yii::app()->createAbsoluteUrl(Yii::app()->params->uploadDir . "SPASIAL/" . $file_info2['filename'] . ".shp");
                $d_iup[] = $map_path_iup;
                // var_dump($d_rku);die;
                // $ff = explode('.', basename($file_info_rku['filename']));
                $judul2 = $this->titleize($nama_perusahaan_iup->idPerusahaan->nama_perusahaan);
                $out_iup .= sprintf($tmpl_checkbox_iup, $i, ($i - 1), $map_path_iup, $nama_perusahaan_iup->idPerusahaan->nama_perusahaan) . "\n";
            }
        }
    }
}

// Peta Tata Batas
$out_tb = '';
$d_tb = array();
$iup_tb = Iuphhk::model()->findAll();
if($iup_tb) {
    foreach($iup_tb as $iupp) {
        $id_iup[] = $iupp->id_iuphhk;
    }

    $criteria_tb = array(
        'condition' => "Model = 'PetaTB' AND Model_id IN(" . implode(',', $id_iup) . ")",
        'order' => 'Model_id',
        'select' => 'File_Name,Model_id'
    );
    $map_tb = Attachment::model()->findAll($criteria_tb);
    if($map_tb) {
        $i = 0;
        foreach ($map_tb as $mtb) {
            $eks_tb = end(explode('/',$mtb->File_Name));
            $eks_tb1 = explode('.', $eks_tb);
            if($eks_tb1[1] == 'shp') {
                $nama_perusahaan_tb = SpasialTb::model()->find('id_iup = '.$mtb->Model_id);
                // var_dump($nama_perusahaan_rku);die;
                $i++;
                $map_path_tb = $eks_tb1[0];
                // $map_path2 = Yii::app()->createAbsoluteUrl(Yii::app()->params->uploadDir . "SPASIAL/" . $file_info2['filename'] . ".shp");
                $d_tb[] = $map_path_tb;
                // var_dump($d_rku);die;
                // $ff = explode('.', basename($file_info_rku['filename']));
                $judul2 = $this->titleize($nama_perusahaan_tb->idPerusahaan->nama_perusahaan);
                $out_tb .= sprintf($tmpl_checkbox_tb, $i, ($i - 1), $map_path_tb, $nama_perusahaan_tb->idPerusahaan->nama_perusahaan) . "\n";
            }
        }
    }
}

// Peta RKU
$out_rku = '';
$d_rku = array();
$model_rku = Rku::model()->findAll(array('condition'=>'status = 1'));
// var_dump($model_rku);die;
if($model_rku) {
	$rku_id = array();
	foreach($model_rku as $md) {
		$rku_id[] = $md->id_rku;
	}
    // $spasial = SpasialRku::model()->find(array('condition'=>'id_perusahaan = '.Yii::app()->user->idPerusahaan()));
    $criteria_rku = array(
        'condition' => "Model = 'PetaRKU' AND Model_id IN(" . implode(',', $rku_id) . ")",
        'order' => 'Model_id',
        'select' => 'File_Name,Model_id'
    );
    $map_rku = Attachment::model()->findAll($criteria_rku);
    // var_dump($map_rku);die;
    if ($map_rku) {
        $i = 0;
        foreach ($map_rku as $mrku) {
            $eks_rku = end(explode('/',$mrku->File_Name));
            $eks_rku1 = explode('.', $eks_rku);
            if($eks_rku1[1] == 'shp') {
                $nama_perusahaan_rku = SpasialRku::model()->find('id_rku = '.$mrku->Model_id);
                // var_dump($nama_perusahaan_rku);die;
                $i++;
                $file_info_rku = pathinfo(Yii::app()->params->uploadPath . '/SPASIAL/' . $mrku->File_Name);
                $map_path_rku = $eks_rku1[0];
                // $map_path2 = Yii::app()->createAbsoluteUrl(Yii::app()->params->uploadDir . "SPASIAL/" . $file_info2['filename'] . ".shp");
                $d_rku[] = $map_path_rku;
                // var_dump($d_rku);die;
                // $ff = explode('.', basename($file_info_rku['filename']));
                $judul2 = $this->titleize($nama_perusahaan_rku->idPerusahaan->nama_perusahaan);
                $out_rku .= sprintf($tmpl_checkbox_rku, $i, ($i - 1), $map_path_rku, $nama_perusahaan_rku->idPerusahaan->nama_perusahaan) . "\n";
            }
        }
    }
}

// Peta RKT
$out_rkt = '';
$tmpl_rkt = '';
$d_rkt = array();
$model_rkt = SpasialRkt::model()->with(array('idRkt'=>array('select'=>'distinct idRkt.tahun_mulai','condition'=>'status = 1', 'order'=>'idRkt.tahun_mulai ASC')))->findAll();
// var_dump($model_rkt);die;
if($model_rkt) {
    $j = 0;
                $i = 0;
    foreach($model_rkt as $mdrkt) {

        $out_rkt = '';
        $tahun = $mdrkt->idRkt->tahun_mulai;
        // echo $tahun.'<br>';
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

    }
}
?>

<?php require_once('filter.php') ?>

<div id="leftCol" class="col-md-3">
    <div class="well well-sm nipz-panel">
        <fieldset>
            <legend>Peta Kawasan/IUP</legend>
            <?php if (!empty($out_iup)) { ?>
                <div id="dataIup">
                    <?php echo $out_iup; ?>
                </div>
            <?php } else { ?>
                <p>Tidak ada data peta.</p>
            <?php } ;?>
        </fieldset>

        <fieldset>
            <legend>Peta Tata Batas</legend>
            <?php if (!empty($out_tb)) { ?>
                <div id="dataTb">
                    <?php echo $out_tb; ?>
                </div>
            <?php } else { ?>
                <p>Tidak ada data peta.</p>
            <?php } ;?>
        </fieldset>

        <?php if (!empty($out_rku)) { ?>
        <fieldset>
            <legend>Peta RKU</legend>
            <div id="dataRku">
                <?php echo $out_rku; ?>
            </div>
        </fieldset>
        <?php } else { ?>
        <fieldset>
            <legend>Peta RKU</legend>
            <p>Tidak ada data peta.</p>
        </fieldset>
        <?php } ;?>

        <?php if (!empty($tmpl_rkt)) { ?>
        <fieldset>
            <legend>Peta RKT</legend>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div id="dataRkt">
                <?php echo $tmpl_rkt; ?>
                </div>
            </div>
        </fieldset>
        <?php } else { ?>
        <fieldset>
            <legend>Peta RKT</legend>
            <p>Tidak ada data peta.</p>
        </fieldset>
        <?php } ;?>
    </div>
</div>
<div id="" class="col-md-9">
    <!-- <h4 class="page-header">Peta</h4>
    <a class="btn btn-primary" href="<?php //echo $this->createUrl('update',array('id'=>$spasial->id));?>">Update Data Peta</a>
	<div class="clearfix" style="margin-bottom:25px"></div> -->

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
Yii::app()->clientScript->registerScript('global_kml_file', "var iup = " . CJSON::encode($d_iup) . ";\nvar tb = " . CJSON::encode($d_tb) . ";\nvar rkt = " . CJSON::encode($d_rkt) . ";\nvar rku = " . CJSON::encode($d_rku) . ";\nvar wmsSourceIup = [];\nvar wmsSourceTb = [];\nvar wmsSourceRkt = [];\nvar wmsSource = [];\nvar rek_permohonan_info = [];\nvar rek_permohonan = [];\nvar permohonan = [];\nvar hasil_identifikasi = [];", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/statics/js/sprintf.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/statics/js/main.min.js', CClientScript::POS_END);
$js_code = "";
$urlGeo = Yii::app()->params->geoServerUrl.Yii::app()->params->namaWorkspace.'/wms';
$geoserver = new GeoserverWrapper(Yii::app()->params->geoServerUrl, Yii::app()->params->geoUser, Yii::app()->params->geoPass);
$urlzzz = $geoserver->getCapabilities(Yii::app()->params->namaWorkspace,'text/xml', $d_rku);
// $urlj = $geoserver->getCapabilities(Yii::app()->params->namaWorkspace,'text/xml');
// var_dump($urlzzz);die;
// $string = trim(preg_replace('/\s+/', ' ', $urlzzz));
$js_code .= <<<EOT
view.setCenter([12941706.133019758,-74113.31276709272]);
view.setZoom(5);
olMapDiv.parentNode.removeChild(olMapDiv);

if({$urlzzz}.hasOwnProperty('error')) {
	alert({$urlzzz}.error);
	$('.fill').css('background-color','rgba(0,0,0,0.7)');
}
if({$urlzzz} == 'error') {
	alert('error');
}

var tiled = [];
var tiledRkt = [];
var tiledIup = [];
var tiledTb = [];

// IUP/Kawasan
if(iup.length > 0) {
    // alert('yes');
    for(var i = 0; i < iup.length;i++) {
        // var format = 'image/png';

        wmsSourceIup[i] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            // 'FORMAT': format, 
            // 'VERSION': '1.1.1',
            // tiled: true,
            STYLES: '',
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

// Tata Batas
if(tb.length > 0) {
    // alert('yes');
    for(var i = 0; i < tb.length;i++) {
        // var format = 'image/png';

        wmsSourceTb[i] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            // 'FORMAT': format, 
            // 'VERSION': '1.1.1',
            // tiled: true,
            STYLES: '',
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

// RKU
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

        map.addLayer(tiled[i]);
    }
}

// RKT
if(rkt.length > 0) {
    for(var i = 0; i < rkt.length;i++) {
        // var format = 'image/png';
        // alert(rkt[i]);
        wmsSourceRkt[i] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            // 'FORMAT': format, 
			// 'VERSION': '1.1.1',
			// tiled: true,
			STYLES: 'RKT',
			LAYERS: 'hti:'+rkt[i]
          }
        });

        tiledRkt[i] = new ol.layer.Tile({
            source: wmsSourceRkt[i]
        });

        map.addLayer(tiledRkt[i]);
    }
}

var parser = {$geoserver->getCapabilitiesClick(Yii::app()->params->namaWorkspace,'text/xml')};

function zoom(key,apa) {
	for(var i=0; i < apa.length; i++) {
		for(var j=0; j < parser.length; j++) {
			if(parser[j].nama[0] == key) {
				if(isEmpty(parser[j])) {
				    alert('Peta tidak ditemukan. Silahkan upload data peta terlebih dahulu.');
				} else {
				    var tes = [parseFloat(parser[j].minx[0]),parseFloat(parser[j].miny[0]),parseFloat(parser[j].maxx[0]),parseFloat(parser[j].maxy[0])];
				    // var h = getCenterOfExtent(tes);
                    var hi = ol.extent.getCenter(tes);

				    view.setCenter(ol.proj.transform(hi, 'EPSG:4326', 'EPSG:3857'));
				    view.setZoom(11);
                    return false;
				}
			}
		}
	}
}

function zoomRkt(key) {
	for(var i=0; i < rkt.length; i++) {
		for(var j=0; j < parser.length; j++) {
			if(parser[j].nama[0] == key) {
				if(isEmpty(parser[j])) {
				    alert('Peta tidak ditemukan. Silahkan upload data peta terlebih dahulu.');
				} else {
				    var tes = [parseFloat(parser[j].minx[0]),parseFloat(parser[j].miny[0]),parseFloat(parser[j].maxx[0]),parseFloat(parser[j].maxy[0])];
                    // var h = getCenterOfExtent(tes);
                    var hi = ol.extent.getCenter(tes);

				    view.setCenter(ol.proj.transform(hi, 'EPSG:4326', 'EPSG:3857'));
				    view.setZoom(11);
                    return false;
				}
			}
		}
	}
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}

function newProv(data) {
    // alert(data.toSource());
    for(var j = 0; j < tiled.length; j++) {
        map.removeLayer(tiled[j]);
    }

    for(var i=0; i < data.length; i++) {
        var format = 'image/png';
        wmsSource[i] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            'FORMAT': format, 
                   'VERSION': '1.1.1',
                   tiled: true,
                STYLES: 'RKT',
                LAYERS: 'hti:'+data[i]
          }
        });

        tiled[i] = new ol.layer.Tile({
            source: wmsSource[i]
          });

        map.addLayer(tiled[i]);
    }
}

function newProvRkt(dataRkt) {
    for(var k = 0; k < tiledRkt.length; k++) {
        map.removeLayer(tiledRkt[k]);
    }
    for(var x=0; x < dataRkt.length; x++) {
        var format = 'image/png';
        wmsSourceRkt[x] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            'FORMAT': format, 
                   'VERSION': '1.1.1',
                   tiled: true,
                STYLES: '',
                LAYERS: 'hti:'+dataRkt[x]
          }
        });

        tiledRkt[x] = new ol.layer.Tile({
            source: wmsSourceRkt[x]
          });

        map.addLayer(tiledRkt[x]);
    }
}

function newProvIup(dataIup) {
    for(var k = 0; k < tiledIup.length; k++) {
        map.removeLayer(tiledIup[k]);
    }
    for(var x=0; x < dataIup.length; x++) {
        var format = 'image/png';
        wmsSourceIup[x] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            'FORMAT': format, 
                   'VERSION': '1.1.1',
                   tiled: true,
                STYLES: '',
                LAYERS: 'hti:'+dataIup[x]
          }
        });

        tiledIup[x] = new ol.layer.Tile({
            source: wmsSourceIup[x]
          });

        map.addLayer(tiledIup[x]);
    }
}

function newProvTb(dataTb) {
    for(var k = 0; k < tiledTb.length; k++) {
        map.removeLayer(tiledTb[k]);
    }
    for(var x=0; x < dataTb.length; x++) {
        var format = 'image/png';
        wmsSourceTb[x] = new ol.source.TileWMS({
          url: '{$urlGeo}',
          params: {
            'FORMAT': format, 
                   'VERSION': '1.1.1',
                   tiled: true,
                STYLES: '',
                LAYERS: 'hti:'+dataTb[x]
          }
        });

        tiledTb[x] = new ol.layer.Tile({
            source: wmsSourceTb[x]
          });

        map.addLayer(tiledTb[x]);
    }
}

map.on('singleclick', function (evt) {
    // alert(evt.coordinate);
    $('#kolapz').collapse('hide');
});
function fit() {
    view.setCenter([12941706.133019758,-74113.31276709272]);
    view.setZoom(5);
}
EOT;

Yii::app()->clientScript->registerScript('inisiasi_checkbox', "
	initializez();
", CClientScript::POS_END);
Yii::app()->clientScript->registerScript('gmap_inisiasi', $js_code, CClientScript::POS_END);