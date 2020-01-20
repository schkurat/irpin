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
    $('#id_el_arh').val($(this).data("arh"));
    $('#adr_el_arh').val($(this).parent().next('.arh-item-adr').html());
    $('#selected_ea').css("display","table-row");
    // alert($(this).data("arh"));
    // alert($(this).parent().next('.arh-item-adr').html());

}