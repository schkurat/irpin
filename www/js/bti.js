function archiveActions(url) {
    $.ajax({
        type: "POST",
        url: "archiveActions.php",
        data: url,
        dataType: "html",
        success: function (html) {
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


function searchArhiv() {
    $('#e_arhiv').fadeOut();

    $('#id_el_arh').val('');
    $('#adr_el_arh').val('');
    $('#selected_ea').css("display","none");

    let url = 'rn=' + $("#rayon").val() + '&ns=' + $("#nas_punkt").val() + '&vl=' + $("#vulutsya").val() + '&bd=' + $("#bd").val() + '&kv=' + $("#kv").val() + '&action=search';
    $('#e_arhiv > tbody').empty();
    archiveActions(url)
}


function selectArhiv() {
    let id_arh = $(this).data("arh");
    let address = $(this).parent().next('.arh-item-adr').html()

    $('#id_el_arh').val(id_arh);
    $('#adr_el_arh').val(address);
    $('#selected_ea').css("display","table-row");

    let url = 'id_ea=' + id_arh + '&adr=' + address + '&action=select';
    $('#open_dir').parent().prev().nextAll('tr').remove();
    archiveActions(url)
}


function delFile() {
    let url_file = $(this).data("url");
    let isDel = confirm("Ви дійсно бажаєте видалити файл?");
    if (isDel){
        let url = 'url=' + url_file + '&action=delete';
        archiveActions(url);
        $(this).parent().parent().remove()
    }
}

function checkEaSelect() {
    if (!$('#e_arhiv > tbody').is(':empty') && $('#id_el_arh').val()==''){
        alert("Зазначте адресу електронного архіву!");
    }
}

function addToStorage() {
    let tax_id = $(this).data("tax-id");
    let isAdd = confirm("Ви дійсно бажаєте додати таксування до електронного архіву?");
    if (isAdd){

        let url = 'idtaks=' + tax_id + '&storage=1';

        $.ajax({
            type: "GET",
            url: "taks_print.php",
            data: url,
            dataType: "html",
            success: function (html) {
                if (html > '') {
                    alert(html);
                }
            },
            error: function (html) {
                alert(html.error);
            }
        });
    }
}

// function changeStatus() {
//     let element = $(this);
//     let zm_kl = $(this).data("kl");
//     let status = $(this).data("status");
//     $.ajax({
//         type: "POST",
//         url: "changeStatus.php",
//         data: 'kl=' + zm_kl + '&status=' + status,
//         dataType: "html",
//         success: function (html) {
//             if (html === '1') {
//                 element.parent().css("background-color","#ffd391");
//                 element.parent().siblings().css("background-color","#ffd391");
//             }
//             if (html === '2') {
//                 element.parent().css("background-color","#ff838e");
//                 element.parent().siblings().css("background-color","#ff838e");
//             }
//         },
//         error: function (html) {
//             alert(html.error);
//         }
//     });
// }