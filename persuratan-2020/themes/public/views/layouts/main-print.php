<?php $baseUrl = Yii::app()->request->baseUrl;
Yii::app()->booster->cs->registerPackage('bootstrap.css');
Yii::app()->clientScript->registerCssFile($baseUrl.'/statics/css/print.css');
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
    	<?php echo $content; ?>
    	<htmlpagefooter name="myFooter1">
<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt;
    color: #000000; font-weight: bold; font-style: italic;"><tr>
    <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
    <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
    <td width="33%" style="text-align: right; ">My document</td>
    </tr></table>
</htmlpagefooter>
    </body>
</html>