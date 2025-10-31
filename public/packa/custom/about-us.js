hideDefaults()
hideAndShowDiv($('#content_type option:selected').attr('data-value'))

$("#content_type").change(function(e) {
    e.preventDefault();
    console.log($('option:selected', this).attr('data-value'));
    hideAndShowDiv($('option:selected', this).attr('data-value'))
    return false;
});

function hideDefaults() {
    $("#order_div").hide();
    $("#document_div").hide();
    $("#image_div").hide();
    $("#thumbnail_div").hide();
    $("#souvenir_div").hide();
    $("#previous_directors_div").hide();
}


function hideAndShowDiv(key) {
    hideDefaults()

    if(key == 'organogram') {
        $("#order_div").show();
        $("#image_div").show();
        $("#document_div").hide();
        $("#thumbnail_div").hide();
        $("#souvenir_div").hide();
    }

    if(key == 'history_of_dph') {
        $("#order_div").hide();
        $("#image_div").hide();
        $("#document_div").show();
        $("#thumbnail_div").show();
        $("#souvenir_div").show();
    }

    if(key == 'previous_directors') {
        $("#order_div").hide();
        $("#image_div").hide();
        $("#document_div").hide();
        $("#thumbnail_div").hide();
        $("#souvenir_div").hide();
        $("#previous_directors_div").show();
    }

}