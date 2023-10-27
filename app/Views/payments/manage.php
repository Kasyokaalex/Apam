<?php echo View("partial/header"); ?>
<style>
    table#datatable td:nth-child(2),
    td:nth-child(7), 
    td:nth-child(9) {
        white-space: nowrap;
        text-align: center;
    }
</style>

<div class="row">
    <div class="col-md-9 inqbox">

        <div class="inqbox float-e-margins">
            <div class="inqbox-title border-top-success">
                <h5>
                   Payments list
                </h5>
                
            </div>
            <div class="inqbox-content table-responsive">

                <table id="datatable" class="table table-hover deletableRows" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th >Payment id</th>
                            <th>Apartment</th>
                            <th>Tenant</th>                   
                            <th>Amount</th>
                            <th >Payment Method</th>
                            <th >Breakdown</th>
                        </tr>
                    </thead>                    
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-3">

        <div class="inqbox full-height d-flex flex-column">

            <div class="inqbox-title"><h5>Why Payment Details ?</h5></div>

            <div class="inqbox-content flex-grow-1 d-flex flex-column justify-content-between" style="padding: 1.2em 1em">

                <div>
                    <p class="" style="margin-bottom: 2em">Keeping records on customers helps you know your best buying customer, Frequency of purchase among others things.</p> 
                    <p class="" style="margin-bottom: 2em">This comes in handy while giving gifts and defining customer discounts.</p>    
                </div>
                <div class="">
                    
                    <a class="btn btn-block btn-purple" href="payments/view/-1">New Payment</a>

                </div>
                
            </div>
        </div>
    </div>
</div>


<div id="feedback_bar"></div>


<?php echo View("partial/footer"); ?>

<script type="text/javascript">

    $(document).ready(function (){
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

                $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?= base_url() ?>/payments/delete" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')


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
            window.location.href = "<?= base_url() ?>/payments/view/" + data[0];
        }

    });
},
});

        $.get("<?=base_url() ?>payments/data", function(data){


            table.clear() //clear content

            var obj = JSON.parse(data);

            //console.log(obj)

            table.rows.add(obj)

           table.draw() //update display

        });

        <?php if(isset($pdf_file)){ ?>

            alertify.confirm( "Payment receipt", "<span style='font-size:40px;position:absolute;top:55px' class='fi fi-sr-checkmark-circle'></span> <span style='margin-left:55px'>Your file has been saved. Would you like to view it?</span>",

              function(){

                window.open("<?=$pdf_file ?>", "_blank");

                //alertify.success('Yes');

              },
              function(){

                window.location.href='payments';
                //alertify.error('No');

              }).set('labels', {ok:'Yes', cancel:'No'});;

        <?php } ?>
        enable_delete('Are you sure to delete?', 'Please select an item to delete!');

    });
</script>
