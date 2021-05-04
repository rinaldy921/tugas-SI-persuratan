<h4> Tenaga Kerja Teknis </h4>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $teknis,
    'attributes' => array(
        array(
            'name' => 'sarjana',
        ),
        array(
            'name' => 'menengah',
        ),
        array(
            'name' => 'asing',
        ),
        array(
            'name' => 'bersertifikat',
        ),
    ),
));
?>
<br>
<br>
<h4> Tenaga Kerja Non Teknis </h4>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $non_teknis,
    'attributes' => array(
        array(
            'name' => 'sarjana',
        ),
        array(
            'name' => 'menengah',
        ),
        array(
            'name' => 'asing',
        ),
        array(
            'name' => 'bersertifikat',
        ),
    ),
));
?>