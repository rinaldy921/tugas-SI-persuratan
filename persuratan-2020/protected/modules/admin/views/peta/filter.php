<?php
    $tahun_mulai = Rku::model()->find(array('select'=>'distinct tahun_mulai', 'order'=>'tahun_mulai ASC'));
    $tahun_sampai = Rku::model()->find(array('select'=>'distinct tahun_sampai', 'order'=>'tahun_sampai DESC'));

    if(empty($tahun_mulai)) {
        $message = Yii::t('app', 'Data RKU dan RKT masih kosong. Silahkan input data RKU dan RKT terlebih dahulu');
        Yii::app()->user->setFlash('error', $message);
        return $this->redirect(array('/admin'));
    }

    foreach(range($tahun_mulai->tahun_mulai,$tahun_sampai->tahun_sampai) as $key => $year) {
        $dt[$year] = (string) $year;
    }

    $per = CHtml::listData(Perusahaan::model()->findAll(),'id_perusahaan','nama_perusahaan');

    $prs1 = Perusahaan::model()->findAll(array('select'=>'id_perusahaan,nama_perusahaan'));

    foreach($prs1 as $perr) {
        $c['id'] = $perr->id_perusahaan;
        $c['text'] = $perr->nama_perusahaan;
        $prs[] = $c;
    }
?>

<div id="page-wrapper" class="col-md-12">
	<?php
        $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            array(
                'id' => Yii::app()->controller->id . '-form',
                'enableAjaxValidation' => false,
                'type' => 'inline',
                'htmlOptions'=>array('class'=>'well well-sm')
            )
        ); 
    ?>
    <?php //echo $form->select2Group($modelPropinsi, 'nama', array('groupOptions' => array('id' => 'TkProv'), 'wrapperHtmlOptions' => array('class' => 'col-md-10'), 'labelOptions' => array('class' => 'col-md-2'), 'widgetOptions' => array('data' => $modelPropinsi->getProvinsi(), 'htmlOptions' => array('empty' => Yii::t('app', 'Pilih Provinsi...'), 'class' => 'form-control form-cascade-control', 'maxlength' => 2))));?>
    <?php echo $form->select2Group($modelPropinsi, 'nama',
            array(
                'groupOptions'=>array('id'=>'provin'),
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-6',
                ),
                'showLabels'=>true,
                'widgetOptions' => array(
                    'data' => $modelPropinsi->getProvinsi(),
                    'htmlOptions' => array(
                        'id' => 'provin',
                        'empty' => Yii::t('app', 'Pilih Provinsi...'),
                        'onclick' => 'js:$.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "'.Yii::app()->createUrl("/admin/peta/prov").'",
                            data: {id:this.value},
                            beforeSend: function() {
                                // $("#perusahaan").select2("data", {"id": null, "text": null});
                            },
                            success: function(data) {
                                // $(\'#kab\').html(data);
                                // alert(pers.toSource());
                                var prov = $("#select2-chosen-1").text();
                                kabs = data.kabupaten;
                                pers = data.perusahaan;
                                $("#perusahaan").empty();
                                if(pers.length > 0) {
                                    $("<option value=\"\">Pilih Perusahaan...</option>").appendTo("#perusahaan");
                                    for(var i = 0; i < pers.length; i++) {
                                        $("<option value="+pers[i].id+">"+pers[i].text+"</option>").appendTo("#perusahaan");
                                    }
                                }
                                // cariProvinsi(prov);
                            }
                        });
                        '
                    )
                )
            )          
        );
        ?>
        <?php 
        echo $form->select2Group($modelPropinsi, 'namaKab', 
            array(
                'groupOptions' => array('id' => 'kab'), 
                'wrapperHtmlOptions' => array('class' => 'col-md-10'), 
                'labelOptions' => array('class' => 'col-md-2'), 
                'widgetOptions' => array(
                    'data' => null, 
                    'asDropDownList' => false, 
                    'options' => array(
                        'allowClear' => true, 
                        'minimumInputLength' => 0, 
                        'data' => 'js: function() { return {results: kabs}; }'
                    ), 
                    'htmlOptions' => array(
                        'id'=>'kab', 
                        'empty' => Yii::t('app', 'Pilih Kabupaten/Kota...'), 
                        'placeholder' => Yii::t('app', 'Pilih Kabupaten/Kota...'), 
                        'class' => 'form-control form-cascade-control', 'maxlength' => 4,
                        'onclick' => 'js:
                            var provId = $("#provin").val();
                            $.ajax({
                                type:"POST",
                                dataType:"JSON",
                                url:"'.Yii::app()->createUrl("/admin/peta/kab").'",
                                data:{id:this.value,idProv:provId},
                                success: function(data){
                                    pers = data.perusahaan;
                                    $("#perusahaan").empty();
                                    $("#perusahaan").siblings(".select2-allowclear").removeClass("select2-allowclear");
                                    $("#perusahaan").siblings().children(".select2-choice").addClass("select2-default");
                                    $("#perusahaan").siblings().children(".select2-choice").children(".select2-chosen").empty().html("Pilih Perusahaan...");
                                    $("#perusahaan").val("");
                                    if(pers.length > 0) {
                                        $("<option value=\"\">Pilih Perusahaan...</option>").appendTo("#perusahaan");
                                        for(var i = 0; i < pers.length; i++) {
                                            $("<option value="+pers[i].id+">"+pers[i].text+"</option>").appendTo("#perusahaan");
                                        }
                                    }
                                }
                            });
                        '
                    )
                )
                )
            );
        ?>

        <?php echo $form->select2Group($modelPropinsi, 'tahun',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-6',
                ),
                'widgetOptions' => array(
                    'data' => $dt,
                    'htmlOptions'=>array('id'=>'tahun', 'empty'=>'Pilih Tahun...'),
                    'options'=>array('allowClear'=>true, 'asDropDownList' => false)
                )
            )
        );
        ?>
        <?php echo $form->select2Group($modelPropinsi, 'perusahaanProvinsi',
            array(
                'wrapperHtmlOptions' => array(
                    'class' => 'col-sm-6',
                ),
                'widgetOptions' => array(
                    'data' => $per,
                    'htmlOptions'=>array('id'=>'perusahaan', 'empty'=>'Pilih Perusahaan...'),
                    'options' => array('allowClear' => true)
                )
            )
        );
        ?>

         <?php
            $ajaxOptions = array('dataType' => 'json',
                'type' => 'post',
                'beforeSend' => 'function() {
                    $("#leftCol").prepend("<img id=\'loader\' src=\''.Yii::app()->baseUrl.'/img/ajax-loader.gif'.'\'/>");
                    $(".nipz-panel").fadeOut(\'fast\');
                }',
                'success' => 'js:function(data) {
                    // alert(data.rkt.length);
                    $("#dataIup").empty();
                    $("#dataTb").empty();
                    $("#dataRku").empty();
                    $("#dataRkt").empty();
                    var namaMap = new Array();
                    var namaMapRkt = new Array();
                    var namaMapIup = new Array();
                    var namaMapTb = new Array();

                    // Peta Kawasan
                    for(var j=0; j<data.iup.length; j++) {
                        if(data.iup[j].nama == "Hasil tidak ditemukan") {
                            if(data.iup.length == 1) {
                                $("<p>"+data.iup[j].nama+"</p>").appendTo("#dataIup");
                            }
                        } else {
                            $(""+data.iup[j].content+"").appendTo("#dataIup");
                        }
                        namaMapIup[j] = data.iup[j].map;
                        if(j === data.iup.length - 1) {
                            newProvIup(namaMapIup);
                        }
                    }

                    // Peta Tata Batas
                    for(var j=0; j<data.tb.length; j++) {
                        if(data.tb[j].nama == "Hasil tidak ditemukan") {
                            if(data.tb.length == 1) {
                                $("<p>"+data.tb[j].nama+"</p>").appendTo("#dataTb");
                            }
                        } else {
                            $(""+data.tb[j].content+"").appendTo("#dataTb");
                        }
                        namaMapTb[j] = data.tb[j].map;
                        if(j === data.tb.length - 1) {
                            newProvTb(namaMapTb);
                        }
                    }

                    for(var i=0; i<data.rku.length; i++) {
                        // alert(data.rku[i].toSource());
                        if(data.rku[i].nama == "Hasil tidak ditemukan") {
                            if(data.rku.length == 1) {
                                $("<p>"+data.rku[i].nama+"</p>").appendTo("#dataRku");
                                fit();
                            }
                        } else {
                            $("<div class=\"checkbox check-nip\"><label><input type=\"checkbox\" name=\"list[]\" id=\"list"+i+"\" onclick=\"rkuTile("+i+");\" checked=\"checked\"><a href=\"#\" onclick=\"zoom(\'"+data.rku[i].map+"\',\'rku\');return false;\">"+data.rku[i].nama+"</a></label></div>").appendTo("#dataRku");
                            fit();
                        }
                        namaMap[i] = data.rku[i].map;
                        if(i === data.rku.length - 1) {
                            newProv(namaMap);
                        }
                    }
                    

                    for(var j=0; j<data.rkt.length; j++) {
                        if(data.rkt[j].nama == "Hasil tidak ditemukan") {
                            if(data.rkt.length == 1) {
                                $("<p>"+data.rkt[j].nama+"</p>").appendTo("#dataRkt");
                            }
                        } else {
                            $(""+data.rkt[j].content+"").appendTo("#dataRkt");
                        }
                        namaMapRkt[j] = data.rkt[j].map;
                        if(j === data.rkt.length - 1) {
                            newProvRkt(namaMapRkt);
                        }
                    }

                    $("#loader").remove();
                    $(".nipz-panel").fadeIn(\'fast\');
                    
                }'
            );
            ?>
            <!-- <div class="clearfix" style="margin-top:10px"></div> -->
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'id'=>'nipz-ajax-submit',
                'buttonType' => 'ajaxSubmit', 'context' => 'primary',
                'label' => Yii::t('app', 'Cari'),
                'ajaxOptions' => $ajaxOptions,
                // 'size' => 'small',
                'url' => Yii::app()->createUrl('/admin/peta/')
            ));
            echo ' ';
            $this->widget('booster.widgets.TbButton', array(
                'buttonType' => 'reset',
                'context' => 'default',
                'htmlOptions'=>array(
                    'onclick'=>'js:
                        var ph = $("#kab").attr("placeholder");

                        $("#provin").siblings(".select2-allowclear").removeClass("select2-allowclear");
                        $("#provin").siblings().children(".select2-choice").addClass("select2-default");
                        $("#provin").siblings().children(".select2-choice").children(".select2-chosen").empty().html("Pilih Provinsi...");
                        $("#provin").val("");

                        $("#kab").siblings(".select2-allowclear").removeClass("select2-allowclear");
                        $("#kab").siblings().children(".select2-choice").addClass("select2-default");
                        $("#kab").siblings().children(".select2-choice").children(".select2-chosen").empty().html(ph);
                        $("#kab").val("");

                        $("#tahun").siblings(".select2-allowclear").removeClass("select2-allowclear");
                        $("#tahun").siblings().children(".select2-choice").addClass("select2-default");
                        $("#tahun").siblings().children(".select2-choice").children(".select2-chosen").empty().html("Pilih Tahun...");
                        $("#tahun").val("");

                        $("#perusahaan").siblings(".select2-allowclear").removeClass("select2-allowclear");
                        $("#perusahaan").siblings().children(".select2-choice").addClass("select2-default");
                        $("#perusahaan").siblings().children(".select2-choice").children(".select2-chosen").empty().html("Pilih Perusahaan...");
                        $("#perusahaan").val("");

                        $("#nipz-ajax-submit").trigger("click");

                        $("#perusahaan").empty();
                        $("<option value=\"\">Pilih Perusahaan...</option>").appendTo("#perusahaan");
                        // alert(persh.toSource());
                        for(var i = 0; i < persh.length; i++) {
                            $("<option value=\""+persh[i].id+"\">"+persh[i].text+"</option>").appendTo("#perusahaan");
                        }
                    '
                ),
                // 'size' => 'small',
//                            'htmlOptions' => array('confirm' => Yii::t('app', 'Form yang telah diisi akan hilang, lanjutkan pembatalan?'), 'class' => 'basebottom', 'onclick' => "window.location.href = '" . CHtml::normalizeUrl(array('index')) . "'"),
                'label' => Yii::t('app', 'Reset'),
            ));
            ?>

    <?php $this->endWidget();?>
</div>
<?php
Yii::app()->clientScript->registerScript('tes',"var kabs = [];var pers = []; var persh = ".CJSON::encode($prs)." ", CClientScript::POS_BEGIN);
Yii::app()->clientScript->registerScript('change value',"
    var pv = '';
    var ph = $('#kab').attr('placeholder');
    $('#provin').change(function() {
        var pr = this.value;
        if (pr != pv) {
            pv = this.value;
            $('#kab').siblings('.select2-allowclear').removeClass('select2-allowclear');
            $('#kab').siblings().children('.select2-choice').addClass('select2-default');
            $('#kab').siblings().children('.select2-choice').children('.select2-chosen').empty().html(ph);
            $('#kab').val('');

            $('#perusahaan').siblings('.select2-allowclear').removeClass('select2-allowclear');
            $('#perusahaan').siblings().children('.select2-choice').addClass('select2-default');
            $('#perusahaan').siblings().children('.select2-choice').children('.select2-chosen').empty().html('Pilih Perusahaan...');
            $('#perusahaan').val('');
        }
    });
    $('#kab').change(function() {
        if (this.value != '') { $('#kab').find('.select2-chosen').removeClass('select2-default'); }
    });
",CClientScript::POS_READY);