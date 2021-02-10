
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
// Wait for the DOM to be ready
$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='registration']").validate({
        // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side

            email: {
                required: true,
                // Specify that email should be validated
                // by the built-in "email" rule
                email: true
            },
            password: {
                required: true,
                minlength: 5
            }
        },
        // Specify validation error messages
        messages: {

            password: {
                required: "Please enter correct password",
                // minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address"
        },
        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            form.submit();
        }
    });
});

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
    $('#dateTime').attr('min', maxDate);

});


$(function() {
    $("[name=send]").each(function(i) {
        $(this).change(function(){
            $('#blk-1, #blk-2').hide();
            divId = 'blk-' + $(this).val();
            $("#"+divId).show('slow');
        });
    });

    $('input[type=radio][name="send"]').change(function() {
        // alert($(this).val()); // or this.value
        var radioval = $(this).attr("data-id");

        if(radioval == 2){
            $("#dateTime").prop('required',true);
            $("#dateTime").val('');

            $("#time").prop('required',true);
            $("#time").val('');
        }else{
            $("#dateTime").prop('required',false);
            $("#time").prop('required',false);

        }
    });
    $("form[name='specifycontent']").validate({
        rules: {
            firstname: "required",
            message: "required",
        },
        messages: {
            firstname: "Please enter your title",
            message: "Please enter Description",
        },
    });


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


    $('#adminname').rules("add", {
        required:true,
        messages: {
            required: "Enter full name"
        }
    });
    $('#txtPassword, #txtConfirmPassword').on('keyup', function () {
        if ($('#txtPassword').val() == $('#txtConfirmPassword').val()) {
            $('#message').html('').css('color', '#008000');
        } else
            $('#message').html('Not Matching').css('color', '#FF0000');
    });
});




$(document).ready(function(){
    // validate the form when it is submitted
    $("#packages2").validate();
    $('#package2').rules("add", {
        required:true,

        messages: {
            required: "Please enter your package"
        }
    });
    $('#credits2').rules("add", {
        required:true,
        min:1,

        messages: {
            required: "Please enter your credits"
        }
    });
    $('#price2').rules("add", {
        required:true,
        min: 1,
        messages: {
            required: "Please enter your price"
        }
    });


    $("#packages3").validate();
    $('#package3').rules("add", {
        required:true,
        messages: {
            required: "Please enter your package"
        }
    });
    $('#credits3').rules("add", {
        required:true,
        min:1,
        messages: {
            required: "Please enter your credits"
        }
    });
    $('#price3').rules("add", {
        required:true,
        min: 1,
        messages: {
            required: "Please enter your price"
        }
    });

    $("#packages4").validate();
    $('#package4').rules("add", {
        required:true,
        messages: {
            required: "Please enter your package"
        }
    });
    $('#credits4').rules("add", {
        required:true,
        min:1,
        messages: {
            required: "Please enter your credits"
        }
    });
    $('#price4').rules("add", {
        required:true,
        min: 1,
        messages: {
            required: "Please enter your price"
        }
    });

    $("#form_id").validate();
    $('#merchantkey').rules("add", {
        required:true,
        messages: {
            required: "Please enter your Merchant Key"
        }
    });
    $('#merchantid').rules("add", {
        required:true,
        min: 1,
        number: true,
        messages: {
            required: "Please enter your Merchant ID "
        }


    });


    $("#form-example-1, #marketingdesription, #termcond, #privacy, #signupterm").validate();
    $('#fileuploadvid').rules("add", {
        required:true,
        messages: {
            required: "This field is required. "
        }
    });
    $('#filetitle').rules("add", {
        required:true,
        messages: {
            required: "This field is required. "
        }
    });


    $('#fileuploadvid2').rules("add", {
        required:true,
        messages: {
            required: "This field is required. "
        }
    });
    $('#filetitle2').rules("add", {
        required:true,
        messages: {
            required: "This field is required. "
        }
    });
    $('#description-1').rules("add", {
        required:true,
        messages: {
            required: "Please enter your description "
        }
    });
    $('#marketingdes').rules("add", {
        required:true,
        messages: {
            required: "Please enter your description "
        }
    });
    $('#termdesc').rules("add", {
        required:true,
        messages: {
            required: "Please enter your description "
        }
    });
    $('#privacydesc').rules("add", {
        required:true,
        messages: {
            required: "Please enter your description "
        }
    });
    $('#siggnupterm').rules("add", {
        required:true,
        messages: {
            required: "Please enter your description "
        }
    });
    $("#merchantkey").keypress(function (e) {
        var keyCode = e.keyCode || e.which;

        $("#lblError").html("");

        //Regex for Valid Characters i.e. Alphabets and Numbers.
        var regex = /^[A-Za-z0-9]+$/;

        //Validate TextBox value against the Regex.
        var isValid = regex.test(String.fromCharCode(keyCode));
        if (!isValid) {
            $("#lblError").html(" Only alphabets and numbers allowed.");
        }

        return isValid;
    });
    $('#basicInputfiled').rules("add", {
        required:false,
        messages: {
            required: "Enter full name"
        }
    });
    $("#basicInputfiled").change(function() {
        readURL(this);
    });
    $('#basicInputfiled').change(
        function () {
            var fileExtension = ["jpg", "jpeg", "gif", "png"];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only 'Image' formats is allowed.");
                this.value = ''; // Clean field
                return false;
            }
        });


    $('#basicInputfiledupdate').rules("add", {
        required:true,
        messages: {
            required: "This field is required."
        }
    });
    $("#basicInputfiledupdate").change(function() {
        readURL(this);
    });
    $('#basicInputfiledupdate').change(
        function () {
            var fileExtension = ["jpg", "jpeg", "gif", "png"];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                alert("Only 'Image' formats is allowed.");
                this.value = ''; // Clean field
                return false;
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
    $("#form_id").validate();

    $("#forgotpasswords").validate();
    $('#user-email').rules("add", {

        email: {
            required: true,
            // Specify that email should be validated
            // by the built-in "email" rule
            email: true
        },
        messages: {
            required: "Please enter a valid email address"
        }
    });
    $(".tab-pane").click(function () {
        $(".tab").removeClass("active");
        // $(".tab").addClass("active"); // instead of this do the below
        $(this).addClass("active");
    });
});
$(function () {
    $("ul.nav-tabs li:first").addClass("active");
    $(".tab-content .tab-pane:first").addClass("active");

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
$(document).ready(function(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    }
    if(mm<10){
        mm='0'+mm
    }

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("datefield").setAttribute("max", today);


});

$(document).ready(function(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    }
    if(mm<10){
        mm='0'+mm
    }

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("date").setAttribute("max", today);

});
$(document).ready(function(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    }
    if(mm<10){
        mm='0'+mm
    }

    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("min-date").setAttribute("max", today);
});
    $('.max-date').change(function(){
    var maxdate = new Date($('.max-date').val());
    var today = new Date();
    var dd = maxdate.getDate();
    var mm = maxdate.getMonth()+1; //January is 0!
    var yyyy = maxdate.getFullYear();
    if(dd<10){
        dd='0'+dd
    }
    if(mm<10){
        mm='0'+mm
    }

        maxdate = yyyy+'-'+mm+'-'+dd;
    document.getElementById("min-date").setAttribute("max", maxdate);
});
$('#compaign_users').change(function(e){
    e.preventDefault();
    var id = $(this).val();
    var url = $(this).attr("data-url");
    let _token   = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: url,
        type:"get",
        data:{
            id:id,
            _token: _token
        },
        success:function(response){
            if(response) {
                $('#maketing_compaign').find('option').remove().end();
                var option = '';
                for (var i=0;i<response.length;i++){
                    option += '<option value="'+ response[i]["id"] + '">' + response[i]["name"] + '</option>';
                }
                //console.log(option);
                $('#maketing_compaign').append(option);
                $('.compaign').show();
                $('.submit_button').show();
            }
        },
    });
});

$(document).ready(function() {
    $('.table').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
    $(".refresh_btn").click(function (e) {
        e.preventDefault();
        $("#datefield").val('');
        $("input[name=keyword]").val('');
        window.location.replace(window.location.pathname)
    });
    $(".publish").click(function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var status = $(this).attr("data-status");
        var url = $(this).attr("data-url");
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url:url,
            type:"POST",
            data:{
                id:id,
                status:status,
                _token: _token
            },
            success:function(response){
                if(response) {
                    window.location.replace(window.location.pathname);
                }
            },
        });
    });
    $('.select2').select2();
    $('.compaign').hide();
    $('.marketing_date').hide();
    $('.submit_button').hide();
    $('.nxt_button').hide();
} );
$('.confirm-color').on('click',function(e){

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to suspend full profile of this user, Remember by doing this user will no longer have access to his account.",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn-dark",
                closeModal: false,
            },
            confirm: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn-dark",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            var radioval = $(this).attr("data-id");
            var profile_url = $('#user_url').val();

            $.ajax({
                type:'put',
                url:profile_url,
                data:{id:radioval},
                success: function (results) {
                    if (results.data) {
                        if (results.data.is_active === "true"){
                            swal("Unsuspended!", "Full profile been Unsuspended.", "success");
                        } else {
                            swal("Suspended!", "Full profile been suspended.", "success");
                        }

                        location.reload();
                        //swal("Done!", results.message, "success");

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            swal("Cancelled","Your profile is safe.");
        }
    });
});

$('.profile-update').on('click',function(e){

    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Are you sure you want to suspend this business, Remember it will restrict this business to be visible in mobile APP.",
        icon: "warning",
        showCancelButton: true,
        buttons: {
            cancel: {
                text: "Cancel",
                value: null,
                visible: true,
                className: "btn-dark",
                closeModal: false,
            },
            confirm: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn-dark",
                closeModal: false
            }
        }
    }).then(isConfirm => {
        if (isConfirm) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            var radioval = $(this).attr("data-id");
            var profile_url = $('#profile_url').val();

            $.ajax({
                type:'put',
                url:profile_url,
                data:{id:radioval},
                success: function (results) {
                    if (results.data.profile_is_suspend === "true"){
                        swal("Suspended!", "Business profile has been suspended.", "success");
                    } else {
                        swal("Unsuspended!", "Business profile has been Unsuspended.", "success");
                    }
                    if (results.data) {
                        location.reload();
                        //swal("Done!", results.message, "success");

                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            swal("Cancelled","Your profile is safe.");
        }
    });


});
