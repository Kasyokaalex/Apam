<html>
    <head>
        <title>Print Preview</title>
        <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url(); ?>bootstrap3/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>font-awesome-4.3.0/css/font-awesome.min.css" />
        <style>

            *{

                font-family: calibri;

                font-size: 8pt;
            }
            ul.checkbox-grid li {
                display: block;
                float: left;
                width: 40%;
                text-decoration: none;
            }

            .loans_pdf_company_name, .loans_pdf_title{
                text-align: center;
            }
        </style>
    </head>
    <body style="font-size: 11px;">

        <div>

            <table width="100%" >
                <tr>
                    <td align="center" style="padding: 20px">
                        <img id="img-pic" src="<?= (trim($this->config->product("logo")) !== "") ? base_url("uploads/logo/" . $this->config->product('logo')) : base_url("uploads/common/no_img.png"); ?>" style="height:50px" /><br/>
                        <h2 style="font-size: 16px"><?= ucwords($this->config->product('company')); ?> </h2>

                        <?= $this->config->product('phone') . " " . $this->config->product('rnc'); ?>
                    </td>
                </tr>
            </table>

            <div class="row" style="border-bottom: .5px solid black;padding: 5px;">
                
                <div style="text-align: left;" class="col-xs-4">Payments statement</div>

                <div style="text-align: right"><?=date(DATE_RFC822) ?></div>
            </div>

            <div class="row text-center" style="padding: 20px 0 0 0;">
                <div class="col-xs-3">
                    <p><strong>Due Date :</strong><br>
                     <?= $trans_date; ?></p>
                </div>

                <div class="col-xs-4">
                    <p><strong>Borrower :</strong> <br> 
                        <?= $client; ?></p>
                </div>

                <div class="col-xs-3">
                    <p><strong>Borrower Account :</strong> <br>
                        <?= $account; ?></p>
                </div>

            </div>

            <hr>

            <div class="row text-center" style="margin-top: 20px;">

                <p style="padding: 20px;">This document is a statement of payment for the loan stated below:</p>
                
                <div class="col-xs-3">
                    <p><strong>Loan id :</strong> <br>
                        <?= $loan_id; ?></p>
                </div>
                
                <div class="col-xs-4">
                    <p><strong>Loan Amount :</strong> <br>
                        <?= $loan_amount; ?></p>
                </div>
                
                <div class="col-xs-3">
                    <p><strong>Interest :</strong> <br>
                        <?= $interest; ?></p>
                </div>
                
                <div class="col-xs-3" style="padding-top: 20px;">
                    <p><strong>Payment Expected :</strong> <br>
                        <?= $expected_payment; ?></p>
                </div>
                
                <div class="col-xs-4" style="padding-top: 20px;">
                    <p><strong>Amount Paid :</strong> <br>
                        <?= $amount_paid; ?></p>
                </div>
                
                <div class="col-xs-3" style="padding-top: 20px;">
                    <p><strong>Teller :</strong> <br>
                        <?= $teller; ?></p>
                </div>

            </div>

            <hr>

            <div class="row text-center">

                <h4 style="font-size: 14px">Payment Details</h4>
                                
                <div class="col-xs-3">
                    <p><strong>Payment id :</strong> <br>
                        <?= $payment_id ?></p>
                </div>
                                
                <div class="col-xs-4">
                    <p><strong>Amount Paid :</strong> <br>
                        <?= $paid; ?></p>
                </div>
                                
                <div class="col-xs-3">
                    <p><strong>New Balance :</strong> <br>
                        <?= $new_balance; ?></p>
                </div>
            </div>

            <br/>
            <br/>
            <br/>

            <table width="100%" style="font-size: 12px">
                <tr>
                    <td align="center">
                        <h3>Thank you!</h3>
                    </td>
                </tr>
            </table>


        </div>

    </body>

</html>