<div class="row" style="margin-top: 2em">

    <div class="col-sm-5">
        <label class="col-sm-5 control-label">
            Passport Photo :
        </label>
        <div class="col-sm-7">

            <div id="filelist"></div>
            <div id="progress" class="overlay"></div>

            <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">

                </div>
            </div>

            <div id="container">
                <a id="pickfiles" href="javascript:;" class="btn btn-sm btn-info" style="min-width: 100px;" data-person-id="<?= $person_info->tenantID; ?>">Browse</a>
            </div>
        </div>
    </div>

    <div class="col-sm-7" style="padding: 0">

        <div class="form-group" style="padding-top: 1em">

            <label class="col-sm-3 control-label"><?= form_label('First name ', 'first_name', array('class' => 'required')); ?></label>
            <div class="col-sm-9" style="padding: 0">
                <input type="text" name="first_name" id="first_name" class="form-control" value="<?= $person_info->firstName ?>">
            </div>
        </div>
        <div class="form-group">

            <label class="col-sm-3 control-label"><?= form_label('Last name ', 'last_name', array('class' => 'required')); ?></label>
            <div class="col-sm-9" style="padding: 0">
                <?php
                echo form_input(
                    array(
                        'name' => 'last_name',
                        'id' => 'last_name',
                        'value' => $person_info->lastName,
                        'class' => 'form-control'
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>

<hr />


<div class="row" style="padding-top: 2em">
    <label class="col-sm-2 control-label"><?= form_label('Email  :', 'email'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
            array(
                'name' => 'email',
                'id' => 'email',
                'value' => $person_info->emailAddress,
                'class' => 'form-control'
            )
        );
        ?>
    </div>
    <label class="col-sm-2 control-label"><?= form_label('ID /Passport No:', 'id_number'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
            array(
                'name' => 'id_number',
                'id' => 'id_number',
                'value' => $person_info->IDNumber,
                'class' => 'form-control'
            )
        );
        ?>
    </div>
</div>



<div class="row">

    <label class="col-sm-2 control-label"><?= form_label('Phone number:', 'id_number'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
            array(
                'name' => 'phone_number',
                'id' => 'phone_number',
                'value' => $person_info->phoneNumber,
                'class' => 'form-control'
            )
        );
        ?>
    </div>

    <label class="col-sm-2 control-label"><?= form_label('Home Address:', 'home_address'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
            array(
                'name' => 'home_address',
                'id' => 'home_address',
                'value' => $person_info->homeAddress,
                'class' => 'form-control'
            )
        );
        ?>
    </div>
</div>

<div class="row">

    <label class="col-sm-2 control-label"><?= form_label('Physical / Business location:', 'physical_address'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
            array(
                'name' => 'physical_address',
                'id' => 'physical_address',
                'value' => $person_info->homeAddress,
                'class' => 'form-control'
            )
        );
        ?>
    </div>

    <label class="col-sm-2 control-label"><?= form_label('Business / Employer:', 'employer'); ?></label>
    <div class="col-sm-4">
        <?php
        echo form_input(
            array(
                'name' => 'employer',
                'id' => 'employer',
                'value' => $person_info->occupation,
                'class' => 'form-control'
            )
        );
        ?>
    </div>
</div>