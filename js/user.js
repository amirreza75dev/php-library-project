$(function() {
 
    // Make an AJAX GET request
    $.ajax({
        url: './includes/ajaxCalls.php?action=books', // Replace with your server-side script URL
        type: 'GET',
        dataType: 'html', // Expected data type (can be 'html', 'json', etc.)
        success: function(response) {
            // Insert the response data into the data-container div
            $('#data-container').append(response);
            // Attach click event using event delegation to dynamically created elements
            $('#data-container').on('click', '.book-req', function() {
                var bookName = $(this).parent().prev().text();
                var bookId = $(this).parent().parent().attr('info');
        
                // Create new HTML content
                var orderedBookHtml = `<div info='${bookId}' class="order-box">
                                        <span class="ordered-book">${bookName} </span>
                                        <img class="cancel-order" src="img/decline.jpg" alt="" onclick="cancelOrder(event)">
                                        
                                        
                                        </div>`;
                 // Loop through each element with the class 'ordered-book'
                var requested = false;
                $('.order-box').each(function() {
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
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });


    function checkForUpdates() {
        $.ajax({
            url: './includes/ajaxCalls.php?action=readUserRequest', // Endpoint to check for updates
            type: 'GET',
            success: function(response) {
                // Update user page content based on the response
                // For example, update the request status dynamically
                var response_array= JSON.parse(response);
                response_array.forEach(element => {
                    var html = ` <div info = '${element.book_id}'>
                     <p>${element.book_name}</p><span>${element.status}</span>
                                        </div>`;

                    if($('#waiting-requests').find(`div[info=${element.book_id}]`).length=== 0){

                        $('#waiting-requests').append(html);
                    }if($('#waiting-requests').find(`div[info=${element.book_id}]`).length=== 1){
                        $('#waiting-requests').find(`div[info=${element.book_id}]`).find('span').html(element.status)

                    }
                    
                    
                });


            },
            complete: function() {
                // Call the function again after a delay
                setTimeout(checkForUpdates, 5000); // Repeat every 5 seconds
            }
        });
    }
    
    // Start checking for updates
    checkForUpdates();
    


    // submit requests
    $('#submit-orders').on('click',function(){
        requestedBooks = []
        if($("#book-inf").children().length > 0){
            
            $("#book-inf").children().each(function(){
                var infoValue = $(this).attr('info');
                var name = $(this).find('span').text();
                 if (infoValue) {
                    requestedBooks.push({"book": name,"book_id":infoValue});
                  }
                  $(this).remove()
                  

                  var html = ` <div  info = '${infoValue}'>
                                    <p>${name}</p><span>waiting</span>
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
            success: function(response) {
                console.log(response);
                var parsedResponse = JSON.parse(response);
                
                if(parsedResponse.message == "successful"){
                    alert('requests send')
                }else{
                    
                    console.log(parsedResponse.message);
                }
            }
        });

    })

    // search functionality
    $('#search').on('keyup',function(){
        var searchValue = $('#search').val().toLowerCase();
        console.log(searchValue);
        $('#data-container tr').each(function(index){
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




})






// cancle order function 

function cancelOrder(e){
    var item= $(e.target).parent();
    item.remove()
}


//search function 
