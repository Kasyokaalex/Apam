<?php echo view('partial/header'); ?>

<style>
    table#datatable td:nth-child(2),
    td:nth-child(7) {
        text-align: center
    }
</style>
<div class="row">
    <div class="col-lg-9">

        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    TENANTS' DATA
                </h5>
                <div class="inqbox-tools">

                    <?= anchor(base_url() . "tenants/view/-1", "<span class='fi fi-sr-add'></span> &nbsp; New tenant", array('id' => 'new', 'style' => 'color:white', 'class' => 'btn btn-sm btn-info btn-sm')); ?>
                </div>
            </div>
            <div class="inqbox-content table-responsive">

                <table id="datatable" class="table table-hover deletableRows" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>tenantID</th>
                            <th>firstName</th>
                            <th>lastName</th>
                            <th>IDNumber</th>
                            <th>phoneNumber</th>
                            <th>Occupation</th>
                            <th>Home Address</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>


    <div class="col-md-3 inqbox-card">

        <div class="inqbox full-height d-flex flex-column">

            <div class="inqbox-title"><h5>Why Tenant Details ?</h5></div>

            <div class="inqbox-content flex-grow-1 d-flex flex-column justify-content-between" style="padding: 1.2em 1em">

                <div>
                    <p class="" style="margin-bottom: 2em">Keeping records on tenants helps you facilitate communication, for security and legal purposes</p> 
                </div>
                <div class="">
                    
                    <a class="btn btn-outline btn-block" href="tenants/view/-1">New Tenant</a>

                </div>
                
            </div>
        </div>
    </div>
</div>

<?= View("partial/footer"); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#datatable").DataTable({

            "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                },
                {
                    "targets": [0],
                    "visible": false,
                }
            ],

            "aLengthMenu": [
                [25, 50, 100, 200, 100000],
                [25, 50, 100, 200, "All"]
            ],

            "aLengthMenu": [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],

            "iDisplayLength": -1,

            fixedHeader: true,

            "order": [],
            "dom": "<'row'<'col-sm-4 text-left'l><'col-sm-4 text-center'B><'col-sm-4 text-right'f>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-5 text-left'i><'col-sm-7 text-right'p>>",

            "rowCallback": function(row, data, index) { // Open Item on click

                // Add delete Button if table had deletableRows

                if ($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')) {

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?= base_url() ?>/tenants/delete" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')

                    // Show buttons on hover
                    $('td', row).hover(function() {
                        // over
                        $(row).find('.actions').toggle();

                    }, function() {
                        // out
                        $(row).find('.actions').toggle();
                    });
                }
                // Open Item on click

                $('td', row).click(function(event) {

                    if ($(event.target).is('td')) {
                        window.location.href = "<?= base_url() ?>/tenants/view/" + data[0];
                    }

                });
            },


        });



        $.get("<?= base_url() ?>tenants/data", function(data) {

            table.clear() //clear content

            var obj = JSON.parse(data);

            table.rows.add(obj)

            table.draw() //update display


        });

        // selecting all
        $(".select_all").click(function() {
            if ($(this).is(":checked")) {
                $("input[name='chk[]']").prop("checked", true);
            } else {
                $("input[name='chk[]']").prop("checked", false);
            }
        });


        enable_delete('Are you sure to delete?', 'Please select an item to delete!');
    });
</script>