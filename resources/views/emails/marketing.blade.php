<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ company('company_name') }}</title>
</head>
<body style="margin:0; padding:0; background:#f5f7fb; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f7fb; padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="background:#0F1B47; padding:20px 30px;">
                            <span style="color:#F5A623; font-size:20px; font-weight:bold;">{{ company('company_name') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px; color:#1f2937; font-size:14px; line-height:1.6;">
                            {!! $bodyHtml !!}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 30px; background:#f5f7fb; color:#7A82A0; font-size:12px;">
                            {{ company('company_name') }} &bull; REC {{ company('rec_number') }} &bull; {{ company('address') }}<br>
                            {{ company('email') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
