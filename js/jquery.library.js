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
            },
            error: function (xhr, status, error) {
                console.error("Error processing request:", status, error);
            },
        });
    });
    // login page javascripts
    $('#log-btn').on('click', function (event) {
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
    $('#register-btn').on('click', function (event) {
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
        $.ajax({
            url: './includes/ajaxCalls.php?action=register',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(dataToSend),
            success: function (response) {
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
    // user page javascripts    
    // submit requests
    $('#submit-orders').on('click', function () {
        requestedBooks = []
        if ($("#book-inf").children().length > 0) {
            $("#book-inf").children().each(function () {
                var infoValue = $(this).attr('info');
                var name = $(this).find('span').text();
                if (infoValue) {
                    requestedBooks.push({ "book": name, "book_id": infoValue });
                }
                $(this).remove()
                var html = ` <div  info = '${infoValue}'>
                                <p>${name}</p><span>pending</span>
                          </div>`
                $('#waiting-requests').append(html);
            })
        }
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
                    alert('requests send')
                } else {
                    console.log(parsedResponse.message);
                }
            }
        });
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
    // cancle order function 
    function cancelOrder(e) {
        var item = $(e.target).parent();
        item.remove()
    }
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
                html += ` <tr>
                                        <td client-id = '${element.client_id}'>${element.client_name}</td>
                                        <td book-id = '${element.book_id}'>${element.book_name}</td>
                                        <td>
                                          <p>pending </p>
                                         </td>
                                        <td>
                                            <img class="acc-req" request_id = '${element.request_id}' src="img/accept.png" alt="accept">
                                            <img class="dec-req" request_id = '${element.request_id}'src="img/decline.jpg" alt="decline">
                                        </td>
                                       </tr>`;
            });
            $("#pending-requests").append(html);
            // accepting request
            $(".acc-req").each(function () {
                var element = $(this);
                element.on("click", function () {
                    element.parent().parent().find("p").html("accepted");
                    var clientID = $(this)
                        .closest("tr")
                        .find("td[client-id]")
                        .attr("client-id");
                    var bookID = $(this)
                        .closest("tr")
                        .find("td[book-id]")
                        .attr("book-id");
                    var requestID = $(this).attr("request_id");
                    var requestData = {
                        requestID: requestID,
                        status: "accepted",
                        clientID: clientID,
                        bookID: bookID,
                    };
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
                });
            });
            // rejecting request
            $(".dec-req").each(function () {
                var element = $(this);
                element.on("click", function () {
                    element.parent().parent().find("p").html("rejected");
                    var clientID = $(this)
                        .closest("tr")
                        .find("td[client-id]")
                        .attr("client-id");
                    var bookID = $(this)
                        .closest("tr")
                        .find("td[book-id]")
                        .attr("book-id");
                    var requestID = $(this).attr("request_id");
                    var requestData = {
                        "requestID": requestID,
                        "status": "declined",
                        "clientID": clientID,
                        "bookID": bookID,
                    };
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
                });
            });
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
        },
    });
}
function books(){
    $.ajax({
        url: './includes/ajaxCalls.php?action=books', // Replace with your server-side script URL
        type: 'GET',
        dataType: 'html', // Expected data type (can be 'html', 'json', etc.)
        success: function (response) {
            // Insert the response data into the data-container div
            $('#data-container').append(response);
            console.log('hi');
            // Attach click event using event delegation to dynamically created elements
            $('#data-container').on('click', '.book-req', function () {
                var bookName = $(this).parent().prev().text();
                var bookId = $(this).parent().parent().attr('info');

                // Create new HTML content
                var orderedBookHtml = `<div info='${bookId}' class="order-box">
                                    <span class="ordered-book">${bookName} </span>
                                    <img class="cancel-order" src="img/decline.jpg" alt="" onclick="cancelOrder(event)">     
                                    </div>`;
                // Loop through each element with the class 'ordered-book'
                var requested = false;
                $('.order-box').each(function () {
                    // Check if the info attribute matches the current bookId
                    if ($(this).attr('info') == bookId) {
                        requested = true;
                        alert("you requested this book before")
                        return false; // Exit the loop early if a match is found
                    }
                });
                // If the book is not already requested, append the HTML content
                if (!requested) {
                    $('#book-inf').append(orderedBookHtml);
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
            url: './includes/ajaxCalls.php?action=userRequest', // Endpoint to check for updates
            type: 'GET',
            success: function (response) {
                // Update user page content based on the response
                // For example, update the request status dynamically
                var responseArray = JSON.parse(response);
                responseArray.forEach(element => {
                    var html = ` <div info = '${element.book_id}'>
                 <p>${element.book_name}</p><span>${element.status}</span>
                                    </div>`;
                    if ($('#waiting-requests').find(`div[info=${element.book_id}]`).length === 0) {
                        $('#waiting-requests').append(html);
                    } if ($('#waiting-requests').find(`div[info=${element.book_id}]`).length === 1) {
                        $('#waiting-requests').find(`div[info=${element.book_id}]`).find('span').html(element.status)
                    }
                });
            },
            complete: function () {
                // Call the function again after a delay
                setTimeout(checkForUpdates, 5000); // Repeat every 5 seconds
            }
        });
    } 


