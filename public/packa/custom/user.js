hideDefaults();
hideAndShowDiv($("#userType option:selected").attr("data-value"), $("#userRole option:selected").attr("data-value"));


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

$("#userType").change(function (e) {
    e.preventDefault();
    hideAndShowDiv(
        $("option:selected", this).attr("data-value"),
        $("#userRole option:selected").attr("data-value")
    );
    return false;
});

$("#userRole").change(function (e) {
    e.preventDefault();
    hideAndShowDiv(
        $("#userType option:selected").attr("data-value"),
        $("option:selected", this).attr("data-value")
    );
    return false;
});

function hideDefaults() {
    $("#program_div").hide();
    $("#section_div").hide();
    $("#district_div").hide();
    $("#hud_div").hide();
    $("#block_div").hide();
    $("#phc_div").hide();
    $("#hsc_div").hide();
    $("#facility_div").hide();
    $("#facility_level_div").hide();
    $("#facility_filter_div").hide();
    
}

function callFacilityListAPI(
    facility_level_id = null,
    district_id = null,
    hud_id = null,
    block_id = null,
    phc_id = null,
    hsc_id = null
) {
    resetFacilityField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl("/api/facility-list"),
        data: {
            facility_level_id: facility_level_id,
            district_id: district_id,
            hud_id: hud_id,
            block_id: block_id,
            phc_id: phc_id,
            hsc_id: hsc_id,
        },
        success: function (data) {
            if (data.status) {
                appendFacilityDatas(data.data);
            }
        },
    });
    return false;
}

function resetFacilityField() {
    $("#facility_id").empty();
    $("#facility_id").append(
        '<option value="" >-- Select Facility -- </option>'
    );
}

function appendFacilityDatas(data) {
    $.each(data, function (key, value) {
        $("#facility_id").append(
            "<option value=" + value.id + ">" + value.name + "</option>"
        );
    });
}

$("#userType").change(function (e) {
    e.preventDefault();
    resetFacilityField();
    let facility_level_id = $(this).val();
    console.log(facility_level_id);
    callFacilityListAPI(facility_level_id);
    return false;
});

$("#district_id").change(function (e) {
    if (
        $("#userType > option:selected").attr("data-value") ==
            "District" ||
        !$(this).val()
    ) {
        return;
    }
    e.preventDefault();
    let facility_level_id = $("#userType").val();
    resetHUDField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl("/api/list-hud"),
        data: { district_id: $(this).val() },
        success: function (data) {
            if (data.status) {
                appendHUDDatas(data.data);
            }
        },
    });
    callFacilityListAPI(facility_level_id, $(this).val(), null, null, null, null);
    return false;
});

function resetHUDField() {
    $("#hud_id").empty();
    $("#hud_id").append('<option value="" >-- Select HUD -- </option>');
}

function appendHUDDatas(data) {
    var hidden_hud_id = $("#hidden_hud_id").val();
    var selected = "";
    $.each(data, function (key, value) {
        selected = "";
        if (hidden_hud_id == value.id) {
            selected = "selected";
        }
        $("#hud_id").append(
            "<option value=" +
                value.id +
                " " +
                selected +
                ">" +
                value.name +
                "</option>"
        );
    });
    if (hidden_hud_id) {
        $("#hud_div").hide();
        $("#hud_id").change();
    }
}

$("#hud_id").change(function (e) {
    if (
        $("#contact_type > option:selected").attr("data-value") == "hud" ||
        !$(this).val()
    ) {
        return;
    }
    e.preventDefault();
    let facility_level_id = $("#userType").val();
    resetBlockField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl("/api/list-block"),
        data: { hud_id: $(this).val() },
        success: function (data) {
            if (data.status) {
                appendBlockDatas(data.data);
            }
        },
    });
    callFacilityListAPI(facility_level_id, null, $(this).val(), null, null, null);
    return false;
});

function resetBlockField() {
    $("#block_id").empty();
    $("#block_id").append('<option value="" >-- Select Block -- </option>');
}

function appendBlockDatas(data) {
    $.each(data, function (key, value) {
        $("#block_id").append(
            "<option value=" + value.id + ">" + value.name + "</option>"
        );
    });
}

$("#block_id").change(function (e) {
    if (
        $("#contact_type > option:selected").attr("data-value") == "block" ||
        !$(this).val()
    ) {
        return;
    }
    e.preventDefault();
    let facility_level_id = $("#userType").val();
    resetPHCField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl("/api/list-phc"),
        data: { block_id: $(this).val() },
        success: function (data) {
            if (data.status) {
                appendPHCDatas(data.data);
            }
        },
    });
    callFacilityListAPI(facility_level_id, null, null, $(this).val(), null, null);
    return false;
});

function resetPHCField() {
    $("#phc_id").empty();
    $("#phc_id").append('<option value="" >-- Select PHC -- </option>');
}

function appendPHCDatas(data) {
    $.each(data, function (key, value) {
        $("#phc_id").append(
            "<option value=" + value.id + ">" + value.name + "</option>"
        );
    });
}

$("#phc_id").change(function (e) {
    var data_value = $("#contact_type > option:selected").attr("data-value");
    if (data_value == "block" || data_value == "phc" || !$(this).val()) {
        return;
    }
    e.preventDefault();
    resetHSCField();
    $.ajax({
        type: "POST",
        url: feedBaseUrl("/api/list-hsc"),
        data: { phc_id: $(this).val() },
        success: function (data) {
            if (data.status) {
                appendHSCDatas(data.data);
            }
        },
    });
    callFacilityListAPI(null, null, null, null, $(this).val(), null);
    return false;
});

$("#hsc_id").change(function (e) {
    var data_value = $("#contact_type > option:selected").attr("data-value");
    if (data_value == "hsc" || !$(this).val()) {
        return;
    }
    e.preventDefault();
    resetFacilityField();
    let hsc_id = $(this).val();
    callFacilityListAPI(null, null, null, null, null, hsc_id);
    return false;
});

function resetHSCField() {
    $("#hsc_id").empty();
    $("#hsc_id").append('<option value="" >-- Select HSC -- </option>');
}

function appendHSCDatas(data) {
    $.each(data, function (key, value) {
        $("#hsc_id").append(
            "<option value=" + value.id + ">" + value.name + "</option>"
        );
    });
}

function hideAndShowDiv(userType, userRole) {
    hideDefaults();
    if (userType === "State") {
        $("#facility_div").show();
        $("#facility_filter_div").show();
        if (userRole === "Admin-approver" || userRole === "Admin-verifier") {
            $("#program_div").show();
            
            $("#facility_level_div").show();
            
        } else if (userRole === "Admin-user") {
            $("#section_div").show();
        }
    }
    if (userType === "District") {
        $("#district_div").show();
        $("#facility_div").show();
        $("#facility_level_div").show();
        $("#facility_filter_div").show();
    }

    if (userType === "HUD") {
        $("#district_div").show();
        $("#hud_div").show();
        $("#facility_div").show();
        $("#facility_level_div").show();
        $("#facility_filter_div").show();
    }
    if (userType === "Block") {
        $("#district_div").show();
        $("#hud_div").show();
        $("#block_div").show();
        $("#facility_div").show();
        $("#facility_level_div").show();
        $("#facility_filter_div").show();
    }
    if (userType === "PHC") {
        $("#district_div").show();
        $("#hud_div").show();
        $("#block_div").show();
        $("#phc_div").show();
        $("#facility_div").show();
        $("#facility_level_div").show();
        $("#facility_filter_div").show();
    }
    if (userType === "HSC") {
        $("#district_div").show();
        $("#hud_div").show();
        $("#block_div").show();
        $("#phc_div").show();
        $("#hsc_div").show();
        $("#facility_div").show();
        $("#facility_level_div").show();
        $("#facility_filter_div").show();
    }
}
