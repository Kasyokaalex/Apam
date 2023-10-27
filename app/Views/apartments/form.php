<?= view("partial/header"); ?>

<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<?=form_open('apartments/save/' . $apartmentID, array('id' => 'apartment_form', 'class' => 'form-horizontal')); ?>

<style>
    #drop-target {
        border: 10px dashed #999;
        text-align: center;
        color: #999;
        font-size: 20px;
        width: 600px;
        height: 300px;
        line-height: 300px;
        cursor: pointer;
    }

    #drop-target.dragover {
        background: rgba(255, 255, 255, 0.4);
        border-color: green;
    }
</style>

<input class="form-control" type="hidden" id="apartment_id" name="apartment_id" value="<?= $apartment_info ? $apartment_info->apartmentID : '' ?>" />
<input class="form-control" type="hidden" id="controller" value="<?= strtolower('apartments'); ?>" />
<input class="form-control" type="hidden" id="linker" value="" />

<div class="row">
    <div class="col-lg-9">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    apartment Information</h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">
                <div class="tabs-container">
                    <ul class="nav nav-pills tab-border-top-danger">

                        <li class="active"><a data-bs-toggle="tab" href="#sectionA">apartments basic information</a></li>

                    </ul>

                    <hr>

                    <div class="tab-content">

                        <div id="sectionA" class="row">


                            <div class="form-group col-sm-6">
                                <label class="form-label"><?= form_label('Apartment Name', 'inp-tenant', array('class' => 'wide required')); ?></label>
                                <div class="">

                                    <input class="form-control" name="apartmentName" type="text" id="apartmentName" value="<?= $apartment_info ? $apartment_info->apartmentName : '' ?>" />
                                </div>


                            </div>

                            <div class="form-group col-sm-6">
                                <label class="form-label"><?= form_label('Description:', 'description', array('class' => 'wide')); ?></label>
                                <div class="">

                                    <input class="form-control" name="description" type="text" id="description" value="<?= $apartment_info ? $apartment_info->description : '' ?>" />

                                </div>
                            </div>

                            <div class="form-group col-sm-6">
                                <label class="form-label">Apartment Status</label>
                                    <div>
                                        <select class="form-control" name="apartmentStatus" id="apartmentstatus">
                                            <option value="pending" <?= ($apartment_info && $apartment_info->apartmentStatus === 'pending') ? 'selected' : '' ?>>Pending</option>
                                            <option value="approved" <?= ($apartment_info && $apartment_info->apartmentStatus === 'approved') ? 'selected' : '' ?>>Approved</option>
                                            <option value="on going" <?= ($apartment_info && $apartment_info->apartmentStatus === 'on going') ? 'selected' : '' ?>>On Going</option>
                                            <option value="paid" <?= ($apartment_info && $apartment_info->apartmentStatus === 'paid') ? 'selected' : '' ?>>Paid</option>
                                        </select>
                                    </div>
                                </div>


                            <div class="form-group col-sm-6">
                                <label class="form-label">House Types</label>
                                <div class="">
                                    <input class="form-control" name="houseTypes" type="text" id="houseTypes" value="<?= $apartment_info ? $apartment_info->houseTypes : '' ?>" />

                                </div>
                            </div>

                            <div class="form-group col-sm-6">
                                <label class="form-label">Units Count</label>
                                <div class="">
                                    <input class="form-control" name="unitsCount" type="number" id="unitsCount" value="<?= $apartment_info ? $apartment_info->unitsCount : '' ?>" />
                                </div>
                            </div>


                            <div class="form-group col-sm-6">
                                <label class="form-label"><?= form_label('Location', 'status', array('class' => 'wide')); ?></label>
                                <div class="">
                                    <input class="form-control" name="status" type="text" id="status" value="<?= $apartment_info ? $apartment_info->apartmentStatus : '' ?>" />
                                </div>
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="form-group col-sm-6">
                                <div class="text-center">
                                    <?php if (config('loggedInStaff')->role != "caretaker") { ?>

                                        <button id="btn-edit" class="btn btn-danger" type="button"> <span class="fi fi-sr-pencil"> </span> &nbsp;Edit apartment</button>
                                    <?php } ?>

                                    <button id="btn-save" class="btn btn-primary" type="submit"> <span class="fi fi-sr-bookmark"> </span> &nbsp;Save</button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="row">

</div>


<?= form_close(); ?>

<?= view("partial/footer"); ?>

<!-- Date picker -->
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="<?= base_url(); ?>js/apartment.js?v=<?= time(); ?>"></script>

<script type='text/javascript'>
    //validation and submit handling
    $(document).ready(function() {

        <?php if ($apartment_info && $apartment_info->apartmentID < 1) { ?>

            $("#payment_date").datepicker("setDate", addDays($('#date_applied').val(), parseInt($("#duration").val() * 30)));

        <?php }
        if (isset($pdf_file)) { ?>

            alertify.confirm("Letter of apartment Request", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-checkmark-circle'></span> <span style='margin-left:55px'>Your file is ready. Would you like to view it?</span>",

                function() {

                    window.open("<?= $pdf_file ?>", "_blank");

                    //alertify.success('Yes');

                },
                function() {

                    window.location.href = 'index.php/apartments';
                    //alertify.error('No');

                }).set('labels', {
                ok: 'Yes',
                cancel: 'No'
            });;

        <?php } ?>
        // $('.input-group.date').datepicker({
        //     todaybtn: "linked",
        //     keyboardNavigation: false,
        //     forceParse: false,
        //     calendarWeeks: true,
        //     autoclose: true,
        //     //startDate: new Date()
        // });

        // Given a string in m/d/y format, return a Date
        function parseMDY(s) {
            var b = s.split(/\D/);
            return new Date(b[2], b[0] - 1, b[1]);
        }

        // Given a Date, return a string in m/d/y format
        function formatMDY(d) {
            function z(n) {
                return (n < 10 ? '0' : '') + n
            }
            if (isNaN(+d)) return d.toString();
            return z(d.getMonth() + 1) + '/' + z(d.getDate()) + '/' + d.getFullYear();
        }

        // Given a string in m/d/y format, return a string in the same format with n days added
        function addDays(s, days) {
            var d = parseMDY(s);
            d.setDate(d.getDate() + Number(days));
            return formatMDY(d);
        }

        if ($("#apartment_id").val() > 0) {

            //$("#statement").show();
            $("#apartment_form input, textarea").prop("readonly", true);
            $("#apartment_form select").prop("disabled", true);
            $("#btn-save").hide();

            $("#btn-break-gen").show();
            $("#btn-edit").show();

            $("#btn-edit").click(function() {
                $("#btn-save").show();
                console.log("clicked");
                $(this).hide();
                $(".btn-remove-row").show();
                $(".remove-file").show();
                $("#apartment_form input, textarea").prop("readonly", false);
                $("#apartment_form select").prop("disabled", false);
                $("#btn-save").show();
            });
        } else {
            $("#btn-edit").hide();

            $("#btn-print").hide();
        }


        $(document).on("click", ".btn-remove-row", function() {
            $("#sp-tenant").hide();
            $("#sp-tenant").html("");
            $("#inp-tenant").val("");
            $("#inp-tenant").show();
            $("#tenant").val("");
        });
        var settings = {
            ignore: "",
            invalidHandler: function(form, validator) {
                set_feedback( 'error', "Error: Please correct all the required fields", true);
            },
            submitHandler: function(form) {
                console.log("making ajax call");
                $(form).ajaxSubmit({
                    success: function(response) {

                        post_apartment_form_submit(response);

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
                apartmentName: "required",
                amount: "required",
                payment_date: {
                    required: true,
                    date: true
                },
                "inp-tenant": "required"
            },
            messages: {
                // account: "Please select a tenant",
                // amount: "apartment amount can not be 0",
                // "inp-tenant": "Please select a tenant"
            }
        };

        $('#apartment_form').validate(settings);

        function post_apartment_form_submit(response) {

            if (!response.success) {
                set_feedback( 'success', response.message, true);
            } else {
                set_feedback( 'error', response.message, true);
            }

            $('#apartment_form').attr("action", "<?= site_url(); ?>/apartments/save/" + response.apartmentID);
        }

        // $("#btn-save").click(function() {
        //     console.log("Save button clicked");
        //     $("#apartment_form").submit();

        // });

    });
</script>