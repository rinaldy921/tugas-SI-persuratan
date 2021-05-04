<div id="tabs_rekap">
    <ul id="list_tabs2" class="nav nav-tabs">
        <li class="active">
            <?php
            echo CHtml::link("Pemanenan RKT", "#child_content", array(
                "data-uri" => $this->createUrl('//perusahaan/rktPemanenan/listRktPanenProduksi/rkt/' . $rkt->id),
                "data-toggle" => "tab",
                "aria-expanded" => "true",
                "onclick" => "return ambilChildContent(this)"
            ));
            ?>
        </li>
        <li>
            <?php
            echo CHtml::link("Penyiapan Lahan", "#child_content", array(
                "data-uri" => $this->createUrl('//perusahaan/rktPemanenanLahan/index/rkt/' . $rkt->id),
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
<script type="text/javascript">
    $(document).ready(function () {
        //$("#list_tabs2").find('li.active > a').trigger('click');                
    });    
</script>