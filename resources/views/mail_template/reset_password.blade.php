<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <!--[if !mso]><!-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]-->
    <title></title>
</head>
<body style="padding: 2rem 0;margin: 0;">
<table style="width:450px;padding: 25px;background: white;border-radius: 20px;margin: 2rem auto">
    <tbody>
    <tr>
        <td style="padding: 25px 0;font-size: 16px;max-width:375px">
            <p style="font-family: sans-serif;font-weight: 600;"><b>Reset Your Password</b></p>
            <p style="font-family: sans-serif;font-weight: 300;    margin-bottom: 30px;">You can reset your password
                using this code:<b>{{$content['code']}}</b></p>
            <div style="text-align: center">
                <a href={{$content['reset_url']}} target="_blank"
                   style="cursor:pointer;border:none;border-radius:10px;outline:none;background: #1D1A34;color:white;padding: 10px 20px">
                    Change Password
                </a>
            </div>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
