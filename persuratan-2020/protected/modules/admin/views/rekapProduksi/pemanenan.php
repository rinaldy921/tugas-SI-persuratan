<p>&nbsp;</p>
<div id="tabs_rekap2">
    <ul id="list_tabs2" class="nav nav-tabs">
        <li class="active">
            <?php
            echo CHtml::link("Pemanenan RKT", "#resuls_content", array(
                "data-uri" => $this->createUrl('//admin/rekapProduksi/pemanenanRkt'),
                "data-toggle" => "tab",
                "aria-expanded" => "true",
                "onclick" => "return ambilContent2(this)"
            ));
            ?>
        </li>
        <li>
            <?php
            echo CHtml::link("Pemanenan Penyiapan Lahan", "#resuls_content", array(
                "data-uri" => $this->createUrl('//admin/rekapProduksi/panenLahan'),
                "data-toggle" => "tab",
                "aria-expanded" => "true",
                "onclick" => "return ambilContent2(this)"
            ));
            ?>
        </li>            
        <li>
            <?php
            echo CHtml::link("Pemanenan Hasil Hutan Bukan Kayu", "#resuls_content", array(
                "data-uri" => $this->createUrl('//admin/rekapProduksi/panenHhbk'),
                "data-toggle" => "tab",
                "aria-expanded" => "true",
                "onclick" => "return ambilContent2(this)"
            ));
            ?>
        </li>                    
    </ul>
    <div class="tab-content2">
        <div id="resuls_content2">
            <div class="loader" style="text-align:center"><h3>Loading...</h3></div>
        </div>
    </div>        
</div>
<script type="text/javascript">
    $("#list_tabs2").find('li.active > a').trigger('click');
    function ambilContent2(obj) {

        var temp = '<div class="loader" style="text-align:center"><h3>Loading...</h3></div>';
        $("#resuls_content2").html(temp);
        var link = $(obj).data('uri');
        if (link != undefined) {
            $.ajax({
                type: "POST",
                data: $('#form-periode-rekap').serialize(),
                dataType: 'html',
                url: link,
                success: function (response, statusText, xhr, $form) {
                    $('#resuls_content2').html(response);
                },
                error: function (error) {
                    $('#resuls_content2').html(error.responseText);
                }
            });
        } else {
            setTimeout(function () {
                $("#resuls_content2").html("Data tidak valid");
            }, 1000);
        }
    }

</script>