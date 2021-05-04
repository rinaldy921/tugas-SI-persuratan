<div class="panel panel-info">
    <div class="panel-heading"><div class="panel-title">Pemerintahan</div></div>
    <div class="panel-body">
        <?php
        $this->widget('booster.widgets.TbGridView', array(
            'id' => Yii::app()->controller->id . '-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider' => $admPemerintahan->search(),
//    'filter' => $model,
            'enableSorting' => FALSE,
            'template' => '{summary}{items}{pager}',
            'columns' => array(
                array(
                    'name' => 'provisi',
                    'value' => '$data->provinsi0->nama'
                ),
                array(
                    'name' => 'kabupaten',
                    'value' => 'isset($data->kabupaten) ? $data->kabupaten0->nama : null'
                ),
                array(
                    'name' => 'kecamatan',
                    'value' => 'isset($data->kecamatan) ? $data->kecamatan0->nama : null'
                ),
//        array(
//            'class' => 'booster.widgets.TbButtonColumn',
//            'template' => '{update} {delete}'
//        ),
            ),
        ));
        ?>
    </div>
    <div class="panel-heading"><div class="panel-title">Pemangkuan Hutan</div></div>
    <div class="panel-body">
        <?php
        $this->widget('booster.widgets.TbGridView', array(
            'id' => Yii::app()->controller->id . '-grid',
            'type' => 'bordered condensed striped',
            'responsiveTable' => true,
            'dataProvider' => $admPemangkuan->search(),
//    'filter' => $model,
            'enableSorting' => FALSE,
            'template' => '{items}{summary}{pager}',
            'columns' => array(
                array(
                    'name' => 'dinhut_prov',
                    'header' => 'Dishut Provinsi',
                    'value' => '$data->dinhutProv->nama',
                ),
                array(
                    'name' => 'dinhut_kab',
                    'header' => 'Dishut Kabupaten',
                    'value' => '$data->dinhutKab->nama',
                ),
                array(
                    'name' => 'id_kph',
                    'header' => 'KPH',
                    'value' => '$data->idKph->nama_kph',
                ),
                array(
                    'name' => 'bkph',
                ),
                array(
                    'name' => 'rph',
                ),
            ),
        ));
        ?>
    </div>
</div>
