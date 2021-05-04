<?php
$this->breadcrumbs = array(
    'Sistem Silvikultur' => array('index'),
    'Create',
);
?>
<div class="col-md-3">
    <div class="navbar-default sidebar" role="navigation">
        <div class="navbar-default sidebar-nav">
            <?php require_once dirname(__FILE__) . '/../layouts/menu_rencana_kerja.php'; ?>
        </div>
    </div>
</div>
<div id="page-wrapper" class="col-md-9">
    <h4 class="page-header">Sistem Silvikultur</h4>
    <div class="col-md-12">
        <div class="row">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                'id' => Yii::app()->controller->id . '-filtertahun-form',
//                'type' => 'inline',
                'htmlOptions' => array('class' => 'well well-sm form-inline')
            ));
            ?>
            <div class="form-group">
                <label for="Rku_periode">Periode Tahun : </label>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                    <input id="Rku_periode" class="span5 form-control ct-form-control" type="text" name="Rku[periode]" value="<?php echo $rku->tahun_mulai . ' - ' . ($rku->tahun_mulai + 9); ?>" placeholder="Pilih Periode RKU">
                </div>
            </div>
            <?php
            echo $form->datePickerGroup($rku, 'tahun_mulai', array('groupOptions' => array('class' => 'hidden'), 'widgetOptions' => array(), 'labelOptions' => array(), 'wrapperHtmlOptions' => array()));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php
    $this->beginWidget('booster.widgets.TbTabs', array(
        'type' => 'tabs',
        'id' => 'silvikulturz',
        'justified' => true,
        'tabs' => array(
            array(
                'label' => 'Sistem Silvikultur',
                'content' => $this->renderPartial('_form', array('model' => $model, 'modelSis' => $modelSis, 'tanaman' => $tanaman), true),
                'active' => true,
                'linkOptions'=>array('id'=>'1')
            ),
            array(
                'label' => 'Tanaman',
                'content' => $this->renderPartial('_form_jenis_tanaman', array('model' => $model2, 'tanaman' => $tanaman), true),
                'linkOptions'=>array('id'=>'2')
            ),
            array(
                'label' => 'Potensi Rata-rata',
                'content' => $this->renderPartial('_form_potensi_produksi', array('potensi_produksi' => $potensi_produksi), true),
                'linkOptions'=>array('id'=>'3')
            ),
            array(
                'label' => 'HHBK',
                'content' => $this->renderPartial('_form_hhbk', array('model_hhbk' => $model_hhbk, 'model_hhbk2' => $model_hhbk2), true),
                'linkOptions'=>array('id'=>'4')
            ),
        ),
    ));
    $this->endWidget();
    ?>
</div>
<?php
Yii::app()->clientScript->registerScript("filter_tahun", "
jQuery('#Rku_periode').datepicker({
    format: { /* Say our UI should display a week ahead, but textbox should store the actual date. This is useful if we need UI to select local dates, but store in UTC */
        toDisplay: function (date, format, language) {
            var d = new Date(date);
            d = d.getFullYear() + ' - '+ (d.getFullYear() + 9);
            return d;
        },
        toValue: function (date, format, language) {
            var d = new Date(date);
            d.setDate(d.getDate() + 7);
            return new Date(d);
        }
    },
    'startView':'decade',
    'minViewMode':2,
    'autoclose':true,
    'language':'id'
}).on('change', function(){
    $(\"#" . Yii::app()->controller->id . "-filtertahun-form\").submit();
});
", CClientScript::POS_END);

Yii::app()->clientScript->registerScript("sembunyi", "
    $('#silvikulturz_tab_1 #load').find('img').hide();
    $('#silvikulturz_tab_1 #load').find('p').hide();
    $('#silvikulturz .nav-tabs li').each(function(e){
        var ieu = $(this);
        var id = $(this).find('a').attr('id');
        ieu.on('click',function(){
            $('#silvikulturz_tab_'+id+' #load').find('img').hide();
            $('#silvikulturz_tab_'+id+' #load').find('p').hide();
        });
        $('#silvikulturz_tab_'+id+' #subm').on('click', function(){
            var data = $('#silvikulturz_tab_'+id).find('form');
            $.ajax({
                type:'POST',
                url:data.attr('href'),
                dataType: 'JSON',
                data:data.serialize(),
                beforeSend: function() {
                    $('#silvikulturz_tab_'+id+' #load').css('display','inline-block');
                    $('#silvikulturz_tab_'+id+' #subm').attr('disabled',true);
                    $('#silvikulturz_tab_'+id+' #load').find('img').show();
                },
                success:function(data){
                    if(data.status = 'success') {
                        $.fn.yiiGridView.update('". Yii::app()->controller->id . "-sistem-grid');
                    }
                    $('#silvikulturz_tab_'+id+' #load').find('img').hide();
                    // if(id === 1) {
                    //     $('#".CHTML::activeId($model,'jumlah')."').val(data.jumlah);
                    //     $('#".CHTML::activeId($model,'id_jenis_silvikultur')."').val(data.id_jenis_silvikultur);
                    // } else if(id === 3) {
                    //     $('#".CHTML::activeId($potensi_produksi,'id_rku')."').val(data.id_rku);
                    //     $('#".CHTML::activeId($potensi_produksi,'potensi_produksi')."').val(data.potensi_produksi);
                    // }
                    // // $('#silvikulturz_tab_'+id+' #data').empty();
                    // // $('#silvikulturz_tab_'+id+' #data').html(data);
                    $('#silvikulturz_tab_'+id+' #load').find('p').text(' '+data.status).delay(100).fadeIn(300);
                    $('#silvikulturz_tab_'+id+' #load').find('p').delay(1500).fadeOut(\"fast\");
                    $('#silvikulturz_tab_'+id+' #subm').attr('disabled',false);
                }
            });
        });
    });
",CClientScript::POS_READY);
?>
<?php
$js ='';
//Yii::app()->createUrl
/*if(CHttpRequest::getParam("tab") != null) {
    $js = "$('#silvikulturz a[href=\"#silvikulturz_tab_".CHttpRequest::getParam("tab")."\"]').tab('show');";
} */
Yii::app()->clientScript->registerScript("tab", $js, CClientScript::POS_READY);
