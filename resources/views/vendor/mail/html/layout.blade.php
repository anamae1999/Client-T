<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body style="margin:0px; padding:0px; background-color:#F8FAFC">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F8FAFC" role="presentation">
        <tr>
            <td align="center">
            <table bgcolor="#CCA34F" class="wrapper" cellpadding="0" cellspacing="0" role="presentation" style="max-width: 600px;">
                <tr>
                    <td align="center">
                        <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <!-- Email Header -->
                            <tr>
                                <td class="body" width="100%" cellpadding="0" cellspacing="0" bgcolor="#CCA34F" style="background-color: #CCA34F !important;">
                                    <table bgcolor="#CCA34F" align="center" cellpadding="0" cellspacing="0" role="presentation" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #CCA34F !important; padding: 20px;">
                                        {{ $header ?? '' }}
                                    </table>
                                </td>
                            </tr>

                            <!-- Email Body -->
                            <tr>
                                <td class="body" width="100%" cellpadding="0" cellspacing="0">
                                    <table class="inner-body" align="center" cellpadding="0" cellspacing="0" role="presentation">
                                        <!-- Body content -->
                                        <tr>
                                            <td class="content-cell" style="padding: 20px;">
                                                {{ Illuminate\Mail\Markdown::parse($slot) }}

                                                <!-- {{ $subcopy ?? '' }} -->
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            
                            <tr>
                                <td class="body" width="100%" cellpadding="0" cellspacing="0" bgcolor="#CCA34F" style="background-color: #CCA34F !important;">
                                    <table bgcolor="#CCA34F" class="inner-body" align="center" cellpadding="0" cellspacing="0" role="presentation">
                                        {{ $footer ?? '' }}
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </td>
        </tr>
    </table>
</body>
</html>
