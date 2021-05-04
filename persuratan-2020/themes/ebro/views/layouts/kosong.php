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
//sweetalert
$cs->registerScriptFile($themeBase . "/assets/js/sweetalert.min.js", CClientScript::POS_END);
$cs->registerScriptFile($themeBase . "/assets/js/jquery.number.js", CClientScript::POS_END);
$cs->registerScriptFile($themeBase . "/assets/js/main.js", CClientScript::POS_END);
/* register css */
// Bootstrap
$cs->registerCssFile($themeBase . "/assets/bootstrap/css/bootstrap.min.css");
$cs->registerCssFile($themeBase . "/assets/css/style.css");
$cs->registerCssFile($themeBase . "/assets/css/theme/color_1.css");
$cs->registerCssFile($themeBase . "/assets/css/font-awesome/css/font-awesome.min.css");
?>

<?php echo $content; ?>

<!--[if lte IE 9]>
        <script src="js/ie/jquery.placeholder.js"></script>
        <script>
                $(function() {
                        $('input, textarea').placeholder();
                });
        </script>
<![endif]-->

<?php
Yii::app()->clientScript->registerScript("nipz-alert","
    $(\"#nipz-alert\").animate({opacity: 1.0}, 10000).fadeOut(\"slow\");
",CClientScript::POS_READY);
