 

@component('mail::panel')
<table  cellpadding="0" cellspacing="0" width="100%" style="background-color:fff;border-left:unset;border:unset;">
        <tr>
            <td style="font-family:Verdana,Arial;font-weight:normal;border-collapse:collapse;vertical-align:top;padding:0 30px;background:#ffffff;text-align:left;width:100%;">
                <p style="text-align:center;color:#474747;font-size:28px;line-height:24px;font-family:'poppins', sans-serif;font-weight:600;margin:1em 0 30px">Hi, {{$user->name}}</p>
                <p style="text-align:center;color:#696464;font-size:16px;line-height:24px;font-family:'poppins', sans-serif;font-weight:500;">You are Register for Proactive Tutors</p>
                </p>
            </td>
        </tr>
        <tr style="background-color:fff;">
            <td>
            <p style="text-align:center;color:#474747;font-size:28px;line-height:24px;font-family:'poppins', sans-serif;font-weight:600;margin:1em 0 30px">Please click on below link to reset the password</p>
            </p>
            </td>
        </tr>
        <tr>
            <td style="font-family:Verdana,Arial;font-weight:normal;border-collapse:collapse;vertical-align:top;padding:0 30px;background:#ffffff;text-align:center;width:100%;">
            <a style="text-decoration: none;font-family: Verdana,Arial;text-transform: uppercase;font-size: 12px;color: #fff;border: solid 1px #fe9435;border-radius:5px;background-color: #fe9435; padding: 14px 32px; letter-spacing: 3.6px; display: inline-block;margin-bottom:10%;" href="{{url('/#/reset-password/'.$user->id)}}">Reset Password</a>
            </td>
        </tr>
</table>
@endcomponent
 