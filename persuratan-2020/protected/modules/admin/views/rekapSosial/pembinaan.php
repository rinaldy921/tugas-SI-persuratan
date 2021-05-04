<p>&nbsp;</p>
<div id="tabs_rekap2">
    <ul id="list_tabs2" class="nav nav-tabs">
        <li class="active">
            <?php
            echo CHtml::link("Kerjasama Koperasi", "#resuls_content", array(
                "data-uri" => $this->createUrl('//admin/rekapSosial/kerjasamaKoperasi'),
                "data-toggle" => "tab",
                "aria-expanded" => "true",
                "onclick" => "return ambilContent2(this)"
            ));
            ?>
        </li>
        <li>
            <?php
            echo CHtml::link("Kemitraan Usaha", "#resuls_content", array(
                "data-uri" => $this->createUrl('//admin/rekapSosial/mitraUsaha'),
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