<?= view("partial/header"); ?>
<style>
    table#datatable td:nth-child(2),
    td:nth-child(8) {
        text-align: center
    }
</style>

<div class="row">
    <div class="col-md-9 pe-0">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-success">
                <h5>
                    system users
                </h5>
                
            </div>
            <div class="inqbox-content table-responsive">
                <table id="datatable" class="table table-hover deletableRows" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>firstName</th>
                            <th>lastName</th>
                            <th>Phone number</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3">

        <div class="inqbox full-height d-flex flex-column">

            <div class="inqbox-title"><h5>Add staff</h5></div>

            <div class="inqbox-content flex-grow-1" style="padding: 1.2em 1em">

                <form action="staffs/view/-1" class="form d-flex flex-column justify-content-between" method="post" accept-charset="utf-8">

                <div class="form-group">

                    <label for="role" class="form-label required">Select Role</label>
                    <select name="role" class="form-control">
                        <option value="user" selected="selected">User</option>
                        <option value="admin">Administrator</option>
                        <option value="mgmt">Management</option>
                    </select>

                    <p class="" style="margin-top: 1em">Roles help in giving some users special permissions</p>       

                </div>

                <div class="d-grid">
                    
                    <button class="btn btn-outline btn-block" type="submit" name="submit"> create user</button>

                </div>

                </form>                
            </div>
        </div>
    </div>
</div>

<?= view("partial/footer"); ?>

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
            fixedHeader: true,

            "aLengthMenu": [
                [25, 50, 100, 200, 100000],
                [25, 50, 100, 200, "All"]
            ],

            "iDisplayLength": 25,

            "order": [1, "desc"],

            buttons: [{

                    extend: 'pdf',

                    download: 'open',

                    text: ' <span class="fa fa-print"></span> &nbsp; Print',

                    className: 'btn btn-sm btn-warning btn-sm',

                    title: " ",

                    footer: true,

                    exportOptions: {

                        columns: [2, 3, 4, 5, 6]
                    },

                    orientation: 'portrait',

                    customize: function(doc) {

                        doc.pageMargins = [70, 30, 70, 50];

                        doc.styles.tableHeader = {

                            color: '#fff',

                            fillColor: '#008080',

                            margin: [5, 5, 5, 5],

                            fontSize: '8',

                            alignment: 'center'

                        };

                        doc.content[1].table.widths = '*';

                        doc.content[1].layout = 'noBorders';

                        doc.styles.tableBodyOdd = {

                            margin: [5, 5, 5, 5],

                            fontSize: '8',

                            border: 1,

                            alignment: 'center'

                        }

                        doc.styles.tableBodyEven = {

                            fillColor: '#eee',

                            margin: [5, 5, 5, 5],

                            fontSize: '8',

                            alignment: 'center'

                        }

                        doc.defaultStyle.alignment = 'left';


                        doc.content.splice(1, 0, {
                                columns: [{

                                        image: '<?= 'data:image/' . pathinfo(base_url() . 'uploads/logo/letter_head.jpg', PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents(base_url() . 'uploads/logo/letter_head.jpg')) ?>',

                                        width: 60,

                                        alignment: 'right'
                                    },

                                    {
                                        text: "<?= config('apamSettings')->email ?> \n <?= config('apamSettings')->website ?> \n <?= config('apamSettings')->phone ?> \n <?= config('apamSettings')->address  ?> ",

                                        bold: true,

                                        fontSize: 9,

                                        alignment: 'right'
                                    }

                                ]
                            },

                            {
                                canvas: [{
                                    type: 'line',
                                    x1: 0,
                                    y1: 0,
                                    x2: 515,
                                    y2: 0,
                                    lineWidth: 0.5
                                }]
                            },

                            {

                                columns: [

                                    {
                                        text: "Staff",
                                        margin: 7,
                                        fontSize: 9
                                    },

                                    {
                                        text: "Printed by : <?= ucfirst(config('loggedInStaff')->firstName) ?>",
                                        alignment: 'right',
                                        margin: 7,
                                        fontSize: 9
                                    }

                                ]

                            },

                            {
                                canvas: [{
                                    type: 'line',
                                    x1: 0,
                                    y1: 0,
                                    x2: 515,
                                    y2: 0,
                                    lineWidth: 0.5
                                }]
                            },

                            {
                                margin: 10,

                                fontSize: 8,

                                text: "This document is a summary of <?= config('apamSettings')->company ?> personel who have legal access to the firms computer system",

                                alignment: 'center'
                            },

                            {
                                text: "",

                                margin: 10

                            }
                        );

                        // Create a footer

                        doc['footer'] = (function(page, pages) {

                            return {


                                columns: [

                                    {
                                        text: '© apam <?= date("Y") ?>',

                                        alignment: 'left'
                                    },

                                    {
                                        alignment: 'center',

                                        width: 100,

                                        text: ['page ', {
                                            text: page.toString()
                                        }, ' of ', {
                                            text: pages.toString()
                                        }]
                                    },

                                    {
                                        // This is the right column
                                        text: '<?= date("D, d M Y H:i:s") ?>',

                                        alignment: 'right'
                                    }
                                ],

                                canvas: [{
                                    type: 'line',
                                    x1: 100,
                                    y1: 0,
                                    x2: 455,
                                    y2: 0,
                                    lineWidth: 0.5
                                }],

                                fontSize: '8',

                                margin: [70, 0, 70, 0]
                            }
                        });

                    }

                }

            ],

            "dom": "<'row'<'col-sm-4 text-left'l><'col-sm-4 text-center'B><'col-sm-4 text-right'f>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-5 text-left'i><'col-sm-7 text-right'p>>",

            "rowCallback": function(row, data, index) { // Open Item on click

                // Add delete Button if table had deletableRows

                if ($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')) {

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" data-href="<?= base_url() ?>/staffs/delete" data-id="' + data[0] + '" class="text-danger btn-rounded tableRowActionBtn"><span class="fi fi-sr-delete"></span></span></div>');

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
                        window.location.href = "<?= base_url() ?>/staffs/view/" + data[0];
                    }

                });
            },


        });



        $.get("<?= base_url() ?>staffs/data", function(data) {

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

        $(document).on("change", "#sel-staff", function() {
            location.href = "" + $(this).val();
        });

        enable_delete('Are you sure to delete?', 'Please select a record to delete!');
    });
</script>