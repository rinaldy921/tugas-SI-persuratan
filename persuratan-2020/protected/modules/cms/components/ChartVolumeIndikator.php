<?php

Yii::import('zii.widgets.CPortlet');

class ChartVolumeIndikator extends CPortlet {

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
			$query_min = "SELECT b_id, b_nama, is_nilai__target, is_id, is_kode_indikator, id_propinsi, nama_propinsi, id_kabupaten, nama_kabupaten, c_realisasi_penyebut, c_rencana_target, c_realisasi_target FROM view_capaian_spm_prov WHERE c_persen_nasional IS NOT NULL AND b_id = ".$this->bidang_id." AND id_propinsi = ".$this->propinsi_id." GROUP BY is_id";
		} else {
			$query_min = "SELECT b_id, b_nama, is_nilai__target, is_id, is_kode_indikator, id_propinsi, nama_propinsi, id_kabupaten, nama_kabupaten, c_realisasi_penyebut, c_rencana_target, c_realisasi_target FROM view_capaian_spm_kab WHERE c_persen_nasional IS NOT NULL AND b_id = ".$this->bidang_id." AND id_propinsi = ".$this->propinsi_id." GROUP BY is_id";
		}
		$dataMin = Yii::app()->db->createCommand($query_min)->queryAll();
        if (!empty($dataMin)) {
            $seriesMin = array();
			$seriesMin2 = array();
			$seriesMin3 = array();
            $kategori = array();
			$daerah = '';
			foreach ($dataMin as $min) {
				$kategori[$min['is_id']] = $min['is_kode_indikator'];
				$daerah = ($this->tingkatan == 'Provinsi') ? $min['nama_propinsi'] : $min['nama_kabupaten'];
				$target = isset($min['c_rencana_target']) ? intval($min['c_rencana_target']) : 0;
				$penyebut = isset($min['c_realisasi_penyebut']) ? intval($min['c_realisasi_penyebut']) : 0;
				$real = isset($min['c_realisasi_target']) ? intval($min['c_realisasi_target']) : 0;
				$seriesMin['name'] = 'Rencana (Jumlah)';
				$seriesMin['data'][] = array($daerah, $target);
				$seriesMin2['name'] = 'Realisasi/Pembilang (Jumlah)';
				$seriesMin2['data'][] = array($daerah, $real);
				$seriesMin3['name'] = 'Realisasi/Penyebut (Jumlah)';
				$seriesMin3['data'][] = array($daerah, $penyebut);
			}
			$series = array($seriesMin, $seriesMin2, $seriesMin3);
            $options = array(
				'theme' => 'grid',
                'chart' => array('type' => 'column'),
                'title' => array('text' => Yii::t('view', 'Rencana dan Realisasi Capaian SPM ') . $this->tingkatan),
                'subtitle' => array('text' => $this->tingkatan.': '.$daerah),
                'yAxis' => array(
					'allowDecimals' => false, 
					'title' => array('text' => Yii::t('view', 'Jumlah/Volume')),
					'min' => 0,
				),
				'legend' => array('enabled' => true),
                'xAxis' => array('categories' => array_values($kategori)),
                'series' => $series,
				'tooltip' => array(
					'useHTML' => true,
				),
                'plotOptions' => array(
                    'column' => array(
						'stacking' => null,
						'dataLabels' => array(
                            'enabled' => true,
                            'crop' => true,
							'useHTML' => true,
							'formatter' => 'js: function() {
								return "<b>"+this.y+"</b>";
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