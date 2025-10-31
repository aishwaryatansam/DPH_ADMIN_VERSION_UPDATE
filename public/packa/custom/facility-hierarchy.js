hideDefaults()
hideAndShowDiv($('#facility_level option:selected').attr('data-value'))

$("#facility_level").change(function(e) {
    e.preventDefault();
    // $.ajax({
    //     type: "POST",
    //     url: feedBaseUrl('/api/facility_level'),
    //     data: {'facility_level':$(this).val()},
    //     success: function (data) {
    //         if(data.status) {
    //             return true;
    //         }
    //     }
    // });
    loadDistrict()
    console.log($('option:selected', this).attr('data-value'));
    hideAndShowDiv($('option:selected', this).attr('data-value'))
    return false;
});






    function hideDefaults() {
        $("#district_div").hide();
        $("#hud_div").hide();
        $("#block_div").hide();
        $("#phc_div").hide();
        $("#hsc_div").hide();
        

    }

    function hideAndShowDiv(key) {
        hideDefaults()
        if(key == 'District') {
            $("#district_div").show();
            $("#hud_div").hide();
            $("#block_div").hide();
            $("#phc_div").hide();
            $("#hsc_div").hide();
        }

        if(key == 'HUD') {
            $("#district_div").show();
            $("#hud_div").show();
            $("#block_div").hide();
            $("#phc_div").hide();
            $("#hsc_div").hide();
        }

        if(key == 'Block') {
            $("#district_div").show();
            $("#hud_div").show();
            $("#block_div").show();
            $("#phc_div").hide();
            $("#hsc_div").hide();
        }

        if(key == 'HSC') {
            $("#district_div").show();
            $("#hud_div").show();
            $("#block_div").show();
            $("#phc_div").show();
            $("#hsc_div").show();
        }

        if(key == 'PHC') {
            $("#district_div").show();
            $("#hud_div").show();
            $("#block_div").show();
            $("#phc_div").show();
            $("#hsc_div").hide();
        }


    }

     function hideAndShow(key) {
        

        if(key == '0') {
            $("#contact_type_div").show();
            $("#name_div").show();
            $("#designation_div").show();
            $("#is_post_vacant_div").show();
            $("#mobile_number_div").show();
            $("#landline_number_div").show();
            $("#email_id_div").show();
            $("#fax_div").show();
            $("#status_div").show();
        }

        if(key == '1') {
            $("#contact_type_div").show();
            $("#name_div").hide();
            $("#designation_div").show();
            $("#is_post_vacant_div").show();
            $("#mobile_number_div").hide();
            $("#landline_number_div").hide();
            $("#email_id_div").hide();
            $("#fax_div").hide();
            $("#status_div").show();
            
        }

        
    }

function loadDistrict() {
    if($('#facility_level > option:selected').attr('data-value') == 'District' || $('#facility_level > option:selected').attr('data-value') == 'HUD' || $('#facility_level > option:selected').attr('data-value') == 'Block' || $('#facility_level > option:selected').attr('data-value') == 'PHC' || $('#facility_level > option:selected').attr('data-value') == 'HSC') {
        resetHUDField();
        $.ajax({
            type: "POST",
            url: feedBaseUrl('/api/list-district'),
            data: {'district_id':$("#hidden_district_id").val()},
            success: function (data) {
                if(data.status) {
                    appendDistrictatas(data.data);
                }
            }
        });
        return false;
    }
}

function resetDistrictField() {
    $("#district_id").empty();
    $("#district_id").append('<option value="" >-- Select District -- </option>');
}

function appendDistrictatas(data) {
    var hidden_district_id = $("#hidden_district_id").val()
    var selected = ''
    $.each(data,function(key, value)
    {
        selected = ''
        if (hidden_district_id == value.id) {
            selected = 'selected'
        }
        $("#district_id").append('<option value=' + value.id + ' '+selected+'>' + value.name + '</option>');
    });
    if(hidden_district_id) {
        $("#district_div").hide()
        $("#district_id").change()
    }
}

$("#district_id").change(function(e) {
    if($('#facility_level > option:selected').attr('data-value') == 'District' || !$(this).val()) {
        return;
    }
    e.preventDefault();
    resetHUDField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl('/api/list-hud'),
        data: {'district_id':$(this).val()},
        success: function (data) {
            if(data.status) {
                appendHUDDatas(data.data);
            }
        }
    });
    return false;
});

function resetHUDField() {
    $("#hud_id").empty();
    $("#hud_id").append('<option value="" >-- Select HUD -- </option>');
}

function appendHUDDatas(data) {
    $.each(data,function(key, value)
    {
        $("#hud_id").append('<option value=' + value.id + '>' + value.name + '</option>');
    });
}

$("#hud_id").change(function(e) {
    if($('#facility_level > option:selected').attr('data-value') == 'HUD' || !$(this).val()) {
        return;
    }
    e.preventDefault();
    resetBlockField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl('/api/list-block'),
        data: {'hud_id':$(this).val()},
        success: function (data) {
            if(data.status) {
                appendBlockDatas(data.data);
            }
        }
    });
    return false;
});

function resetBlockField() {
    $("#block_id").empty();
    $("#block_id").append('<option value="" >-- Select Block -- </option>');
}

function appendBlockDatas(data) {
    $.each(data,function(key, value)
    {
        $("#block_id").append('<option value=' + value.id + '>' + value.name + '</option>');
    });
}

$("#block_id").change(function(e) {
    if($('#facility_level > option:selected').attr('data-value') == 'Block' || !$(this).val()) {
        return;
    }
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


$("#phc_id").change(function(e) {
    var data_value = $('#facility_level > option:selected').attr('data-value');
    if( data_value == 'Block' || data_value == 'PHC' || !$(this).val()) {
        return;
    }
    e.preventDefault();
    resetHSCField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl('/api/list-hsc'),
        data: {'phc_id':$(this).val()},
        success: function (data) {
            if(data.status) {
                appendHSCDatas(data.data);
            }
        }
    });
    return false;
});

function resetHSCField() {
    $("#hsc_id").empty();
    $("#hsc_id").append('<option value="" >-- Select HSC -- </option>');
}

function appendHSCDatas(data) {
    $.each(data,function(key, value)
    {
        $("#hsc_id").append('<option value=' + value.id + '>' + value.name + '</option>');
    });
}
