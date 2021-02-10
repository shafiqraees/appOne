
      (function(){
  // Get inputs by container
  $('.double-slider input[type="range"]').on('input', function(e){
      // Split the elements From/To Slider and From/To values so you can handle them separtely
      const fromSlider = $(this).parent().children('input[type="range"].from'),
          toSlider = $(this).parent().children('input[type="range"].to'),
          fromValue = parseInt($(this).parent().children('input[type="range"].from').val()),
          toValue = parseInt($(this).parent().children('input[type="range"].to').val()),
          currentlySliding = $(this).hasClass('from') ? 'from' : 'to',
          outputElemFrom = $(this).parent().children('.value-output.from'),
          outputElemTo = $(this).parent().children('.value-output.to');

      // Check which slider has been adjusted and prevent them from crossing each other
      if(currentlySliding == 'from' && fromValue >= toValue){
        fromSlider.val((toValue - 1));
        fromValue = (toValue - 1);
      } else if(currentlySliding == 'to' && toValue <= fromValue){
        toSlider.val((fromValue + 1));
        toValue = (fromValue + 1);
      }

      // Updating the output values so they mirror the current slider's value
      outputElemFrom.html(fromValue);
      outputElemTo.html(toValue);

      // Caluculating and setting the progressbar widths
      $('.progressbar_from').css('width', ((fromSlider.width() / parseInt(fromSlider[0].max)) * fromSlider[0].value)  + "px");
      $('.progressbar_to').css('width', (toSlider.width() - ((toSlider.width() / parseInt(toSlider[0].max)) * toSlider[0].value))  + "px");

  });
})();



      (function(){
  // Get inputs by container
  $('.doubl-slider input[type="range"]').on('input', function(e){
      // Split the elements From/To Slider and From/To values so you can handle them separtely
      const fromSlider = $(this).parent().children('input[type="range"].from'),
          toSlider = $(this).parent().children('input[type="range"].to'),
          fromValue = parseInt($(this).parent().children('input[type="range"].from').val()),
          toValue = parseInt($(this).parent().children('input[type="range"].to').val()),
          currentlySliding = $(this).hasClass('from') ? 'from' : 'to',
          outputElemFrom = $(this).parent().children('.value-output.from'),
          outputElemTo = $(this).parent().children('.value-output.to');

      // Check which slider has been adjusted and prevent them from crossing each other
      if(currentlySliding == 'from' && fromValue >= toValue){
        fromSlider.val((toValue - 1));
        fromValue = (toValue - 1);
      } else if(currentlySliding == 'to' && toValue <= fromValue){
        toSlider.val((fromValue + 1));
        toValue = (fromValue + 1);
      }

      // Updating the output values so they mirror the current slider's value
      outputElemFrom.html(fromValue);
      outputElemTo.html(toValue);

      // Caluculating and setting the progressbar widths
      $('.progressbar_from').css('width', ((fromSlider.width() / parseInt(fromSlider[0].max)) * fromSlider[0].value)  + "px");
      $('.progressbar_to').css('width', (toSlider.width() - ((toSlider.width() / parseInt(toSlider[0].max)) * toSlider[0].value))  + "px");

  });
})();

function executeAutomaticVisibility(name) {
  $("[name=" + name + "]:checked").each(function() {
    $("[showIfIdChecked=" + this.id + "]").show();
  });
  $("[name=" + name + "]:not(:checked)").each(function() {
    $("[showIfIdChecked=" + this.id + "]").hide();
  });
}

$(document).ready(function() {
  triggers = $("[showIfIdChecked]")
    .map(function() {
      return $("#" + $(this).attr("showIfIdChecked")).get()
    })
  $.unique(triggers);
  triggers.each(function() {
    executeAutomaticVisibility(this.name);
    $(this).change(function() {
      executeAutomaticVisibility(this.name);
    });
  });
});

$('input[type="radio"]').change(function () {
    $(this).closest('div.question').find('p.hien').toggle(this.value == 'Yes');
}).change();


$('.hide-show input').change(function () {
    $(this).closest('.hide-show').next('.hide-show-yes').toggle(this.value == 'yes').next('.hide-show-no').toggle(this.value == 'no');
}).filter(':checked').change();


$(function() {
    $("[name=UniqueImpressions]").each(function(i) {
        $(this).change(function(){
            $('#blk-1, #blk-2').hide();
            divId = 'blk-' + $(this).val();
            $("#"+divId).show('slow');
        });
    });
 });


$(function() {
    $("[name=Endoncebudgetends]").each(function(i) {
        $(this).change(function(){
            $('#blk-1, #blk-3').hide();
            divId = 'blk-' + $(this).val();
            $("#"+divId).show('slow');
        });
    });
 });



$(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;
   // alert(maxDate);
    $('#txtDate').attr('min', maxDate);
    /*$( "#txtDate" ).datepicker({
        dateFormat: 'yyyy-mm-dd',
        changeMonth: true,
        changeYear: true
    });*/
});


$(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;
   // alert(maxDate);
    $('#endtxtDate').attr('min', maxDate);
});


      $('#imgInp').change(
          function () {
              var fileExtension = ["jpg", "jpeg", "gif", "png"];
              if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                  alert("Only 'Image' formats is allowed.");
                  this.value = ''; // Clean field
                  return false;
              }
          });
var _validFileExtensions = [".ogg", ".ogv", ".mpeg", ".mov", ".wmv" , ".flv" , ".mp4"];
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }

            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}

      function initAutocomplete() {
          var input = document.getElementById('autocomplete');
          // var options = {
          //   types: ['(regions)'],
          //   componentRestrictions: {country: "IN"}
          // };
          var options = {}

          var autocomplete = new google.maps.places.Autocomplete(input, options);

          google.maps.event.addListener(autocomplete, 'place_changed', function() {
              var place = autocomplete.getPlace();
              var lat = place.geometry.location.lat();
              var lng = place.geometry.location.lng();
              var placeId = place.place_id;
              // to set city name, using the locality param
              var componentForm = {
                  locality: 'short_name',
              };
              $("#latitude").val(lat);
              $("#longitude").val(lng);
              $("#location_id").val(placeId);
          });
      }
      function geolocate() {
          if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                  var geolocation = {
                      lat: position.coords.latitude,
                      lng: position.coords.longitude
                  };

                  var circle = new google.maps.Circle(
                      {center: geolocation, radius: position.coords.accuracy});
                  autocomplete.setBounds(circle.getBounds());
              });
          }
      }

      $(document).ready(function() {
          $('input[type=radio][name="UniqueImpressions"]').change(function() {
              // alert($(this).val()); // or this.value
              var radioval = $(this).val();
              if(radioval == 2){
                  $("#basicInput123").addClass("required");
                  $("#basicInput123").val('');
              }else{
                  $("#basicInput123").removeClass("required");

              }
          });
          $('input[type=radio][name="Endoncebudgetends"]').change(function() {
             // alert($(this).val()); // or this.value
              var radioval = $(this).val();
              if(radioval == 3){
                  $("#endtxtDate").addClass("required");
                  $("#endtxtDate").val('');
              }else{
                  $("#endtxtDate").removeClass("required");

              }
          });
          $( "#basicInput3" ).keyup(function(event) {
              event.preventDefault();
              var url = $("input[name=url]").val();
              let Gender = $('input[name="Gender"]:checked').val();
              //let Gender = $('input[type=radio][name="Gender"]')
              let latitude = $("input[name=latitude]").val();
              let longitude = $("input[name=longitude]").val();
              let Location = $("input[name=Location]").val();
              let Age_from = $("input[name=Age_from]").val();
              let Age_to = $("input[name=Age_to]").val();
              let radius = $("input[name=radius]").val();
              let _token   = $('meta[name="csrf-token"]').attr('content');

              $.ajax({
                  url:url,
                  type:"POST",
                  data:{
                      Gender:Gender,
                      latitude:latitude,
                      longitude:longitude,
                      Location:Location,
                      Age_from:Age_from,
                      Age_to:Age_to,
                      radius:radius,
                      _token: _token
                  },
                  success:function(response){
                      console.log(response);
                      if(response) {
                          $('.success').text(response.success);
                           $("#audience_mache").text(response.data);
                      }
                  },
              });
          });
          $(".refresh_btn").click(function (e) {
              e.preventDefault();
              $("#datefield").val('');
              $("input[name=keyword]").val('');
              window.location.replace(window.location.pathname)
          });
      });
      //the maps api is setup above
      window.onload = function() {
          var lattitude = $('#lat').val();
          var longitude = $('#long').val();

          var latlng = new google.maps.LatLng(lattitude,longitude); //Set the default location of map

          var map = new google.maps.Map(document.getElementById('map'), {

              center: latlng,

              zoom: 11, //The zoom value for map

              mapTypeId: google.maps.MapTypeId.ROADMAP

          });

          var marker = new google.maps.Marker({

              position: latlng,

              map: map,

              title: 'Place the marker for your location!', //The title on hover to display

              draggable: true //this makes it drag and drop

          });

          google.maps.event.addListener(marker, 'dragend', function(a) {

              console.log(a);

              document.getElementById('loc').value = a.latLng.lat().toFixed(4) + ', ' + a.latLng.lng().toFixed(4); //Place the value in input box



          });

      };


      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                  $('#imagePreview').hide();
                  $('#imagePreview').fadeIn(650);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#imageUpload").change(function() {
          readURL(this);
      });



      $('#imageUpload').change(
          function () {
              var fileExtension = ["jpg", "jpeg", "gif", "png"];
              if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                  alert("Only 'Image' formats is allowed.");
                  this.value = ''; // Clean field
                  return false;
              }
          });


      $(document).ready( function() {
          $(document).on('change', '.btn-file :file', function() {
              var input = $(this),
                  label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
              input.trigger('fileselect', [label]);
          });

          $('.btn-file :file').on('fileselect', function(event, label) {

              var input = $(this).parents('.input-group').find(':text'),
                  log = label;

              if( input.length ) {
                  input.val(log);
              } else {
                  if( log ) alert(log);
              }

          });
          function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function (e) {
                      $('#img-upload').attr('src', e.target.result);
                  }

                  reader.readAsDataURL(input.files[0]);
              }
          }

          $("#imgInp").change(function(){
              readURL(this);
          });

      });
      $(function() {
          $("form[name='update-profile']").validate({
              // Specify validation rules
              rules: {
                  Password : {
                      minlength : 5
                  },

                  password_confirmation: {
                      equalTo: "#txtPassword"
                  }

              },
              // Specify validation error messages
              messages: {

                  Password: {
                      required: "Please provide a password",
                      minlength: "Your password must be at least 5 characters long"
                  },

              },
              // Make sure the form is submitted to the destination defined
              // in the "action" attribute of the form when valid

          });
          $('#username').rules("add", {
              required:true,
              messages: {
                  required: "Enter full name"
              }
          });
          $('#txtPassword, #txtConfirmPassword').on('keyup', function () {
              if ($('#txtPassword').val() == $('#txtConfirmPassword').val()) {
                  $('#message').html('').css('color', 'green');
              } else
                  $('#message').html('Not Matching').css('color', 'red');
          });

          $("#steps-uid-0").validate();
          $('#basicInput3').rules("add", {
              required:true,
              min: 1,
              messages: {
                  required: "Enter a value minimum 1"
              }
          });
          $('#basicInput123').rules("add", {

              min: 2,
              messages: {
                  required: "Enter a value minimum 2"
              }
          });
          $('#alocatefunds').rules("add", {

              min: 1,
              messages: {
                  required: "Enter a value minimum 1"
              }
          });
          var d = new Date(),
              h = d.getHours(),
              m = d.getMinutes();
          if(h < 10) h = '0' + h;
          if(m < 10) m = '0' + m;
          $('input[type="time"][value="now"]').each(function(){
              $(this).attr({'value': h + ':' + m});
          });
      });



