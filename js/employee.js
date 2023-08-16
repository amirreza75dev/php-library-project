$(function() {
    // Make an AJAX GET request
    $.ajax({
        url: './controler/employee-controler.php', 
        type: 'GET',
        dataType: 'json', // Expected data type (can be 'html', 'json', etc.)
        success: function(response) {
            // var parsedResponse = JSON.parse(response);
                console.log(response);

            
                    var  html=`<tr>
                        <th>name</th>
                        <th>requested book</th>
                        <th>status</th>
                        <th>response</th>
                        
                        </tr>`;

                        response.forEach(element => {

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

    
    
                                       </tr>`
                        
                    });


                    $('#pending-requests').append(html)
                             // accepting request

                    $('.acc-req').each(function(){
                        var element = $(this)
                        element.on('click',function(){
                            element.parent().parent().find('p').html('accepted')
                            var clientID = $(this).closest('tr').find('td[client-id]').attr('client-id');
                            var bookID = $(this).closest('tr').find('td[book-id]').attr('book-id');
                            var requestID = $(this).attr('request_id');
                            var requestData= {
                                "requestID" : requestID,
                                "status" : 'accepted',
                                "clientID":clientID,
                                "bookID" :bookID
                            }
                            //sending ajax request to save request
                            $.ajax({
                                url: './controler/lending-controler.php',
                                type: 'POST',
                                dataType: 'json',
                                contentType: 'application/json',
                                data: JSON.stringify(requestData),
                                success: function(response) {
                                    console.log('Request processed successfully:', response);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error processing request:', status, error);
                                }
                            });





                        })



                    })

                    // rejecting request
                    $('.dec-req').each(function(){
                        var element = $(this)
                        element.on('click',function(){
                            element.parent().parent().find('p').html('rejected')
                            var clientID = $(this).closest('tr').find('td[client-id]').attr('client-id');
                            var bookID = $(this).closest('tr').find('td[book-id]').attr('book-id');
                            var requestID = $(this).attr('request_id');
                            var requestData= {
                                "requestID" : requestID,
                                "status" : 'declined',
                                "clientID":clientID,
                                "bookID" :bookID
                            }
                            //sending ajax request to save request
                            $.ajax({
                                url: './controler/lending-controler.php',
                                type: 'POST',
                                dataType: 'json',
                                contentType: 'application/json',
                                data: JSON.stringify(requestData),
                                success: function(response) {
                                    console.log('Request processed successfully:', response);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error processing request:', status, error);
                                }
                            });




                        })



                    })


},
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
        }
    });

                    // accepting request

                    $('.acc-req').each(function(){
                        var element = $(this)
                        element.on('click',function(){
                            element.parent().parent().find('p').html('accepted')
                        })



                    })


        //adding new book

        $('#submit-book').on('click',function(event){
            event.preventDefault();

            var book_name = $('#book-name').val();
            var author_id= $('#author-id').val();
            var section_id= $('#section-id').val();
            var avl= $('#avl').val();
            var requestData = {
                'book_name':book_name,
                'author_id':author_id,
                'section_id':section_id,
                'avl':avl

            }
            console.log(requestData);
            // sending ajax to save new book
            $.ajax({
                url: './controler/adding-book-controler.php',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                success: function(response) {

                    
                    console.log('Request processed successfully:', response);
                },
                error: function(xhr, status, error) {
                    
                    console.error('Error processing request:', status, error);
                }
            });




        })


})
