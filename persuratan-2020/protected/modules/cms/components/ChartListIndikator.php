<?php

Yii::import('zii.widgets.CPortlet');

class ChartListIndikator extends CPortlet {

    public $tingkatan = 'Kabupaten/Kota';
	public $bidang_id = null;
	public $propinsi_id = null;

    public function run() {
        $this->renderContent();
        $content = ob_get_clean();
        echo $content;
    }

    protected function renderContent() {
        $tk = ($this->tingkatan == 'Provinsi') ? 'view_capaian_spm_prov' : 'view_capaian_spm_kab';
		$condition = "";
		if (isset($this->bidang_id) && !empty($this->bidang_id) && $this->bidang_id != 0 && isset($this->propinsi_id) && !empty($this->propinsi_id) && $this->propinsi_id != 0) {
			$condition = " AND b_id = ".$this->bidang_id." AND id_propinsi = ".$this->propinsi_id;
		}
		if ($this->tingkatan == 'Provinsi') {
			$query_min = "SELECT b_id, b_nama, is_nilai__target, is_id, is_kode_indikator, id_propinsi, nama_propinsi, id_kabupaten, nama_kabupaten, c_rencana_target, c_realisasi_target, c_realisasi_penyebut, c_capaian, c_persen_daerah, c_persen_nasional FROM view_capaian_spm_prov WHERE c_persen_nasional IS NOT NULL AND b_id = ".$this->bidang_id." AND id_propinsi = ".$this->propinsi_id." GROUP BY is_id";
		} else {
			$query_min = "SELECT b_id, b_nama, is_nilai__target, is_id, is_kode_indikator, id_propinsi, nama_propinsi, id_kabupaten, nama_kabupaten, c_rencana_target, c_realisasi_target, c_realisasi_penyebut, c_capaian, c_persen_daerah, c_persen_nasional FROM view_capaian_spm_kab WHERE c_persen_nasional IS NOT NULL AND b_id = ".$this->bidang_id." AND id_propinsi = ".$this->propinsi_id." GROUP BY is_id";
		}
		$dataMin = Yii::app()->db->createCommand($query_min)->queryAll();
        if (!empty($dataMin)) {
            $seriesMin = array();
			$seriesMin2 = array();
			$seriesMin3 = array();
			$seriesMin4 = array();
            $kategori = array();
			$daerah = '';
			foreach ($dataMin as $min) {
				$kategori[$min['is_id']] = $min['is_kode_indikator'];
				$daerah = ($this->tingkatan == 'Provinsi') ? $min['nama_propinsi'] : $min['nama_kabupaten'];
				$nilai_nas = isset($min['c_persen_nasional']) ? round($min['c_persen_nasional'], 2) : 0;
				$nilai_prov = isset($min['c_persen_daerah']) ? round($min['c_persen_daerah'], 2) : 0;
				$target = isset($min['is_nilai__target']) ? round($min['is_nilai__target'], 2) : 0;
				$cap = isset($min['c_capaian']) ? round($min['c_capaian'], 2) : 0;
				$ren = isset($min['c_rencana_target']) ? intval($min['c_rencana_target']) : 0;
				$real = isset($min['c_realisasi_target']) ? intval($min['c_realisasi_target']) : 0;
				$real2 = isset($min['c_realisasi_penyebut']) ? intval($min['c_realisasi_penyebut']) : 0;
				$seriesMin4['name'] = 'Capaian (%)';
				$seriesMin4['data'][] = array($daerah, $cap);
				$seriesMin4['composition'][] = "<b>Capaian (%): </b>".$cap."<br><b>Realisasi Pembilang: </b>".$real."<br><b>Realisasi Peyebut: </b>".$real2;
				$seriesMin2['name'] = 'Persentase Thdp. Target Daerah (%)';
				$seriesMin2['data'][] = array($daerah, $nilai_prov);
				$seriesMin2['composition'][] = "<b>Persentase (%): </b>".$nilai_prov."<br><b>Rencana Pembilang: </b>".$ren."<br><b>Realisasi Pembilang: </b>".$real;
				$seriesMin3['name'] = 'Persentase Thdp. Target Nasional (%)';
				$seriesMin3['data'][] = array($daerah, $nilai_nas);
				$seriesMin3['composition'][] = "<b>Persentase (%): </b>".$nilai_nas."<br><b>Target Nasional (%): </b>".$target."<br><b>Capaian (%): </b>".$cap;
			}
			$series = array($seriesMin4, $seriesMin2, $seriesMin3);
            $options = array(
				'theme' => 'grid',
                'chart' => array('type' => 'column'),
                'title' => array('text' => Yii::t('view', 'Prosentase Capaian SPM ') . $this->tingkatan),
                'subtitle' => array('text' => $this->tingkatan.': '.$daerah),
                'yAxis' => array(
					'allowDecimals' => true, 
					'title' => array('text' => Yii::t('view', 'Persentase')),
					'min' => 0,
					//'labels' => array(
						//'formatter' => 'js: function() { return null; }'
					//),
				),
				'legend' => array('enabled' => true),
                'xAxis' => array('categories' => array_values($kategori)),
                'series' => $series,
				'tooltip' => array(
					'useHTML' => true,
					'formatter' => 'js: function() {
						return this.series.options.composition[this.point.x];
					}'
				),
                'plotOptions' => array(
                    'column' => array(
						'stacking' => null,
						'dataLabels' => array(
                            'enabled' => false,
                            'crop' => true,
							'useHTML' => true,
							'formatter' => 'js: function() {
								return "<b>"+this.y+" (%)</b>";
							}'
                        ),
                    ),
					'enableMouseTracking' => false,
                ),
            );
            Yii::app()->controller->widget('booster.widgets.TbHighCharts', array('options' => $options));
        } else {
		?>
			<div class="alert alert-danger">
				<a data-dismiss="alert" class="close">&times;</a>
				<?php echo Yii::t('view', 'Data tidak ditemukan.'); ?>
			</div>
		<?php
		}
    }

}

?>