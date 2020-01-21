function searchArhiv() {
    $('#e_arhiv').fadeOut();
    $.ajax({
        type: "POST",
        url: "getArchive.php",
        data: 'rn=' + $("#rayon").val() + '&ns=' + $("#nas_punkt").val() + '&vl=' + $("#vulutsya").val() + '&bd=' + $("#bd").val() + '&kv=' + $("#kv").val(),
        dataType: "html",
        success: function (html) {
            $('#e_arhiv > tbody').empty();
            if (html > '') {
                $('#e_arhiv > tbody').append(html);
                $('#e_arhiv').fadeIn();
            }
        },
        error: function (html) {
            alert(html.error);
        }
    });
}

function selectArhiv() {
    let id_arh = $(this).data("arh");
    let address = $(this).parent().next('.arh-item-adr').html()

    $('#id_el_arh').val(id_arh);
    $('#adr_el_arh').val(address);
    $('#selected_ea').css("display","table-row");

    $.ajax({
        type: "POST",
        url: "getArchive.php",
        data: 'id_ea=' + id_arh + '&adr=' + address,
        dataType: "html",
        success: function (html) {
            $('#open_dir').parent().prev().nextAll('tr').remove();
            if (html > '') {
                $('#e_arhiv > tbody').append(html);
                $('#e_arhiv').fadeIn();
            }
        },
        error: function (html) {
            alert(html.error);
        }
    });
}