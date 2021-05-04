<?php
$this->pageTitle = Yii::t('view', 'Message');
$this->breadcrumbs = array(
    Yii::t('view', 'Message') => array('admin'),
);
?>
<div class="add-new-form">
    <?php
    echo CHtml::link("<i class='fa fa-plus'></i> " . Yii::t('view', 'Buat Pesan Baru'), array('create'), array('class' => 'btn btn-info'));
    ?>    
</div>
<div class="inbox">
    <div class="col-md-12 mail-right-box">  
        <?php
        $this->widget('booster.widgets.TbExtendedGridView', array(
            'id' => 'message-grid',
            'type' => 'hover condensed',
            'dataProvider' => $model,
            'selectableRows' => 2,
            'columns' => $this->getIndexList($model),
            'responsiveTable' => true,
            'template' => '{summary}{items}{pager}',
            'hideHeader' => true,
            'htmlOptions' => array('class' => 'mails grid-view extended-grid-view'),
            'bulkActions' => array(
                'actionButtons' => array(
                    array(
                        'id' => 'delete_all',
                        'buttonType' => 'button',
                        'context' => 'danger',
                        //'size' => 'small',
                        'encodeLabel' => false,
                        'label' => '<i class="fa fa-trash-o"></i> ' . Yii::t('view', 'Hapus Pilihan'),
                        'click' => 'js:function(values){
                            var th = this, afterDelete = function(){};
                            $("body").addClass("loading");
                            $.ajax({
                                type: "POST",
                                url: "' . Yii::app()->createUrl('/cms/message/deleteAll') . '",
                                data: {params: values},
                                success: function(data) {
                                    $("body").removeClass("loading");
                                    window.location.href = "' . Yii::app()->createUrl($this->route) . '";
                                },
                                fail: function(XHR) {
                                    $("body").removeClass("loading");
                                    alert("' . Yii::t('view', 'Pesan tidak dapat dihapus') . '");
                                    return afterDelete(th, false, XHR);
                                }
                            });
                            return false;
                        }',
                    ),
                    array(
                        'id' => 'read_all',
                        'buttonType' => 'button',
                        'context' => 'success',
                        'encodeLabel' => false,
                        'label' => '<i class="fa fa-check-circle-o"></i> ' . Yii::t('view', 'Sudah Dibaca'),
                        'click' => 'js:function(values){
                            var th = this, afterDelete = function(){};
                            $("body").addClass("loading");
                            $.ajax({
                                type: "POST",
                                url: "' . Yii::app()->createUrl('/cms/message/markAll') . '",
                                data: {params: values},
                                success: function(data) {
                                    var len = values.length;
                                    var old = $("#msg-count span.badge").text();
                                    if (old && old != "" && old != "undefined") {
                                        if ((old - len) == 0) { 
                                            $("#msg-count span.badge").remove(); 
                                        } else if ((old - len) >= 1) {
                                            $("#msg-count span.badge").text((old - len));
                                        }
                                    }
                                    $("body").removeClass("loading");
                                    jQuery("#message-grid").yiiGridView("update");
                                    afterDelete(th, true, data);
                                },
                                fail: function(XHR) {
                                    $("body").removeClass("loading");
                                    alert("' . Yii::t('view', 'Pesan tidak dapat diubah') . '");
                                    return afterDelete(th, false, XHR);
                                }
                            });
                            return false;
                        }',
                    )
                ),
                'checkBoxColumnConfig' => array(
                    'name' => 'id',
                    'htmlOptions' => array('width' => 5),
                ),
            ),
        ));
        ?>
    </div>
</div>
<div style="display: none;" tabindex="-1" class="modal fade" id="myModal"></div>