<?php

Yii::import('zii.widgets.CPortlet');

class ChartIndikator extends CPortlet {

    public $tingkatan = 'Kabupaten/Kota';
	public $bidang_id = null;
	public $propinsi_id = null;

    public function run() {
        $this->renderContent();
        $content = ob_get_clean();
        echo $content;
    }

    protected function renderContent() {
        $tk = ($this->tingkatan == 'Provinsi') ? 'chart_min_max_prov' : 'chart_min_max_kab';
		$condition = "1=1";
		$b_ = 'all_bid';
		$p_ = 'all_prop';
		if (isset($this->bidang_id) && !empty($this->bidang_id) && $this->bidang_id != 0) {
			$condition .= " AND b_id = ".$this->bidang_id;
			$b_ = $this->bidang_id;
		}
		if (isset($this->propinsi_id) && !empty($this->propinsi_id) && $this->propinsi_id != 0) {
			$condition .= " AND id_propinsi = ".$this->propinsi_id;
			$p_ = $this->propinsi_id;
		}
		$data = array();
		$cache_min  = Yii::app()->cache->get('chart_'.$this->tingkatan.'_'.$b_.'_'.$p_);
		if (isset($cache_min) && !empty($cache_min)) {
			$data = $cache_min;
		} else {
			$query = "SELECT * FROM $tk WHERE $condition AND t_tahun = (SELECT MAX(t_tahun) FROM $tk GROUP BY t_tahun LIMIT 1)";
			$dataq = Yii::app()->db->createCommand($query)->queryAll();
			Yii::app()->cache->set('chart_'.$this->tingkatan.'_'.$b_.'_'.$p_, $dataq, 0);
			$data = $dataq;
		}
        if (!empty($data)) {
            $seriesMin = array();
			$seriesMax = array();
            $kategori = array();
			foreach ($data as $min) {
				if ($min && !empty($min)) {
					$kategori[$min['b_id']] = $min['b_singkatan'];
					$daerah = ($this->tingkatan == 'Provinsi') ? $min['nama_propinsi'] : $min['nama_kabupaten'];
					$nilai = isset($min['nilai_value']) ? round($min['nilai_value'], 2) : 0;
					$target = isset($min['nilai_value']) ? round($min['is_nilai__target'], 2) : 0;
					$real = isset($min['c_realisasi_target']) ? intval($min['c_realisasi_target']) : 0;
					$cap = isset($min['c_capaian']) ? round($min['c_capaian'], 2) : 0;
					$biaya = isset($min['pembiayaan']) ? round($min['pembiayaan'], 2) : 0;
					if ($min['status'] == 'Terendah') {
						$seriesMin['name'] = 'Persentase Terendah (%)';
						$seriesMin['data'][] = array($daerah, $nilai);
						$seriesMin['composition'][] = ($this->tingkatan == 'Provinsi') ? "<b>Indikator: </b>".$min['is_kode_indikator']."<br><b>Target Nasional (%): </b>".$target."<br><b>Provinsi: </b>".$daerah."<br><b>Capaian (%): </b>".$cap."<br><b>Pembiayaan (Juta Rp.) : </b>".$biaya : "<b>Indikator: </b>".$min['is_kode_indikator']."<br><b>Target Nasional (%): </b>".$target."<br><b>Kabupaten/Kota: </b>".$daerah."<br><b>Capaian (%): </b>".$cap."<br><b>Pembiayaan (Juta Rp.) : </b>".$biaya;
					} elseif ($min['status'] == 'Tertinggi') {					
						$seriesMax['name'] = 'Persentase Tertinggi (%)';
						$seriesMax['data'][] = array($daerah, $nilai);
						$seriesMax['composition'][] = ($this->tingkatan == 'Provinsi') ? "<b>Indikator: </b>".$min['is_kode_indikator']."<br><b>Target Nasional (%): </b>".$target."<br><b>Provinsi: </b>".$daerah."<br><b>Capaian (%): </b>".$cap."<br><b>Pembiayaan (Juta Rp.) : </b>".$biaya : "<b>Indikator: </b>".$min['is_kode_indikator']."<br><b>Target Nasional (%): </b>".$target."<br><b>Kabupaten/Kota: </b>".$daerah."<br><b>Capaian (%): </b>".$cap."<br><b>Pembiayaan (Juta Rp.) : </b>".$biaya;
						//$seriesMax['composition'][] = ($this->tingkatan == 'Provinsi') ? "<b>Target Nasional (%): </b>".$target."<br><b>Indikator: </b>".$min['is_kode_indikator']."<br><b>Provinsi: </b>".$daerah."<br><b>Persentase (%): </b>".$nilai."<br><b>Capaian (%) : </b>".$cap."<br><b>Realisasi : </b>".$real : "<b>Target Nasional (%): </b>".$target."<br><b>Indikator: </b>".$min['is_kode_indikator']."<br><b>Kabupaten/Kota: </b>".$daerah."<br><b>Persentase (%): </b>".$nilai."<br><b>Capaian (%) : </b>".$cap."<br><b>Realisasi : </b>".$real;
					}
				}
			}
			$series = array($seriesMin, $seriesMax);
            $options = array(
				'theme' => 'grid',
                'chart' => array('type' => 'column'),
                'title' => array('text' => Yii::t('view', 'Prosentase Capaian SPM ') . $this->tingkatan),
                'subtitle' => array('text' => Yii::t('view', 'Tertinggi/Terendah Terhadap Target Nasional')),
                'yAxis' => array(
					'allowDecimals' => true, 
					'title' => array('text' => Yii::t('view', 'Persentase')),
					'min' => 0,
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
                            'enabled' => true,
                            'crop' => true,
							'useHTML' => true,
							'formatter' => 'js: function() {
								return "<em>"+this.y+"</em>";
							}'
                        ),
                    )
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