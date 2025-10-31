hideDefaults()
hideAndShowDiv($('#navigation_id').attr('data-value'))
var allowed_size = 5;
$("#navigation_id").change(function(e) {
    e.preventDefault();
   
    hideAndShowDiv($('option:selected', this).attr('data-value'))
    return false;
       
});

function hideDefaults() {
    $("#image_div").hide();
}

function hideAndShowDiv(key) {
        hideDefaults()

        if(key == 'announcements') {
            $("#image_div").show();
            $("#file_name_div").hide();
            $("#dated_div").hide();
           
        }

        if(key != 'announcements') {
            $("#image_div").hide();
            $("#file_name_div").show();
            $("#dated_div").show();
           
        }
        if(key == 'library') {
        	allowed_size = 15;
        }
        
}

 $(function() {
        $('#document').change(function(){


            if(Math.round(this.files[0].size/(1024*1024)) > allowed_size) {
            	var message = 'Please select file size less than '+allowed_size+' MB';
                alert(message);
                $('#document').val('');
            }


        });
    });


    

