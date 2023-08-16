
// password required characters
var number = /([0-9])/;
var alphabets = /([a-zA-Z])/;
var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
// password value
var value;

// password and password repeat value

var repeatPassValue;

function checkPasswordStrength() {

    // password value
    value = $('#pass').val().trim();

    // Reset all error messages
    $('.min-char').css('display', 'none');
    $('.alpha-char').css('display', 'none');
    $('.special-char').css('display', 'none');
    $('.num-char').css('display', 'none');

    // Check conditions sequentially and display the first error message encountered
    if (value.length < 6) {
        $('.min-char').css('display', 'block');
    }if (!value.match(alphabets)) {
        $('.alpha-char').css('display', 'block');
    }if (!value.match(special_characters)) {
        $('.special-char').css('display', 'block');
    }if (!value.match(number)) {
        $('.num-char').css('display', 'block');
    }

}


function checkPasswordRepeat(){
    // Reset  error message
    $('.repeat-pass').css('display', 'none');
    // password and password repeat value

    repeatPassValue = $('#pass-check').val().trim();
     // Check conditions
    if(!repeatPassValue.match(value)){
        $('.repeat-pass').css('display', 'block');
    }

    // activating submit button if there is no errors
        // checking all conditions for activating submit button
    console.log(value);
    if(value.match(number) && value.match(special_characters) && value.match(alphabets) && value.length > 6 && repeatPassValue.match(value)){
        $('#log-btn').removeAttr('disabled');
    }


    }



// sending data to database with ajax

$(function() {
   
    $('#log-btn').on('click',function(event) {
        event.preventDefault();
        var name = $('#name').val().trim();
        var email = $('#email').val().trim();
        var password = $('#pass').val().trim();
        var selectedRadio = $('input[name="role"]:checked').val();
        var dataToSend = {
            'name': name,
            'email': email,
            'password': password,
            'selectedRadio': selectedRadio
        };
        console.log(selectedRadio);
        
        
            $.ajax({
                url: './controler/register-controler.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(dataToSend),
                success: function(response) {
                    
                    var parsedResponse = JSON.parse(response);
                    console.log(parsedResponse);
                    if(parsedResponse.message == "successful"){
                        window.location.href = './login.php';
                    }else{
                        console.log(parsedResponse.message);
                    }
                }
            });
            
     
        


    });
});







