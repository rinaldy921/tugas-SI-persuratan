<?php
    // $rkt = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku = '. $rku->id_rku.' AND tahun_mulai = '.$params['rkt']));
    foreach($param as $mkt) {
        $th_rkt[] = $mkt;
    }
    $rktz = Rkt::model()->findAll(array('condition'=>'status = 1 AND id_rku = '. $rku->id_rku.' AND tahun_mulai IN('.implode(',',$th_rkt).')'));


    // $data = new CArrayDataProvider($rktz,array(
    //     'pagination'=>false
    // ));
?>
<div id="rkt">
    <?php foreach($rktz as $key => $rkt): ?>

        <div class="page-header">
            <h4>Data RKT <?php echo $rkt->tahun_mulai; ?></h4>
        </div>

        <div class="sub-item">
            <h5>&#8801; Legalitas</h5>
        </div>

        <table class="nipz" width="100%" cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <th>Nomor SK RKT</th>
                    <td>:</td>
                    <td><?= $rkt->nomor_sk ?></td>
                    <th>Tahun Mulai</th>
                    <td>:</td>
                    <td><?= $this->getDateMonth($rkt->tahun_mulai) ?></td>
                </tr>
                <tr>
                    <th>Tanggal Mulai Berlaku</th>
                    <td>:</td>
                    <td><?= $this->getDateMonth($rkt->mulai_berlaku) ?></td>
                    <th>Tanggal SK</th>
                    <td>:</td>
                    <td><?= $this->getDateMonth($rkt->tanggal_sk) ?></td>
                </tr>
                <tr>
                    <th>Tanggal Akhir Berlaku</th>
                    <td>:</td>
                    <td><?= $this->getDateMonth($rkt->akhir_berlaku) ?></td>
                </tr>
            </tbody>
        </table>

        <div class="sub-item">
            <h5>&#8801; Prasyarat</h5>
            <h6>1. Organisasi & Tenaga Kerja</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'ganis');
            $this->renderPartial('application.modules.admin.views.rkt.test.index_ganis',array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>2. Penataan Batas Blok</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'tatabatas');
            $this->renderPartial('application.modules.admin.views.rkt.test.index_tatabatas',array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>3. Penataan Ruang (Kawasan Lindung)</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'kawasan');
            $test = $model->search()->data[0]->idBlok->id_sektor;
            if(!empty($test)) {
                $this->renderPartial('application.modules.admin.views.rkt.test._index_kawasanlindung_sektor', array('model'=>$model));
            } else {
                $this->renderPartial('application.modules.admin.views.rkt.test._index_kawasanlindung', array('model'=>$model));
            }
        ?>

        <div class="sub-item">
            <h6>4. Penataan Ruang (Areal Tidak Efektif)</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'arealNonProduktif');
            $test = $model->search()->data[0]->idBlok->id_sektor;
            if(!empty($test)) {
                $this->renderPartial('application.modules.admin.views.rkt.test._index_areal_non_produktif_sektor', array('model'=>$model));
            } else {
                $this->renderPartial('application.modules.admin.views.rkt.test._index_areal_non_produktif', array('model'=>$model));
            }
        ?>

        <div class="sub-item">
            <h6>5. Penataan Ruang (Areal Efektif)</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'arealProduktif');
            $test = $model->search()->data[0]->idBlok->id_sektor;
            if(!empty($test)) {
                $this->renderPartial('application.modules.admin.views.rkt.test._index_areal_produktif_sektor', array('model'=>$model));
            } else {
                $this->renderPartial('application.modules.admin.views.rkt.test._index_areal_produktif', array('model'=>$model));
            }
        ?>

        <div class="sub-item">
            <h6>6. Penataan Areal Kerja</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'arealKerja');
            $this->renderPartial('application.modules.admin.views.rkt.test._index_areal_kerja', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>7. Pembukaan Wilayah Hutan</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'pwh');
            $this->renderPartial('application.modules.admin.views.rkt.test._index_pwh', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>8. Pemasukan dan Penggunaan Peralatan</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'masukGunaAlat');
            $this->renderPartial('application.modules.admin.views.rkt.test._index_masukgunaalat', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>9. Pembangunan Sarana Prasarana</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'sarpras');
            $this->renderPartial('application.modules.admin.views.rkt.test._index_bangunsarpras', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h5>&#8801; Kelestarian Fungsi Produksi</h5>
            <h6>1. Pengadaan Bibit</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'bibit');
            $this->renderPartial('application.modules.admin.views.rktProduksi._index_bibit', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>2. Penyiapan Lahan</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'siapLahan');
            $test = $model->search()->data[0]->idBlok->id_sektor;
            if(!empty($test)) {
                $this->renderPartial('application.modules.admin.views.rktProduksi._index_siaplahan_sektor', array('model'=>$model));
            } else {
                $this->renderPartial('application.modules.admin.views.rktProduksi._index_siaplahan', array('model'=>$model));
            }
        ?>

        <div class="sub-item">
            <h6>3. Penanaman</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'tanam');
            $test = $model->search()->data[0]->idBlok->id_sektor;
            if(!empty($test)) {
                $this->renderPartial('application.modules.admin.views.rktProduksi._index_tanam_sektor', array('model'=>$model));
            } else {
                $this->renderPartial('application.modules.admin.views.rktProduksi._index_tanam', array('model'=>$model));
            }
        ?>

        <div class="sub-item">
            <h6>4. Pemeliharaan (Penyulaman)</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'sulam');
            $this->renderPartial('application.modules.admin.views.rktProduksi._index_sulam', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>5. Pemeliharaan (Penjarangan)</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'jarang');
            $this->renderPartial('application.modules.admin.views.rktProduksi._index_jarang', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>6. Pemeliharaan (Pendangiran)</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'dangir');
            $this->renderPartial('application.modules.admin.views.rktProduksi._index_dangir', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>7. Pemanenan (Luas Areal)</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'panenAreal');
            $this->renderPartial('application.modules.admin.views.rktProduksi._index_panenareal', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>8. Pemanenan (Volume Produksi Hasil Tanaman)</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'panenTanaman');
            $this->renderPartial('application.modules.admin.views.rktProduksi._index_panentanaman', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>9. Pemanenan (Volume Produksi Penyiapan Lahan (LOA & Non LOA))</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'panenLahan');
            $this->renderPartial('application.modules.admin.views.rktProduksi._index_panensiaplahan', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>10. Pemasaran</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'pasar');
            $this->renderPartial('application.modules.admin.views.rktProduksi._index_pasar', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h5>&#8801; Kelestarian Fungsi Lingkungan</h5>
            <h6>1. Perlindungan dan Pengamanan Hutan</h6>
        </div>

        <?php
            $model = $this->cariRkt($rkt->id,'dungtan');
            $this->renderPartial('application.modules.admin.views.rktLingkungan._index_dungtan', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>2. Pengendalian Hama dan Penyakit</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'dalmakit');
            $this->renderPartial('application.modules.admin.views.rktLingkungan._index_dalmakit', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>3. Pengendalian Kebakaran</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'dalkar');
            $this->renderPartial('application.modules.admin.views.rktLingkungan._index_dalkar', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>4. Pengelolaan dan Pemantauan Lingkungan</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'pantau');
            $this->renderPartial('application.modules.admin.views.rktLingkungan._index_pantaulingkungan', array('modelPantau'=>$model));
        ?>

        <div class="sub-item">
            <h5>&#8801; Kelestarian Fungsi Sosial</h5>
            <h6>1. Pembinaan dan Pemberdayaan Masyarakat (Pembangunan Penyaluran Infrastruktur Pemukiman)</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'inframukim');
            $this->renderPartial('application.modules.admin.views.rktSosial._index_inframukim', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>2. Pembinaan dan Pemberdayaan Masyarakat (Peningkatan SDM)</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'sdm');
            $this->renderPartial('application.modules.admin.views.rktSosial._index_sdm', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>3. Pembinaan Kelembagaan Masyarakat (Kerjasama Koperasi)</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'kerjasama');
            $this->renderPartial('application.modules.admin.views.rktSosial._index_kerjasama', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>4. Pembinaan Kelembagaan Masyarakat (Kemitraan Usaha)</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'bangunmitra');
            $this->renderPartial('application.modules.admin.views.rktSosial._index_bangunmitra', array('model'=>$model));
        ?>

        <div class="sub-item">
            <h6>5. Penanganan Konflik Sosial</h6>
        </div>
        <?php
            $model = $this->cariRkt($rkt->id,'konflik');
            $this->renderPartial('application.modules.admin.views.rktSosial._index_konfliksosial', array('modelKonflikSosial'=>$model));
        ?>
        <div class="pagebreak"></div>
    <?php endforeach; ?>
</div>