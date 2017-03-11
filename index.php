<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous"
    >
    <style>
        body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .table-container {
            margin-top: 50px;
        }
        #submitButton {
            margin-left: 50px;
        }
    </style>
</head>
<body>
    <div class="alert-container" id="alert-container">
        
    </div>
    <form action="">
        <label class="btn btn-primary btn-lg btn-file" id="selectCSVButton">
            Click Here to Select a CSV<input type="file" name="CSVToUpload" id="CSVToUpload" class="hidden">
        </label>
        <input type="submit" value="Save Users in Database" class="btn btn-success btn-lg" id="submitButton" style="display: none;">
    </form>
    <div class="container table-container">
        <div id="output" class="table-responsive">
            
        </div>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.1.1.js"
        integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA="
        crossorigin="anonymous">
    </script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script
        src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous">
    </script>
    <script>
        $(function () {
            $("#CSVToUpload").on("change", function () {
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv|.txt)$/; //checking if the file is .csv or .txt
                if (regex.test($("#CSVToUpload").val().toLowerCase())) {
                    if (typeof (FileReader) != "undefined") {

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("#alert-container").empty(); //removing any previous alert

                            var rows = e.target.result.split("\n"); //splitting rows based on new line
                            var headers = rows[0].split(","); //this is for splitting the columns of the first row containing the headers
                            var tableFromCSV = '<table class="table table-bordered table-striped table-hover"><thead><tr>';
                            for (var j = 0; j < headers.length; j++) {
                                tableFromCSV += '<th>'+headers[j]+'</th>'; //getting each header and appending to the header row
                            }
                            tableFromCSV += '</tr></thead><tbody>';
                            for (var i = 1; i < rows.length; i++) {
                                var cells = rows[i].split(","); //splitting the columns of each row
                                tableFromCSV += '<tr>';
                                for (var j = 0; j < cells.length; j++) {
                                    tableFromCSV += '<td>'+cells[j]+'</td>'; //appending columns
                                }
                                tableFromCSV += '</tr>';
                            }
                            tableFromCSV += '</tbody>';
                            $("#output").html(tableFromCSV); //showing the whole table in the 'output' div
                            $("#submitButton").show();
                        }
                        reader.readAsText($("#CSVToUpload")[0].files[0]);
                    } else {
                        $("#alert-container").html(
                            '<div class="alert alert-danger" role="alert">'+
                                '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                'This browser does not support HTML5.'+
                            '</div>'
                        );
                        $("#submitButton").hide();
                        $("#output").empty();
                    }
                } else {
                    $("#alert-container").html(
                        '<div class="alert alert-danger alert-dismissible" role="alert">'+
                            '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                            '<strong>Alert!</strong> Please upload a valid CSV file.'+
                        '</div>'
                    );
                    $("#submitButton").hide();
                    $("#output").empty();
                }
            });
        });
    </script>
</body>
</html>