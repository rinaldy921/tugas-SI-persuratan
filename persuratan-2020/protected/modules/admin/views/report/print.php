<?php $baseUrl = Yii::app()->request->baseUrl;
Yii::app()->booster->cs->registerPackage('bootstrap.css');
Yii::app()->clientScript->registerCssFile($baseUrl.'/statics/css/print.css');
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <?php
        if(isset($params)) {
            $model = $params['iup'];
            $modal = $params['modal'];
            $investasi = $params['investasi'];
            $admPemerintahan = $params['admPemerintahan'];
            $admKehutanan = $params['admKehutanan'];
            
            
//            print_r("<pre>");
//            print_r($admKehutanan);
//            print_r("</pre>"); exit(1);
            // $rku = $params['rku'];
            // RKU di ceklis

            if(isset($params['rku']) && !empty($params['rku'])) {
                // Silvikultur
                $rkuSilvikultur = RkuSistemSilvikultur::model()->find(array('condition' => 'id_rku='.$rku->id_rku));
                $rkuTanaman = new RkuTanamanSilvikultur('search');
                $rkuTanaman->unsetAttributes();
                $rkuTanaman->id_rku = $rku->id_rku;
                
                $rkuPotensiProduksi = RkuPotensiProduksi::model()->find(array('condition' => 'id_rku='.$rku->id_rku));

                // Rku Prasyarat
                $rkuModelGanis = new RkuGanis;
                $rkuModelGanis->unsetAttributes();
                if (isset($_GET['RkuGanis']))
                    $rkuModelGanis->attributes = $_GET['RkuGanis'];
                $rkuModelGanis->id_rku = $rku->id_rku;

                $rkuTataBatas = new RkuTataBatas;
                $rkuTataBatas->unsetAttributes();
                if (isset($_GET['RkuTataBatas']))
                    $rkuTataBatas->attributes = $_GET['RkuTataBatas'];
                $rkuTataBatas->id_rku = $rku->id_rku;

                $rkuKawasan = new RkuKawasanLindung;
                $rkuKawasan->unsetAttributes();
                if (isset($_GET['RkuKawasanLindung']))
                    $rkuKawasan->attributes = $_GET['RkuKawasanLindung'];
                $rkuKawasan->id_rku = $rku->id_rku;

                $rkuArealNonProduktif = new RkuArealNonProduktif;
                $rkuArealNonProduktif->unsetAttributes();
                if (isset($_GET['RkuArealNonProduktif']))
                    $rkuArealNonProduktif->attributes = $_GET['RkuArealNonProduktif'];
                $rkuArealNonProduktif->id_rku = $rku->id_rku;

                $rkuArealProduktif = new RkuArealProduktif('search');
                $rkuArealProduktif->unsetAttributes();
                if (isset($_GET['RkuArealProduktif']))
                    $rkuArealProduktif->attributes = $_GET['RkuArealProduktif'];
                $rkuArealProduktif->id_rku = $rku->id_rku;

                $rkuArealKerja = new RkuArealKerja;
                $rkuArealKerja->unsetAttributes();
                if (isset($_GET['RkuArealKerja']))
                    $rkuArealKerja->attributes = $_GET['RkuArealKerja'];
                $rkuArealKerja->id_rku = $rku->id_rku;

                $rkuPwh = new RkuPwh;
                $rkuPwh->unsetAttributes();
                if (isset($_GET['RkuPwh']))
                    $rkuPwh->attributes = $_GET['RkuPwh'];
                $rkuPwh->id_rku = $rku->id_rku;
                
                $rkuPeralatan = new RkuPeralatan;
                $rkuPeralatan->unsetAttributes();
                if (isset($_GET['RkuPeralatan']))
                    $rkuPeralatan->attributes = $_GET['RkuPeralatan'];
                $rkuPeralatan->id_rku = $rku->id_rku;
                
                $rkuSarpras = new RkuSarpras;
                $rkuSarpras->unsetAttributes();
                if (isset($_GET['RkuSarpras']))
                    $rkuSarpras->attributes = $_GET['RkuSarpras'];
                $rkuSarpras->id_rku = $rku->id_rku;


                // Rku Produksi
                $rkuBibit = new RkuBibitNew();
                $rkuBibit->unsetAttributes();
                if (isset($_GET['RkuBibitNew']))
                    $rkuBibit->attributes = $_GET['RkuBibitNew'];
                $rkuBibit->id_rku = $rku->id_rku;

                $rkuSiapLahan = new RkuPenyiapanLahan('search');
                $rkuSiapLahan->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuPenyiapanLahan']))
                    $rkuSiapLahan->attributes = $_GET['RkuPenyiapanLahan'];
                $rkuSiapLahan->id_rku = $rku->id_rku;

                $rkuPenanaman = new RkuTanam('search');
                $rkuPenanaman->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuTanam']))
                    $rkuPenanaman->attributes = $_GET['RkuTanam'];
                $rkuPenanaman->id_rku = $rku->id_rku;

                $rkuPemeliharaan = new RkuPelihara('search');
                $rkuPemeliharaan->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuPelihara']))
                    $rkuPemeliharaan->attributes = $_GET['RkuPelihara'];
                $rkuPemeliharaan->id_rku = $rku->id_rku;

                $rkuPanen = new RkuPanen('search');
                $rkuPanen->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuPanen']))
                    $rkuPanen->attributes = $_GET['RkuPanen'];
                $rkuPanen->id_rku = $rku->id_rku;

                $rkuPasar = new RkuPasar('search');
                $rkuPasar->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuPasar']))
                    $rkuPasar->attributes = $_GET['RkuPasar'];
                $rkuPasar->id_rku = $rku->id_rku;

                // Rku Lingkungan
                $rkuHamkit = new RkuHamaPenyakit('search');
                $rkuHamkit->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuHamaPenyakit']))
                    $rkuHamkit->attributes = $_GET['RkuHamaPenyakit'];
                $rkuHamkit->id_rku = $rku->id_rku;

                $rkuTekdam = new RkuTeknikPemadaman('search');
                $rkuTekdam->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuTeknikPemadaman']))
                    $rkuTekdam->attributes = $_GET['RkuTeknikPemadaman'];
                $rkuTekdam->id_rku = $rku->id_rku;

                $rkuAlatDamkar = new RkuAlatDamkar('search');
                $rkuAlatDamkar->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuAlatDamkar']))
                    $rkuAlatDamkar->attributes = $_GET['RkuAlatDamkar'];
                $rkuAlatDamkar->id_rku = $rku->id_rku;

                $rkuPerambahan = new RkuPerambahanHutan('search');
                $rkuPerambahan->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuPerambahanHutan']))
                    $rkuPerambahan->attributes = $_GET['RkuPerambahanHutan'];
                $rkuPerambahan->id_rku = $rku->id_rku;

                $rkuPemantauan = new RkuPemantauanLingkungan('search');
                $rkuPemantauan->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuPemantauanLingkungan']))
                    $rkuPemantauan->attributes = $_GET['RkuPemantauanLingkungan'];
                $rkuPemantauan->id_rku = $rku->id_rku;

                //Rku Sosial
                $mukim = new RkuInfraMukim('search');
                $mukim->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuInfraMukim']))
                    $mukim->attributes = $_GET['RkuInfraMukim'];
                $mukim->id_rku = $rku->id_rku;

                $lembaga = new RkuKelembagaan('search');
                $lembaga->unsetAttributes();  // clear any default values
                if (isset($_GET['RkuKelembagaan']))
                    $lembaga->attributes = $_GET['RkuKelembagaan'];
                $lembaga->id_rku = $rku->id_rku;
            }
        }
        ?>
        <!-- <div id="header">
            <table width="100%" border="0">
                <tr>
                    <td width="13%"><img width="80" src="<?php echo Yii::app()->baseUrl; ?>/img/logo22.png"></td>
                    <td>
                        <h4>Kementerian Lingkungan Hidup dan Kehutanan</h4>
                        <h5>Direktorat Bina Usaha Hutan Tanaman</h5>
                    </td>
                </tr>
            </table>
        </div> -->
        <div id="body">
            <div id="body-center">
                <h4>
                    <strong><?php echo Yii::t('app', 'DATA PEMEGANG IUPHHK'); ?></strong>
                </h4>
                <h5>
                    <?php echo $model->getAttributeLabel('nomor'); ?>: 
                    <?php echo $model->nomor; ?>
                </h5>
            </div>
            <div id="iup">
                <table class="nipz" width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td width="100%" colspan="4"><bold>1.&nbsp;&nbsp;DATA POKOK </bold></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="37%">a.&nbsp;&nbsp;Nama Perusahaan</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $model->idPerusahaan->nama_perusahaan ?></td>
                        </tr>
                        
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="37%">b.&nbsp;&nbsp;Status Perusahaan</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="37%">c.&nbsp;&nbsp;Alamat</td>
                            <td width="1%"></td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kantor Pusat</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $model->idPerusahaan->alamat?></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="37%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kantor Cabang</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="4">d.&nbsp;&nbsp;Keputusan IUIPHHK-HTI </td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Nomor</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $model->nomor ?></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Tanggal</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $model->tanggal ?></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Luas Izin</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $model->luas ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Masa Berlaku</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="4">e.&nbsp;&nbsp;Addendum 1 </td>
                        </tr>
                       
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">f.&nbsp;&nbsp;Kelas Perusahaan</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">g.&nbsp;&nbsp;Status Permodalan</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $modal->jenis ?></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">h.&nbsp;&nbsp;Jumlah Investasi Awal (Rp)</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $investasi->jml_rupiah ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">h.&nbsp;&nbsp;Jumlah Investasi Awal (USD)</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $investasi->jml_dollar ?></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="4">i.&nbsp;&nbsp;Susunan Pengurus Perusahaan </td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Komisaris Utama</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Komisaris</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Direktur Utama</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Direktur Keuangan</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Direktur Produksi</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Direktur Pengembangan</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Direktur Umum</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="4">j.&nbsp;&nbsp;Kepemilikan Industri </td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Terkait Dengan Industri</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Jenis Produk</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Lokasi</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        
                        
                         <tr>
                            <td width="100%" colspan="4"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan="4"><bold>2.&nbsp;&nbsp;LOKASI AREAL KERJA </bold></td>
                        </tr>
                         <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="4">a.&nbsp;&nbsp;Administrasi Pemerintahan </td>
                        </tr>
                       
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Provinsi</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $admPemerintahan->provinsi0->nama ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kabupaten</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $admPemerintahan->kabupaten0->nama ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Kecamatan</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $admPemerintahan->kecamatan0->nama ?></td>
                        </tr>
                        
                         <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="98%" colspan="4">a.&nbsp;&nbsp;Administrasi Kehutanan </td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Provinsi/KPH/CDK</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $admKehutanan->dinhutProv->nama.' / '.$admKehutanan->idKph->nama_kph ?></td>
                        </tr>
                         <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Bagian Hutan/Dinas Kabupaten</td>
                            <td width="1%">:</td>
                            <td width="60%"><?= $admKehutanan->dinhutKab->nama ?></td>
                        </tr>
                        
                          <tr>
                            <td width="100%" colspan="4"><bold>&nbsp;&nbsp; </bold></td>
                        </tr>
                        
                          <tr>
                            <td width="100%" colspan="4"><bold>3.&nbsp;&nbsp;TATA BATAS AREAL KERJA </bold></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;a. SK. Tata Batas (No./Tanggal)</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;b. Panjang Batas (temu gelang)</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                        <tr>
                            <td width="4%">&nbsp;</td>
                            <td width="35%">&nbsp;&nbsp;&nbsp;&nbsp;c. Progres Tata Batas</td>
                            <td width="1%">:</td>
                            <td width="60%"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php if(isset($params['rku'])): ?>
                <div id="rku">
                    <div class="page-header">
                        <h4>Data RKU</h4>
                    </div>

                    <?php if(isset($params['rkuLegalitas']) || isset($params['rkuAll'])):?>
                        <div class="sub-item">
                            <h5>&#8801; Legalitas</h5>
                        </div>
                        <?php
                            $this->widget('booster.widgets.TbGridView', array(
                                'id' => Yii::app()->controller->id . '-grid',
                                'type' => 'bordered condensed striped konten',
                                'responsiveTable' => false,
                                'enableSorting' => false,
                                'dataProvider' => $rku->search(),
                                'template' => '{items}',
                                'columns' => array(
                                    'tahun_mulai',
                                    'tahun_sampai',
                                    'nomor_sk',
                                    'tgl_sk',
                                    array(
                                        'name' => 'mulai_berlaku',
                                        'value' => 'isset($data->mulai_berlaku) ? Yii::app()->controller->getDateMonth($data->mulai_berlaku) : null'
                                    ),
                                    array(
                                        'name' => 'akhir_berlaku',
                                        'value' => 'isset($data->akhir_berlaku) ? Yii::app()->controller->getDateMonth($data->akhir_berlaku) : null'
                                    ),
                                )
                            ));
                        ?>
                    <?php endif; ?>

                    <?php if(isset($params['rkuSilvi']) || isset($params['rkuAll'])):?>
                        <div class="sub-item">
                            <h5>&#8801; Sistem Silvikultur</h5>
                        </div>
                        <div id="data">
                            <table class="nipz" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                    <tr>
                                        <th width="18%">Sistem Silvikultur</th>
                                        <td width="1%">:</td>
                                        <td width="80%"><?= isset($rkuSilvikultur->id_jenis_silvikultur) ? $rkuSilvikultur->idJenisSilvikultur->jenis_silvikultur : NULL ?></td>
                                    </tr>
                                    <tr>
                                        <th>Potensi Rata-rata</th>
                                        <td>:</td>
                                        <td><?= isset($rkuPotensiProduksi->potensi_produksi) ? number_format($rkuPotensiProduksi->potensi_produksi,2,',','.') . ' m3/Ha ' : NULL ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <?php
                            $this->widget('booster.widgets.BootGroupGridView', array(
                                'id' => Yii::app()->controller->id . '-grid',
                                'type' => 'bordered condensed striped',
                                'responsiveTable' => true,
                                'enableSorting' => false,
                                'dataProvider' => $rkuTanaman->search(),
                                'mergeColumns' => array('id_jenis_produksi_lahan'),
                                'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                'template' => '{items}',
                                // 'filter' => $model,
                                'columns' => array(
                                    array(
                                        'name' => 'id_jenis_produksi_lahan',
                                        'header' => 'Tata Ruang',
                                        'value' => '$data->idJenisProduksiLahan->jenis_produksi',
                                    ),
                                    array(
                                        'name' => 'id_jenis_tanaman',
                                        'header' => 'Jenis Tanaman',
                                        'value' => '$data->idJenisTanaman->nama_tanaman',
                                    ),
                                    array(
                                        'name' => 'daur',
                                        'value' => '$data->daur ? $data->daur . " Tahun" : "-"',
                                    ),
                                    array(
                                        'name' => 'jarak_tanam',
                                        'value' => '$data->jarak_tanam ? $data->jarak_tanam : "-"',
                                    )
                                )
                            ));
                        ?>
                    <?php endif; ?>

                    <?php if(isset($params['rkuPrasyarat']) || isset($params['rkuAll'])):?>
                        <div class="sub-item">
                            <h5>&#8801; Prasyarat</h5>
                            <h6>1. Organisasi dan Tenaga Kerja</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => 'ganis-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuModelGanis->search(),
                                    'enableSorting' => false,
                                    'template' => '{items}{pager}',
                                    'columns' => array(
                                        array(
                                            'name' => 'id_ganis',
                                            'value' => '$data->idGanis->nama_jenis',
                                            'footer' => 'Total',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                        array(
                                            'name' => 'jumlah',
                                            'value' => 'isset($data->jumlah) ? number_format($data->jumlah,0) : "" ',
                                            'footer' => '<strong>' . $rkuModelGanis->getTotal($rkuModelGanis->search()->getData(), 'jumlah') . '</strong>',
                                        )
                                    ),
                                ));
                            ?>
                        </div>

                        <div class="sub-item">
                            <h6>2. Penataan Batas Blok</h6>
                        </div>
                        <div id="data">
                        <?php
                            $this->widget('booster.widgets.TbGridView', array(
                                'id' => Yii::app()->controller->id . '-tata-batas-grid',
                                'type' => 'bordered condensed striped',
                                'responsiveTable' => true,
                                'dataProvider' => $rkuTataBatas->search(),
                                'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                'template' => '{items}',
                                'enableSorting' => false,
                                // 'filter' => $model,
                                'columns' => array(
                                    array(
                                        'name' => 'id_jenis_batas',
                                        'header' => 'Jenis Batas',
                                        'value' => '$data->idJenisBatas->jenis_batas',
                                    ),
                                    array(
                                        'name' => 'jumlah',
                                        'value' => '$data->jumlah ? $data->jumlah . " Km" : "-"',
                                    )
                                )
                            ));
                        ?>
                        </div>

                        <div class="sub-item">
                            <h6>3. Penataan Ruang (Kawasan Lindung)</h6>
                        </div>
                        <div id="data">
                        <?php
                            $this->widget('booster.widgets.TbGridView', array(
                                'id' => Yii::app()->controller->id . '-kawasan-lindung-grid',
                                'type' => 'bordered condensed striped',
                                'responsiveTable' => true,
                                'dataProvider' => $rkuKawasan->search(),
                                'enableSorting' => false,
                            // 'filter'=>$model,
                                'template' => '{items}',
                                'columns' => array(
                                    array(
                                        'name' => 'id_jenis_kawasan_lindung',
                                        'header' => 'Kawasan Lindung',
                                        'value' => '$data->idJenisKawasanLindung->nama_jenis',
                                        'footer' => '<strong>Total</strong>',
                                        'footerHtmlOptions'=>array('class'=>'footer')
                                    ),
                                    array(
                                        'header' => 'Jumlah (Ha)',
                                        'name' => 'jumlah',
                                        'type' => 'raw',
                                        'footer' => RkuBibitNew::model()->getTotal($rkuKawasan->search()->getData(), 'jumlah'),
                                        'footerHtmlOptions'=>array('class'=>'footer')
                                    ),
                                ),
                            ));
                            ?>
                        </div>

                        <div class="sub-item">
                            <h6>4. Penataan Ruang (Areal Tidak Efektif)</h6>
                        </div>
                        <div id="data">
                        <?php
                            $this->widget('booster.widgets.TbGridView', array(
                                'id' => Yii::app()->controller->id . '-non-produktif-grid',
                                'type' => 'bordered condensed striped',
                                'responsiveTable' => true,
                                'dataProvider' => $rkuArealNonProduktif->search(),
                                'enableSorting' => false,
                            // 'filter'=>$model,
                                'template' => '{items}{pager}',
                                'columns' => array(
                                    array(
                                        'name' => 'id',
                                        'header' => 'Jenis Areal',
                                        'value' => '"Areal Tidak Efektif"'
                                    ),
                                    array(
                                        'header' => 'Jumlah (Ha)',
                                        'name' => 'jumlah',
                                        'type' => 'raw',
                                        // 'value' => '!empty($data->jumlah) ? $data->jumlah : "-"'
                                    ),
                                ),
                            ));
                            ?>
                        </div>

                        <div class="sub-item">
                            <h6>5. Penataan Ruang (Areal Efektif)</h6>
                        </div>
                        <div id="data">
                        <?php
                            $this->widget('booster.widgets.TbGridView', array(
                                'id' => Yii::app()->controller->id . '-produktif-grid',
                                'type' => 'bordered condensed striped',
                                'responsiveTable' => true,
                                'dataProvider' => $rkuArealProduktif->search(),
                                'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                'template' => '{items}',
                                'enableSorting' => false,
                                // 'filter' => $model,
                                'columns' => array(
                                    array(
                                        'name' => 'id_jenis_produksi_lahan',
                                        'header' => 'Areal Produktif',
                                        'value' => '$data->idJenisProduksiLahan->jenis_produksi',
                                        'footer' => 'Total',
                                        'footerHtmlOptions'=>array('class'=>'footer')
                                    ),
                                    array(
                                        'header' => 'Jumlah (Ha)',
                                        'name' => 'jumlah',
                                        'type' => 'raw',
                                        'footer' => RkuBibitNew::model()->getTotal($rkuArealProduktif->search()->getData(), 'jumlah'),
                                    )
                                )
                            ));
                            ?>
                        </div>

                        <div class="sub-item">
                            <h6>6. Penataan Areal Kerja</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-areal-kerja-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuArealKerja->search(),
                                    'enableSorting' => false,
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}',
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'daur',
                                        ),
                                        'tahun',
                                        'lokasi_rkt',
                                        array(
                                            'name' => 'id_jenis_produksi_lahan',
                                            'header' => 'Areal Produktif',
                                            'value' => '$data->idJenisProduksiLahan->jenis_produksi',
                                        ),
                                        array(
                                            'header' => 'Jumlah (Ha)',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                        )
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>7. Pemasukkan & Penggunaan Peralatan</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-peralatan-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuPeralatan->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'id_peralatan',
                                            'header' => 'Nama Peralatan',
                                            'value' => '$data->idPeralatan->jenis_peralatan',
                                        ),
                                        array(
                                            'header' => 'Jumlah',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                        ),
                                        'keterangan',
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>8. Pengadaan Sarpras</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-sarpras-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuSarpras->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'id_jenis_sarpras',
                                            'header' => 'Nama Sarpras',
                                            'value' => '$data->idJenisSarpras->jenis_sarpras',
                                        ),
                                        array(
                                            'header' => 'Jumlah',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                        )
                                    )
                                ));
                            ?>
                        </div>

                        <div class="sub-item">
                            <h6>9. Pembukaan Wilayah Hutan</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-pwh-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuPwh->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'id_jenis_pwh',
                                            'header' => 'Jenis Pembukaan',
                                            'value' => '$data->idJenisPwh->jenis_pembukaan',
                                        ),
                                        array(
                                            'header' => 'Jumlah (meter)',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                        )
                                    )
                                ));
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($params['rkuKelProd']) || isset($params['rkuAll'])):?>
                        <div class="sub-item">
                            <h5>&#8801; Kelestarian Fungsi Produksi</h5>
                            <h6>1. Pembenihan/Pembibitan</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.BootGroupGridView', array(
                                    'id' => Yii::app()->controller->id . '-bibit-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'mergeColumns' => array('tahun', 'id_tanaman_silvikultur'),
                                    'dataProvider' => $rkuBibit->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'tahun',
                                            'footer' => '<strong>Total</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                        array(
                                            'name' => 'id_tanaman_silvikultur',
                                            'header' => 'Tata Ruang',
                                            'value' => '$data->idTanamanSilvikultur->idJenisProduksiLahan->jenis_produksi',
                                        ),
                                        array(
                                //            'name' => 'id_jenis_tanaman_bibit',
                                            'header' => 'Jenis Tanaman',
                                            'value' => '$data->idTanamanSilvikultur->idJenisTanaman->nama_tanaman',
                                        ),
                                        array(
                                            'header' => 'Jumlah (Btg)',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                            'footer' => '<strong>'.$rkuBibit->getTotal($rkuBibit->search()->getData(), 'jumlah').'</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        )
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>2. Penyiapan Lahan Untuk Penanaman HTI</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.BootGroupGridView', array(
                                    'id' => Yii::app()->controller->id . '-siaplahan-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuSiapLahan->search(),
                                    'mergeColumns' => array('tahun', 'id_jenis_lahan', 'id_tanaman_silvikultur'),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'tahun',
                                            'footer' => 'Total',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                        array(
                                            'name' => 'id_jenis_lahan',
                                            'header' => 'Jenis Lahan',
                                            'value' => '$data->idJenisLahan->jenis_lahan'
                                        ),
                                        array(
                                            'name' => 'id_tanaman_silvikultur',
                                            'header' => 'Tata Ruang',
                                            'value' => '$data->idTanamanSilvikultur->idJenisProduksiLahan->jenis_produksi',
                                        ),
                                        array(
                                //            'name' => 'id_jenis_tanaman_bibit',
                                            'header' => 'Jenis Tanaman',
                                            'value' => '$data->idTanamanSilvikultur->idJenisTanaman->nama_tanaman',
                                        ),
                                        array(
                                            'header' => 'Jumlah (Ha)',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                            'footer' => '<strong>' . RkuBibitNew::model()->getTotal($rkuSiapLahan->search()->getData(), 'jumlah') . '</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                    )
                                ));
                            ?>
                        </div>

                        <div class="sub-item">
                            <h6>3. Penanaman</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.BootGroupGridView', array(
                                    'id' => Yii::app()->controller->id . '-penanaman-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuPenanaman->search(),
                                    'mergeColumns' => array('tahun', 'id_jenis_lahan', 'id_tanaman_silvikultur'),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'tahun',
                                            'footer' => '<strong>Total</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                        array(
                                            'name' => 'id_jenis_lahan',
                                            'header' => 'Jenis Lahan',
                                            'value' => '$data->idJenisLahan->jenis_lahan'
                                        ),
                                        array(
                                            'name' => 'id_tanaman_silvikultur',
                                            'header' => 'Tata Ruang',
                                            'value' => '$data->idTanamanSilvikultur->idJenisProduksiLahan->jenis_produksi',
                                        ),
                                        array(
                                //            'name' => 'id_jenis_tanaman_bibit',
                                            'header' => 'Jenis Tanaman',
                                            'value' => '$data->idTanamanSilvikultur->idJenisTanaman->nama_tanaman',
                                        ),
                                        array(
                                            'header' => 'Jumlah (Ha)',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                            'footer' => '<strong>'.RkuBibitNew::model()->getTotal($rkuPenanaman->search()->getData(), 'jumlah').'</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>4. Pemeliharaan Tanaman</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.BootGroupGridView', array(
                                    'id' => Yii::app()->controller->id . '-pemeliharaan-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuPemeliharaan->search(),
                                    'mergeColumns' => array('tahun', 'id_tanaman_silvikultur'),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'tahun',
                                            'footer' => '<strong>Total</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                        array(
                                            'name' => 'id_tanaman_silvikultur',
                                            'header' => 'Tata Ruang',
                                            'value' => '$data->idTanamanSilvikultur->idJenisProduksiLahan->jenis_produksi',
                                        ),
                                        array(
                                            'header' => 'Jenis Tanaman',
                                            'value' => '$data->idTanamanSilvikultur->idJenisTanaman->nama_tanaman',
                                        ),
                                        array(
                                            'header' => 'Jumlah (Ha)',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                            'footer' => '<strong>' . RkuBibitNew::model()->getTotal($rkuPemeliharaan->search()->getData(), 'jumlah') . '</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        )
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>5. Pemanenan</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.BootGroupGridView', array(
                                    'id' => Yii::app()->controller->id . '-panen-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuPanen->search(),
                                    'mergeColumns' => array('tahun', 'id_tanaman_silvikultur'),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    'columns' => array(
                                        array(
                                            'name' => 'tahun',
                                            'footer' => '<strong>Total</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                        array(
                                            'name' => 'id_tanaman_silvikultur',
                                            'header' => 'Tata Ruang',
                                            'value' => '$data->idTanamanSilvikultur->idJenisProduksiLahan->jenis_produksi',
                                        ),
                                        array(
                                            'header' => 'Jenis Tanaman',
                                            'value' => '$data->idTanamanSilvikultur->idJenisTanaman->nama_tanaman',
                                        ),
                                        array(
                                            'header' => 'Luas (Ha)',
                                            'name' => 'luas',
                                            'type' => 'raw',
                                            'footer' => '<strong>' . RkuBibitNew::model()->getTotal($rkuPanen->search()->getData(), 'luas') . '</strong>',
                                        ),
                                        array(
                                            'header' => 'Volume (M3)',
                                            'name' => 'volume',
                                            'type' => 'raw',
                                            'footer' => '<strong>' . RkuBibitNew::model()->getTotal($rkuPanen->search()->getData(), 'volume') . '</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        )
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>6. Pemasaran</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.BootGroupGridView', array(
                                    'id' => Yii::app()->controller->id . '-pasar-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuPasar->search(),
                                    'mergeColumns' => array('tahun', 'id_jenis_pasar'),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'tahun',
                                            'footer' => '<strong>Total</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        ),
                                        array(
                                            'name' => 'id_jenis_pasar',
                                            'header' => 'Tata Ruang',
                                            'value' => '$data->idJenisPasar->nama_pemasaran',
                                        ),
                                        array(
                                            'name' => 'id_jenis_tanaman',
                                            'header' => 'Jenis Tanaman',
                                            'value' => '$data->idJenisTanaman->nama_tanaman'
                                        ),
                                        array(
                                            'header' => 'Jumlah (M³)',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                            'footer' => '<strong>' . RkuBibitNew::model()->getTotal($rkuPasar->search()->getData(), 'jumlah') . '</strong>',
                                            'footerHtmlOptions'=>array('class'=>'footer')
                                        )
                                    )
                                ));
                                ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($params['rkuKelLing']) || isset($params['rkuAll'])): ?>
                        <div class="sub-item">
                            <h5>&#8801; Kelestarian Fungsi Lingkungan</h5>
                            <h6>1. Hama dan Penyakit Tanaman</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-hamkit-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuHamkit->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'hama',
                                            'header' => 'Hama dan Penyakit Tanaman',
                                        ),
                                        array(
                                            'name' => 'solusi',
                                            'header' => 'Cara Menangani',
                                        ),
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>2. Teknik Pemadaman Kebakaran Hutan</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-tekdam-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuTekdam->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'metode',
                                            'header' => 'Metode',
                                        ),
                                        array(
                                            'name' => 'kondisi_kebakaran',
                                            'header' => 'Kondisi Sumber Kebakaran',
                                        ),
                                        array(
                                            'name' => 'cara',
                                            'header' => 'Cara Penanganan dan Prasarana',
                                        ),
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>3. Alat Pemadam Kebakaran</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-damkar-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuAlatDamkar->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'id_damkar',
                                            'header' => 'Jenis Alat',
                                            'value' => '$data->idDamkar->jenis_dalkar'
                                        ),
                                        array(
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                        ),
                                        array(
                                            'name' => 'keterangan',
                                        ),
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>3. Perambahan Hutan, Penggembalaan Liar dan Pembalakan Liar</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-perambahan-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $rkuPerambahan->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'perlindungan',
                                            'header' => 'Jenis Perlindungan',
                                        ),
                                    )
                                ));
                                ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($params['rkuKelSos']) || isset($params['rkuAll'])):?>
                        <div class="sub-item">
                            <h5>&#8801; Kelestarian Fungsi Sosial</h5>
                            <h6>1. Pembangunan Penyaluran Infrastruktur Pemukiman</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-pemukiman-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $mukim->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'id_infra_mukim',
                                            'header' => 'Jenis',
                                            'value' => '$data->idInfraMukim->nama_sarana',
                                        ),
                                        array(
                                            'header' => 'Rencana',
                                            'name' => 'jumlah',
                                            'type' => 'raw',
                                        ),
                                    )
                                ));
                                ?>
                        </div>

                        <div class="sub-item">
                            <h6>2. Kelembagaan Masyarakat</h6>
                        </div>
                        <div id="data">
                            <?php
                                $this->widget('booster.widgets.TbGridView', array(
                                    'id' => Yii::app()->controller->id . '-kelembagaan-grid',
                                    'type' => 'bordered condensed striped',
                                    'responsiveTable' => true,
                                    'dataProvider' => $lembaga->search(),
                                    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
                                    'template' => '{items}{pager}',
                                    'enableSorting' => false,
                                    // 'filter' => $model,
                                    'columns' => array(
                                        array(
                                            'name' => 'kegiatan',
                                        ),
                                        array(
                                            'header' => 'Rencana',
                                            'name' => 'rencana',
                                            'type' => 'raw',
                                        ),
                                        'keterangan',
                                    )
                                ));
                                ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="pagebreak"></div>
            <?php endif; ?>
            <?php if(isset($params['rkt'])): ?>
                <?php $this->renderPartial('rkt',array('rku'=>$rku,'param'=>$params['rkt'])); ?>
            <?php endif;?>
        </div>
        <htmlpagefooter name="myFooter1">
            <hr>
            <table width="100%" cellpadding="0" cellspacing="0" style="vertical-align:middle">
                <tr>
                    <td style="font-style:italic;font-weight:bold">Data IUPHHK-HTI <?php echo $model->idPerusahaan->nama_perusahaan; ?><br><span>{DATE j F Y }</span></td>
                    <td style="font-style:italic;text-align:right;font-weight:bold">{PAGENO}/{nbpg}</div></td>
                </tr>
            </table>
        <!-- <table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
            color: #000000; font-weight: bold; font-style: italic;"><tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
            <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right; ">My document</td>
            </tr></table> -->
        </htmlpagefooter>
    </body>
</html>