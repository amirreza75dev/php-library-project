$(function () {
    // employee javascripts
    // Make an AJAX GET request
    // accepting request
    $(".acc-req").each(function () {
        var element = $(this);
        element.on("click", function () {
            element.parent().parent().find("p").html("accepted");
        });
    });
    //adding new book
    $("#submit-book").on("click", function (event) {
        event.preventDefault();
        var sectionId = $('#section-name').find("option:selected").val()
        var bookName = $("#book-name").val();
        var authorId = $("#author-id").val();
        var avl = $("#avl").val();
        var requestData = {
            "bookName": bookName,
            "authorId": authorId,
            "sectionId": sectionId,
            "avl": avl,
        };
        // sending ajax to save new book
        $.ajax({
            url: "./includes/ajaxCalls.php?action=addingBook",
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(requestData),
            success: function (response) {
                console.log("Request processed successfully:", response);
                alert('book added successfully');
            },
            error: function (xhr, status, error) {
                console.error("Error processing request:", status, error);
            },
        });
    });
    // login page javascripts
    $('.login-container').on('submit', function (event) {
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
            success: function (response) {
                console.log(response);
                var parsedResponse = JSON.parse(response);
                console.log(parsedResponse);
                if (parsedResponse.message == "successful") {
                    window.location.href = parsedResponse.page;
                } else {
                    $('.invalid p').css('display', 'block');
                    console.log(parsedResponse.message);
                }
            }
        });
    });
    // register page javascripts
    // password required characters
    var number = /([0-9])/;
    var alphabets = /([a-zA-Z])/;
    var specialCharacters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    // password value
    var value;
    // password and password repeat value
    var repeatPassValue;
    $('#pass').on('keyup',function checkPasswordStrength() {
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
        } if (!value.match(alphabets)) {
            $('.alpha-char').css('display', 'block');
        } if (!value.match(specialCharacters)) {
            $('.special-char').css('display', 'block');
        } if (!value.match(number)) {
            $('.num-char').css('display', 'block');
        }
    })
    $('#pass-check').on('keyup',function checkPasswordRepeat() {
        // Reset  error message
        $('.repeat-pass').css('display', 'none');
        // password and password repeat value
        repeatPassValue = $('#pass-check').val().trim();
        // Check conditions
        if (!repeatPassValue.match(value)) {
            $('.repeat-pass').css('display', 'block');
        }
        // activating submit button if there is no errors
        // checking all conditions for activating submit button
        if (value.match(number) && value.match(specialCharacters) && value.match(alphabets) && value.length > 6 && repeatPassValue.match(value)) {
            $('#register-btn').removeAttr('disabled');
        }
    })
    // sending data to database with ajax 
    $('.register-container').on('submit', function (event) {
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
        console.log(dataToSend);
        $.ajax({
            url: './includes/ajaxCalls.php?action=register',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(dataToSend),
            success: function (response) {
                console.log(dataToSend);
                var parsedResponse = JSON.parse(response);
                console.log(parsedResponse);
                if (parsedResponse.message == "successful") {
                    window.location.href = './login.php';
                } else {
                    console.log(parsedResponse.message);
                }
            }
        });
    });
    // client page javascripts    
    // submit requests
    $('#submit-orders').on('click', function () {
        requestedBooks = []
        if ($("#book-inf").children().length > 0) {
            $("#book-inf").children().each(function () {
                var infoValue = $(this).attr('info');
                var individualBookRequest = this;    
                var bookRequested = false;
                var bookName = $(this).find('span').text()
                if ($('#waiting-requests table').children().length > 1) {
                    $('#waiting-requests table').children().not(':first-child').each(function () {
                        var bookInfoValue = $(this).attr('info');
                        if (bookInfoValue == infoValue) {
                            alert('You requested '+ bookName +' before');
                            $(individualBookRequest).remove();
                            bookRequested = true;
                            return false; // Exit the loop early
                        }
                    });
                } 
                if(!bookRequested){
                    addingRequest(individualBookRequest,infoValue);
                }
                
            });
            alert('your requests sent')
        }else{
            alert('please put your order first')
        }      
    })
    // search functionality
    $('#search').on('keyup', function () {
        var searchValue = $('#search').val().toLowerCase();
        console.log(searchValue);
        $('#data-container tr').each(function (index) {
            // Skip the first row with th tags
            if (index === 0) {
                return true; // Continue to the next iteration
            }
            var bookName = $(this).find('td:eq(1)').text().toLowerCase();
            console.log(bookName);
            if (bookName.indexOf(searchValue) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        }
        )
    })
// searching client books in employee page
    $('#submit-search-client').on('click', function (event) {
        event.preventDefault();
        var searchedValue = $('#search-client-input').val().toLowerCase();
        var searchedValueObject={
            "searchedValue": searchedValue
        }
        console.log(searchedValue);
        $.ajax({
            url: './includes/ajaxCalls.php?action=clientBooks', // Endpoint to check for updates
            type: 'POST', //
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(searchedValueObject),
            success: function (response) {
                // Update client page content based on the response
                // For example, update the request status dynamically
                var html =`<tr>
                                <th>book name</th>
                                <th>start date</th>
                                <th>end date</th>
                            </tr>`;
                if (response.data.length > 0) {
                  (response.data).forEach(function (item) {
                    html += `<tr>
                                    <td>${item.book_name}</td>
                                    <td>${item.start_date}</td>
                                    <td>${item.end_date}</td>
                                </tr>`;
                  });
                } else {
                  html += `<tr>
                                <td>No results found</td>
                            </tr>`;
                }
                $('#client-books-table').html(html)
            }
        });
    })
    // cancel order by client
    $('#orders').on('click','.cancel-order',function(){
        $(this).parent().remove();
    })
    $('#received-btn').on('click',function(){
        var bookId = $('#received-book-input').val();
        var dataToSend = {
            'bookId': bookId
        }
        $.ajax({
            url: './includes/ajaxCalls.php?action=received',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(dataToSend),
            success: function (response) {
                var parsedResponse = JSON.parse(response);
                if(parsedResponse.message == false){
                    alert('we received this book before')
                }else{
                    alert('book received successfully')
                }
                
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    })
});
//functions 
function readRequests(){
    $.ajax({
        url: "./includes/ajaxCalls.php?action=readRequests",
        type: "GET",
        dataType: "json", // Expected data type (can be 'html', 'json', etc.)
        success: function (response) {
            // var parsedResponse = JSON.parse(response);
            var html = `<tr>
                        <th>name</th>
                        <th>requested book</th>
                        <th>status</th>
                        <th>response</th>     
                        </tr>`;

            response.forEach((element) => {
                html += ` <tr request_id = '${element.request_id}'>
                                        <td client-id = '${element.client_id}'>${element.client_name}</td>
                                        <td book-id = '${element.book_id}'>${element.book_name}</td>
                                        <td>
                                             <p class="status">pending </p>
                                         </td>
                                        <td>
                                            <img class="acc-req"  src="img/accept.png" alt="accept">
                                            <img class="dec-req" src="img/decline.jpg" alt="decline">
                                        </td>
                          </tr>`;
            });
            $("#pending-requests").append(html);
            // accepting request
            $(".acc-req").each(function () {
                var element = $(this);
                element.on("click", function () {
                    element.parent().parent().find("p").html("accepted");
                });
            });
            // rejecting request
            $(".dec-req").each(function () {
                var element = $(this);
                element.on("click", function () {
                    element.parent().parent().find("p").html("rejected");
                });
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        },
    });
}
function books() {
    $.ajax({
        url: './includes/ajaxCalls.php?action=books',
        type: 'GET',
        dataType: 'html',
        success: function (response) {
            $('#data-container').append(response);
            // Attach click event using event delegation to dynamically created elements
            $('#data-container').on('click', '.book-req', function () {
                var bookName = $(this).closest('tr').find("td[info='book-name']").text();
                var bookId = $(this).closest('tr').attr('info');
                var startDate = $(this).closest('tr').find("input[id='start']").val();
                var endDate = $(this).closest('tr').find("input[id='end']").val();
                if (startDate > endDate) {
                    alert('start date should be less than end date');
                    return;
                } else {
                    // Create new HTML content
                    var orderedBookHtml = `<div info='${bookId}' class="order-box">
                        <span info-start='${startDate}' info-end='${endDate}' class="ordered-book">${bookName} </span>
                        <img class="cancel-order" src="img/decline.jpg" alt="">     
                    </div>`;
                    // Loop through each element with the class 'order-box'
                    var requested = false;
                    $('.order-box').each(function () {
                        // Check if the info attribute matches the current bookId
                        if ($(this).attr('info') == bookId) {
                            requested = true;
                            alert("you put your order for this book before");
                            return false; // Exit the loop early if a match is found
                        }
                    });
                    // If the book is not already requested, append the HTML content
                    if (!requested) {
                        $('#book-inf').append(orderedBookHtml);
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });
}
//check for updates function 
    // Make an AJAX GET request
    function checkForUpdates() {
        $.ajax({
            url: './includes/ajaxCalls.php?action=clientRequest', // Endpoint to check for updates
            type: 'GET',
            success: function (response) {
                // Update client page content based on the response
                // For example, update the request status dynamically
                var responseArray = JSON.parse(response);
                responseArray.forEach(element => {
                    var html = ` <tr class="requested-book" info = '${element.book_id}'>
                                    <td>${element.book_name}</td>
                                    <td>${element.start_date}</td>
                                    <td>${element.end_date}</td>
                                    <td>${element.status}</td>
                                </tr>`;
                    if ($('#waiting-requests').find(`tr[info=${element.book_id}]`).length === 0) {
                        $('#waiting-requests table').append(html);
                    } if ($('#waiting-requests').find(`tr[info=${element.book_id}]`).length === 1) {
                        $('#waiting-requests').find(`tr[info=${element.book_id}]`).find('td:last').html(element.status)
                    }
                });
            },
            complete: function () {
                // Call the function again after a delay
                setTimeout(checkForUpdates, 5000); // Repeat every 5 seconds
            }
        });
    } 
//adding request to waiting requests
function addingRequest(individualBookRequest,infoValue){
    var name = $(individualBookRequest).find('span').text();
    var startDate = $(individualBookRequest).find('span').attr('info-start');
    var endDate = $(individualBookRequest).find('span').attr('info-end');
    if (infoValue) {
        requestedBooks.push({ "book": name, "book_id": infoValue, "startDate": startDate, "endDate": endDate });
    }
    $(individualBookRequest).remove()
    var html = ` <tr class="requested-book"  info = '${infoValue}'>
                    <td>${name}</td>
                    <td>${startDate}</td>
                    <td>${endDate}</td>
                    <td>pending</td>
                </tr>`
    $('#waiting-requests table').append(html);
                // sending ajax requests to request-controler
                $.ajax({
                    url: './includes/ajaxCalls.php?action=requestedBooks',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(requestedBooks),
                    success: function (response) {
                        console.log(response);
                        var parsedResponse = JSON.parse(response);
                        if (parsedResponse.message == "successful") {
                            console.log('requests send')
                        } else {
                            console.log(parsedResponse.message);
                        }
                    }
                });
}
// approving requets
$('#approve-requests').on('click',function(){
    var requestRows = $('#pending-requests').children()
    requestRows.each(function(index,element){
        var elementText = $(element).find('.status').text()
        if(elementText == 'accepted'){
            var clientId = $(this)
            .closest("tr")
            .find("td[client-id]")
            .attr("client-id");
        var bookId = $(this)
            .closest("tr")
            .find("td[book-id]")
            .attr("book-id");
        var requestId = $(element).attr("request_id");
        var requestData = {
            requestId: requestId,
            status: "accepted",
            clientId: clientId,
            bookId: bookId,
        };
        console.log(requestData);
        element.remove();
        //sending ajax request to save request
        $.ajax({
            url: "./includes/ajaxCalls.php?action=lending",
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(requestData),
            success: function (response) {
                console.log("Request processed successfully:", response);
            },
            error: function (xhr, status, error) {
                console.error("Error processing request:", status, error);
            },
        });
        }
        if(elementText =='rejected'){
            var clientId = $(this)
            .closest("tr")
            .find("td[client-id]")
            .attr("client-id");
        var bookId = $(this)
            .closest("tr")
            .find("td[book-id]")
            .attr("book-id");
        var requestId = $(element).attr("request_id");
        var requestData = {
            "requestId": requestId,
            "status": 'rejected',
            "clientId": clientId,
            "bookId": bookId,
        };
        console.log(requestData);
        element.remove();
        //sending ajax request to save request
        $.ajax({
            url: "./includes/ajaxCalls.php?action=lending",
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(requestData),
            success: function (response) {
                console.log("Request processed successfully:", response);
            },
            error: function (xhr, status, error) {
                console.error("Error processing request:", status, error);
            },
        });
        }
    });
    alert('changed status has been sent successfully')
})
