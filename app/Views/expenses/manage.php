
<?=View("partial/header"); ?>

<link rel="stylesheet" href="<?=base_url()?>/public/css/choices.min.css">
<script src="<?=base_url()?>/public/js/choices.min.js"></script>
<script type="text/javascript" src="<?=base_url() ?>/public/js/moment.min.js"></script>

<div class="row flex-grow-1 m-0">
    <div class="col-md-9 inqbox">
        <div class="inqbox-content full-height d-flex flex-column">
            <div class="table-body g-0 flex-grow-1">
                <div class="col-md-12">
                    <table id="datatable" class="table table-hover tableClickable deletableRows" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th >Expense id</th>
                                <th >Expense Name</th>
                                <th >Amount Spent</th>
                                <th >Expense Category</th>
                                <th >Date/ Time</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>

        </div>
        <div id="feedback_bar"></div>
    </div>

    <div class="col-md-3 d-flex flex-column px-2">

        <div class="inqbox">

            <div class="inqbox-title"><h5>New expense</h5></div>

            <div class="inqbox-content">

                <?=form_open(base_url().'/expenses/view/-1', 'class="form"'); ?>

                <div class="form-group px-3">

                    <label for="category"><?=form_label('Select Category', 'category', ['style'=>"margin:1em 0", 'class'=>"form-label"]); ?></label>
                    
                    <select name="category" class="form-control" id="categorySelect">

                        <?php foreach ($categories as $cat) { ?>
                        
                            <option value="<?=$cat->categoryID ?>" ><?=$cat->name ?></option>
                            
                        <?php } ?>

                    </select>
                    <p class="" style="margin-top: 1em">Categories help in summarizing and breaking down expediture.</p>       

                </div>

                    <div class="d-grid px-3">
                        
                        <button class="btn btn-purple btn-block" type="submit" name="submit">Create Expense</button>
                        
                        <a class="btn btn-outline text-purple my-3" href="#" data-bs-toggle="modal" data-bs-target="#categories_modal"><span class="fa fa-align-right"></span> &nbsp; Manage Categories</a>

                    </div>

                <?=form_close(); ?>
                
            </div>
        </div>

        <div class="inqbox" style="margin-top : 20px">

            <div class="inqbox-title"><h5>Overview</h5></div>

            <div class="inqbox-content">
              <div class="" style="padding: 1.5em 1em ">
                <h2 id="total_spent" style="margin: 0px">Ksh. 0</h2>
                <span class="">Spent This Month</span>
              </div>
              <div class="">
                <div class="chart-area">
                  <canvas id="lineChartExample"></canvas>
                </div>
              </div>
            </div>
        </div>
    </div>

<!-- EXPENSES MODAL -->

<div class="modal fade" id="categories_modal" role="dialog">

    <div class="modal-dialog" style="min-width: 850px;margin-top: 9em;">
        <!-- Modal content-->
        <div class="modal-content" style="min-height: 500px">

            <form id="expense_category_form" action="<?=base_url()?>/expenses/saveCategory" method='POST'>
            
                <div class="close"><span data-dismiss="modal"><span class="fi fi-rr-cross-circle"></span></span></div>

                <div class="modal-body" id="my_modal" id="">
                
                    <div class="" style="margin: 0; display: flex">
                    
                        <div class="" style="width: calc(100% - 270px); padding: 1em 2em 0">

                            <div style="padding: 2.5em 1em; position: absolute">
                                <h4 class="text-purple" style="text-transform: uppercase">Expenses Categories</h4>  
                            </div>
                            
                            <div class="container-fluid" style="padding: 1em;">
                                   
                            <div class="table-body g-0">
                                <div class="row container-fluid ">
                                    <table id="dTableCategories" class="table table-hover tableClickable deletableRows" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>Category Name</th>
                                                <th>Department</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>                                             
                                
                            </div>
                        </div>

                        <div style="padding: 1em; width: 270px; background: #fafafa; height: 600px">

                            <div style="height: 20px;"></div>
                            
                            <div>
                                
                                <div class="container-fluid">
                                    <h4 class="cat-panel-title">Expense category</h4>
                                    <hr>
                                    <p style="margin-bottom: 20px">Categories help in identifying which department takes up more expenses and if they should be scaled up or down.</p>
                                    
                                    <div class="text-center btn-add-new" style="background: #efefef; width: 130px; padding: 25px 0px 15px; border-radius: 10px; cursor: pointer; margin: 0 auto; border: 1px solid #ddd; margin-top: 4em">
                                        <span style="font-size: 27px;" class="fi fi-sr-add"></span> <br>
                                        <span class="btn btn-link">CREATE NEW</span>
                                    </div>
                                    
                                    <div class="cats-panel" hidden>
                                        
                                        <input type="hidden" class="categoryID" name="categoryID" value="-1">
                                        <div class="form-group">

                                            <label><?=form_label('Category Name', 'category_name', ["required"]); ?></label>
                                            <?=form_input('category_name', "", "class='form-control' id='category_name' placeholder='e.g. Printing'"); ?> 

                                        </div>
                                                                            
                                        <div class="form-group">

                                            <?=form_label('Department', 'departmentID', []); ?>
                                            <?=form_dropdown('departmentID', [], [], "class='form-control' placeholder='Select Department' id='departments'"); ?> 

                                        </div>
                                        
                                                    
                                        <div class="form-group">                                
                                        
                                            <button type="submit" class="btn btn-purple btn-save">create</button> &nbsp; &nbsp;
                                            <button type="button" class="btn btn-danger btn-close">cancel</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div> 
                    </div>
                        
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<!-- EXPENSES MODAL -->

<?=View("partial/footer"); ?>

<script src="<?=base_url() ?>/public/js/chartjs.min.js" type="text/javascript"></script>

<span id="month_select" style="display: none"><div class="justify-content-end" style="margin-top: .5rem; display: flex;position: relative;">
        
    <select style="width: 120px" id="expenses_month"> </select>
    
    <select id="expenses_year">

        <?php for ($i = 0; $i < 5; $i++) { ?>

            <option value="<?=date("Y") - $i ?>"><?=date("Y") - $i ?></option>
            
        <?php } ?>

    </select>

</div></span>

<script type="text/javascript">


    $(document).ready(function (){
        var deptsChoice = new Choices('#departments', {
            itemSelectText: "",
            placeholderValue: "Select Department",
            searchPlaceholderValue: "Search Departments...",
        });
        
        var catsChoice = new Choices('#categorySelect', {
            itemSelectText: "",
            placeholderValue: "Select Category",
            searchPlaceholderValue: "Search Categories...",
        });

        var table = $("#datatable").DataTable({

            "columnDefs" : [{"targets" : [0] , "orderable" : false},

                            {"targets" : [0], "visible": false}

            ],

            "autoWidth": false,
            
            // "fixedHeader": true,

            // "aLengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],

            "iDisplayLength": 7,

            "order": [0],

            "language": { "sSearch": "", "searchPlaceholder" : "Search Expenses ..." },


            "dom": "<'row'<'col text-left'f><'col text-right'<'select_month'>B>>" + "<'row padded-t'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 text-left'p>>",
            
            "rowCallback": function ( row, data, index ) { // Open Item on click

                // Add delete Button if table had deletableRows

                if($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')){

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?=base_url() ?>/expenses/delete" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')

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
                        window.location.href = "<?=base_url() ?>/expenses/view/" + data[0];
                    }                    

                });
            },
        });

        //changes
        var dTableCategories = $("#dTableCategories").DataTable({

            "columnDefs" : [
                
                {"targets" : [0,1] , "orderable" : false},

                {"targets" : [0], "visible": false},

                {"targets" : [0], "searchable": false}

            ],

            "iDisplayLength": 7,

            "order": [],

            "language": { "sSearch": "", "searchPlaceholder" : "Search categories ..." },

            "dom": "<'row'<'col-sm-6 text-left'JKSDF><'col-sm-6 text-right'f>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 text-center'p>>",

            "rowCallback": function ( row, data, index ) {

                // Add delete Button if table had deletableRows

                if($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')){

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?=base_url() ?>/expenses/deleteCategory" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')

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
                
                        $('.btn-add-new').hide();
                        $(".cats-panel").show();
                        $(".cats-panel .categoryID").val(data[0]);
                        $(".cats-panel-title").html('Category Details');                        
                        $(".btn-save").html("update");
                        
                        $("#category_name").val(data[2]);
                        deptsChoice.setChoiceByValue(data[4]);
                    }                    

                });
            },
        });
        

        // POPULATE PRODUCT CATEGORIES
        
        function populateCategories() {

            $.get("<?=base_url() ?>/expenses/getCategories4Table", function(data){
                // console.log(data);

                dTableCategories.clear() //clear content

                var obj = JSON.parse(data);

                dTableCategories.rows.add(obj)
                dTableCategories.draw(); //update display

            });
            
        }
        
        populateCategories();
        
        $(".btn-add-new").click(function (e) {
                        
            $(this).hide();
            $(".cats-panel").show();
            $(".cats-panel-title").html('New Product Category');
            $(".cats-panel input").val("");
            $(".btn-save").html("create");
            $(".cats-panel .categoryID").val(-1);
        });
        
        $(".btn-close").click(function (e) {
                        
            $('.cats-panel').hide();
            $(".btn-add-new").show();
            $(".cats-panel-title").html('Product Category');
        });
        // HANDLING EXPENSE CATEGORY FORM SUBMIT

        var category_settings = {
            submitHandler: function (form) {
                
                $(form).ajaxSubmit({
                    success: function (response) {
                        
                        post_form_submit(response);
                        
                        populateCategories();
                        
                        $('.cats-panel').hide();
                        $(".btn-add-new").show();
                        $(".cats-panel-title").html('Product Category');
                        
                        window.location.reload();

                    },
                    error:function(response){

                        // console.log(response)
                    },
                    dataType: 'json',
                    type: 'post'
                });

            }
        };

        $('#expense_category_form').validate(category_settings);

        function post_form_submit(response)
        {

            if (!response.success)
            {
                set_feedback('error', response.message, false);
            }
            else
            {
                set_feedback('success', response.message, true);
            }
            
        }

        // General configuration for the charts with Line gradientStroke
        // gradientChartOptionsConfiguration = {
        //   maintainAspectRatio: false,
        //   showAllTooltips: true,
        //   legend: {
        //     display: false
        //   },
        //   responsive: 1,
        //   scales: {
        //     yAxes: [{
        //       display: 0,
        //       gridLines: 0,
        //       ticks: {
        //         display: false
        //       },
        //       gridLines: {
        //         zeroLineColor: "transparent",
        //         drawTicks: false,
        //         display: false,
        //         drawBorder: false
        //       }
        //     }],
        //     xAxes: [{
        //       display: 0,
        //       gridLines: 0,
        //       ticks: {
        //         display: false
        //       },
        //       gridLines: {
        //         zeroLineColor: "transparent",
        //         drawTicks: false,
        //         display: false,
        //         drawBorder: false
        //       }
        //     }]
        //   },
        //   layout: {
        //     padding: {top:15}
        //   },

        //   tooltips : {

        //     caretPadding : 15,

        //     xPadding : 15,

        //     yPadding : 9,

        //     caretSize : 6,

        //     cornerRadius : 3,

        //     backgroundColor : "#fff",

        //     titleFontSize : 14,

        //     titleFontColor : '#888',

        //     titleFontFamily : 'rubik',

        //     bodyFontSize : 16,

        //     bodyFontColor : '#888',

        //     bodyFontFamily : "rubik",

        //     bodyFontStyle : "bold",

        //     displayColors : false,

        //     borderColor : 'rgba(0, 0, 0, .2)',

        //     borderWidth : .5,

        //     callbacks: {

        //         label: function(tooltipproduct, data) {

        //             var label = data.datasets[tooltipproduct.datasetIndex].label || '';

        //             if (label) {
        //                 label += ' ';
        //             }
        //             label = Math.round(tooltipproduct.yLabel * 100) / 100;
        //             return "Ksh. " + label.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
        //         },
        //         labelColor: function(tooltipproduct, chart) {
        //             return {
        //                 // borderColor: 'rgba(255, 0, 0, 1)',
        //                 // backgroundColor: 'rgba(255, 0, 0, 1)'
        //             };
        //         },
        //         labelTextColor: function(tooltipproduct, chart) {
        //             return '#800080';
        //         }
        //     }
        //   }
        // };

        // Chart.pluginService.register({
        //   beforeRender: function (chart) {
        //     if (chart.config.options.showAllTooltips) {
        //         // create an array of tooltips
        //         // we can't use the chart tooltip because there is only one tooltip per chart
        //         chart.pluginTooltips = [];
        //         chart.config.data.datasets.forEach(function (dataset, i) {
        //             chart.getDatasetMeta(i).data.forEach(function (sector, j) {
        //                 chart.pluginTooltips.push(new Chart.Tooltip({
        //                     _chart: chart.chart,
        //                     _chartInstance: chart,
        //                     _data: chart.data,
        //                     _options: chart.options.tooltips,
        //                     _active: [sector]
        //                 }, chart));
        //             });
        //         });

        //         // turn off normal tooltips
        //         chart.options.tooltips.enabled = false;
        //     }
        // },
        //   afterDraw: function (chart, easing) {
        //     if (chart.config.options.showAllTooltips) {
        //         // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
        //         if (!chart.allTooltipsOnce) {
        //             if (easing !== 1)
        //                 return;
        //             chart.allTooltipsOnce = true;
        //         }

        //         // turn on tooltips
        //         chart.options.tooltips.enabled = true;
        //         var tooltipNo = 1;
        //         Chart.helpers.each(chart.pluginTooltips, function (tooltip) {

        //             //Turn only the 2nd tooltip

        //             if (tooltipNo == 2) {

        //                 tooltip.initialize();
        //                 tooltip.update();
        //                 // we don't actually need this since we are not animating tooltips
        //                 tooltip.pivot();
        //                 tooltip.transition(easing).draw();

        //             }

        //             tooltipNo += 1;
        //         });
        //         chart.options.tooltips.enabled = false;
        //     }
        //   }
        // });

        // var daily_stats;
        // var cardStatsMiniLineColor = "#fff", cardStatsMiniDotColor = "#fff";
        // var chartColor = "#000";

        // ctx = document.getElementById('lineChartExample').getContext("2d");

        // gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
        // gradientStroke.addColorStop(0, '#80b6f4');
        // gradientStroke.addColorStop(1, chartColor);

        // gradientFill = ctx.createLinearGradient(0, 160, 0, 0);
        // gradientFill.addColorStop(0, "#ffff");
        // gradientFill.addColorStop(1, "#fa06");q

         $("div.select_month").html($("#month_select").html());


        function populate_data(time_start, time_end) {
            var monthNames = ["January", "February", "March", "April", "May", "June",

                              "July", "August", "September", "October", "November", "December"

                            ];

            var current_month =  <?=date('m') ?>;

            var selected_month = $("#expenses_month").val();

            $("#expenses_month").empty();

            var selected = "";

            // console.log(selected_month)

            if($("#expenses_year").val() == <?=date('Y') ?>){

                if(selected_month > current_month){                    

                    time_start = moment( <?=date('Y') ?> + "-" + current_month + "-" + "01").unix();
                    
                    time_end = moment( <?=date('Y') ?> + "-" + current_month + "-" + "01").endOf('month').unix();

                    selected_month = current_month;
                }

                for(var k = 0; k < current_month; k++){

                    selected = "";

                    if (k == (current_month - 1) && selected_month == null  ) {

                        selected = "selected";

                    }

                    if(selected_month == (k+1)) {

                        selected = "selected";
                    }

                    var value = (k + 1) > 9 ? (k + 1): "0" + (k + 1);

                    $("#expenses_month").append('<option ' + selected +' value ="' + value + '">' + monthNames[k] + '</option>')

                }

            }else{

                monthNames.forEach( function(element, index) {

                    selected = "";

                    if ((index+1) == selected_month ) {

                        selected = "selected";
                    }

                    var value = (index + 1) > 9 ? (index + 1): "0" + (index + 1);

                    $("#expenses_month").append('<option ' + selected +' value ="' + value + '">' + monthNames[index] + '</option>')
                    
                });

            }

            $.get("<?=base_url() ?>/expenses/getAll/" + time_start + "/" + time_end, function(response){
                
                table.clear() //clear content
            
                table.settings()[0]._iDisplayLength = calcTableRowCount(table);

                var obj = JSON.parse(response);

                $('#total_spent').html(obj.monthly_total)

                table.rows.add(obj.table_data)

                table.draw() //update display


                daily_stats = obj.daily_stats

                // console.log(daily_stats)

                // myChart = new Chart(ctx, {

                //   type: 'line',
                //   responsive: true,
                //   data: {
                //     labels: ["<?=date('F, d', time()-172800) ?>", "<?=date('F, d', time()-86400) ?>", "<?=date('F, d') ?>"],
                //     datasets: [{
                //       borderColor: "#fa0",
                //       pointBorderColor: "#FFF",
                //       pointBackgroundColor: "#fa0",
                //       pointBorderWidth: 2,
                //       pointHoverRadius: 6,
                //       pointHoverBorderColor: "#fao5",
                //       pointHoverBorderWidth: 2,
                //       pointRadius : 6,
                //       fill: true,
                //       backgroundColor: gradientFill,
                //       borderWidth: 2,
                //       data: JSON.parse(daily_stats)
                //     }]
                //   },
                //   options: gradientChartOptionsConfiguration
                // });

            }); 
            
        }

        populate_data(<?=strtotime(date("Y-m-01")) ?>, <?=strtotime(date("Y-m-t 23:59:59")) ?>);

        $(document).on("change", "#expenses_month, #expenses_year", function () {

            var month = $("#expenses_month").val();

            var year = $("#expenses_year").val();

            var time_start = moment(year + "-" + month + "-" + "01").unix();

            var time_end = moment(year + "-" + month + "-" + "01").endOf('month').unix();
            
            populate_data(time_start, time_end);
        })
        
        enable_delete('Are you sure to delete?', 'Please select something to delete!');

    });

</script>