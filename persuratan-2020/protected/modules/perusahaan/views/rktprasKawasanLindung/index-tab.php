<div id="tabs_rekap">
    <ul id="list_tabs2" class="nav nav-tabs">
        <li class="active">
            <?php
            echo CHtml::link("Kawasan Lindung", "#child_content", array(
                // "data-uri" => $this->createUrl('//perusahaan/rktprasKawasanLindung/DaftarKawasanLindung/rkt/' . $rkt->id),
                "data-uri" => $this->createUrl('//perusahaan/rktprasKawasanLindung/daftarKawasanLindung',array('rkt'=>$rkt,)),
                "data-toggle" => "tab",
                "aria-expanded" => "true",
                "onclick" => "return ambilChildContent(this)"
            ));
            ?>
        </li>
        <li>
            <?php
            echo CHtml::link("Areal Tidak Efektif", "#child_content", array(
                // "data-uri" => $this->createUrl('//perusahaan/rktPemanenanLahan/index/rkt/' . $rkt->id),
                "data-uri" => $this->createUrl('//perusahaan/rktprasArealTidakEfektif/daftarKawasanLindung',array('rkt'=>$rkt,)),

                "data-toggle" => "tab",
                "aria-expanded" => "true",
                "onclick" => "return ambilChildContent(this)"
            ));
            ?>
        </li>
        <li>
            <?php
            echo CHtml::link("Areal Efektif", "#child_content", array(
                // "data-uri" => $this->createUrl('//perusahaan/rktPemanenanLahan/index/rkt/' . $rkt->id),
                "data-uri" => $this->createUrl('//perusahaan/rktprasArealEfektif/daftarArealEfektif',array('rkt'=>$rkt,)),
                "data-toggle" => "tab",
                "aria-expanded" => "true",
                "onclick" => "return ambilChildContent(this)"
            ));
            ?>
        </li>
    </ul>
    <div class="tab-content">
        <div id="child_content">
            <div class="loader" style="text-align:center"><h3>Loading...</h3></div>
        </div>
    </div>
</div>



<input type="hidden" id="checkCompleteAjaxParent">
<script type="text/javascript">
    //document ready apabila halaman ini load page biasa
    $(document).ready(function () {
        setTimeout(function(){
            $("#list_tabs2").find('li.active > a').trigger('click');
        }, 500);
    });

    //document ready apabila halaman ini di ajax kan , tapi harus ada pengecekan karena hasil dari fungsi ajax success nya pun berupa ajax, agar tidak looping
    //$( document ).ajaxComplete(function() {
    $( document ).ajaxSuccess(function() {
         if ($('#checkCompleteAjaxParent').val()==''){
         setTimeout(function(){
                $('#list_tabs2').find('li.active > a').trigger('click');
                $('#checkCompleteAjaxParent').val(1);
            }, 500);
         }
    });
</script>
