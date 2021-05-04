<?php
$rku = Rku::model()->find('id_rku = '.$model->id_rku);
?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $model->nomor_sk ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $model->idPerusahaan->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggal Keputusan</th>
                    <td><?= $this->getDateMonth($model->tanggal_sk) ?></td>
                    <th>Telepon</th>
                    <td><?= $model->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Tahun RKT</th>
                    <td><?= $model->tahun_mulai ?></td>
                    <th>Alamat</th>
                    <td><?= $model->idPerusahaan->alamat ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div id="page-wrapper" class="col-md-12">
    <h4 class="page-header">Prasyarat</h4>
    <?php 
    $this->widget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'rootwizard',
        'placement'=>'left',
        'tabs' => array(
            array(
                'label' => 'Prasyarat',
                'content' => $this->renderPartial('test/index2', array(
                        'model'=>$model,
                        'ganis'=>$ganis,
                        'tatabatas'=>$tatabatas,
                        'tataruang'=>$tataruang,
                        'arealProduktif' => $arealProduktif,
                        'arealKerja' => $arealKerja,
                        'arealNonProduktif' => $arealNonProduktif,
                        'inventarisasi' => $inventarisasi,
                        'pwh' => $pwh,
                        'masukGunaAlat' => $masukGunaAlat,
                        'bangunSarpras' => $bangunSarpras,
                        'bloksektor' => $bloksektor,
                        'idRkt' => $idRkt
                    ), true),
                'active' => true
            ),
        )
    ));
    ?>
</div>
<!-- 
'ganis' => $modelGanis,
'tatabatas' => $modelTataBatas,
'tataruang' => $modelKawasan,
'arealProduktif' => $modelArealProduktif,
'arealKerja' => $modelArealKerja,
'arealNonProduktif' => $modelArealNonProduktif,
'inventarisasi' => $modelInventarisasi,
'pwh' => $modelPwh,
'masukGunaAlat' => $modelMasukGunaAlat,
'bangunSarpras' => $modelBangunSarpras,
'bloksektor' => $bloksektor,
'idRkt' => $idRkt -->