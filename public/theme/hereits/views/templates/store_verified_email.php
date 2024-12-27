<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
    <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
    <title>Hereits</title> <!-- The title tag shows in email notifications, like Android 4.4. -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&display=swap" rel="stylesheet">
    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 9 - 26 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
    <!--[if mso]>
		<style>
			* {
				font-family: sans-serif !important;
			}
		</style>
	<![endif]-->

    <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
    <!--[if !mso]><!-->
    <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,675' rel='stylesheet' type='text/css'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset -->
    <style>
        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */

        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What is does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            /* margin: 0 auto !important; */
        }

        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        span,
        p {
            margin: 0;
        }

        .content-main-table tr td {
            padding-left: 55px;
            padding-right: 55px;
        }

        .footer-table-main tr td {
            padding-left: 55px;
            padding-right: 55px;
        }

        .td-top {
            padding-top: 30px;
        }

        .td-bottom {
            padding-bottom: 30px;
        }

        .td-top-botom {
            padding: 30px 0;
        }

        .reset-pass {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .btn {
            background: #099e44;
            padding: 9px 25px;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            -ms-border-radius: 2px;
            -o-border-radius: 2px;
            border-radius: 2px;
            font-family: Rubik;
            font-weight: normal;
            color: #ffffff;
            font-family: -apple-system, Helvetica, Arial, sans-serif;
            font-size: 16px;
            font-weight: 500;
            letter-spacing: .5px;
            text-decoration: none;
            display: inline-block;
        }

        .tbl-with {
            width: 310px;
        }

        .f-links {
            color: #2b6be2;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            text-transform: capitalize;
        }

        .f-links:hover {
            cursor: pointer;
            text-decoration: underline;
        }

        .main-links {
            color: #2b6be2;
            word-break: break-all;
        }

        .social-img {
            max-width: 46px;
            width: 100%;
        }

        .app-dwl-img {
            max-width: 140px;
            width: 100%;
        }

        /* Responsive start  */
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }

            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }

            table.center-on-narrow {
                display: inline-block !important;
            }

            .content-main-table tr td {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .footer-table-main tr td {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .tbl-with {
                width: 100% !important;
            }
        }

        @media screen and (max-width: 360px) {
            .padd-lr15 {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
        }

        @media screen and (max-width: 240px) {
            .social-img {
                max-width: 30px !important;
            }

            .app-dwl-img {
                max-width: 90px !important;
            }
        }

        /* Responsive End */
    </style>

</head>

<body bgcolor="#f5f5f5" width="100%" style="margin: 0;">
    <center style="width: 100%;">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto; margin-top: 10px;margin-bottom: 10px;" class="email-container">

            <!-- Header start -->
            <tr>
                <td align="center" valign="top" style="padding:22px 0;background: #000000;border-top-left-radius: 10px;border-top-right-radius: 10px;" class="header-padding">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td align="center" valign="middle" class="logo-top-bottom"><a href="#"><img mc:edit="logo-main" src="<?= base_url() ?>assets/Logo/white-text-logo.png" width="100" alt="Hereits"></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Header End -->

            <!-- Content start -->
            <tr>
                <td>
                    <table class="content-main-table" style="background: #ffffff;" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <td class="td-top-botom" align="left" style="border-bottom: 1px solid #e5e5e5; margin: 0 55px;">
                                <h5 style="margin: 0; font: bold 16px -apple-system,Helvetica,Arial,sans-serif;  color: #33373d; text-transform:uppercase;"> <strong style="text-transform: capitalize;">Hi,</strong> <?= $username ?></h5>
                                <p style="margin-top: 20px;font-size: 16px;font-weight: 400;word-break: keep-all;line-height: 1.4;color: #33373d;font-family: -apple-system,Helvetica,Arial,sans-serif;">your store <b><?= $Store_name ?></b> is verified successfully.</p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="margin-top: 20px;display: inline-block;line-height: 22px;text-align: left;font-size: 16px;font-weight: 400;word-break: keep-all;color: #33373d;font-family: -apple-system,Helvetica,Arial,sans-serif;"> hello, your store <b><?= $Store_name ?></b> is now verified successfully. please select plan and then add product or services and other details in store.
                        </tr>
                        <tr>
                            <td style="padding:0 15px; display:block; margin-top:20px;margin-bottom:20px;text-align:center;">
                                <a class="btn" href="<?= base_url() ?>Login">
                                    Login to Hereits
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="display: inline-block;line-height: 22px;font-size: 16px;font-weight: 400;word-break: keep-all;color: #33373d;font-family: -apple-system,Helvetica,Arial,sans-serif;"> If above button does not work, past this link into your browser:</td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size:16px; font-family: -apple-system,Helvetica,Arial,sans-serif; margin-top: 20px; margin-bottom: 30px; display: inline-block;text-align: left;"> <a class="main-links" href="<?= base_url() ?>Login"><?= base_url() ?>Login</a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Content End -->

            <!-- Footer start -->
            <tr>
                <td width="100%">
                    <table width="100%" bgcolor="#f5f5f5" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; text-align:center;background: #EDF1F4;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                        
                        <tr>
                            <td>
                                <table style="width: 100%;" class="footer-table-main">
                                    <tr>
                                        <td style="font-size:13px; font-family: -apple-system,Helvetica,Arial,sans-serif; color:#787878;" class="td-top">
                                            <singleline>
												This email was intended for <?= $username ?>, because you signed up for Hereits | If you didn’t
												sign up for Hereits account using in this email address, please ignore this massage.
											</singleline>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" class="td-top">
                                <table class="tbl-with" align="center" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; text-align:center;">
                                    <tr>
                                        <td><a href="#"><img class="app-dwl-img" src="<?= base_url() ?>assets/front-end/images/emailer-images/androidapp.png" alt="google play"></a></td>
                                        <!-- td><a href="#"><img class="app-dwl-img" src="<?= base_url() ?>assets/front-end/images/emailer-images/appleapps.png" alt="app store"></a></td -->
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-top td-bottom padd-lr15" style="font-size:13px; font-family: -apple-system,Helvetica,Arial,sans-serif; color:#787878;">©<?= date("Y") ?> Hereits All Rights Reserved. <a class="f-links" href="<?= base_url() ?>Terms">terms & condition</a> <a class="f-links" href="<?= base_url() ?>Privacy">privacy policy.</a></td>
                        </tr>

                    </table>
                </td>
            </tr>
            <!-- Footer End -->
        </table>
    </center>
</body>

</html>