<?php 
//print_r($mode);exit(1);
?>

<ul class="nav" id="side-menu">
    <?php if($mode == 'absen'){$aktif = 'active';}else{$aktif= '';}?>
      <li class="<?php echo $aktif;?>">
          <a href="<?php echo(Yii::app()->createUrl("/perusahaan/realisasibulanan/absen"));?>"><i class=""></i> <span>Absensi Laporan Realisasi Bulanan</span></a>
      </li>
</ul>
<ul class="nav" id="side-menu">
     <?php if($mode == 'realisasirkt'){$aktif = 'active';}else{$aktif= '';}?>
      <li class="<?php echo $aktif;?>">
          <a href="<?php echo(Yii::app()->createUrl("/perusahaan/realisasibulanan/absen"));?>"><i class=""></i> <span>Realisasi RKT</span></a>
          <ul class="nav nav-pills nav-stacked nav-submenu">
              <li>
                   <a href="<?php echo(Yii::app()->createUrl("/perusahaan/realisasibulanan/viewprasyarat"));?>">Prasyarat</a>
                   <a href="<?php echo(Yii::app()->createUrl("/perusahaan/realisasibulanan/viewfproduksi"));?>">Kelestarian Fungsi Produksi</a>
                   <a href="<?php echo(Yii::app()->createUrl("/perusahaan/realisasibulanan/viewflingkungan"));?>">Kelestarian Fungsi Lingkungan</a>
                   <a href="<?php echo(Yii::app()->createUrl("/perusahaan/realisasibulanan/viewsosial"));?>">Kelestarian Fungsi Sosial</a>  
              </li>
          </ul>
      </li>
      
</ul>




<?php /*

$this->widget('zii.widgets.CMenu', array(
    'encodeLabel' => FALSE,
    'htmlOptions' => array('id'=>'side-menu','class'=>'nav'),
    'submenuHtmlOptions' => array('class' => 'nav nav-pills nav-stacked nav-submenu'),
    'items' => array(
        array(
            'label' => 'Absensi Laporan Realisasi Bulanan',
            'url' => array('/perusahaan/realisasibulanan/absen'),
            'active' => (Yii::app()->controller->id == 'realisasibulanan') ? true : false
        ),
        array(
            'label' => Yii::t('app', 'Realisasi RKT'),
            'url' => 'javascript:{}',
            // 'submenuOptions' => array('style' => 'display:none'),
            'items' => array(
                array(
                    'label' => 'Prasyarat',
                    'url' => array('/perusahaan/realprasyarat'),
                    'active' => (Yii::app()->controller->id == 'realprasyarat') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Produksi',
                    'url' => array('/perusahaan/realproduksi'),
                    'active' => (Yii::app()->controller->id == 'realproduksi') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Lingkungan',
                    'url' => array('/perusahaan/reallingkungan'),
                    'active' => (Yii::app()->controller->id == 'reallingkungan') ? true : false
                ),
                array(
                    'label' => 'Kelestarian Fungsi Sosial',
                    'url' => array('/perusahaan/realsosial'),
                    'active' => (Yii::app()->controller->id == 'realsosial') ? true : false
                ),
                // array(
                //     'label' => 'Serapan Tenaga Kerja',
                //     'url' => array('/perusahaan/serapanTenagaKerja'),
                //     'active' => (Yii::app()->controller->id == 'serapanTenagaKerja') ? true : false
                // ),
            )
        ),
    ),
));
 * 
 */
?>