<?= View("partial/header"); ?>

<?= form_open('tenants/save/' . $tenantID, array('id' => 'tenant_form', 'class' => 'form-horizontal')); ?>
<input type="hidden" id="tenant_id" value="<?= $tenantID ?>" />
<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">

                <ol class="breadcrumb">
                    <li>
                        <a href="<?= site_url(); ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?= site_url("tenants"); ?>"><?= ucwords('tenants'); ?></a>
                    </li>
                    <li class="active">
                        <strong>Add</strong>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    tenants basic information
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">

                <div class="tabs-container">

                    <ul class="nav nav-pills">

                        <?php if ($tenantID > -1) { ?>

                            <li class="active"><a data-bs-toggle="tab" href="#sectionB">Payment History</a></li>

                        <?php  } ?>

                        <li class="<?= ($tenantID == -1) ? 'active' : '' ?>"><a data-bs-toggle="tab" href="#sectionA">Personal Information</a></li>

                    </ul>

                    <hr>

                    <div class="tab-content">

                        <div id="sectionA" class=" <?= ($tenantID == -1) ? 'active' : '' ?>" style="padding-top: 2em">

                            <div style="text-align: center">
                                <div id="required_fields_message">Please input all the required fields</div>
                                <ul id="error_message_box"></ul>
                            </div>
                            <div class="row" style="margin-top: 2em">

                                <div class="col-sm-5">
                                <label class="form-label">
                                    <label for="logo" class="wide">Passport Photo :</label>
                                </label>
                                <div>

                                        <img id="img-pic" src="" style="height:99px; object-fit:contain">
                                        <div id="filelist"></div>
                                        <div id="progress" class="overlay"></div>
                                        <div id="container" style="position: relative;">
                                        <div id="html5_1hdgernngp85t8f1msspqkvfb3_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 6px; left: 0px; width: 120px; height: 34px; overflow: hidden; z-index: 0;"><input id="html5_1hdgernngp85t8f1msspqkvfb3" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept="image/jpeg,image/gif,image/png,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,.csv,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf"></div></div>

                                    </div>
                                    
                                    <div class="col-sm-7">

                                        <div id="filelist"></div>
                                        <div id="progress" class="overlay"></div>

                                        <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                                            <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">

                                            </div>
                                        </div>

                                        <div id="container">
                                            <?php if ($tenant_info && $tenant_info->tenantID) : ?>
                                                <a id="pickfiles" href="javascript:;" class="btn btn-sm btn-info" style="min-width: 100px;" data-person-id="<?= $tenant_info->tenantID; ?>">Browse</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-7" style="padding: 0">

                                    <div class="form-group" style="padding-top: 1em">

                                        <label class="col-sm-3 control-label"><?= form_label('First name ', 'first_name', array('class' => 'required')); ?></label>
                                        <div class="col-sm-9" style="padding: 0">
                                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $tenant_info ? $tenant_info->firstName : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <label class="col-sm-3 control-label"><?= form_label('Last name ', 'last_name', array('class' => 'required')); ?></label>
                                        <div class="col-sm-9" style="padding: 0">

                                            <input type="text" name="last_name" id="lastName" class="form-control" value="<?= $tenant_info ? $tenant_info->lastName : '' ?>">

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr />
                            <div class="row">

                            <div class="col-6 form-group">
                                <label class="form-label"><?= form_label('Email  ', 'email'); ?></label>
                                <div class="">
                                    <input type="text" name="email" id="email" class="form-control" value="<?= $tenant_info ? $tenant_info->emailAddress : '' ?>">
                                </div>
                            </div>
                            <div class="col-6 form-group">

                                <label class="form-label"><?= form_label('ID /Passport No', 'id_number'); ?></label>
                                <div class="">

                                <input type="text" name="id_number" id="id_number" class="form-control" value="<?= $tenant_info ? $tenant_info->IDNumber : '' ?>">

                                </div>
                            </div>



                            <div class="col-6 form-group">

                                <label class="form-label"><?= form_label('Phone number', 'id_number'); ?></label>
                                <div class="">

                                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?= $tenant_info ? $tenant_info->phoneNumber : '' ?>">

                                </div>
                            </div>

                            <div class="col-6 form-group">
                             <label class="form-label"><?= form_label('Home Address', 'home_address'); ?></label>
                                <div class="">

                                    <input type="text" name="home_address" id="home_address" class="form-control" value="<?= $tenant_info ? $tenant_info->homeAddress : '' ?>">
                                </div>
                            </div>

                            <div class="col-6 form-group">

                                <label class="form-label"><?= form_label('Physical / Business location:', 'physical_address'); ?></label>
                                <div class="">

                                    <input type="text" name="physical_address" id="physical_address" class="form-control" value="<?= $tenant_info ? $tenant_info->homeAddress : '' ?>">

                                </div>
                            </div>

                            <div class="col-6 form-group">
                                <label class="form-label"><?= form_label('Business / Employer', 'employer'); ?></label>
                                <div class="">
                                    <input type="text" name="employer" id="employer" class="form-control" value="<?= $tenant_info ? $tenant_info->occupation : '' ?>">
                                </div>
                            </div>

                        <div class="col-6 form-group">
                            <label class="form-label">Occupation </label>
                            <div class="">
                                <input type="text" name="occupation" id="occupation" class="form-control" value="<?= $tenant_info ? $tenant_info->occupation : '' ?>">
                            </div>
                        </div>

                        <div class="col-6 form-group">
                        <label class="form-label">Monthly Income </label>
                            <div class="">
                                <input type="text" name="income" id="income" class="form-control" value="<?= $tenant_info ? $tenant_info->occupation : '' ?>">

                            </div>
                        </div>

                    </div>

                    <!-- <?php if ($tenantID > -1) { ?>

                        <div id="sectionB" class="" style="padding-top: 2em">

                            <p class="small text-center">The tenants apartment history has been as follows</p>

                            <table class="table table-bordered table-striped text-center" id="datatable">

                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 1%">#</th>
                                        <th>Principal</th>
                                        <th>Date issued</th>
                                        <th>Due date</th>
                                        <th>Latest payment</th>
                                        <th>Total Paid</th>
                                        <th>Payment status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>



                                </tbody>

                            </table>

                            <div class="text-center">

                                <a href="<?= base_url() ?>index.php/tenants/printIt/<?= $tenantID ?>" class="btn btn-sm btn-warning" id="btn-print"> <span class="fa fa-print"></span> &nbsp; Print History</a>

                            </div>


                        </div>

                    <?php  } ?> -->


                    <div class="row" style="padding: 2em">
                        <div class="form-group">
                            <div class="text-center">

                                <?php if ((int) $tenantID > -1) : ?>

                                    <button type="button" class="btn btn-sm btn-primary" id="btn-edit"> <span class="fa fa-pencil"></span> &nbsp; Edit</button>

                                <?php endif; ?>

                                <?php
                                $display = '';
                                if ($tenantID > -1) {
                                    $display = 'display: none';
                                }
                                ?>

                                <button type="submit" name="submit" style="display: <?= $display ?>" class="btn btn-info" id="btn-save"> Save Changes &nbsp; <span class="fa fa-save"></span></button>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?= form_close(); ?>



<script src="<?= base_url(); ?>js/people.js?v=<?= time(); ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var table = $("#datatable").DataTable({

            "fixedHeader": true,

            "columnDefs": [{
                "targets": [0, 7],
                "orderable": false
            }],

            "aLengthMenu": [
                [25, 50, 100, 200, 100000],
                [25, 50, 100, 200, "All"]
            ],

            "iDisplayLength": 25,

            "order": [],

            "dom": "<'row'<'col-sm-4 text-left'l><'col-sm-4 text-center'><'col-sm-4 text-right'f>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-5 text-left'i><'col-sm-7 text-right'p>>"
        });

        if ($("#tenant_id").val() > 0) {

            $("#tenant_form input, textarea").prop("disabled", true);

            $("#btn-edit").click(function() {
                $("#btn-save").show();
                $(this).hide();
                $("#tenant_form input, textarea").prop("disabled", false);
            });
        }



        $("#btn-del-row, #btn-del-row-g").click(function() {
            $('.select_').each(function() {
                if ($(this).is(":checked")) {
                    $(this).parent().parent().remove();
                }
            });
        });

        if ($("#tenant_id").val() > 0) {
            $(".btn-remove-row").hide();
            $(".remove-file").hide();

            //$("#statement").show();
            $("#btn-add-row, #btn-add-row-g").prop("disabled", true);
            $("#btn-del-row, #btn-del-row-g").prop("disabled", true);
            $("#btn-save").hide();

            $("#btn-break-gen").show();
            $("#btn-edit").show();
            $("#btn-print").show();

            $("#btn-edit").click(function() {
                $("#btn-save").show();
                $(this).hide();
                $(".btn-remove-row").show();
                $(".remove-file").show();
                $("#btn-add-row, #btn-add-row-g").prop("disabled", false);
                $("#btn-del-row, #btn-del-row-g").prop("disabled", false);
                $("#btn-save").show();
            });
        } else {
            $("#btn-edit").hide();

            $("#btn-print").hide();
        }

        $(document).on("click", ".btn-remove-row", function() {
            //console.log("clicked");
            $("#sp-tenant").hide();
            $("#sp-tenant").html("");
            $("#inp-tenant").val("");
            $("#inp-tenant").show();
            $("#tenant").val("");
        });

        var settings = {
            submitHandler: function(form) {
                $("#btn-save").prop("disabled", true);
                $(form).ajaxSubmit({
                    success: function(response) {

                        post_person_form_submit(response);
                        $("#submit").prop("disabled", false);

                        // console.log(response)
                    },
                    error: function(response) {

                        // console.log(response)
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                first_name: "required",
                last_name: "required",
                email: "email"
            },
            messages: {
                first_name: "First name is required",
                last_name: "Last name is required",
                email: "Please enter a valid email address"
            }
        };

        $('#tenant_form').validate(settings);

        function post_person_form_submit(response) {
            if (!response.success) {
                set_feedback(response.message, 'error_message', true);
            } else {
                set_feedback(response.message, 'success_message', false);
            }

            $("#tenant_form").attr("action", "<?= site_url(); ?>/tenants/save/" + response.personID);
        }


        <?php if (isset($pdf_file)) { ?>

            alertify.confirm("tenant Statement", "<span style='font-size:40px;position:absolute;top:55px' class='lnr lnr-checkmark-circle'></span> <span style='margin-left:55px'>Your file has been saved. Would you like to view it?</span>",

                function() {

                    window.open("<?= $pdf_file ?>", "_blank");

                    //alertify.success('Yes');

                },
                function() {

                    window.location.href = 'tenants';
                    //alertify.error('No');

                }).set('labels', {
                ok: 'Yes',
                cancel: 'No'
            });;

        <?php } ?>
    });
</script>