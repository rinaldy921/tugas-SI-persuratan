<?php
$this->widget('booster.widgets.HeaderGroupGridView', array(
    'id' => Yii::app()->controller->id . '-rekap-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model,
    'itemsCssClass'=>'nipz',
    // 'filter' => $model,
    'template' => '{items}',
    'mergeHeaders' => array(
        array(
            'name' => 'Penanaman',
            'start' => '4',
            'end' => '12',
        ),
        array(
            'name' => 'Produksi',
            'start' => '13',
            'end' => '15',
            'rowspan' => '2'
        )
    ),
    'subHeaders' => array(
        array(
            'name' => 'Tanaman Pokok',
            'start' => '4',
            'end' => '6',
        ),
        array(
            'name' => 'Tanaman Unggulan',
            'start' => '7',
            'end' => '9',
        ),
        array(
            'name' => 'Tanaman Kehidupan',
            'start' => '10',
            'end' => '12',
        )
    ),
    'columns' => array(
        array('header' => 'No', 'value' => '$row+1'),
        array(
            'name' => 'nama_badan',
            'header' => 'Nama Perusahaan',
            'value' => '!empty($data->idPerusahaan->nama_perusahaan) ? $data->idPerusahaan->nama_perusahaan : ""',
            'htmlOptions'=>array('style'=>'white-space:nowrap')
        ),
        // 'nomor',
        array(
            'name'=>'nomor',
            'header'=>'Nomor SK IUPHHK',
            'value'=>'$data->idPerusahaan->iuphhks[0]->nomor',
        ),
        array(
            'name'=>'luas',
            'header'=>'Luas Areal (Ha)',
            'value'=>'number_format($data->idPerusahaan->iuphhks[0]->luas,2,",",".")',
        ),
        //tapok 4,5,6
            array(
                'header' => 'Jenis',
                'name' => 'jenis_tanaman_tapok',
                'value' => '$data->getTanaman($data->id_rkt,"tapok")'
            ),
            array(
                'header' => 'Rencana (Ha)',
                'name' => 'rencana_tapok',
                'value' => '$data->getTotalRencana($data->id_rkt,"tapok","jumlah")'
            ),
            array(
                'header' => 'Realisasi (Ha)',
                'name' => 'realisasi_tapok',
                'value' => '$data->getTotalRencana($data->id_rkt,"tapok","realisasi")'
            ),
        //end tapok
        //tanggul 7,8,9
            array(
                'header' => 'Jenis',
                'name' => 'jenis_tanaman_tanggul',
                'value' => '$data->getTanaman($data->id_rkt,"tanggul")'
            ),
            array(
                'header' => 'Rencana (Ha)',
                'name' => 'rencana_tanggul',
                'value' => '$data->getTotalRencana($data->id_rkt,"tanggul","jumlah")'
            ),
            array(
                'header' => 'Realisasi (Ha)',
                'name' => 'realisasi_tanggul',
                'value' => '$data->getTotalRencana($data->id_rkt,"tanggul","realisasi")'
            ),
        //end tanggul
        //tadup 10,11,12
            array(
                'header' => 'Jenis',
                'name' => 'jenis_tanaman_tadup',
                'value' => '$data->getTanaman($data->id_rkt,"tadup")'
            ),
            array(
                'header' => 'Rencana (Ha)',
                'name' => 'rencana_tadup',
                'value' => '$data->getTotalRencana($data->id_rkt,"tadup","jumlah")'
            ),
            array(
                'header' => 'Realisasi (Ha)',
                'name' => 'realisasi_tadup',
                'value' => '$data->getTotalRencana($data->id_rkt,"tadup","realisasi")'
            ),
        //end tadup
        //produksi 13,14,15
            array(
                'header' => 'Jenis',
                'name' => 'jenis_produksi',
                'value' => '$data->getProduksiTanaman($data->id_rkt)'
            ),
            array(
                'header' => 'Rencana (M3)',
                'name' => 'rencana_produksi',
                'value' => '$data->getRencanaProduksi($data->id_rkt,"jumlah")'
            ),
            array(
                'header' => 'Realisasi (M3)',
                'name' => 'realisasi_produksi',
                'value' => '$data->getRencanaProduksi($data->id_rkt,"realisasi")'
            ),
        //end produksi

        // array(
        //     'name' => 'tahun',
        //     'header' => 'Tahun',
        //     'value' => '!empty($data->tahun) ? $data->tahun : ""'
        // ),
        array(
            'name' => 'nilai_kinerja',
            'header' => 'Nilai Kinerja',
            'value' => '!empty($data->id_perusahaan) ? $data->getKinerja($data->id_perusahaan,$data->id_rkt) : ""',
            'headerHtmlOptions'=>array('style'=>'text-align:center')
        ),
    ),
));
?>