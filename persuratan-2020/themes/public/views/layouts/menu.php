<div class="container">
    <div class="navbar navbar-default" role="navigation">
        <div class="navbar-inner">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => array(
                            array(
                                'label' => Yii::t('view', 'Beranda'),
                                'url' => array('/site/index'),
                                'active' => (in_array($this->route, array('', '/', 'site/index'))),
                            ),
                            array(
                                'label' => Yii::t('view', 'Kontak'),
                                'url' => array('/site/contact')
                            ),
                            array(
                                'label' => Yii::t('view', 'Tentang'),
                                'url' => array('/cms/page/read', 'slug' => 'tentang')
                            ),
                        ),
                        'htmlOptions' => array('class' => 'nav navbar-nav'),
                    ));
                    ?>
                    <?php if (!Yii::app()->user->isGuest) { ?>
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown">
                                <a href="javascript:{}" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo Yii::app()->user->namaUser(); ?> 
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="<?php echo Yii::app()->createUrl(''. Yii::app()->user->getRoleName().''); ?>" target="_blank">
                                            <i class="fa fa-dashboard"></i> <?php echo Yii::t('view', 'Dashboard'); ?>
                                        </a>
                                    </li>                                        
                                    <li>
                                        <a href="<?php echo Yii::app()->createUrl('/site/logout'); ?>">
                                            <i class="fa fa-lock"></i> <?php echo Yii::t('view', 'Keluar'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    <?php } else { ?>
                        <ul class="nav navbar-nav pull-right">
                            <li>
                                <a href="<?php echo Yii::app()->createUrl('/site/login'); ?>">
                                    <i class="fa fa-user"></i> <?php echo Yii::t('view', 'Login'); ?>
                                </a>
                            </li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>