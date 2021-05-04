<?php
$this->pageTitle = Yii::t('view', 'Notifikasi');
$this->breadcrumbs = array(
    Yii::t('view', 'Notifikasi') => array('admin'),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('notifikasi-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbExtendedGridView', array(
    'id' => 'notifikasi-grid',
    'type' => 'bordered hover condensed',
    'dataProvider' => $model->search(),
    'selectableRows' => 2,
    'columns' => $this->getIndexList($model),
    'responsiveTable' => true,
    'template' => '{summary}{items}{pager}',
    //'hideHeader' => true,
    'htmlOptions' => array('class' => 'grid-view extended-grid-view'),
    'bulkActions' => array(
        'actionButtons' => array(
            array(
                'id' => 'not_del_all',
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
                        url: "' . Yii::app()->createUrl('/cms/notifikasi/deleteAll') . '",
                        data: {params: values},
                        success: function(data) {
                            $("body").removeClass("loading");
                            window.location.href = "' . Yii::app()->createUrl($this->route) . '";
                        },
                        fail: function(XHR) {
                            $("body").removeClass("loading");
                            alert("' . Yii::t('view', 'Notifikasi tidak dapat dihapus') . '");
                            return afterDelete(th, false, XHR);
                        }
                    });
                    return false;
                }',
            ),
            array(
                'id' => 'not_read_all',
                'buttonType' => 'button',
                'context' => 'success',
                'encodeLabel' => false,
                'label' => '<i class="fa fa-check-circle-o"></i> ' . Yii::t('view', 'Sudah Dibaca'),
                'click' => 'js:function(values){
                    var th = this, afterDelete = function(){};
                    $("body").addClass("loading");
                    $.ajax({
                        type: "POST",
                        url: "' . Yii::app()->createUrl('/cms/notifikasi/markAll') . '",
                        data: {params: values},
                        success: function(data) {
                            var len = values.length;
                            var old = $("#notifikasi-count span.badge").text();
                            if (old && old != "" && old != "undefined") {
                                if ((old - len) == 0) { 
                                    $("#notifikasi-count span.badge").remove(); 
                                } else if ((old - len) >= 1) {
                                    $("#notifikasi-count span.badge").text((old - len));
                                }
                            }
                            $("body").removeClass("loading");
                            jQuery("#notifikasi-grid").yiiGridView("update");
                            afterDelete(th, true, data);
                        },
                        fail: function(XHR) {
                            $("body").removeClass("loading");
                            alert("' . Yii::t('view', 'Notifikasi tidak dapat diubah') . '");
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
<div style="display: none;" tabindex="-1" class="modal fade" id="myModal"></div>