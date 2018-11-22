<!DOCTYPE html>
<html>
    <head>
        <title>
            Importar excel
        </title>
        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    </head>
<body>
    <div class="container">
        <br />
        <h3 align="center">Como importar Excel Data into Mysql in Codeigniter</h3>
        <form method="post" id="import_form" enctype="multipart/form-data">
            <p>
                <label>Seleccione un archivo Excel</label>
                <input type="file" name="file" id="file" required accept=".xls, .xlsx" />
            </p>
            <br />
            <input type="submit" name="import" value="Importar" class="btn btn-info" />
        </form>
        <br />
        <div class="table-responsive" id="customer_data">
            <table class="table">
                <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Postal Code</th>
                    <th>Country</th>
                </tr>
                </thead>
                <tbody id="table_data">

                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){
        load_data();
        function load_data()
        {
            $.ajax({
                url: "<?php echo base_url();?>index.php/Excel_import/fetch",
                method:"POST",
                success: function(data){
                    data = JSON.parse(data);
                    var html='';
                    for(var i=0; i<data.length;i++){
                            html += '<tr>';
                            html += '<td>' + data[i].CustomerID + '</td>';
                            html += '<td>' + data[i].CustomerName + '</td>';
                            html += '<td>' + data[i].Address + '</td>';
                            html += '<td>' + data[i].City + '</td>';
                            html += '<td>' + data[i].PostalCode + '</td>';
                            html += '<td>' + data[i].Country + '</td>';
                            html += '</tr>';
                            $('#table_data').html(html);
                    }

                }
            })
        }
        $('#import_form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Excel_import/import",
                method: "POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success:function(data) {
                    $('#file').val('');
                    load_data();
                    alert(data);
                }
            })
        });
    });
</script>