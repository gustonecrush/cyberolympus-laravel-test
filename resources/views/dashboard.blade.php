<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <style>
            * {
                font-family: 'Poppins', sans-serif;
            }

            .data-user {
                border-radius: 20px;
                box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                padding: 50px 30px;
                display: flex;
                flex-direction: column;
                width: 500px;
            }

            .data-user button {
                width: 100px;
                margin-top: 20px;
            }

            .data-top {
                width: 500px;
            }

            .data-customer, .data-top {
                border-radius: 20px;
                box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
                padding: 50px 30px;
            }

            td, th {
                text-align: center;
            }

        </style>
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="mb-5">

    <nav class="navbar navbar-expand-lg navbar-light bg-light p-4">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form action="/logout" method="post" class="ms-auto">
                @csrf
                <button type="submit" class="btn btn-secondary">Log Out</button>
            </form>
            </div>
        </div>
    </nav>
    
    <main class="container mt-5">
        <h1>Welcome to Dashboard</h1>

        <div class="data-user mt-4">
            <h2>Data User</h2>
            <ul class="list-group data-user-logged-in">
                <li class="list-group-item"></li>
            </ul>
            <button type="button" data-bs-toggle="modal" data-bs-target="#userInfo" class="btn btn-dark">See More</button>
        </div>
       
        <div class="data-customer mt-4">
            <div class="col">
                <h2 class="mb-4">Data Customers</h2>
                <button type="button" data-bs-toggle="modal" data-bs-target="#modal" class="btn btn-primary mb-4">Tambah Customer Baru</button>
            </div>
           
             <table class="table">
                 <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination">
                     <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    @for ($i = 1; $i < ($totalCustomers/10); $i++)
                        <li class="page-item"><a class="page-link" href="#" onclick="setPage">{{ $i }}</a></li>
                    @endfor
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>

        <div class="data-top mt-4">
            <h2>Top 10 Sold Products 🛒</h2>
            <ol class="list-group">
                @foreach ($top10SoldProducts as $item)
                     <li class="list-group-item">{{ $item->product_name }} >> {{ $item->sold }} pcs</li>
                @endforeach
            </ol>
        </div>

        <div class="data-top mt-4">
            <h2>Top 10 The most Order ✨</h2>
            <ol class="list-group">
                @foreach ($top10TheMostOrder as $item)
                     <li class="list-group-item">{{ $item->name }} >> {{ $item->orders }} orders</li>
                @endforeach
            </ol>
        </div>

        <div class="data-top mt-4">
            <h2>Top Agent Get The Most Customers 🔥</h2>
            <ol class="list-group">
                @foreach ($topAgentGetTheMostCustomers as $item)
                     <li class="list-group-item">{{ $item->agent_name }} >> {{ $item->customers }} orders</li>
                @endforeach
            </ol>
        </div>
       
    </main>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            fetchData();
            fetchCustomers();
        }) 

        function fetchData() {
            $('ul.data-user-logged-in').html(``);
            $.ajax({
                url: '/getUser',
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, values) {
                        name = data[key].first_name + " " + data[key].last_name
                        email = data[key].email
                        phone_number = data[key].phone
                        $('ul.data-user-logged-in').append("<li class='list-group-item'> 👤 : " + name + "</li>" + "<li class='list-group-item'> 📍 : " + email + "</li>" + "<li class='list-group-item'> ☎️ : " + phone_number + "</li>") 
                    })

                    $.each(data, function(key, values) {
                        name = data[key].first_name + " " + data[key].last_name
                        email = data[key].email
                        phone_number = data[key].phone
                        pin = data[key].pin
                        lastLogin = data[key].last_login
                        createdAt = data[key].created_at
                        updatedAt = data[key].updated_at
                        $('ul.data-user-logged-in-more').append("<li class='list-group-item'> Name : " + name + "</li>" + "<li class='list-group-item'> Address : " + email + "</li>" + "<li class='list-group-item'> Phone Number : " + phone_number + "</li>" + "<li class='list-group-item'> PIN : " + pin + "</li>" + "<li class='list-group-item'> Last Login : " + lastLogin + "</li>" + "<li class='list-group-item'> Updated At : " + updatedAt + "</li>" + "<li class='list-group-item'> Created At : " + createdAt + "</li>") 
                    })
                }
            })
        }

        async function fetchCustomers() {
            $('tbody').html(``);
            await $.ajax({
                url: '/getCustomers',
                type: 'get',
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, values) {
                        data = data[key].data
                        $.each(data, function(key, values) {
                            name = data[parseInt(key)].first_name + data[parseInt(key)].last_name
                            address = data[parseInt(key)].address
                            phone_number = data[parseInt(key)].phone
                            $('tbody').append('<tr>\
                                <th>' + parseInt(key+1) + '</th>\
                                <td>' + name + '</td>\
                                <td>' + address + '</td>\
                                <td>' + phone_number + '</td>\
                                <td>' + 
                                    '<button type="button" class="btn btn-warning">Edit</button>' +
                                    ' | ' +
                                    '<button type="button" class="btn btn-danger">Delete</button>' + 
                                    ' | ' +
                                    '<button type="button" class="btn btn-dark">Orders</button>' + 
                                    '</td>\
                                </tr>')

                            $('div.')
                        })
                    })
                }
            })
        }

        async function postNewCustomer() {

            let form = $("#post-customer");
            let firstName = $('#first_name').val();
            let last_name = $('#last_name').val();
            let address = $('#address').val();
            let phoneNumber = $('#phone_number').val()
            let regisDate = $('regis_date').val();

            // Run Ajax
            $.ajax({
                url: '/customers',
                type: 'post',
                success: function(data) {
                    console.log("success!");
                }
            })

        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <div class="modal" tabindex="-1" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Customer Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="post-customer">
                    @csrf
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Abdul">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Al-Gifary">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Jakarta, Indonesia">
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="+628893423xxx">
                    </div>
                    <div class="mb-3">
                        <label for="regis_date" class="form-label">Registration Date</label>
                        <input type="date" class="form-control" id="regis_date" name="" >
                    </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Rest</button>
                <button type="submit" class="btn btn-success">Tambah Customer</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="userInfo">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Info</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group data-user-logged-in-more">
                    <li class="list-group-item"></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal" tabindex="-1" id="userInfo">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Orders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group data-user-logged-in-more">
                    <li class="list-group-item"></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div> --}}

</body>
</html>