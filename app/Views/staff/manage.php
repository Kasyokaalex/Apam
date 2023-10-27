<?=View("partial/header"); ?>

<div class="row flex-grow-1">

    <div class="col-md-9 pe-0">
    
        <div class="inqbox full-height">           
            <div class="inqbox-content full-height">
            
                <div class="table-body g-0 p-3 full-height">
                    <table id="datatable" class="table table-hover tableClickable deletableRows">
                        <thead>
                            <tr>
                                <th>Staff Name</th>
                                <th >Phone number</th>
                                <th >ID/Passport</th>
                                <th >Store</th>
                                <th >Email</th>
                                <th ></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">

        <div class="inqbox full-height d-flex flex-column">

            <div class="inqbox-title"><h5>Add staff</h5></div>

            <div class="inqbox-content flex-grow-1" style="padding: 1.2em 1em">

                <?=form_open(base_url().'/staff/view/-1', 'class="form d-flex flex-column justify-content-between"'); ?>

                <div class="form-group">

                    <?=form_label('Select Role', 'role', ['class' => 'form-label required'], 'style="margin-top:1em"'); ?>

                    <?=form_dropdown('role', array('user' => 'User', 'admin' => 'Administrator', 'mgmt' => 'Management') , 'user', 'class="form-control"', 'select a thing'); ?>

                    <p class="" style="margin-top: 1em">Roles help in giving some users special permissions</p>       

                </div>

                <div class="d-grid">
                    
                    <button class="btn btn-purple btn-block" type="submit" name="submit"> create user</button>

                </div>

                <?=form_close(); ?>
                
            </div>
        </div>
    </div>
</div>

<?=View("partial/footer"); ?>

<script type="text/javascript">

    $(document).ready(function () {
                

        var table = $("#datatable").DataTable({

            "columnDefs" : [

                {"targets" : [5] , "visible" : false},

                {"targets" : [5], "searchable" : false}

            ],

            fixedHeader : true,

            "iDisplayLength": 10,

            "order": [0, "asc"],

            "language": { "sSearch": "", "searchPlaceholder" : "Search staff ..." },

            buttons: [{

                extend:'pdf',

                download: 'open',

                text:' <span class="fa fa-print"></span> &nbsp; Export',

                className:'btn btn-sm btn-warning btn-sm',

                title: " ",

                footer : true,

                exportOptions: {

                    columns: [0, 1, 2, 3],

                    modifier: { page: 'all'}
                },

                orientation: 'portrait',

                customize: function(doc) {

                    doc.pageMargins = [40, 30, 40, 40];

                    doc.styles.tableHeader = {

                                            color : '#fff',

                                            fillColor : '#800080',

                                            margin : [5,5,5,5],

                                            fontSize : '8',

                                            alignment : 'center'

                                            };

                    doc.content[1].table.widths =  '*';

                    doc.content[1].layout = 'noBorders';

                    doc.styles.tableBodyOdd = { 

                                            margin : [5,5,5,5],

                                            fontSize : '8',

                                            border: 1,

                                            alignment : 'center'

                                            }                                           

                    doc.styles.tableBodyEven = { 

                                            fillColor : '#eee',

                                            margin : [5,5,5,5],                                         

                                            fontSize : '8',

                                            alignment : 'center'

                                            }

                    doc.defaultStyle.alignment = 'left';


                    doc.content.splice(1, 0,                        
                        {
                            columns: [
                            {

                                image : '<?='data:image/'.pathinfo(base_url().'/uploads/logo/main.png',PATHINFO_EXTENSION).';base64,'.base64_encode(file_get_contents(base_url().'/uploads/logo/main.png')) ?>',

                                width: 60,

                                alignment : 'right'
                            },

                            {
                                text : "<?= config('apamSettings')->email ?> \n <?= config('apamSettings')->website ?> \n <?= config('apamSettings')->phone ?> \n <?= config('apamSettings')->address  ?> ",

                                bold : true,

                                fontSize : 9,

                                alignment : 'right'
                            }

                            ]
                        },

                        {
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 515, y2: 0, lineWidth: 0.5 }]
                        },

                        {

                        columns: [

                            {text : "Staff", margin : 7, fontSize : 9 },

                            {text : "Printed by : <?=ucfirst(config('loggedInStaff')->firstName) ?>", alignment: 'right', margin : 7, fontSize : 9}

                            ]

                        },

                        {
                             canvas: [{ type: 'line', x1: 0, y1: 0, x2: 515, y2: 0, lineWidth: 0.5 }]
                        },

                        {   
                            margin : 10,

                            fontSize : 8,

                            text: "This document is a summary of <?=config('apamSettings')->company ?> personel who have legal access to the firms computer system",

                            alignment: 'center'
                        },

                        {
                            text : "",

                            margin : 10

                        }
                    );

                    // Create a footer

                    doc['footer']=(function(page, pages) {

                        return {                           
                            

                            columns: [

                                {
                                    text : '© Shoman <?=date("Y") ?>',

                                    alignment : 'left'
                                },

                                {
                                    alignment: 'center',

                                    width: 100,

                                    text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }]
                                },

                                {
                                    // This is the right column
                                    text : '<?=date("D, d M Y H:i:s") ?>',

                                    alignment : 'right'
                                }
                            ],

                            canvas: [{ type: 'line', x1: 100, y1: 0, x2: 455, y2: 0, lineWidth: 0.5 }],

                            fontSize : '8',

                            margin: [70, 0, 70, 0]
                        }
                    });

                }  

                }

            ],

            "dom": "<'row'<'col-sm-5 text-left'f><'col-sm-3 text-center' ><'col-sm-4 text-right'B>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 text-center'p>>",

            "rowCallback": function ( row, data, index ) { // Open Item on click

                // Add delete Button if table had deletableRows

                if($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')){

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?=base_url() ?>/staff/delete" data-id=' + data[5] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')

                    // Show buttons on hover
                    $('td', row).hover(function () {
                            // over
                            $(row).find('.actions').toggle(); 
                            
                        }, function () {
                            // out
                            $(row).find('.actions').toggle(); 
                        }
                    );
                    }
                                
                    // Open Item on click

                    $('td', row).click(function(event){

                        if($(event.target).is('td')){
                            window.location.href = "<?=base_url() ?>/staff/view/" + data[5];
                        }                    

                    });
            },
        });

        $.get("<?=base_url() ?>/staff/getAll", function(data){

            table.clear() //clear content
            
            table.settings()[0]._iDisplayLength = calcTableRowCount(table);

            var obj = JSON.parse(data);

            //console.log(obj)

            table.rows.add(obj)

           table.draw() //update display

        }); 

        $(document).on("change", "#sel-staff", function(){ 
            location.href = "<?=site_url(current_url(true)->getSegment(1))?>?staffID=" + $(this).val();
        });
        
        enable_delete('Are you sure to delete?', 'Please select a record to delete!');
    });

</script>