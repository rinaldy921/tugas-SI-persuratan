<?php $label = Logic::getLastLoginByPerusahan($iup->id_perusahaan);?>
<?php
$this->breadcrumbs = array(
    'Rencana Kerja Umum'
);
$list = CHtml::listData(Rkt::model()->findAll(array('select'=>'tahun_mulai','order'=>'tahun_mulai ASC','condition'=>'status = 1')), 'tahun_mulai','tahun_mulai');
?>
<div id="page-wrapper" class="col-md-12">
    <div class="panel panel-success">
        <table class="detail-view table">
            <tbody>
                <tr>
                    <th>Nomor SK</th>
                    <td><?= $iup->nomor ?></td>
                    <th>Nama Perusahaan</th>
                    <td><?= $iup->idPerusahaan->nama_perusahaan ?></td>
                </tr>
                <tr>
                    <th>Tanggak Keputusan</th>
                    <td><?= $this->getDateMonth($iup->tanggal) ?></td>
                    <th>Telepon</th>
                    <td><?= $iup->idPerusahaan->telepon ?></td>
                </tr>
                <tr>
                    <th>Luas Areal</th>
                    <td><?= floatval($iup->luas) ?> Ha</td>
                    <th>Alamat</th>
                    <td><?= $iup->idPerusahaan->alamat ?></td>
                </tr>
                <tr>
                    <th></th>
                    <td></td>
                    <th>Login Terakhir</th>
                    <td class=""><?=$label?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rkt.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <div class="col-md-12">
        <div class="row">
            <?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
                'id'=> Yii::app()->controller->id . '-filtertahun-form',
                    'type'=>'inline',
                    'htmlOptions'=>array('class'=>'well well-sm')
                //     'enableClientValidation' => true,
                //     'clientOptions' => array(
                //         'validateOnSubmit' => true,
                //     ),
                // 'enableAjaxValidation'=>false,
            )); ?>
            <div class="form-group">
                <label for="Rkt_tahun_mulai">Pilih Tahun : </label>
                <div class="input-group">
                    <!-- <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span> -->
                    <select id="Rkt_tahun_mulai" class="form-control" name="Rkt[tahun_mulai]">
                        <?php foreach($list as $th) : ?>
                            <option value="<?php echo $th;?>" <?php echo ($rkt->tahun_mulai === $th) ? 'selected' : '' ?>><?php echo $th;?></option>
                        <?php endforeach;?>
                    </select>
                    <!-- <input id="Rkt_tahun_mulai" class="span5 form-control ct-form-control" type="text" name="Rkt[tahun_mulai]" value="<?php //echo $tahun;?>"> -->
                </div>
            </div>
            <?php //echo $form->datePickerGroup($model,'tahun_mulai',array('widgetOptions'=>array('events'=>array('hide'=>'js:function(){$("#'.Yii::app()->controller->id.'-filtertahun-form").submit();}'), 'options' => array('format'=>'yyyy','startView'=>'decade','minViewMode'=>2,'autoclose'=>true ),'htmlOptions'=>array('class'=>'span5')), 'prepend'=>'<i class="glyphicon glyphicon-calendar"></i>')); ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <h4 class="page-header">Laporan Kinerja Tahun : <?php echo $rkt->tahun_mulai; ?></h4>
    <?php
    $this->widget('booster.widgets.TbGroupGridView', array(
        'id' => Yii::app()->controller->id . '-mata-air-grid',
        'type' => 'bordered condensed',
        'responsiveTable' => true,
        'dataProvider' => $model,
        'mergeColumns' => array('total', 'grade', 'rekom'),
        'template' => '{items}',
        'mergeCellCss' => 'vertical-align: middle;text-align:center;',
        'columns' => array(
            array(
                'name' => 'aspek',
                'header' => 'Aspek',
            ),
            array(
                'name' => 'bobot',
                'header' => 'Bobot',
            ),
            array(
                'name' => 'kpi',
                'header' => 'Kriteria',
            ),
            array(
                'name' => 'nilai',
                'header' => 'Nilai',
            ),
            array(
                'name' => 'total',
                'header' => 'Total Nilai',
            ),
            array(
                'name' => 'grade',
                'header' => 'Grade/Mark',
            ),
            array(
                'name' => 'rekom',
                'header' => 'Rekomendasi',
            )
        )
    ));
    ?>
</div>
<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
jQuery('#Rkt_tahun_mulai').on('change', function(){
    $(\"#".Yii::app()->controller->id."-filtertahun-form\").submit();
    // $.ajax({
    //     type:'POST',
    //     url: '".Yii::app()->createAbsoluteUrl('//admin/laporan/'.$id)."',
    //     success: function(data) {
    //         alert(data);
    //     }
    // });
});
", CClientScript::POS_END);