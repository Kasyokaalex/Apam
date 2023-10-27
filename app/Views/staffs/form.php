<?= view("partial/header"); ?>

<link href="css/plugins/iCheck/custom.css" rel="stylesheet">



    <?= form_open('/staffs/save/' .$staffID, array('id' => 'staff_form', 'class' => 'form-horizontal')); ?>



        <div class="row">
            <div class="col-lg-12">
                <div class="inqbox float-e-margins">
                    <div class="inqbox-title">
                        <h5>
                            User login info
                        </h5>
                        <div class="inqbox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="inqbox-content">
                        <br />

                        <div class="row">
                        <div class="col-4 form-group">
                            <label class="form-label">Username</label>
                            <div class="">

                                <input type="text" name="username" id="username" class="form-control" value="<?= $staff_info? $staff_info->username:'' ?>" />
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-label">First Name</label>
                            <div class="">

                                <input type="text" name="firstName" id="username" class="form-control" value="<?= $staff_info? $staff_info->firstName:'' ?>" />
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-label">Last Name</label>
                            <div class="">

                                <input type="text" name="lastName" id="username" class="form-control" value="<?= $staff_info? $staff_info->lastName:'' ?>" />
                            </div>
                        </div>
                        </div>
                        <div class="row">

                        <div class="col-4 form-group">
                            <label class="form-label">Email</label>
                            <div class="">

                                <input type="text" name="email" id="username" class="form-control" value="<?= $staff_info? $staff_info->email :'' ?>" />
                            </div>
                        </div>
                        <div class="col-4 form-group">
                            <label class="form-label">ID Number</label>
                            <div class="">

                                <input type="text" name="idNumber" id="username" class="form-control" value="<?= $staff_info? $staff_info->idNumber:'' ?>" />
                            </div>
                        </div>
                        

                        </div>


                        <?php
                        $password_label_attributes = $staffID == "" ? array('class' => 'required') : array();
                        ?>
                        <div class="row">

                        <div class="col-4 form-group">
                            <label class="form-label"><?= form_label('Password :', 'password', $password_label_attributes); ?></label>
                            <div class="">
                                <input class="form-control" type="password" name="password" id="password" />
                            </div>
                        </div>

                        <div class="col-4 form-group">
                            <label class="form-label">
                                <?= form_label('Confirm password :', 'repeat_password', $password_label_attributes); ?></label>
                            <div class="">
                                <input class="form-control" type="password" name="repeat_password" id="repeat_password" />
                            </div>
                        </div>
                        </div>
                        

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="row">
        <div class="form-group">
            <div class="text-center">
                <button type="submit" name="submit" id="submit" class="btn btn-sm btn-primary" style="margin-left: 90%;">Save changes</button>
            </div>
        </div>

    </div>



<?php
echo form_close();
?>

<div id="feedback_bar"></div>

<?= view("partial/footer"); ?>

<script src="js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url(); ?>js/people.js?v=<?= time(); ?>"></script>

<script type="text/javascript">
    $(document).on("click", ".remove", function() {
        $(this).parent().parent().remove();
    });

    $(document).ready(function() {
        
        var settings = {
            submitHandler: function(form) {
                $("#submit").prop("disabled", true);
                $(form).ajaxSubmit({
                    success: function(response) {

                        post_person_form_submit(response);

                        $("#submit").prop("disabled", false);
                    },
                    error: function(response) {

                        // console.log(response)
                    },
                    dataType: 'json',
                    type: 'post'
                });

            },
            rules: {
                firstName: "required",
                lastName: "required",
                idNumber: "required",
                email: "required",
                username: "required",
                password: {
                    required: function(element) {
                        return $("#staffID").val() == "";
                    }
                },
                repeat_password: {
                    equalTo: "#password"
                }
            },
            messages: {
                firstName: "This field is required!",
                lastName: "This field is required!",
                idNumber: "This field is required!",
                email: "required",
                username: "This field is required!",
                password: "This field is required!",
                repeat_password: "This field is required!"" 
            }
        };

      

        $('#staff_form').validate(settings);

        $('#staff_category_form').validate(category_settings);

        function post_person_form_submit(response) {

            if (!response.success) {
                set_feedback(response.message, 'error_message', false);
            } else {
                set_feedback(response.message, 'success_message', true);
            }

        }
    });
</script>