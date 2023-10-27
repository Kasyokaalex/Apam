<?= view("partial/header"); ?>

<div class="row flex-grow-1 m-0">
    <div class="col-lg-9">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title " style="background: linear-gradient(90deg, #e9573f, gold); color: white;">
                <h5>
                    apartmentS SUMMARY
                </h5>
                <div class="inqbox-tools">

                    <?= anchor(base_url() . "apartments/view/-1", "<span class='fi fi-sr-add'></span> &nbsp; New Apartment", array('id' => 'new', 'style' => 'color:white', 'class' => 'btn btn-sm btn-info btn-sm')); ?>
                </div>

            </div>
            <div class="inqbox-content table-responsive">

                <div class="row table-body">
                    <div class="col-md-12">
                        <table id="datatable" class="table table-hover deletableRows" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Apartment id</th>
                                    <th>ApartmentName</th>
                                    <th>description</th>
                                    <th>apartmentStatus</th>
                                    <th>housetypes</th>
                                    <th>Units</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div id="feedback_bar"></div>
    </div>
    <div class="col-md-3 d-flex flex-column px-3">

        <div class="inqbox">

            <div class="inqbox-title"><h5>House Types</h5></div>

            <div class="inqbox-content">

                <form action="" class="form" method="post" accept-charset="utf-8">

                <div class="form-group px-3">

                    <label for="category"><label for="category" style="margin:1em 0" class="form-label">Select Category</label></label>
                    
                    <select name="category" class="form-control" id="categorySelect">

                                                
                            <option value="1" >1Bedroom</option>                    
                            <option value="2" >2Bedroom</option>                     
                            <option value="7" >3Bedroom</option>
                            
                        
                    </select>
                    <p class="" style="margin-top: 1em"></p>       

                </div>

                    <div class="d-grid px-3">
                        
                        <button class="btn btn-secondary btn-block" type="submit" name="submit">Create Room type</button>
                        
                        <a class="btn btn-light  text-purple my-3" href="#" data-bs-toggle="modal" data-bs-target="#categories_modal"><span class="fa fa-align-right"></span> &nbsp; Manage </a>

                    </div>

                </form>                
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

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?= base_url() ?>/apartments/delete" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')


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
                        window.location.href = "<?= base_url() ?>/apartments/view/" + data[0];
                    }

                });
            },
        });


        function getAll() {

            $.get("<?= base_url() ?>apartments/data", function(data) {

                table.clear() //clear content

                 console.log(data)

                var obj = JSON.parse(data);

                table.rows.add(obj)
                table.draw()

            });
        }

        getAll();

        function post_form_submit(response) {

            if (!response.success) {
                set_feedback('error', response.message, false);
            } else {
                set_feedback('success', response.message, true);
            }

        }

        enable_delete('Are you sure to delete?', 'Please select an item to delete!');

    });
</script>