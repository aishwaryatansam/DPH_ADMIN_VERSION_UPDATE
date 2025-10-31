
$("#block_id").change(function(e) {
    
    e.preventDefault();
    resetPHCField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl('/api/list-phc'),
        data: {'block_id':$(this).val()},
        success: function (data) {
            if(data.status) {
                appendPHCDatas(data.data);
            }
        }
    });
    return false;
});

function resetPHCField() {
    $("#phc_id").empty();
    $("#phc_id").append('<option value="" >-- Select PHC -- </option>');
}

function appendPHCDatas(data) {
    $.each(data,function(key, value)
    {
        $("#phc_id").append('<option value=' + value.id + '>' + value.name + '</option>');
    });
}


