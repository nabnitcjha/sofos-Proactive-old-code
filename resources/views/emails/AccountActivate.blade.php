 

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
            <p style="text-align:center;color:#474747;font-size:28px;line-height:24px;font-family:'poppins', sans-serif;font-weight:600;margin:1em 0 30px">Please Use the following  credentials for login</p>
            </p>
            </td>
        </tr>
        <tr>
            <td style="font-family:Verdana,Arial;font-weight:normal;border-collapse:collapse;vertical-align:top;padding:0 30px;background:#ffffff;text-align:left;width:100%;">
                <p style="text-align:center;color:#474747;font-size:28px;line-height:24px;font-family:'poppins', sans-serif;font-weight:600;margin:1em 0 30px"><span>useremail:</span><span>{{$user->email}}</span></p>
                <p style="text-align:center;color:#696464;font-size:16px;line-height:24px;font-family:'poppins', sans-serif;font-weight:500;"><span>password:</span><span>{{$dynamicPassword}}</span></p>
                <p style="text-align:center;color:#474747;font-size:28px;line-height:24px;font-family:'poppins', sans-serif;font-weight:600;margin:1em 0 30px"><span>Login Link:</span><span>http://9dd132dd2889.ngrok.io</span></p>
                </p>
            </td>
        </tr>
</table>
@endcomponent
 