<?= view("partial/header"); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-title">
                <h5>
                    Company setup
                </h5>
                <div class="inqbox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="inqbox-content">

                <div class="tabs-container">

                    <ul class="nav nav-pills tab-border-top-danger" style="padding: 0 0 4em 1em">

                        <li class="active">
                            <a data-bs-toggle="tab" href="#tab-info">Company Information</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="tab-info" class="">

                            <div style="text-align: center">
                                <ul id="error_message_box"></ul>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 control-label">

                                    <div class="col-sm-3">
                                        <img id="img-pic" src="<?= (trim(config('logo')) !== '') ? base_url("uploads/logo/" . config('logo')) : base_url("uploads/common/no_img.png"); ?>" style="height:99px" />
                                        <div id="filelist"></div>
                                        <div id="progress" class="overlay"></div>

                                        <div class="progress progress-task" style="height: 4px; width: 15%; margin-bottom: 2px; display: none">
                                            <div style="width: 0%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="50" role="progressbar" class="progress-bar progress-bar-info">

                                            </div>
                                        </div>

                                        <div id="container">
                                            <a id="browsefile" href="javascript:;" class="btn btn-sm btn-info" style="min-width: 100px; border-radius: 0px !important; margin: 0 !important">Browse</a>
                                        </div>
                                    </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="company" class="form-label">Company name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="company" id="company" value="<?= config('apamSettings')->company ?>" class="form-control">
                                    </div>

                                </div>

                                <div class="form-group col-sm-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="phone" id="phone" value="<?= config('apamSettings')->phone ?>" class="form-control">

                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="row" style="padding-top: 2em">
                            <div class="form-group col-sm-6">
                                <label for="Postal Address" class="form-label">Postal Address</label>
                                <div class="">
                                    <input type="text" name="address" id="address" value="<?= config('apamSettings')->address ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="Currency" class="form-label">Currency</label>
                                <div class="">
                                    <input type="currency" name="currency_symbol" id="currency_symbol" class="form-control" value="<?= config('apamSettings')->currency_symbol ?>">
                                </div>
                            </div>


                            <div class="form-group col-sm-6">
                                <label for="website" class="form-label">Website</label>
                                <div class="">
                                    <input type="text" name="website" id="website" value="<?= config('apamSettings')->website ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="email" class="form-label">Email</label>
                                <div class="">
                                    <input type="email" name="email" id="email" value="<?= config('apamSettings')->email ?>" class="form-control">
                                </div>
                            </div>


                            <div class="form-group col-sm-6">
                                <label for="Language" class="form-label">Language</label>
                                <div class="">
                                    <select id="language" name="language" class="form-control">
                                        <?php
                                        $languageOptions = json_decode(config('ApamSettings')->language, true);

                                        if (is_array($languageOptions)) {
                                            $selectedLanguage = 'en';

                                            foreach ($languageOptions as $value => $label) {
                                                $selected = ($value == $selectedLanguage) ? 'selected' : '';
                                                echo "<option value='{$value}' {$selected}>{$label}</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Language options not available</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="Timezone" class="form-label">Timezone</label>
                                    <div class="">

                                        <select id="timezone" name="timezone" class="form-control">
                                            <?php
                                            $timezoneOptions = [
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

                                            ];

                                            $selectedTimezone = 'Pacific/Midway'; // Default selected timezone

                                            foreach ($timezoneOptions as $value => $label) {
                                                $selected = ($value == $selectedTimezone) ? 'selected' : '';
                                                echo "<option value='{$value}' {$selected}>{$label}</option>";
                                            }
                                            ?>
                                        </select>
                                
                                </div>
                            </div>
                        </div>

                        <div id="sys_pref" class=" active">

                            <div class="form-group" style="padding-top: 2em">


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

            <?php

            if (config('loggedInStaff')->role === "mgmt" || config('loggedInStaff')->role === "admin") {
                echo '<input type="submit" name="submit" id="submit" value="Save" class="btn btn-sm btn-primary">';
            }
            ?>
        </div>
    </div>

    <?= view("partial/footer"); ?>

    <script type="text/javascript" src="<?= base_url(); ?>/js/config.js"></script>


    <script type='text/javascript'>
        //validation and submit handling
        $(document).ready(function() {
            var settings = {
                submitHandler: function(form) {
                    $("#submit").prop("disabled", true);
                    $("#submit").val('Saving...');

                    $(form).ajaxSubmit({
                        success: function(response) {

                            $("#submit").prop("disabled", false);
                            $("#submit").val("Save");

                            if (response.success) {
                                set_feedback(response.message, 'success_message', false);
                            } else {
                                set_feedback(response.message, 'error_message', true);
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

            $('#config_form').validate(settings);

        });
    </script>