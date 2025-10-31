var __listData = {};

function feedToken(){
	return $("meta[name='csrf-token']").attr('content');
}

//Get the url of the current page, from the meta tags from <head> section
function feedCurrentUrl(urlPath='') {
  var current_url = $('meta[name="current_url"]').attr('content'); //{{url('/')}}
  if(urlPath) {
    current_url = current_url+urlPath;
  }
  return current_url;
}


//Get the url of the current page, from the meta tags from <head> section
function feedBaseUrl(urlPath='') {
  var base_url = $('meta[name="base_url"]').attr('content'); //{{url('/')}}
  if(urlPath) {
    base_url = base_url+urlPath;
  }
  return base_url;
}

$(function(){


        $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': feedToken(),
       'Authorization': '$2y$10$b7ni4jXzyml/VwoFtGpG/OaWOoJT.g2UVW9sHbCEJFO7gH0Lcp5rq'
       }
    });
});

// Initialize tooltip
function callTooltip() {
  $('[data-toggle="tooltip"]').tooltip(); 
}

// schemes dropdown
$(document).ready(function() {
  $('#programDivisions').change(function() {
      var programId = $(this).val();

      // Clear the schemes dropdown
      $('#schemes').empty();
      $('#schemes').append('<option> -- Select --</option>');

      // Fetch schemes based on selected program using POST request
      if (programId) {
          $.ajax({
              url: feedBaseUrl('/api/list-scheme'), // Use the named route
              method: 'POST',
              data: {
                  program_id: programId,
              },
              success: function(data) {
                  // Populate the schemes dropdown with the retrieved data
                  $.each(data.data, function(key, value) {
                      $('#schemes').append('<option value="' + value.id +
                          '">' +
                          value.name + '</option>');
                  });
              },
              error: function(xhr) {
                  console.error(xhr);
              }
          });
      }
  });
});

