<?php
$this->breadcrumbs=array(
	'Rkt Bulan'=>array('index'),
        'Syncronize',
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
            <?php require_once dirname(__FILE__) . '/../layouts/master_data_menu.php'; ?>        </div>                   
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Data Master Group User Menu</h4>
    
     <a href="<?php echo $this->createUrl('/admin/rktBulan/create');?>"><button type="button" name="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah RKT Bulan</button></a>
     <a href="<?php echo $this->createUrl('/admin/rktBulan/syncrktbulan');?>"><button type="button" name="button" class="btn btn-primary"><i class="fa fa-history"></i> Syncronize RKT Bulan</button></a>
   
    <?php $this->widget('booster.widgets.BootGroupGridView', array(
    'id' => 'rku-pembenihan-grid',
    'type' => 'bordered condensed striped',
    'responsiveTable' => true,
    'dataProvider' => $model->search(),
    'mergeColumns' => array('id_rkt'),
    'htmlOptions' => array('class' => 'grid-view ugi-grid bordered'),
    'template' => '{items}{pager}',
    'enableSorting' => false,
      
    'columns' => array(
                        'id',
                        'id_rkt',
                        'tahun',
                        'bulan',
        array(
        'class'=>'booster.widgets.TbButtonColumn',
        ),                   
       
    )
));
?>
</div>

<script type="text/javascript">
    function show_form_pembibitan(id = '')
    {
       // var url = "<?php // echo $this->createUrl('//perusahaan/rkuKelestarian/addPembibitan', array('id_rku' => $rku->id_rku)); ?>?id_bibit=" + id;
        var url = "<?php echo $this->createUrl('/admin/rktBulan/create');?>;

//        var title = "Tambah Data Pengadaan Bibit";
//        showModal(url, title);
        
        window.location.replace(url);
    }
</script>
