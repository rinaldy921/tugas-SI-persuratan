<?php
$this->pageTitle = $model->wp_trim($model->judul, 60);
$this->breadcrumbs = array(
    Yii::t('view', 'Message') => array($this->defaultAction),
    $model->wp_trim($model->judul, 60),
);
?>
<div class="row chat-box">
    <div class="col-md-12">
        <div class="panel panel-cascade recipient-box">
            <div class="text-justify">
                <blockquote>                    
                    <?php echo $model->pesan; ?>
                    <small>
                        <img class="chat-user-avatar img-thumbnail" src="<?php echo Yii::app()->baseUrl . '/' . $model->with(array('user.siteProfiles'))->user->siteProfiles->avatar; ?>" alt="" class="avatar">
                        <?php echo $model->with(array('user.siteProfiles'))->user->siteProfiles->firstname; ?>
                    </small>
                </blockquote>
            </div>
            <div class="panel-body nopadding">
                <div class="list-group conversation">
                    <?php if ($child) { ?>
                        <?php
                        foreach ($child as $m) {
                            $user = Yii::app()->getModule('user')->user($m->user_id);
                            $avatar = (($user->profile) && $user->profile->getAttribute('avatar')) ? $user->profile->getAttribute('avatar') : 'files/no-avatar.png';
                            ?>
                            <div class="list-group-item <?php echo ($m->messageStatus->status == 1) ? '' : 'unread'; ?>" id="msg-<?php echo $m->id; ?>">
                                <img src="<?php echo Yii::app()->baseUrl . '/' . $avatar; ?>" alt="" class="chat-user-avatar">
                                <span class="username">
                                    <?php echo $m->user->siteProfiles->firstname; ?> 
                                    <span class="time"><?php echo $m->getDateTime($m->tanggal); ?></span> 
                                </span>
                                <p class="text-justify">
                                    <?php
                                    if ($m->user_id == Yii::app()->user->id) {
                                        $this->widget('booster.widgets.TbEditableField', array(
                                            'type' => 'textarea',
                                            'model' => $m,
                                            'attribute' => 'pesan',
                                            'url' => Yii::app()->createUrl("/cms/message/updateReply"),
                                            'pk' => $m->id,
                                            'mode' => 'inline',
                                            'options' => array('rows' => 3),
                                        ));
                                    } else {
                                        echo $m->pesan;
                                    }
                                    ?>
                                </p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
                $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id' => Yii::app()->controller->id . '-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                ));
                ?> 
                <input type="hidden" name="Message[parent_id]" value="<?php echo $model->id; ?>">
                <input type="hidden" name="Message[user_tujuan]" value="<?php echo $model->user_id; ?>">
                <input type="hidden" name="Message[judul]" value="Re: <?php echo $model->judul; ?>">
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea rows="3" name="Message[pesan]" placeholder="<?php echo Yii::t('view', 'Kirim tulisan balasan'); ?>" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <?php echo CHtml::ajaxSubmitButton(Yii::t('view', ' Kirim '), array('reply'), array('success' => 'js:function(data) { var obj = JSON.parse(data); window.location.href = obj.redirect; return false; }'), array('class' => 'btn text-white bg-primary')); ?>
                    </div>                    
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerScript('delMsgHover', "
var pause;
var findMsg = function() {
    $('div.conversation div.unread').each(function(){
        var current = $(this);
        var id = current.attr('id');
        var link_id = id.substr(4, id.length);
        var link_url = '" . Yii::app()->createUrl('/cms/message/updateStatus') . "';
        $.post(link_url, {'id': link_id, 'value': 1}, function() { 
            current.removeClass('unread'); 
            var old = $('#msg-count span.badge').text();
            if (old && old != '' && old != 'undefined') {
                if ((old - 1) == 0) { 
                    $('#msg-count span.badge').remove(); 
                } else if ((old - 1) >= 1) {
                    $('#msg-count span.badge').text((old-1));
                }
            }
        });
        return false;
    });
};
$('div.conversation').find('div.unread').each(function() {
    var current = $(this);
    current.hover(function() {
        pause = setTimeout(findMsg, 1500);
    }, function() {
        clearTimeout(pause);
    });
});
", CClientScript::POS_READY);
?>