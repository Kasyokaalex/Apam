<?=View("partial/header"); ?>

<link href="css/datepicker3.css" rel="stylesheet">

<?=form_open('/payments/save/'.$paymentID, array('id'=> 'payment_form', 'class'=> 'form-horizontal')); ?>

<input type="hidden" id="paymentID" name="paymentID" value="<?= $payment_info ? $payment_info->paymentID: '' ?>" />


<div class="row">
    <div class="col-lg-12 border-top-info">
        <div class="inqbox float-e-margins">

            <div class="inqbox-title">
                <h5>
                    Payment information
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fi fi-sr-angle-small-up"></i>
                    </a>
                </div>
            </div>

            <div class="inqbox-content" style="padding: 2em;">

            <div class="row">
                <div class="col-4 form-group">
                    <label class="form-label"><?=form_label('Tenant :', 'inp-borrower-id', array('class'=> 'wide')); ?></label>
                    <div class="">
                        
                        <input class="form-control" id="tenant" name="tenant" value="<?= $payment_info ? $payment_info->tenant: '' ?>" />
                        
                    </div>
                </div>
                <div class="col-4 form-group" id="data_1">
                    <label class="form-label"><?=form_label('Date :', 'payment_date', array('class'=> 'wide required')); ?></label>
                    <div class="">
                        <div class="input-group date">
                            <span class="input-group-texton"><i class="fa fa-calendar"></i></span>
                            <?=form_input(['name'=> 'date_paid','id'=> 'date_paid','value'=> (!empty($payment_info->date_paid)) ? date("m/d/Y", strtotime($payment_info->date_paid)) : date('m/d/Y'),'class'=> 'form-control']
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                <label class="form-label"><?=form_label("Amount" . ':', 'amount', array('class'=> 'wide required')); ?></label>
                    <div class="">
                    <input type="text" class="form-control" id="amount" name="amount" value="<?= $payment_info ? $payment_info->amount: '' ?>" />

                    </div>
                </div>
                <div class="col-4 form-group" id="data_1">
                <label class="form-label"><?=form_label('Apartment', 'paid_by', array('class'=> 'wide required')); ?></label>
                    <div class="">
                        <div class="input-group date">
                            <span class="input-group-texton"><i class="fa fa-calendar"></i></span>
                           
                            <input type="text" class="form-control" id="apartment" name="apartment" value="<?= $payment_info ? $payment_info->apartment: '' ?>" />

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4 form-group">
                <label class="form-label"><?=form_label('Payment method:', 'method', array('class'=> 'wide required')); ?></label>
                    <div class="">
                    <?php

                        $products = array('cash'=> 'Cash','mpesa'=> 'Mpesa','bank_transfer'=> 'Bank Transfer');

                        if (empty($payment_info->payment_method)) {
                            if ($payment_info) {
                                $payment_info->payment_method = "cash";
                            }
                        }

                        echo form_dropdown('payment_method', $products, $payment_info ? $payment_info->payment_method : '', 'class="form-control"');?>
                    </div>
                </div>
                
            </div>
            </div>
        </div>
    </div>
</div>


<input type="hidden" id="user_info" value="<?= config('loggedInStaff')->staffID; ?>" />

<div class="row">
    <div class="form-group">
        <div class="text-center">

        <?php if (config('loggedInStaff')->role != "mnmt") { ?>

                <button id="btn-edit" class="btn btn-sm btn-danger" type="button"><span class="fa fa-pencil"></span> &nbsp;Edit Payment</button>
                
                <?php } ?>

            <?=form_submit(['name'=> 'submit','id'=> 'btn-save','value'=> 'Save','class'=> 'btn btn-sm btn-primary']
                );

            ?>

        </div>
    </div>
</div>

<?=form_close();
?>



<?=View("partial/footer"); ?>

<!-- Date picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

<script type='text/javascript'>

        if ($("#paymentID").val() > 0)
        {

            $("input, textarea").prop("readonly", true);
            $("select").prop("disabled", true);
            $("#btn-save").hide();
            $("#btn-edit").show();

            $("#btn-edit").click(function () {
                
                $("#btn-save").show();
               
                $(this).hide();

                $("input, textarea").prop("readonly", false);

                $("select").prop("disabled", false);
            });
        }
        else
        {
            $("#btn-approve").hide();
            $("#btn-break-gen").hide();
            $("#btn-edit").hide();
        }

    //validation and submit handling
    $(document).ready(function ()
    {
    
        var settings = {
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    success: function (response) {
                        post_payment_form_submit(response);
                        
                        console.log(response);
                    },

                    error: function(response) {
                        
                        console.log(response);
                    },
                    dataType: 'json',
                    type: 'post'});
            },
            rules: {
                borrower: "required",
                loan_id: {greaterThanZero: true, required:true},
                paid_by: "required",
                principal: "required",
                interest: "required",
                penalty: "required",
                renewal: "required",
            },
            messages: {
                borrower: "Borrower is required!",
                loan_id: {greaterThanZero:"Borrower doesn't have an active Loan!", required:"Please select a loan!"}
            }
        };

        $('#payment_form').validate(settings);

        $.validator.addMethod("greaterThanZero", function (value, element) {

            // console.log(value);

            if (parseFloat(value) > 0)
            {
                return true;
            }
            return false;
            
        }, "Amount must be greater than 0!");

    });

   

  

    function post_payment_form_submit(response)
    {
        if (!response.success)
        {
            set_feedback('error', response.message, true);
        }
        else
        {
            set_feedback('success', response.message, false);
        }

        $("#payment_form").attr("action", "<?= site_url(); ?>/payments/save/" + response.paymentID);
    }
</script>