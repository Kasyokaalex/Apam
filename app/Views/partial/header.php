<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <base href="<?= base_url(); ?>" />
    <title><?= config('apamSettings')->company . ' -- Powered by VintEx Technologies'; ?></title>

    <script>
        BASE_URL = '<?= base_url(); ?>';
        TOKEN_HASH = '<?= csrf_field(); ?>';
    </script>

    <!-- Toastr style -->

    <link href="<?= base_url() ?>/public/css/toastr.min.css" rel="stylesheet">
    </link>

    <link href="<?= base_url(); ?>public/css/bootstrap.min.css" rel="stylesheet">
    </link>
    <link href="<?= base_url(); ?>/public/css/bootstrap-reboot.css" rel="stylesheet">
    </link>

    <link href="<?= base_url() ?>/public/fonts/flaticons/uicons-solid-rounded.css" rel="stylesheet" type="text/css">

    <link href="<?= base_url(); ?>/public/css/alertify.min.css" rel="stylesheet">
    </link>

    <!-- <link href="<?= base_url(); ?>/public/css/simplepicker.css" rel="stylesheet"> -->
    <link href="<?= base_url(); ?>/public/css/toastr.min.css" rel="stylesheet">

    <link href="<?= base_url(); ?>/public/css/style.css" rel="stylesheet"></link>
    <!-- Choices -->
    <link href="<?= base_url(); ?>/public/css/choices.min.css" rel="stylesheet"></link>




    <!-- Data Tables -->
    <link href="<?= base_url() ?>/public/css/dataTables/dataTables.material.css" rel="stylesheet">
    </link>
    <link rel="stylesheet" href="<?= base_url() ?>/public/css/material-switch.css">

    <!-- Mainly scripts -->
    <script src="<?= base_url(); ?>/public/js/jquery-3.7.0.min.js"></script>
    <script src="<?= base_url(); ?>/public/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>/public/js/jquery.slimscroll.min.js"></script>

    <script src="<?= base_url(); ?>/public/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?= base_url(); ?>/public/js/dataTables/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url(); ?>/public/js/dataTables/dataTables.responsive.js"></script>
    <script src="<?= base_url(); ?>/public/js/dataTables/dataTables.tableTools.min.js"></script>

    <script src="<?= base_url(); ?>/public/js/jquery.form.min.js"></script>
    <script src="<?= base_url(); ?>/public/js/alertify.min.js"></script>
    <script src="<?= base_url(); ?>/public/js/manage_tables.js?v=<?= time() ?>"></script>
    <!-- Choices.js -->
    <script src="<?= base_url(); ?>/public/js/choices.min.js"></script>


    <!-- Jquery Validate -->
    <script src="<?= base_url(); ?>/public/js/jquery.validate.min.js"></script>
    <script src="<?= base_url(); ?>/public/js/toastr.min.js"></script>
    <script src="<?= base_url(); ?>/public/js/jquery.autocomplete.js" type="text/javascript"></script>

    <script src="<?= base_url(); ?>/public/js/plupload/plupload.full.min.js" type="text/javascript" language="javascript"></script>

    <script src="<?= base_url(); ?>/public/js/common.js?v=<?= time() ?>" type="text/javascript" language="javascript" charset="UTF-8"></script>

    <!-- pdf export -->

    <!--<script type="text/javascript" src="<?= base_url() ?>/public/js/export_data/pdfmake.min.js"></script>-->
    <script type="text/javascript" src="<?= base_url() ?>/public/js/export_data/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/js/export_data/buttons.flash.min.js"></script>
    <!--<script type="text/javascript" src="<?= base_url() ?>/public/js/export_data/vfs_fonts.js"></script>-->
    <!--<script type="text/javascript" src="<?= base_url() ?>/public/js/export_data/jszip.min.js"></script>-->
    <script type="text/javascript" src="<?= base_url() ?>/public/js/export_data/buttons.html5.min.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>/public/js/toastr.min.js"></script>

</head>

<body>

    <?= csrf_field() ?>
    <input type="hidden" id="base_url" value="<?= base_url() ?>" />

    <div id="wrapper">
        <nav class="navbar-default navbar-static-side fixed-menu" role="navigation">
            <div class="sidebar-collapse">
                <div id="hover-menu"></div>
                <!-- <ul class="nav metismenu" id="side-menu">

                        <li> -->

                <!-- START : Left sidebar -->
                <div class="nano left-sidebar">
                    <div class="nano-content">
                        <ul class="nav nav-pills nav-stacked nav-inq">
                            <li>
                                <div class="logopanel" style="margin: 2em 0; z-index: 99999; background: transparent;">
                                    <div class="profile-element">
                                        <!-- <h3 style="font-family: billgates; font-size:24px; color:purple">apam</h3> -->
                                        <img src="<?= base_url() ?>public/imgs/log.svg" alt="" width="25%">
                                    </div>
                                    <div class="logo-element">
                                        <h3>SHO</h3>
                                    </div>
                                </div>
                            </li>

                            <?php

                            $uri = current_url(true);;
                            $uri->setSilent();

                            $selected = (strpos(strtolower(substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1)), strtolower('home')) !== FALSE) ? "active" : ""; ?>

                            <li class="<?= $selected; ?>">
                                <a href="<?= base_url("home") ?>"><i class="fi fi-sr-home" aria-hidden="true"></i>
                                    <span class="nav-label">Dashboard</span></a>
                            </li>

                            <?php foreach ((new App\Models\Modules())->where('is_active >', 0)->orderBy("sort", "asc")->findAll() as $module) : ?>

                                <?php if (in_array($module->controller, ["if it has a dropdown"])) : ?>

                                    <li class="nav-parent <?= ($select_new !== "") ? $select_new : $select_list; ?>">
                                        <a href="<?= base_url("$module->controller"); ?>" title="<?= $module->moduleID; ?>">
                                            <i><?= str_replace("font-size: 50px", "font-size: 16px", $module->icons); ?></i>
                                            <span class="nav-label"><?= $module->moduleID ?></span>
                                        </a>

                                    </li>

                                <?php else :

                                    $selected = ($uri->getSegment(2) === $module->controller || $uri->getSegment(2) . "/" . $uri->getSegment(3) === $module->controller) ? "active" : "";

                                    if ($uri->getSegment(3) == "restock_logs" && $module->controller == "stock") {
                                        $selected = "";
                                    };

                                ?>
                                    <li class="<?= $selected; ?>">
                                        <?php if ($module->moduleID == "staff" && config('LoggedInStaff')->role != 'admin') { ?>
                                            <a href="<?= base_url("$module->controller"); ?>"> <?= $module->icons; ?> <span class="nav-label">My Profile</span></a>
                                        <?php } else { ?>
                                            <a href="<?= base_url("$module->controller"); ?>"> <?= $module->icons; ?> <span class="nav-label"><?= $module->moduleID; ?></span></a>
                                        <?php } ?>
                                    </li>

                                <?php endif; ?>
                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>
                <!-- END : Left sidebar -->

                </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">

            <!-- BEGIN HEADER -->
            <div id="header">
                <nav class="navbar navbar-fixed-top show-menu-full" id="nav" role="navigation" style="margin-left: 10px;">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-style-2" href="javascript:void(0)"><i class="fi fi-rr-menu-burger" style="font-size:19px; position:absolute; padding-top: 3px"></i> </a>

                        <h4 class="float-end minimalize-style-2" style="line-height: 2; text-transform: uppercase;">
                            apam</h4>

                    </div>

                    <ul class="nav navbar-top-links navbar-right align-items-center">



                        <li class="dropdown">

                            <?php $notifications = (new App\Models\Setting)->get_notifications(); ?>

                            <a href="#" class="dropdown-toggle" id="reportrange" data-bs-toggle="dropdown" aria-expanded="false">

                                <span class="fi fi-rr-bell" style="font-size: 1.6em;" title="Stat settings"></span>

                                <span class="badge badge-danger" style="position: absolute; padding: 4px; line-height: 0.7;"><?= sizeof($notifications); ?></span>

                            </a>

                            <ul class="dropdown-menu mt-2" style="padding: 6px; width: 300px; left: -12rem">

                                <?php

                                if ($notifications != null) {

                                    foreach ($notifications as $product) { ?>

                                        <li>

                                            <a class="row" href="<?= $product['link'] ?>">

                                                <div class="col-sm-2 lnr <?= $product['icon'] ?>"></div>

                                                <div style="line-height: 1.5" class="col-sm-10"><?= $product['message'] ?></div>
                                            </a>

                                        </li>

                                    <?php }
                                } else { ?>

                                    <li>

                                        <a class="row" href="">
                                            <div class="text-center">All caught up! Nothing today!</div>
                                        </a>

                                    </li>

                                <?php } ?>

                            </ul>

                        </li>

                        <li class="divider"></li>

                        <li class="dropdown">

                            <?php //var_dump(config('LoggedInStaff')); 
                            ?>

                            <a href="#" title="Logout, about apam" class="dropdown-toggle" style="display: flex; justify-content: center; vertical-align: middle;" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if ((config('LoggedInStaff')->photo ?? "") !== "" && file_exists(FCPATH  .  "/public/uploads/staff/" . config('LoggedInStaff')->photo)) :  ?>
                                    <img src="<?= base_url("/public/uploads/staff/" . config('LoggedInStaff')->photo); ?>" style="width:25px;height:25px; border: 1px solid #800080; padding: 1px; object-fit:cover" alt="" class="media-object img-circle" />
                                <?php else : ?>
                                    <img src="<?= base_url() ?>/public/imgs/user.png" style="width:25px;height:25px; border: 1px solid #800080; padding: 1px" alt="" class="media-object img-circle" />
                                <?php endif; ?>

                                <b style="line-height: 2; margin-left: 10px"><?= config('LoggedInStaff')->firstName . " " . config('LoggedInStaff')->lastName ?></b>

                                <span class="fi fi-rr-angle-small-down" style="padding: 7px;"></span>

                            </a>

                            <ul class="dropdown-menu">

                                <li><a class="dropdown-item" href="<?= base_url("staff/view/" . config('LoggedInStaff')->staffID); ?>"><i class="fi fi-sr-mode-portrait"></i> &nbsp; My Profile</a></li>

                                <li><a class="dropdown-item" href="<?= base_url("home/logout") ?>"><i class="fi fi-sr-arrow-small-left"></i> &nbsp; Logout</a></li>

                                <li class="dropdown-divider m-0 p-0"></li>

                                <li><a class="dropdown-item" href="#" id="modalButtton" type="button" data-bs-toggle="modal" data-bs-target="#modal_abt_apam"><i class="fi fi-sr-info"></i> &nbsp; About</a></li>

                            </ul>

                        </li>
                    </ul>
                </nav>
            </div>
            <!-- END HEADER -->

            <!-- BEGIN CONTENT -->
            <div class="wrapper wrapper-content d-flex flex-column">

                <!-- SHOW ALERT TO RENEW SUBSCRIPTION IF IT EXPIRES IN 10 DAYS OR LESS -->
                <?php $expiryDate = config('LoggedInStaff')->subscription->expiryDate ?? 0;
                $timeRemaining = $expiryDate - time();
                $daysRemaining = ($timeRemaining) / (60 * 60 * 24);

                if ($daysRemaining <= 10 && $timeRemaining > 0) : ?>

                    <div class="alert alert-info">
                        Your <strong><?= config('LoggedInStaff')->subscription->name ?> Package </strong>subscription
                        expires
                        in <?= floor($daysRemaining) ?> days

                        <a href="https://portal.myapam.com" target="_blank" style="margin: -8px;" class="btn btn-info float-end">Renew Subscription</a>
                    </div>

                <?php endif ?>


                <!-- ABOUT PROJECT apam MODAL -->

                <div class="modal fade" id="modal_abt_apam" role="dialog">

                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                            <!-- <div class="modal-header">

                                <h4 id="modal-title">The apam </h4>

                                </div> -->

                            <div class="close"><span data-dismiss="modal"><span class="fi fi-rr-cross-circle"></span></span></div>

                            <div class="modal-body" style="padding: 1.8em !important;">

                                <h4>ABOUT apam</h4>

                                <p>apam is a Business Management Tool with an Integrated Point Of Sale System (POS). It
                                    was intended to make business management streamlined by storing customer, sales and
                                    expenditure data which informs strategic planning, Customer Rewarding and
                                    Perfromance reporting.</p>

                                <hr>

                                <h4>THE DEVELOPERS</h4>

                                <p>Vint Ex Technologies has vast experienced in Software Matters with a passion simplify
                                    the word for you.</p>

                                <p>Other products by this developer can be found on their website, You want to find out
                                    what they can do? Check it out!</p>


                                <a target="_blank" href="https://www.vintextechnologies.com" class="btn btn-purple" style="margin-top: 1em">Developers' website</a>

                            </div>
                        </div>

                    </div>
                </div>

                <!-- end of Modal -->