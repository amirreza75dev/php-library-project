// sending data to database with ajax
$(function() {
   
    $('#log-btn').on('click',function(event) {
        console.log("hi");
        event.preventDefault();
        var email = $('#name').val().trim();
        console.log(email);
        var password = $('#pass').val().trim();
        var selectedRadio = $('input[name="role"]:checked').val();
        var dataToSend = {
            'email': email,
            'password': password,
            'selectedRadio': selectedRadio
        };
        
            $.ajax({
                url: './includes/ajaxCalls.php?action=login',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(dataToSend),
                success: function(response) {
                    console.log(response);
                    var parsedResponse = JSON.parse(response);
                    console.log(parsedResponse);
                    if(parsedResponse.message == "successful"){
                        window.location.href = parsedResponse.page;
                    }else{
                        $('.invalid p').css('display', 'block');
                        console.log(parsedResponse.message);
                    }
                }
            });
            
     
        


    });
});