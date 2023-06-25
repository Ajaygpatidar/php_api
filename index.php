<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <table id="main" border="0" cellspacing="0">
        <tr>
            <td id="header">
                <h1>API</h1>

                <div id="search-bar">
                    <label>Search :</label>
                    <input type="text" id="search" autocomplete="off" name="search">
                </div>
            </td>
        </tr>
        <tr>
            <td id="table-form">
                <form id="addForm">
                    Name : <input type="text" name="sname" id="sname">
                    Age : <input type="text" name="sage" id="sage">
                    City : <input type="text" name="scity" id="scity">
                    <input type="submit" id="save-button" value="Save">
                </form>
            </td>
        </tr>
        <tr>
            <td id="table-data">
                <table width="100%" cellpadding="10px">
                    <tr class="bg-info">
                        <th width="40px">Id</th>
                        <th>Name</th>
                        <th width="50px">Age</th>
                        <th width="150px">City</th>
                        <th width="60px">Edit</th>
                        <th width="70px">Delete</th>
                    </tr>
                    <tbody id="load-table"></tbody>
                </table>
            </td>
        </tr>
    </table>

    <div id="error-message" class="messages"></div>
    <div id="success-message" class="messages"></div>

    <!-- Popup Modal Box for Update the Records -->
    <div id="modal">
        <div id="modal-form">
            <h2>Edit Form</h2>
            <form action="" id="edit-form">
                <table cellpadding="10px" width="100%">
                    <tr>
                        <td width="90px">Name</td>
                        <td><input type="text" name="sname" id="edit-name">
                            <input type="text" name="sid" id="edit-id" hidden="">
                        </td>
                    </tr>
                    <tr>
                        <td>Age</td>
                        <td><input type="number" name="sage" id="edit-age"></td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td><input type="text" name="scity" id="edit-city"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" id="edit-submit" value="Update"></td>
                    </tr>
                </table>
            </form>
            <div id="close-btn">X</div>
        </div>
    </div>


</body>

</html>
<script type="text/javascript" src="js/jquery.js"></script>
<script>
    $("document").ready(function() {
        function loadtable() {
            $.ajax({
                url: 'fetch_all.php',
                type: "GET",
                success: function(data) {
                    //   console.log(data);  
                    if (data.status == false) {
                        $("#load-table").append("<tr><td><h2>" + data.message + "</h2></td></tr>");
                    } 
                    else {
                        $.each(data, function(key, value) {
                            $("#load-table").append("<tr>" +
                                "<td>" + value.id + "</td>" +
                                "<td>" + value.student_name + "</td>" +
                                "<td>" + value.age + "</td>" +
                                "<td>" + value.city + "</td>" +
                                "<td><button class='edit-btn' data-eid='" + value.id + "'>Edit</button></td>" +
                                "<td><button class='delete-btn' data-id='" + value.id + "'>Delete</button></td>" +
                                "</tr>");
                        });
                    }
                }
            });
        }
        loadtable();

        $(document).on("click", ".edit-btn", function() {
            $("#modal").show();
            var studentid = $(this).data("eid");
            var obj = {

                sid: studentid
            };
            var myjson = JSON.stringify(obj);
            $.ajax({
                url: "edit.php",
                method: "POST",
                data: myjson,
                success: function(data) {
                    $("#edit-id").val(data[0].id);
                    $("#edit-name").val(data[0].student_name);
                    $("#edit-age").val(data[0].age);
                    $("#edit-city").val(data[0].city);
                }

            });
        });
        $("#close-btn").on("click", function() {
            $("#modal").hide();

        });
        //data in json form
        function jsonData(targetForm) {
            var arr = $(targetForm).serializeArray();

            var obj = {};
            for (var a = 0; a < arr.length; a++) {
                if (arr[a].value == "") {
                    return false;
                }
                obj[arr[a].name] = arr[a].value;
            }

            var json_string = JSON.stringify(obj);

            return json_string;

        }
        $("#edit-submit").on("click", function(e) {
            e.preventDefault();
            var jsonobj = jsonData("#edit-form");
            if (jsonobj == false) {
                alert('All Fields are required');
            } else {
                $.ajax({
                    url: "api_update.php",
                    method: "POST",
                    data: jsonobj,
                    success: function(data) {
                        alert(data.message);
                        window.location.reload(1);
                    }

                });
            }
        });
        ///insert record
        $("#save-button").on("click", function(e) {
            e.preventDefault();
            console.log('hello');
            var formdata = jsonData("#addForm");
            if (formdata == false) {
                alert('All Fields are required');
            } else {
                $.ajax({
                    url: "insert.php",
                    method: "POST",
                    data: formdata,
                    success: function(data) {
                        alert(' data Insert');
                        window.location.reload(1);
                    }
                });
            }


        });
        ///delete record
        $(document).on("click", ".delete-btn", function() {
            var studentid = $(this).data("id");
            var obj = {

                sid: studentid
            };
            var myjson = JSON.stringify(obj);
            $.ajax({
                url: "api_delete.php",
                method: "POST",
                data: myjson,
                success: function(data) {
                    alert('deleted');
                    window.location.reload(1);
                }

            });
        });
        //Live Search Record
        $("#search").on("keyup", function() {
            var searchName = $(this).val();
            var obj1 = {searchName : searchName};
            var myJSON = JSON.stringify(obj1);
            $("#load-table").html("");
            $.ajax({
                url: 'api_search.php',
                type: "POST",
                data : myJSON,
                success: function(data) {
                    if (data.status == false) {
                        $("#load-table").append("<tr><td colspan='6'><h2>"+ data.message +"</h2></td></tr>");
                    } else {
                        $.each(data, function(key, value) {
                            $("#load-table").append("<tr>" +
                                "<td>" + value.id + "</td>" +
                                "<td>" + value.student_name + "</td>" +
                                "<td>" + value.age + "</td>" +
                                "<td>" + value.city + "</td>" +
                                "<td><button class='edit-btn' data-eid='" + value.id + "'>Edit</button></td>" +
                                "<td><button class='delete-btn' data-id='" + value.id + "'>Delete</button></td>" +
                                "</tr>");
                        });
                    }
                }
            });
        })

    });
</script>