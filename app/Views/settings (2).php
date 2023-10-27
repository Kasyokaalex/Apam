<?= View("partial/header"); ?>

<div class="row tabs-container flex-grow-1" style="padding-bottom: 1em">

<div class="col-lg-3">

<div class="inqbox full-height float-e-margins">

    <div class="inqbox-content" style="border-radius: 0 5px 5px 0">

        <div class="tabs-container">

            <ul class="nav nav-pills secondary-nav" style="padding: 0 0 4em 0em; display:grid">

                <li class="active">
                    <a data-toggle="tab" href="#tab-info">Company Information</a>
                </li>

                <li><a data-toggle="tab" href="#tab-depts">Departments</a></li>

                <li><a data-toggle="tab" href="#tab-payment_modes">Payment Methods</a></li>

                <!-- <li class="">
                    <a data-toggle="tab" href="#tab-taxation">Taxation</a>
                </li> -->

                <li class="">
                    <a data-toggle="tab" href="#tab-stores">Stores/ Outlets</a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab-prefs">Preferences</a>
                </li>

            </ul>
        </div>

    </div>
</div>
</div>

    <div class="col-lg-9" style="padding : 0">

        <div class="inqbox">

            <div class="inqbox-content" style="border-radius: 5px 0 0 5px">

                <div class="">

                    <div class="tab-content">

                        <div id="tab-info" class="tab-pane active">

                            <div class="inqbox-title">
                                <h5>Company Info</h5>
                            </div>

                            <?= form_open(base_url() . '/settings/save', array('id' => 'config_form', 'class' => 'p-4')); ?>

                            <div class="row">

                                <div class="col-sm-6">

                                    <label class="form-label"><?= form_label('Company logo :', 'logo', array('class' => 'wide')); ?></label>

                                    <div>

                                        <img id="img-pic" src="<?= (trim(Config('apamSettings')->logo) !== "") ? base_url("/public/uploads/logo/" . Config('apamSettings')->logo) : base_url("/public/uploads/common/no_img.png"); ?>" style="height:99px; object-fit:contain" />
                                        <div id="filelist"></div>
                                        <div id="progress" class="overlay"></div>

                                        <div class="progress progress-task" style="height: 4px; width: 120px; margin-bottom: 2px; display: none">
                                            <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar progress-bar-info">

                                            </div>
                                        </div>

                                        <div id="container">
                                            <a id="browsefile" href="javascript:;" class="btn btn-sm btn-info" style="min-width: 120px; margin-top: 6px">Browse</a>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-sm-6">

                                    <div class="form-group">

                                        <label class="form-label"><?= form_label('Company name ', 'company', array('class' => 'wide required')); ?></label>

                                        <div class="">
                                            <?=form_input(
                                                array(
                                                    'name' => 'company',
                                                    'id' => 'company',
                                                    'value' => config('apamSettings')->company,
                                                    'class' => 'form-control'
                                                )
                                            );
                                            ?>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label class=" form-label"><?= form_label('Phone number(s) ', 'phone', array('class' => 'wide required')); ?></label>
                                        <div class="">
                                            <?=form_input(
                                                array(
                                                    'name' => 'phone',
                                                    'id' => 'phone',
                                                    'value' => config('apamSettings')->phone,
                                                    'class' => 'form-control phone'
                                                )
                                            );
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="row py-3">

                                <div class="col-sm-6 form-group">

                                    <label class="form-label"><?= form_label('Postal Address ', 'postal_address', array('class' => 'wide required')); ?></label>
                                    <div class="">
                                        <?=form_input(
                                            array(
                                                'name' => 'address',
                                                'id' => 'address',
                                                'value' => config('apamSettings')->address,
                                                'class' => 'form-control'
                                            )
                                        );
                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-6 form-group">

                                    <label class="form-label"><?= form_label('Currency ', 'currency_symbol', array('class' => 'wide required')); ?></label>
                                    
                                    <select class="form-control" name="currency_symbol" id="currency">
                                    
                                        <?php foreach ($currencies as $currency) { ?>
                                                                                
                                            <option value="<?=$currency->currency ?>" <?=($currency->code == 'KE') ? "selected" : "" ?>> <?=$currency->currency." - ". $currency->country ?> </option>
                                            
                                        <?php } ?>
                                        
                                    </select>
                                </div>

                                <div class="col-sm-6 form-group">

                                    <label class="form-label"><?= form_label('Website ', 'website', array('class' => 'wide required')); ?></label>
                                    <div class="">
                                        <?=form_input(
                                            array(
                                                'name' => 'website',
                                                'id' => 'website',
                                                'value' => config('apamSettings')->website,
                                                'class' => 'form-control'
                                            )
                                        );
                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-6 form-group">

                                    <label class="form-label"><?= form_label('Email ', 'email', array('class' => 'wide required')); ?></label>
                                    <div class="">
                                        <?=form_input(
                                            array(
                                                'name' => 'email',
                                                'id' => 'email',
                                                'value' => config('apamSettings')->email,
                                                'class' => 'form-control'
                                            )
                                        );
                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-6 form-group">

                                    <label class="form-label"><?php echo form_label('Language ', 'language', array('class' => 'wide required')); ?></label>

                                    <div class="">

                                        <?= form_dropdown('language', array('en' => 'English'), Config('apamSettings')->language, "class='form-control'");
                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-4 form-group">

                                    <label class="form-label"><?= form_label('Timezones ', 'timezone', array('class' => 'wide required')); ?></label>

                                    <div class="">
                                        <?= form_dropdown('timezone', array(
                                            'Pacific/Midway' => '(GMT-11:00) Midway Island, Samoa',
                                            'America/Adak' => '(GMT-10:00) Hawaii-Aleutian',
                                            'Etc/GMT+10' => '(GMT-10:00) Hawaii',
                                            'Pacific/Marquesas' => '(GMT-09:30) Marquesas Islands',
                                            'Pacific/Gambier' => '(GMT-09:00) Gambier Islands',
                                            'America/Anchorage' => '(GMT-09:00) Alaska',
                                            'America/Ensenada' => '(GMT-08:00) Tijuana, Baja California',
                                            'Etc/GMT+8' => '(GMT-08:00) Pitcairn Islands',
                                            'America/Los_Angeles' => '(GMT-08:00) Pacific Time (US & Canada)',
                                            'America/Denver' => '(GMT-07:00) Mountain Time (US & Canada)',
                                            'America/Chihuahua' => '(GMT-07:00) Chihuahua, La Paz, Mazatlan',
                                            'America/Dawson_Creek' => '(GMT-07:00) Arizona',
                                            'America/Belize' => '(GMT-06:00) Saskatchewan, Central America',
                                            'America/Cancun' => '(GMT-06:00) Guadalajara, Mexico City, Monterrey',
                                            'Chile/EasterIsland' => '(GMT-06:00) Easter Island',
                                            'America/Chicago' => '(GMT-06:00) Central Time (US & Canada)',
                                            'America/New_York' => '(GMT-05:00) Eastern Time (US & Canada)',
                                            'America/Havana' => '(GMT-05:00) Cuba',
                                            'America/Bogota' => '(GMT-05:00) Bogota, Lima, Quito, Rio Branco',
                                            'America/Caracas' => '(GMT-04:30) Caracas',
                                            'America/Santiago' => '(GMT-04:00) Santiago',
                                            'America/La_Paz' => '(GMT-04:00) La Paz',
                                            'Atlantic/Stanley' => '(GMT-04:00) Faukland Islands',
                                            'America/Campo_Grande' => '(GMT-04:00) Brazil',
                                            'America/Goose_Bay' => '(GMT-04:00) Atlantic Time (Goose Bay)',
                                            'America/Glace_Bay' => '(GMT-04:00) Atlantic Time (Canada)',
                                            'America/St_Johns' => '(GMT-03:30) Newfoundland',
                                            'America/Araguaina' => '(GMT-03:00) UTC-3',
                                            'America/Montevideo' => '(GMT-03:00) Montevideo',
                                            'America/Miquelon' => '(GMT-03:00) Miquelon, St. Pierre',
                                            'America/Godthab' => '(GMT-03:00) Greenland',
                                            'America/Argentina/Buenos_Aires' => '(GMT-03:00) Buenos Aires',
                                            'America/Sao_Paulo' => '(GMT-03:00) Brasilia',
                                            'America/Noronha' => '(GMT-02:00) Mid-Atlantic',
                                            'Atlantic/Cape_Verde' => '(GMT-01:00) Cape Verde Is.',
                                            'Atlantic/Azores' => '(GMT-01:00) Azores',
                                            'Europe/Belfast' => '(GMT) Greenwich Mean Time : Belfast',
                                            'Europe/Dublin' => '(GMT) Greenwich Mean Time : Dublin',
                                            'Europe/Lisbon' => '(GMT) Greenwich Mean Time : Lisbon',
                                            'Europe/London' => '(GMT) Greenwich Mean Time : London',
                                            'Africa/Abidjan' => '(GMT) Monrovia, Reykjavik',
                                            'Europe/Amsterdam' => '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
                                            'Europe/Belgrade' => '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague',
                                            'Europe/Brussels' => '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris',
                                            'Africa/Algiers' => '(GMT+01:00) West Central Africa',
                                            'Africa/Windhoek' => '(GMT+01:00) Windhoek',
                                            'Asia/Beirut' => '(GMT+02:00) Beirut',
                                            'Africa/Cairo' => '(GMT+02:00) Cairo',
                                            'Asia/Gaza' => '(GMT+02:00) Gaza',
                                            'Africa/Blantyre' => '(GMT+02:00) Harare, Pretoria',
                                            'Asia/Jerusalem' => '(GMT+02:00) Jerusalem',
                                            'Europe/Minsk' => '(GMT+02:00) Minsk',
                                            'Asia/Damascus' => '(GMT+02:00) Syria',
                                            'Europe/Moscow' => '(GMT+03:00) Moscow, St. Petersburg, Volgograd',
                                            'Africa/Addis_Ababa' => '(GMT+03:00) Nairobi',
                                            'Asia/Tehran' => '(GMT+03:30) Tehran',
                                            'Asia/Dubai' => '(GMT+04:00) Abu Dhabi, Muscat',
                                            'Asia/Yerevan' => '(GMT+04:00) Yerevan',
                                            'Asia/Kabul' => '(GMT+04:30) Kabul',
                                            'Asia/Baku' => '(GMT+05:00) Baku',
                                            'Asia/Yekaterinburg' => '(GMT+05:00) Ekaterinburg',
                                            'Asia/Tashkent' => '(GMT+05:00) Tashkent',
                                            'Asia/Kolkata' => '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi',
                                            'Asia/Katmandu' => '(GMT+05:45) Kathmandu',
                                            'Asia/Dhaka' => '(GMT+06:00) Astana, Dhaka',
                                            'Asia/Novosibirsk' => '(GMT+06:00) Novosibirsk',
                                            'Asia/Rangoon' => '(GMT+06:30) Yangon (Rangoon)',
                                            'Asia/Bangkok' => '(GMT+07:00) Bangkok, Hanoi, Jakarta',
                                            'Asia/Krasnoyarsk' => '(GMT+07:00) Krasnoyarsk',
                                            'Asia/Hong_Kong' => '(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi',
                                            'Asia/Irkutsk' => '(GMT+08:00) Irkutsk, Ulaan Bataar',
                                            'Australia/Perth' => '(GMT+08:00) Perth',
                                            'Australia/Eucla' => '(GMT+08:45) Eucla',
                                            'Asia/Tokyo' => '(GMT+09:00) Osaka, Sapporo, Tokyo',
                                            'Asia/Seoul' => '(GMT+09:00) Seoul',
                                            'Asia/Yakutsk' => '(GMT+09:00) Yakutsk',
                                            'Australia/Adelaide' => '(GMT+09:30) Adelaide',
                                            'Australia/Darwin' => '(GMT+09:30) Darwin',
                                            'Australia/Brisbane' => '(GMT+10:00) Brisbane',
                                            'Australia/Hobart' => '(GMT+10:00) Hobart',
                                            'Asia/Vladivostok' => '(GMT+10:00) Vladivostok',
                                            'Australia/Lord_Howe' => '(GMT+10:30) Lord Howe Island',
                                            'Etc/GMT-11' => '(GMT+11:00) Solomon Is., New Caledonia',
                                            'Asia/Magadan' => '(GMT+11:00) Magadan',
                                            'Pacific/Norfolk' => '(GMT+11:30) Norfolk Island',
                                            'Asia/Anadyr' => '(GMT+12:00) Anadyr, Kamchatka',
                                            'Pacific/Auckland' => '(GMT+12:00) Auckland, Wellington',
                                            'Etc/GMT-12' => '(GMT+12:00) Fiji, Kamchatka, Marshall Is.',
                                            'Pacific/Chatham' => '(GMT+12:45) Chatham Islands',
                                            'Pacific/Tongatapu' => '(GMT+13:00) Nuku\'alofa',
                                            'Pacific/Kiritimati' => '(GMT+14:00) Kiritimati'

                                        ), Config('apamSettings')->timezone ? Config('apamSettings')->timezone : date_default_timezone_get(), "class='form-control' id='timezone'");
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col-sm-12" style="padding-top: 20px;">

                                    <?=form_submit(
                                        array(
                                            'name' => 'submit',
                                            'type' => 'submit',
                                            'value' => 'Save changes',
                                            'class' => 'btn btn-purple btn-save'
                                        )
                                    );
                                    ?>

                                    <button type="button" class="btn btn-info btn-edit">Edit settings</button>

                                </div>
                            </div>

                            <?= form_close(); ?>

                        </div>


                        <div id="tab-payment_modes" class="tab-pane">

                            <div class="row-eq-height">

                                <div class="col-md-8">

                                    <div class="inqbox">

                                        <div class="inqbox-content">

                                            <div class="table-body g-0 p-3 ">
                                                <div class="col-md-12">
                                                    <table id="datatablePayments" class="table table-hover tableClickable deletableRows">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Icon</th>
                                                                <th>Method Name</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" style="border-left: 1px solid #eee; padding:0 2px 0 0">

                                    <div class="inqbox form-panel" style="display: none">

                                        <div class="inqbox-title" style="border: none;">

                                            <h5 style="padding: .7em">New Method</h5>
                                            <div class="inqbox-tools" style="padding: 0.5em 0; font-size: 1.3em;">
                                                <span style="cursor: pointer;" class="close-form fi fi-rr-cross-circle"></span>
                                            </div>
                                        </div>

                                        <div class="inqbox-content" style="padding: 0 1em;">

                                            <?= form_open(base_url() . '/settings/savePaymentMethod', 'class="form" id="paymentMethodForm"'); ?>

                                            <input id="methodID" type="hidden" name="methodID">

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Method Name ', 'name', array('class' => 'required')); ?></label>

                                                <?= form_input('name', '', "class='form-control' id='method-name' placeholder='eg. Bank, Mpesa Paybill...' required"); ?>
                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Description ', 'description', array('class' => 'required')); ?></label>


                                                <?= form_input('description', '', "class='form-control' id='description' placeholder='Account Number...' required"); ?>
                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><label class="required">Payment Icon </label></label>

                                                <div class="radio-tile-group icon-selector" style="padding: 1em 0">

                                                    <?php $payments_icons = ['smartphone', 'bank', 'briefcase', 'star', 'subtitles'];
                                                    $index = 0;
                                                    foreach ($payments_icons as $icon) { ?>

                                                        <div class="input-container tile">

                                                            <input class="radio-button radio-tile-fi-fi-sr-<?= $icon ?>" type="radio" value="fi fi-sr-<?=$icon ?>" name="icon" <?=($index == 1) ? "checked" : "" ?> />

                                                            <div class="radio-tile">
                                                                <label for="walk" class="radio-tile-label"><i class="fi fi-sr-<?= $icon ?>"></i></label>
                                                            </div>

                                                        </div>

                                                    <?php $index++;
                                                    } ?>
                                                </div>
                                            </div>

                                            <div class="form-group">

                                                <button class="btn btn-purple btn-save" type="submit" name="submit"> Save method</button>

                                                <button class="btn btn-info btn-edit" role="button"> Edit Method</button>

                                            </div>

                                            <?= form_close(); ?>

                                        </div>
                                    </div>

                                    <div class="inqbox add-new-panel">

                                        <div class="inqbox-content" style="height: 100%; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: center; ">

                                            <div class="text-center btn-add-new" style="background: #efefef; padding: 25px 0px 15px; border-radius: 10px; cursor: pointer">
                                                <span style="font-size: 27px;" class="fi fi-rr-add"></span> <br>
                                                <button class="btn btn-link">CREATE NEW</button>
                                                <p style="max-width: 170px;">Create a new Payment Method</p>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div id="tab-depts" class="tab-pane">

                            <div class="row-eq-height">

                                <div class="col-sm-12">

                                    <div class="inqbox">

                                        <div class="inqbox-title">
                                            <h5>Business Departments</h5>
                                            <button id="newDept" class="btn btn-purple btn-sm float-end">New Department </button>
                                        </div>

                                        <div class="inqbox-content">

                                            <div class="container-fluid">
                                                <div class="col-md-12" style="padding: 2em;">
                                                    <table id="datatableDepartments" class="table table-hover tableClickable deletableRows">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>#</th>
                                                                <th>Department Name</th>
                                                                <th>Expenses</th>
                                                                <th>Products</th>
                                                                <th>Services</th>
                                                                <th>Date Created</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- <div id="tab-taxation" class="tab-pane">

                            <div class="row-eq-height">

                                <div class="col-md-8">

                                    <div class="inqbox">

                                        <div class="inqbox-content">

                                            <div class="table-body g-0 p-3 ">
                                                <div class="col-md-12">
                                                    <table id="datatableTax" class="table table-hover tableClickable deletableRows">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Tax Name</th>
                                                                <th>Percentage</th>
                                                                <th>Description</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" style="border-left: 1px solid #eee; padding:0 2px 0 0">

                                    <div class="inqbox form-panel" style="display: none">

                                        <div class="inqbox-title" style="border: none;">
                                        
                                            <h5 style="padding: .7em">New Tax</h5>
                                            <div class="inqbox-tools" style="padding: 0.5em 0; font-size: 1.3em;">
                                                <span style="cursor: pointer;" class="close-form fi fi-rr-cross-circle"></span>
                                            </div>
                                        </div>

                                        <div class="inqbox-content" style="padding: 0 1em;">

                                            <?= form_open(base_url() . '/settings/saveTax', 'class="form" id="taxForm"'); ?>
                                            
                                            <input type="hidden" name="taxID" id="taxID">

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Tax Name ', 'name', array('class' => 'required')); ?></label>


                                                <?= form_input('name', '', "class='form-control' id='tax-name' placeholder='eg. VAT,...' required"); ?>
                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Taxation Mode ', 'tax-mode', array('class' => 'required')); ?></label>
                                                
                                                <div class="">
                                                    <?= form_dropdown('tax-mode', array('1' => "Inclusive", '0' => 'Exclusive'), '', 'class="form-control" id="tax-mode"') ?>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Percentage ', 'percentage', array('class' => 'required')); ?></label>

                                                <?= form_input('percentage', '', "class='form-control' id='percentage' placeholder='16%, ...' required"); ?>
                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Description ', 'description', array('class' => 'required')); ?></label>

                                                <?= form_textarea('description', '', "class='form-control' id='description' placeholder='Tax Description' rows='3' required"); ?>
                                            </div>

                                            <div class="form-group">
                                                
                                                <button class="btn btn-purple btn-save" type="submit" name="submit"> Save changes</button>
                                                <button class="btn btn-info btn-edit" role="button"> Edit Tax</button>

                                            </div>

                                            <?= form_close(); ?>
                                            
                                        </div>
                                    </div>
                                    
                                    <div class="inqbox add-new-panel">

                                        <div class="inqbox-content" style="height: 100%; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: center; ">

                                            <div class="btn-add-new text-center" style="background: #efefef; padding: 25px 0px 15px; border-radius: 10px; cursor: pointer">
                                                <span style="font-size: 27px;" class="fi fi-rr-add"></span> <br>
                                                <button class="btn btn-link">CREATE NEW</button>
                                                <p style="max-width: 170px;">Create a new Tax by percentage</p>
                                            </div>

                                        </div>
                                            
                                    </div>

                                </div>
                            </div>
                        </div> -->

                        <div id="tab-stores" class="tab-pane">

                            <div class="row-eq-height">

                                <div class="col-md-8">

                                    <div class="inqbox">

                                        <div class="inqbox-content">

                                            <div class="table-body g-0 p-3 ">
                                                <div class="col-md-12">
                                                    <table id="datatableStores" class="table table-hover tableClickable deletableRows">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Store Name</th>
                                                                <th>Physical Address</th>
                                                                <th>Phone Number</th>
                                                                <th>Creation Date</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4" style="border-left: 1px solid #eee; padding:0 2px 0 0">

                                    <div class="inqbox form-panel" style="display: none">

                                        <div class="inqbox-title" style="border: none;">

                                            <h5 style="padding: .7em 0">New Store/Outlet</h5>
                                            <div class="inqbox-tools" style="padding: 0.5em 0; font-size: 1.3em;">
                                                <span style="cursor: pointer;" class="close-form fi fi-rr-cross-circle"></span>
                                            </div>
                                        </div>

                                        <div class="inqbox-content" style="padding: 0 2em;">

                                            <?= form_open(base_url() . '/settings/saveStore', 'class="form" id="storeForm"'); ?>

                                            <input type="hidden" name="storeID" id="storeID" value="">

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Store Name ', 'storeName', array('class' => 'required')); ?></label>


                                                <?= form_input('storeName', '', "class='form-control' id='storeName' placeholder='Store/ Outlet Name,...' required"); ?>
                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Store Location', 'store-location', array('class' => 'required')); ?></label>

                                                <div class="">
                                                    <?= form_input('store-location', 'store-location', 'class="form-control" id="store-location" placeholder="Physical Address"') ?>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Phone number ', 'store-phone', array('class' => 'required')); ?></label>

                                                <?= form_input('store-phone', '', "class='form-control phone' id='store-phone' placeholder='e.g +2547...' required"); ?>
                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Store Email ', 'store-email', array('class' => 'required')); ?></label>

                                                <?= form_input('store-email', '', "class='form-control' id='store-email' placeholder='e.g +2547...' required"); ?>
                                            </div>

                                            <div class="form-group">

                                                <label class="form-label"><?= form_label('Country ', 'countryID', array('class' => 'required')); ?></label>

                                                <?php //form_dropdown('countryID', $countries, '254', "class='form-control' id='countryID' required"); 
                                                ?>
                                                <select class="form-control" name="countryID" id="country">

                                                    <option disabled value="">Select Country</option>

                                                    <?php foreach ($countries as $country) { ?>

                                                        <option value="<?= $country->code ?>"> <?= $country->name ?> </option>

                                                    <?php } ?>

                                                </select>
                                            </div>

                                            <div class="form-group">

                                                <button class="btn btn-purple btn-save" type="submit" name="submit"> Save changes</button>
                                                <button class="btn btn-info btn-edit" role="button"> Edit Store</button>

                                            </div>

                                            <?= form_close(); ?>

                                        </div>
                                    </div>

                                    <div class="inqbox add-new-panel">

                                        <div class="inqbox-content" style="height: 100%; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: center; ">

                                            <div class="btn-add-new text-center" style="background: #efefef; padding: 25px 0px 15px; border-radius: 10px; cursor: pointer">
                                                <span style="font-size: 27px;" class="fi fi-rr-add"></span> <br>
                                                <button class="btn btn-link">CREATE NEW</button>
                                                <p style="max-width: 170px;">Create a New Store with Location</p>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="tab-prefs" class="tab-pane">

                            <div class="row-eq-height">

                                <div class="col-md-12" style="padding: 2em;">
                                    
                                    <ul class="list-group">
                                        <?php foreach($preferences as $pref){ ?>
                                                                             
                                            <li class="list-group-item">
                                                <div class="material-switch float-end" style="padding: 18px;">
                                                    <input class="pref_switch" data-id="<?=$pref->prefID ?>" <?=in_array($pref->prefID, json_decode(config('apamSettings')->preferences))? 'checked':'' ?> id="<?=$pref->short_hand??'' ?>" name="<?=$pref->short_hand??'' ?>" type="checkbox"/>
                                                    <label for="<?=$pref->short_hand??'' ?>" class="label-default"></label>
                                                </div>
                                                <h4><?=$pref->title ?></h4>
                                                <p class="text-muted"><?=$pref->description ?></p>
                                            </li>
                                        <?php } ?>
                                        
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<!-- CATEGORIES MODAL -->

<div class="modal fade" id="departments_modal" role="dialog">
    <div class="modal-dialog" style="width: 6   50px;margin-top: 9em">
        <!-- Modal content-->
        <div class="modal-content">

            <form id="department_form" action="<?=base_url()?>/settings/saveDepartment">
            
                <input type="hidden" id="departmentID" name="departmentID" value=''>
            
                <div class="close"><span data-bs-dismiss="modal"><span class="fi fi-rr-cross-circle"></span></span></div>

                <div class="modal-body" id="my_modal" id="">

                    <div class="" style="margin: 0;">

                        <div style="padding: 1em;">

                            <div style="height: 20px;"></div>

                            <div>

                                <div class="container-fluid">
                                    <h4 class="">New Department</h4>
                                    <hr>
                                    <p style="margin-bottom: 2em">Departments help a business in defining and comparing business investment sectors.</p>

                                    <div class="form-group">

                                        <label class="form-label"><?= form_label('Department Name ', 'departmentName', array('class' => 'wide required')); ?></label>

                                        <?= form_input('departmentName', "", "class='form-control' id='departmentName' placeholder='e.g. Printing and Branding'"); ?>

                                    </div>
                                    
                                                
                                    <div class="form-group float-end">
                                    
                                        <button class="btn btn-outline btn-edit" style="display:none">Edit Department</button>
                                        
                                        <button type="submit" class="btn btn-purple btn-save">save Department</button>
                                        
                                        <button class="btn btn-danger btn-cancel" style="display:none">Cancel</button>

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


<?= View("partial/footer"); ?>

<script type="text/javascript" src="<?= base_url(); ?>/public/js/settings.js"></script>

<script src="<?=base_url(); ?>public/js/choices.min.js"></script>
<link rel="stylesheet" href="<?=base_url(); ?>public/css/choices.min.css"/>

<link rel="stylesheet" href="<?=base_url() ?>public/css/intlTelInput.min.css">
<style type="text/css">.iti{display:block} .iti input{padding-left: 94px !important;}</style>
<script src="<?=base_url() ?>public/js/intlTelInput.min.js"></script>


<script type='text/javascript'>
    //validation and submit handling
    $(document).ready(function() {
        
        var timezoneChoice = new Choices('#timezone', {
            itemSelectText: "",
            placeholderValue: "Select TimeZone",
            searchPlaceholderValue: "Search Timezones...",
        });
        
        var countryChoice = new Choices('#country', {
            itemSelectText: "",
            placeholderValue: "Select Country",
            searchPlaceholderValue: "Search Countries...",
        });
        
        var currencyChoice = new Choices('#currency', {
            itemSelectText: "",
            placeholderValue: "Select Currency",
            searchPlaceholderValue: "Search Currencies...",
        });
                
        var input = document.querySelector(".phone");

        var iti = window.intlTelInput(input, {
          // allowDropdown: false,
          // autoHideDialCode: false,
          autoPlaceholder: "aggressive",
          // dropdownContainer: document.body,
          // excludeCountries: ["us"],
          // formatOnDisplay: true,
          geoIpLookup: function(callback) {
            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
              var countryCode = (resp && resp.country) ? resp.country : "";
              callback(countryCode);
            });
          },
          hiddenInput: "phone",
          // initialCountry: "ke",
          // localizedCountries: { 'de': 'Deutschland' },
          nationalMode: true,
          // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
          // placeholderNumberType: "MOBILE",
          preferredCountries: ['ke', 'ug', 'tz'],
          separateDialCode: true,
          utilsScript: "<?=base_url() ?>public/js/utils.js",
        });

        $(".btn-add-new").click(function(e) {
            e.preventDefault();

            var parentTab = $(this).closest('.tab-pane');

            parentTab.find(".add-new-panel").hide();
            parentTab.find(".form-panel").show();
            parentTab.find(".btn-edit").hide();

            parentTab.find(".form-panel input").not(".radio-button").val("");
            parentTab.find(".form-panel input").prop("disabled", false);
        });

        $(".close-form").click(function(e) {
            e.preventDefault();

            var parentTab = $(this).closest('.tab-pane');

            parentTab.find(".add-new-panel").show();
            parentTab.find(".form-panel").hide();
        });

        $(".btn-edit").click(function(e) {
            e.preventDefault();

            var parentTab = $(this).closest('form');

            parentTab.find(".form-control").removeAttr('disabled');

            parentTab.find(".btn-save").show();
            $(this).hide();
        });

        var table = $("#datatablePayments").DataTable({

            "columnDefs": [{
                    "targets": [1],
                    "orderable": false
                },

                {
                    "targets": [0],
                    "visible": false
                }

            ],

            "iDisplayLength": 10,

            "order": [],

            "language": {
                "sSearch": "",
                "searchPlaceholder": "Search Methods ..."
            },

            "dom": "<'row'<'col-sm-5 text-left'f><'col-sm-3 text-center' ><'col-sm-4 text-right'>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 text-center'p>>",

            "rowCallback": function(row, data, index) { // Open Item on click

                // Add delete Button if table had deletableRows

                if ($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')) {

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?= base_url() ?>/settings/deletePaymentMethod" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')

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

                    var parentTab = $(this).closest('.tab-pane');

                    if ($(event.target).is('td')) { // GET PAYMENT METHOD DATA

                        $.get("<?= base_url() ?>/settings/getPaymentMethod/" + data[0], {},
                            function(responseData, textStatus, jqXHR) {


                                // GET PAYMENT METHOD DATA

                                parentTab.find("form .form-control").prop('disabled', 'true')

                                parentTab.find("#methodID").val(responseData.methodID);
                                parentTab.find("#method-name").val(responseData.name);
                                parentTab.find("#description").val(responseData.description);
                                parentTab.find(".radio-tile-" + responseData.icon.replace(" ", "-")).prop('checked', true);

                                parentTab.find(".add-new-panel").hide();
                                parentTab.find(".form-panel").show();

                                parentTab.find(".btn-save").hide();
                                parentTab.find(".btn-edit").show();

                            },
                            "json"
                        );

                    }

                });
            },
        });

        var dTableTaxes = $("#datatableTax").DataTable({

            "columnDefs": [{
                    "targets": [1],
                    "orderable": false
                },

                {
                    "targets": [0],
                    "visible": false
                }

            ],

            "iDisplayLength": 10,

            "order": [],

            "language": {
                "sSearch": "",
                "searchPlaceholder": "Search Methods ..."
            },

            "dom": "<'row'<'col-sm-5 text-left'f><'col-sm-3 text-center' ><'col-sm-4 text-right'>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 text-center'p>>",

            "rowCallback": function(row, data, index) { // Open Item on click

                // Add delete Button if table had deletableRows

                if ($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')) {

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?= base_url() ?>/settings/deleteTax" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')

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

                    var parentTab = $(this).closest('.tab-pane');

                    if($(event.target).is('td')){ // GET PAYMENT METHOD DATA
                                                
                        $.get("<?=base_url() ?>/settings/getTax/"+data[0], {},
                            function (responseData, textStatus, jqXHR) {
                                
                                // console.log(responseData)
                                
                                parentTab.find("form .form-control").prop('disabled', 'true')

                                parentTab.find("#taxID").val(responseData.taxID);
                                parentTab.find("#tax-name").val(responseData.name);
                                parentTab.find("#tax-mode").val(responseData.inclusive);
                                parentTab.find("#percentage").val(responseData.percentage);
                                parentTab.find("#description").val(responseData.description);

                                parentTab.find(".add-new-panel").hide();
                                parentTab.find(".form-panel").show();

                                parentTab.find(".btn-save").hide();
                                parentTab.find(".btn-edit").show();


                            },
                            "json"
                        );

                    }

                });
            },
        });

        var dTableStores = $("#datatableStores").DataTable({

            "columnDefs": [{
                    "targets": [1],
                    "orderable": false
                },

                {
                    "targets": [0],
                    "visible": false
                }

            ],

            "iDisplayLength": 10,

            "order": [],

            "language": {
                "sSearch": "",
                "searchPlaceholder": "Search Stores ..."
            },

            "dom": "<'row'<'col-sm-5 text-left'f><'col-sm-3 text-center' ><'col-sm-4 text-right'>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 text-center'p>>",

            "rowCallback": function(row, data, index) { // Open Item on click

                // Add delete Button if table had deletableRows

                if ($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')) {

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?= base_url() ?>/settings/deleteStore" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')

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

                    var parentTab = $(this).closest('.tab-pane');

                    if($(event.target).is('td')){ // GET PAYMENT METHOD DATA
                                                
                        $.get("<?=base_url() ?>/settings/getStore/"+data[0], {},
                            function (responseData, textStatus, jqXHR) {
                                
                                // console.log(responseData)
                                
                                parentTab.find("form .form-control").prop('disabled', 'true')

                                parentTab.find("#storeID").val(responseData.storeID);
                                parentTab.find("#storeName").val(responseData.storeName);
                                parentTab.find("#store-location").val(responseData.physicalLocation);
                                parentTab.find("#store-phone").val(responseData.phone);
                                parentTab.find("#store-email").val(responseData.email);
                                parentTab.find("#countryID").val(responseData.countryID);

                                parentTab.find(".add-new-panel").hide();
                                parentTab.find(".form-panel").show();

                                parentTab.find(".btn-save").hide();
                                parentTab.find(".btn-edit").show();


                            },
                            "json"
                        );

                    }

                });
            },
        });
        
        $('#newDept').click(function(){
            
            var parent = $('#departments_modal');
            
            parent.find("#departmentID").val('');
            parent.find(".form-control").prop('disabled', false)

            parent.find("#departmentName").val('');

            parent.find(".btn-save").show();
            parent.find(".btn-save").val('create');
            parent.find(".btn-edit").hide();
            
            $('#departments_modal').modal('show');
        });
        
        var dTableDepartments = $("#datatableDepartments").DataTable({

            "columnDefs": [{
                    "targets": [1],
                    "orderable": false
                },

                {
                    "targets": [0],
                    "visible": false
                }

            ],

            "iDisplayLength": 5,

            "order": [],

            "language": {
                "sSearch": "",
                "searchPlaceholder": "Search Departments ..."
            },

            "dom": "<'row'<'col-sm-5 text-left'><'col-sm-3 text-center' ><'col-sm-4 text-right'>>" + "<'row padded'<'col-sm-12'tr>>" + "<'row'<'col-sm-12 text-center'p>>",

            "rowCallback": function(row, data, index) { // Open Item on click

                // Add delete Button if table had deletableRows

                if ($(this).hasClass('deletableRows') && !$(row).find('td:last-child div').hasClass('actions')) {

                    $(row).find('td:last-child').append('<div class="actions"><span id="delete" title="Delete" href="<?= base_url() ?>/settings/deleteDepartment" data-id=' + data[0] + ' class="text-danger btn-rounded tableRowActionBtn" ><span class="fi fi-sr-delete"></span></span></div>')

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

                    var parentTab = $('#departments_modal');

                    if($(event.target).is('td')){ // GET PAYMENT METHOD DATA
                                                
                        $.get("<?=base_url() ?>/settings/getDepartment/"+data[0], {},
                            function (responseData, textStatus, jqXHR) {
                                
                                // console.log(responseData)
                                parentTab.find("#departmentID").val(data[0]);
                                parentTab.find(".form-control").prop('disabled', 'true')

                                parentTab.find("#departmentName").val(responseData.name);

                                parentTab.find(".btn-save").hide();
                                parentTab.find(".btn-save").val('Update');
                                parentTab.find(".btn-edit").show();
                                
                                $("#departments_modal").modal('show');                    
                                
                            },
                            "json"
                        );

                    }

                });
            },
        });

        // POPULATE PAYMENT METHODS

        $.get("<?= base_url() ?>/settings/paymentMethods", function(data) {

            table.clear() //clear content

            var obj = JSON.parse(data);

            // console.log(obj)

            table.rows.add(obj)

            table.draw() //update display

        });

        //POPULATE TAXES

        // $.get("<?= base_url() ?>/settings/taxes", function(data){

        //     dTableTaxes.clear() //clear content

        //     var obj = JSON.parse(data);

        //     // console.log(obj)

        //     dTableTaxes.rows.add(obj)

        //     dTableTaxes.draw() //update display

        // }); 

        //POPULATE STORES

        $.get("<?= base_url() ?>/settings/getStores", function(data) {

            dTableStores.clear() //clear content

            var obj = JSON.parse(data);

            // console.log(obj)

            dTableStores.rows.add(obj)

            dTableStores.draw() //update display

        });

        //POPULATE DEPARTMENTS

        $.get("<?= base_url() ?>/settings/departments", function(data) {

            dTableDepartments.clear() //clear content
            
            console.log(data)

            var obj = JSON.parse(data);

            dTableDepartments.rows.add(obj)

            dTableDepartments.draw() //update display

        });

        var settings = {
            submitHandler: function(form) {
                $(form).find(".btn-save").prop("disabled", true);
                $(form).find(".btn-save").val('Saving changes...');

                $(form).ajaxSubmit({
                    success: function(response) {

                        if (response.success) {
                            set_feedback('success', response.message, false);

                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            set_feedback('error', response.message, true);

                            $(form).find(".btn-save").prop("disabled", false);
                            $(form).find(".btn-save").val("Save changes");
                        }
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                company: "required",
                address: "required",
                phone: "required",
                email: "email"

            },
            messages: {
                company: "Company name is required!",
                address: "Business address required!",
                phone: "Phone number is required!",
                email: "Please enter a valid email address"

            }
        };

        $('#config_form').find(".form-control").attr("disabled", "true");
        $('#config_form').find(".btn-save").hide();
        $('#config_form').find(".btn-edit").show();

        $('#config_form').validate(settings);

        var PaymentModeSettings = {
            submitHandler: function(form) {

                $(form).find(".btn-save").prop("disabled", true);
                $(form).find(".btn-save").val('Saving changes...');

                $(form).ajaxSubmit({
                    success: function(response) {

                        if (response.success) {
                            set_feedback('success', response.message, false);

                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            set_feedback('error', response.message, true);

                            $(form).find(".btn-save").prop("disabled", false);
                            $(form).find(".btn-save").val("save method");

                        }
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                name: "required",
                icon: "required",
                description: "required"

            },
            messages: {
                name: "Method Name is required!",
                icon: "Please select an icon",
                description: "Account number is required!"

            }
        };

        $('#paymentMethodForm').validate(PaymentModeSettings);



        var storeFormSettings = {
            submitHandler: function(form) {

                $(form).find(".btn-save").prop("disabled", true);
                $(form).find(".btn-save").val('Saving changes...');

                $(form).ajaxSubmit({
                    success: function(response) {

                        $("#submit").prop("disabled", false);
                        $("#submit").val("Save");

                        if (response.success) {
                            set_feedback('success', response.message, false);

                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            set_feedback('error', response.message, true);

                            $(form).find(".btn-save").prop("disabled", false);
                            $(form).find(".btn-save").val("save method");
                        }
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                storeName: "required",
                'store-location': "required",
                'store-phone': "required"

            },
            messages: {
                storeName: "Method Name is required!",
                'store-location': "Physical Location is required",
                'store-phone': "Phone Number is required!"

            }
        };

        $('#storeForm').validate(storeFormSettings);

        var departmentFormSettings = {
            submitHandler: function(form) {

                $(form).find(".btn-save").prop("disabled", true);
                $(form).find(".btn-save").val('Saving changes...');

                $(form).ajaxSubmit({
                    success: function(response) {

                        $(".btn-save").prop("disabled", false);
                        $(".btn-save").val("Save");

                        if (response.success) {
                            set_feedback('success', response.message, false);

                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            set_feedback('error', response.message, true);

                            $(form).find(".btn-save").prop("disabled", false);
                            $(form).find(".btn-save").val("save method");
                        }
                    },
                    dataType: 'json',
                    type: 'post'
                });
            },
            rules: {
                departmentName: "required",

            },
            messages: {
                departmentName: "Invalid Department Name!",

            }
        };

        $('#department_form').validate(departmentFormSettings);

        enable_delete('Are you sure to delete?', 'Please select a record to delete!');

    });
</script>