<?=View("partial/header"); ?>

<link rel="stylesheet" href="<?=base_url()?>/public/css/choices.min.css">
<script src="<?=base_url()?>/public/js/choices.min.js"></script>

<?= form_open('expenses/save/'. $expenseID, array('id'=> 'expense_form', 'class'=> 'row flex-grow-1')); ?>
<input type="hidden" id="expenseID" name="expenseID" value="<?= $expenseID ?>" />

<?php if (isset($expense_info->category)) {  $expense_category = $expense_info->category; } ?>

<div class="row flex-grow-1 m-0">

    <div class="col-md-9 d-flex ps-0">
        <div class="inqbox">
            <div class="inqbox-title">
                <h5> Expense information </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <!-- <i class="fi fi-sr-angle-small-up"></i> -->
                    </a>
                </div>
            </div>
            <div class="inqbox-content">

                <div class="tabs-container px-3 py-4" style="min-height: 50vh">

                    <div class="row">

                        <div class="col-6 form-group">

                            <label class="form-label"><label class="required">Expense Name </label></label>

                            <input class="form-control input" name="name" id="name" type="text" value="" required>

                        </div>

                        <div class="col-6 form-group">

                            <label class="form-label"><label class="required">Date of Expenditure </label></label>

                            <div class="">

                                <div class="input-group date" id="datetimepicker">
                                    <span class="input-group-text"><i class="fi fi-rr-calendar"></i></span>

                                    <?=form_input(['name'=> 'date','type'=> 'datetime','id'=> 'date','value'=>  date("d F Y H:i", time()),'class'=> 'form-control']
                                    );
                                    ?>
                                </div>
                                
                            </div>                              
                        </div>
                        <div class="col-6 form-group">

                            <label class="form-label"><label class="required">Expense Category </label></label>
                            
                            <select name="category" class="form-control" id="categorySelect">

                                <?php foreach ($categories as $cat) { ?>
                                
                                    <option <?=($cat->categoryID == $expense_category) ? "selected" : "" ?> value="<?=$cat->categoryID ?>" ><?=ucwords($cat->name) ?></option>
                                    
                                <?php } ?>

                            </select>

                        </div>

                        <div class="col-6 form-group">                    

                            <label class="form-label"><label class="required">Amount (<?=ucwords(config('apamSettings')->currency_symbol) ?>) </label></label>
                            <div class="">
                                <?=form_input(['name'=> 'amount','id'=> 'amount', 'class' => 'form-control']); ?>                                
                            </div>

                        </div>

                        <input type="hidden" id="addedBy" name="addedBy" value="<?=config('loggedInStaff')->staffID ?> "/>
                    
                        <div class="col-6 form-group">

                            <label class="form-label"><label class="required">Supplier </label></label>

                            <select name="supplier" class="form-control" id="supplierSelect">
                                
                                <option value="-1"> Not Applicable</option>

                                <?php //foreach ($suppliers as $sup) { ?>
                                
                                    <!-- <option value="<?//=$sup->supplierID ?>" ><?//=($sup->isCompany)? $sup->company : $sup->firstName." ".$sup->lastName ?></option> -->
                                    
                                <?php //} ?>

                            </select>

                        </div>


                        <div class="col-6 form-group">

                            <label class="form-label"><?=form_label('Description:', 'description', array('class'=> 'wide')); ?></label>
                            <div class="">
                                <?=form_textarea(['name'=> 'description','id'=> 'description', 'class' => 'form-control', 'rows' => 3])?>
                            </div>
                        </div>

        

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 inqbox d-flex flex-column">

            <div class="inqbox-title"><h4>Why record expenses ?</h4></div>

            <div class="inqbox-content d-flex flex-column flex-grow-1 justify-content-between" style="padding: 1.5em 1em">

                <div>
                    <p>Expenses are one of the great ways one can keep track of their earnings. This inturn helps you to plan ahead and understand what your business needs to survive.</p>
                </div>

                <div class="">

                    <?php if ((int) $expenseID > -1) { ?>

                        <button type="button" class="btn btn-primary btn-edit" style="margin-right: 10px;"> <span class="fi fi-sr-pencil"></span> &nbsp; Edit</button>
                    
                        <button class="btn btn-purple btn-save" type="submit" name="submit btn-save" style="margin-right: 10px;"> update</button>
                        
                        <span class="btn btn-default" onclick="window.history.go(-1); return false;">back</span>

                    <?php }else { ?>
                    
                        <button class="btn btn-outline btn-save" type="submit" name="submit" style="margin-right: 10px;"> create</button>
                        
                        <span class="btn btn-danger" onclick="window.history.go(-1); return false;">cancel</span>

                    <?php } ?>

                </div>

                <?=form_close(); ?>
                
            </div>
        </div>
</div>


<?= form_close(); ?>


<?=View("partial/footer"); ?>

<script src="<?=base_url() ?>/public/js/expenses.js?v=<?=time()?>"></script>
<script>

var settings = {
            ignore: "",
            invalidHandler: function(form, validator) {
                set_feedback( 'error', "Error: Please correct all the required fields", true);
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {

                        post_expense_form_submit(response);

                        console.log(response);

                        if ($("#apartment_id").val() > 0) {
                            setTimeout(function() {
                                location.reload()
                            }, 5000);
                        }
                    },

                    error: function(response) {

                        console.log(response);
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                
                amount: "required",
                name: "required",
            },
            messages: {
                amount: "Please enter the amount",
                name: "Please enter the name of the expense",
            }
        };

        $('#expense_form').validate(settings);

        function post_expense_form_submit(response) {

            if (!response.success) {
                set_feedback( 'success', response.message, true);
            } else {
                set_feedback( 'error', response.message, true);
            }

            $('#expense_form').attr("action", "<?= site_url(); ?>/expenses/save/" + response.expenseID);
        }
</script>
