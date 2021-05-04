<?php
$baseUrl = Yii::app()->baseUrl;
$themeBase = Yii::app()->theme->baseUrl;
// setup scriptmap for jquery and jquery-ui
$cs = Yii::app()->clientScript;
$cs->scriptMap["jquery.js"] = $themeBase . "/assets/js/jquery.min.js";
$cs->scriptMap["jquery.min.js"] = $cs->scriptMap["jquery.js"];
$cs->scriptMap["jquery-ui.min.js"] = $themeBase . "/assets/js/lib/jquery_ui/jquery-ui-1.10.3.custom.min.js";
/* register js files */
$cs->registerCoreScript('jquery');
$cs->scriptMap["bootstrap.js"] = $themeBase . "/assets/bootstrap/js/bootstrap.min.js";
$cs->scriptMap["bootstrap.min.js"] = $cs->scriptMap["bootstrap.js"];

$cs->scriptMap["bootstrap-datepicker.js"] = $themeBase . "/assets/bootstrap/datepicker/js/bootstrap-datepicker.min.js";
$cs->scriptMap["bootstrap-datepicker.min.js"] = $cs->scriptMap["bootstrap-datepicker.js"];

// jquery cookie
$cs->registerScriptFile($themeBase . "/assets/js/jquery_cookie.min.js", CClientScript::POS_END);
// app-js
$cs->registerScriptFile($themeBase . "/assets/js/ebro_common.js", CClientScript::POS_END);
// tinyNav
$cs->registerScriptFile($themeBase . "/assets/js/tinynav.js", CClientScript::POS_END);
// slimscroll
$cs->registerScriptFile($themeBase . "/assets/js/lib/jQuery-slimScroll/jquery.slimscroll.min.js", CClientScript::POS_END);
// navgoco
$cs->registerScriptFile($themeBase . "/assets/js/lib/navgoco/jquery.navgoco.min.js", CClientScript::POS_END);

/* register css */
// Bootstrap
$cs->registerCssFile($themeBase . "/assets/bootstrap/css/bootstrap.min.css");
$cs->registerCssFile($themeBase . "/assets/css/style.css");
$cs->registerCssFile($themeBase . "/assets/css/theme/color_1.css");
$cs->registerCssFile($themeBase . "/assets/css/font-awesome/css/font-awesome.min.css");
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistem Pelaporan dan Monitoring Kinerja IUPHHK - HTI</title>

        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <!-- <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"> -->

        <!--[if lt IE 9]>
                <link rel="stylesheet" href="css/ie.css">
                <script src="js/ie/html5shiv.js"></script>
                <script src="js/ie/respond.min.js"></script>
                <script src="js/ie/excanvas.min.js"></script>
        <![endif]-->

        <!-- custom fonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    </head>
    <body class=" sidebar_hidden side_fixed">
        <div id="wrapper_all">
            <header id="top_header">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9 col-xs-12">
                            <a href="#" class="navbar-brand" title="">
                                <img src="<?php echo $baseUrl; ?>/img/logo.png" width="70">
                            </a>
                            <h4><strong>Kementerian Lingkungan Hidup dan Kehutanan</strong></h4>
                            <h5><strong>Direktorat Usaha Hutan Produksi</strong></h5>
                        </div>
                        <?php if (!Yii::app()->user->isGuest): ?>
                            <div class="col-sm-3 hidden-xs">
                                <p class="pull-right">Selamat Datang <br>
                                    <strong style="float: right"><?php echo Yii::app()->user->namaUser(); ?></strong></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <strong>Sistem Pelaporan dan Monitoring Kinerja IUPHHK - HTI</strong>
                            <?php if (!Yii::app()->user->isGuest): ?>
                                <div class="pull-right dropdown">
                                    <a href="<?php echo Yii::app()->createUrl('//site/logout'); ?>" class="user_info">
                                        Logout <i class="fa fa-sign-out"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </header>
            <?php if (isset($this->breadcrumbs)): ?>
                <section id="breadcrumbs">
                    <div class="container-fluid">
                        <?php
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                            'htmlOptions' => array('class' => ''),
                            'tagName' => 'ul',
                            'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
                            'inactiveLinkTemplate' => '<li><span>{label}</span></li>',
                            'links' => $this->breadcrumbs,
                            'separator' => '',
                        ));
                        ?>
                    </div>
                </section>
            <?php endif ?>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <a data-dismiss="alert" class="close">&times;</a>
                    <?php echo Yii::app()->user->getFlash('success'); ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('info')): ?>
                <div class="alert alert-info">
                    <a data-dismiss="alert" class="close">&times;</a>
                    <?php echo Yii::app()->user->getFlash('info'); ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('error')): ?>
                <div class="alert alert-danger">
                    <a data-dismiss="alert" class="close">&times;</a>
                    <?php echo Yii::app()->user->getFlash('error'); ?>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('notice')): ?>
                <div class="alert alert-warning">
                    <a data-dismiss="alert" class="close">&times;</a>
                    <?php echo Yii::app()->user->getFlash('notice'); ?>
                </div>
            <?php endif; ?>
            <section class="container-fluid clearfix main_section">
                <div id="main_content_outer" class="clearfix">
                    <div id="main_content">
                        <?php echo $content; ?>
                    </div>
                </div>
            </section>
            <div id="footer_space"></div>
        </div>

        <footer id="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        &copy; 2015 Direktorat Bina Usaha Hutan Tanaman
                    </div>
                </div>
            </div>
        </footer>

        <!--[if lte IE 9]>
                <script src="js/ie/jquery.placeholder.js"></script>
                <script>
                        $(function() {
                                $('input, textarea').placeholder();
                        });
                </script>
        <![endif]-->

    </body>
</html>
