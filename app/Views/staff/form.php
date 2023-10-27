<?=View("partial/header"); ?>

<link rel="stylesheet" href="<?=base_url()?>/public/css/choices.min.css">
<script src="<?=base_url()?>/public/js/choices.min.js"></script>

<?=form_open(base_url().'/staff/save', array('id'=> 'staff_form', 'class'=> 'flex-grow-1 d-flex flex-column')); ?>

<input type="hidden" id="staffID" name="staffID" value="<?=$staffID  ?>" />

<div class="row flex-grow-1 m-0">
    <div class="col-md-9 inqbox">

        <div class="inqbox">

            <div class="inqbox-title">

                <h5>User basic information</h5>

                <?php if(isset($_POST['role'])){

                    $role = $_POST['role'];

                }

                ?>

                <div class="inqbox-tools">
                    
                    <span id="role" class="badge "></span>
                </div>

            </div>

            <div class="inqbox-content p-4">

            <div class="row" style="margin-top: 2em">

                <div class="col-sm-6">
                    <label for=""><label class="form-label"> Display Picture </label></label>
                    <div class="">
                    
                        <div id="container">
                            <a id="pickPhoto" href="javascript:;" class="" style="min-width: 100px; position: absolute;height: 120px"></a> 
                        </div>
                        
                        <input type="hidden" name="photo" id="photo">
                        
                        <img id="img-pic" src="<?=base_url() ?>/public/imgs/80x80.png" style="height:120px" />
                        <div id="filelist"></div>
                        <div id="progress" class="overlay"></div>

                        <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                            <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">

                            </div>                                    
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">                    

                    <div class="form-group">

                        <label class=" form-label"><?=form_label('First name ', 'firstName', array('class'=> 'required')); ?></label>
                        <div class="">
                            <input type="text" name="firstName" id="firstName" class="form-control" value="" autocomplete="nop">
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px">

                        <label class=" form-label"><?=form_label('Last name ', 'lastName', array('class'=> 'required')); ?></label>
                        <div class="">
                            <input type="text" name="lastName" id="lastName" class="form-control" value="" autocomplete="nop">
                        </div>
                    </div>
                </div>
                </div>

                <hr/>

                <div class="row">

                    <div class="col-sm-6 form-group">

                        <label class="form-label"><?=form_label('Phone Number ', 'phone', array('class'=> 'required')); ?></label>
                        <div class="">
                            <input type="text" name="phone" id="phone" class="form-control" value="" autocomplete="nop">
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">

                        <label class="form-label"><?=form_label('Email Address ', 'email'); ?></label>
                        <div class="">
                            <?=form_input(['name'=> 'email','id'=> 'email','autocomplete'=> "nop",'placeholder'=> "e.g. kelvin@shoman.com",'class'=> 'form-control'] ); ?>
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">

                        <label class="form-label"><?=form_label( 'ID /Passport No ', 'IDNumber', ['class'=> 'required']); ?></label>

                        <div class="">
                            <input type="text" name="IDNumber" id="IDNumber" class="form-control" value="" autocomplete="nop">
                        </div>

                    </div>      
                    <div class="col-sm-6 form-group" style="margin-top: 30px">
                        
                        <div class="form-check d-flex">
                            <div class="material-switch">
                                <input class="form-check-input" type="checkbox" name ="systemUser" id="systemUserCheck">
                                <label class="form-check-label" for="systemUserCheck">
                                    <span class="handle"></span>
                                    <span class="check-label"></span>
                                </label>
                            </div>
                            <h4 class="ps-3 mt-2"> Active System User</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="inqbox full-height d-flex flex-column">

            <div class="inqbox-title"><h5>Security Credentials</h5></div>

            <div class="inqbox-content p-3 flex-grow-1">
            
                <div class="form-group">          
                                
                    <label class="form-label"><?=form_label('User Role ', 'role', ['class'=> 'required']); ?></label>
                            
                    <select name="role" class="form-control" id="roleSelect">

                        <option value="user" >Basic User / Cashier</option>
                        <option value="mgmt" >Management</option>
                        <option value="admin" >Administator</option>

                    </select>
                </div>
                
                <div class="form-group">                    

                    <label class="form-label"><?=form_label('Username ', 'username'); ?></label>
                    <div class="">
                        <?=form_input(
                                array('name'=> 'username','id'=> 'username','class'=> 'form-control',
                                    "autocomplete" => "nop",
                                    // 'value'=> $staffData->username
                                )
                        );
                        ?>
                    </div>
                </div>

                <div class="form-group">

                    <label class="form-label"><?=form_label('Password (8+ chars ) ', 'password', ['class'=> 'required']); ?></label>
                    <div class="">
                        <?=form_password(array('name'=> 'password','id'=> 'password','class'=> 'form-control','placeholder'=> '')); ?>
                    </div>
                </div>

                <div class="form-group">

                    <label class="form-label"><?=form_label('Confirm password :', 'repeat_password', ['class'=> 'required']); ?></label>
                    <div class="">
                        <?=form_password(array('name'=> 'repeat_password','id'=> 'repeat_password','class'=> 'form-control')); ?>
                    </div>
                </div>

                <p>Use a simple password while creating a user account. The owner will set a strong password afterwards.</p>

            </div>

            <div class="p-3">

                <div>
                <?php if ((int) $staffID > -1) { ?>
                        <button type="button" class="btn btn-primary btn-edit" style="margin-right: 10px;"> <span class="fi fi-sr-pencil"></span> &nbsp; Edit</button>
                        <?php } else { ?>
                    
                        <button class="btn btn-purple btn-save" type="submit" name="submit btn-save" style="margin-right: 10px;"> Create</button>
                        <?php } ?>
                        
                    <a class="btn btn-default" href="<?=base_url() ?>/staff"> <span class="fi fi-sr-arrow-left"></span> &nbsp; back</a>

                </div>
            </div>

        </div>
    </div>
</div>

<?=form_close(); ?>

<?=View("partial/footer"); ?>
<script>
var settings = {
            ignore: "",
            invalidHandler: function(form, validator) {
                set_feedback( 'error', "Error: Please correct all the required fields", true);
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {

                        post_staff_form_submit(response);

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
                firstName: "required",
                lastName: "required",
                phone: "required",
                IDNumber: "required",
                role: "required",
                username: "required",
                password: "required",
                repeat_password: {
                    equalTo: "#password"
                }


            },
            messages: {
                firstName: "required",
                lastName: "required",
                phone: "required",
                IDNumber: "required",
                role: "required",
                username: "required",
                password: "required",
                repeat_password: {
                    equalTo: "Passwords do not match"
                }

            }
        };

        $('#staff_form').validate(settings);

        function post_staff_form_submit(response) {

            if (!response.success) {
                set_feedback( 'success', response.message, true);
            } else {
                set_feedback( 'error', response.message, true);
            }

            $('#staff_form').attr("action", "<?= site_url(); ?>/staff/save/" + response.staffID);
        }
</script>