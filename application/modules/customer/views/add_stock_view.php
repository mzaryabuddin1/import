<?php

$pagetab = "stock";
$pagename = "manage_stock";


$filtered_modules = array_filter($_SESSION['customer_modules'], function ($module) {
    return $module['module'] === 'users';
});

$filtered_modules = array_values($filtered_modules);


$view = $filtered_modules[0]['view'];
$insert = $filtered_modules[0]['insert'];
$update = $filtered_modules[0]['update'];
$delete = $filtered_modules[0]['delete'];


include_once('common/header.php');
include_once('common/sidebar.php');
?>

<div class="page-wrapper pagehead">
    <div class="content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Stock</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>customer-dashboard">Stock</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form id="regstr">
                            <div class="alert alert-danger alert-dismissible fade show <?= isset($_GET['err']) ? '' : 'd-none' ?> " id="error" role="alert"><?= isset($_GET['err']) ? $_GET['err'] : '' ?></div>
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-10">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">File <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" id="fileInput" name="username" minlength="3" placeholder="Username" required>
                                        <small id="emailHelp" class="form-text text-muted">Should be unique.</small>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Sample File</label>
                                        <a class="btn btn-block btn-dark" href="<?= base_url() . 'uploads/sample/sample.xlsx' ?>" download="">Download</a>
                                        <!-- <input type="password" class="form-control" name="password"  placeholder="Password" required> -->
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>GD#</th>
                                            <th>GDate</th>
                                            <th>HS#</th>
                                            <th>Desc</th>
                                            <th>Qty</th>
                                            <th>UOM</th>
                                            <th>STVOI</th>
                                            <th>STPIMP</th>
                                            <th>VAT</th>
                                            <th>ST.R</th>
                                            <th>MaxSale</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl">
                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-none" id="spinner">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<?php
include_once('common/footer.php');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>


<script>

    const hscodes = JSON.parse('<?= json_encode($hscode) ?>')
    
    document.getElementById('fileInput').addEventListener('change', handleFileSelect, false);

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: 'array' });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                const json = XLSX.utils.sheet_to_json(worksheet, { header: 1 });
                const resultArray = json.slice(1); // Remove the first row
                createFormFields(resultArray)
                console.log(resultArray);
                // You can now use resultArray as needed
            };
            reader.readAsArrayBuffer(file);
        }
    }

    function createFormFields(data) {
        const headings = ['gd_number', 'hscode', 'item_description', 'qty', 'unit_of_measurement', 'sales_taxable_value_of_import', 'sales_tax_paid_at_import_stage', 'value_addition_tax_on_commerical_import', 'sales_tax_rate', 'max_sale_able_value', 'comments'];
        let html = "";
        for (let index = 0; index < data.length; index++) {
            html += "<tr>"
            html += '<td><input type="text" class="form-control" value="'+ data[index][0] +'" name="'+ headings[0] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][1] +'" name="'+ headings[1] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][2] +'" name="'+ headings[2] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][3] +'" name="'+ headings[3] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][4] +'" name="'+ headings[4] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][5] +'" name="'+ headings[5] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][6] +'" name="'+ headings[6] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][7] +'" name="'+ headings[7] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][8] +'" name="'+ headings[8] +'[]" required/></td>'
            
            html += '<td><input type="text" class="form-control" value="'+ data[index][7] == 0 ? "Zero or Exempted" : data[index][7] / data[index][6] +'" name="'+ headings[8] +'[]" required/></td>'

            
            html += '<td><input type="text" class="form-control" value="'+ data[index][9] +'" name="'+ headings[9] +'[]" required/></td>'
            html += '<td><input type="text" class="form-control" value="'+ data[index][10] +'" name="'+ headings[10] +'[]" required/></td>'
            html += "</tr>"

        }
        $("#tbl").html(html);
        console.log(html)
    }

    $("#regstr").on("submit", function(e) {
        e.preventDefault()

        const formdata = new FormData(this)

        let permissionsArray = [];

        $('tr').each(function() {
            let module = $(this).find('input[type="checkbox"]').data('module');
            if (module) {
                let view = $(this).find('input.view').is(':checked') ? 1 : 0;
                let insert = $(this).find('input.add').is(':checked') ? 1 : 0;
                let update = $(this).find('input.update').is(':checked') ? 1 : 0;
                let deletePerm = $(this).find('input.delete').is(':checked') ? 1 : 0;

                permissionsArray.push({
                    module: module,
                    view: view,
                    insert: insert,
                    update: update,
                    delete: deletePerm
                });
            }
        });

        formdata.append("permissions", JSON.stringify(permissionsArray));


        $.ajax({
            url: "<?php echo base_url() . "customer-add-stock-submit"; ?>",
            type: "post",
            data: formdata,
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            cache: false,
            beforeSend: function() {
                $(":submit").prop("disabled", true);
                $(":submit").addClass("d-none");
                $("#spinner").removeClass("d-none");
                $("#error").addClass("d-none");
            },
            success: function(res) {
                let obj = JSON.parse(res);
                console.log(obj);
                if (obj.error) {
                    $("#error").html(obj.error);
                    $("#error").removeClass("d-none");
                    $("#spinner").addClass("d-none");
                    $(":submit").removeClass("d-none");
                    toastr.error("Please check errors list!", "Error");
                    $(window).scrollTop(0);
                } else if (obj.success) {
                    $("#spinner").addClass("d-none");
                    toastr.success("Success!", "Hurray");
                    setTimeout(function() {
                        window.location = '<?php echo base_url() . 'customer-stock' ?>';
                    }, 1000);
                } else {
                    $("#spinner").addClass("d-none");
                    $(":submit").prop("disabled", false);
                    $(":submit").removeClass("d-none");
                    toastr.error("Something bad happened!", "Error");
                    $(window).scrollTop(0);
                }
                $(":submit").prop("disabled", false);
            },
            error: function(error) {
                toastr.error("Error while sending request to server!", "Error");
                $(window).scrollTop(0);
                $("#spinner").addClass("d-none");
                $(":submit").prop("disabled", false);
                $(":submit").removeClass("d-none");
            }
        })

    })
</script>