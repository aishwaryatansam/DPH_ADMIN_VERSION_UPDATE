hideDefaults()
hideAndShowDiv($('#contact_type').attr('data-value'))

$("#contact_type").change(function(e) {
    e.preventDefault();
    resetDesignationField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl('/api/contact-designations'),
        data: {'contact_type':$(this).val()},
        success: function (data) {
            if(data.status) {
                appendDesignationDatas(data.data);
            }
        }
    });
    // loadHud()
    // hideAndShowDiv($('option:selected', this).attr('data-value'))
    return false;
});



function callFacilityListAPI(facility_type_id = null, hud_id = null, block_id = null, phc_id = null, hsc_id = null) {
    resetFacilityField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl('/api/facility-list'),
        data: {
            'facility_type_id': facility_type_id,
            'hud_id': hud_id,
            'block_id': block_id,
            'phc_id': phc_id,
            'hsc_id': hsc_id
        },
        success: function (data) {
            if (data.status) {
                appendFacilityDatas(data.data);
            }
        }
        
    });
    return false;
}

$("#facility_type").change(function(e) {
    e.preventDefault();
    resetFacilityField();
    hideAndShowDiv($('option:selected', this).attr('data-value'))
    let facility_type_id = $(this).val(); 
    callFacilityListAPI(facility_type_id);
    return false;
});


$("#is_post_vacant").change(function(e) {
    e.preventDefault();
   console.log($(this).is(':checked'));
    var isChecked = $(this).is(':checked');
    hideAndShow(isChecked ? 1 : 0);
    // hideAndShow($('option:selected', this).attr('data-value'))
    return false;
});



    function resetFacilityField() {
        $("#facility_id").empty();
        $("#facility_id").append('<option value="" >-- Select Facility -- </option>');
    }

    function appendFacilityDatas(data) {
        $.each(data,function(key, value)
        {
            $("#facility_id").append('<option value=' + value.id + '>' + value.name + '</option>');
        });
    }

    function resetDesignationField() {
        $("#designation_id").empty();
        $("#designation_id").append('<option value="" >-- Select Designation -- </option>');
    }

    function appendDesignationDatas(data) {
        $.each(data,function(key, value)
        {
            $("#designation_id").append('<option value=' + value.id + '>' + value.name + '</option>');
        });
    }

    function hideDefaults() {
        $("#hud_div").hide();
        $("#block_div").hide();
        $("#phc_div").hide();
        $("#hsc_div").hide();
        

    }

    function hideAndShowDiv(key) {
        hideDefaults()
        console.log(key);
        if(key == 'hud') {
            $("#hud_div").show();
            $("#block_div").hide();
            $("#phc_div").hide();
            $("#hsc_div").hide();
        }

        if(key == 'block') {
            $("#hud_div").show();
            $("#block_div").show();
            $("#phc_div").hide();
            $("#hsc_div").hide();
        }

        if(key == 'hsc') {
            $("#hud_div").show();
            $("#block_div").show();
            $("#phc_div").show();
            $("#hsc_div").show();
        }

        if(key == 'phc') {
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
            $("#qualification_div").show();
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
            $("#qualification_div").hide();
            $("#designation_div").show();
            $("#is_post_vacant_div").show();
            $("#mobile_number_div").hide();
            $("#landline_number_div").hide();
            $("#email_id_div").hide();
            $("#fax_div").hide();
            $("#status_div").show();
            
        }

        
    }

function loadHud() {
    if($('#contact_type > option:selected').attr('data-value') == 'hud' || $('#contact_type > option:selected').attr('data-value') == 'block' || $('#contact_type > option:selected').attr('data-value') == 'phc' || $('#contact_type > option:selected').attr('data-value') == 'hsc') {
        resetHUDField();
        $.ajax({
            type: "POST",
            url: feedBaseUrl('/api/list-hud'),
            data: {'hud_id':$("#hidden_hud_id").val()},
            success: function (data) {
                if(data.status) {
                    appendHUDDatas(data.data);
                }
            }
        });
        return false;
    }
}

function resetHUDField() {
    $("#hud_id").empty();
    $("#hud_id").append('<option value="" >-- Select HUD -- </option>');
}

function appendHUDDatas(data) {
    var hidden_hud_id = $("#hidden_hud_id").val()
    var selected = ''
    $.each(data,function(key, value)
    {
        selected = ''
        if (hidden_hud_id == value.id) {
            selected = 'selected'
        }
        $("#hud_id").append('<option value=' + value.id + ' '+selected+'>' + value.name + '</option>');
    });
    if(hidden_hud_id) {
        $("#hud_div").hide()
        $("#hud_id").change()
    }
}

$("#hud_id").change(function(e) {
    if($('#contact_type > option:selected').attr('data-value') == 'hud' || !$(this).val()) {
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
    callFacilityListAPI(null,$(this).val(),null, null, null);
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
    if($('#contact_type > option:selected').attr('data-value') == 'block' || !$(this).val()) {
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
    callFacilityListAPI(null,null,$(this).val(), null, null);
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
    var data_value = $('#contact_type > option:selected').attr('data-value');
    if( data_value == 'block' || data_value == 'phc' || !$(this).val()) {
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
    callFacilityListAPI(null, null, null, $(this).val(), null);
    return false;
});


$("#hsc_id").change(function(e) {
    var data_value = $('#contact_type > option:selected').attr('data-value');
    if( data_value == 'hsc' || !$(this).val()) {
        return;
    }
    e.preventDefault();
    resetFacilityField();
    let hsc_id = $(this).val();
    callFacilityListAPI(null, null, null, null, hsc_id);
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
