<!DOCTYPE html>
<html>
  <head>
    <title>重新設定管理系統密碼</title>
  </head>
  <body>
    <div style="background-color:#f2f2f2">
      <center>
      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color:#f2f2f2">
        <tbody>
          <tr>
            <td align="center" valign="top" style="border-collapse:collapse;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif">
              <table border="0" cellpadding="2" cellspacing="0" width="100%" style="background-color:#006CA3;border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="border-collapse:collapse;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif"></td></tr></tbody></table>
            </td>
          </tr>
          <tr>
            <td align="center" valign="top" style="padding:40px 20px">
              <table border="0" cellpadding="0" cellspacing="0" style="width:600px">
                <tbody><tr>
                  <td align="center" valign="top" style="padding-bottom:30px">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:separate!important;border-radius:4px">
                      <tbody><tr>
                        <td align="center" valign="top" style="padding-top:40px;padding-right:40px;padding-bottom:0;padding-left:40px">
                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                              <tr>
                                <td valign="middle" width="100%" style="color:#606060;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif;font-size:15px;line-height:150%;text-align:left">
                                  <h1 style="color:#606060!important;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif;font-size:24px;font-weight:bold;letter-spacing:-1px;line-height:115%;margin:0;padding:0;text-align:center">重新設定管理系統密碼</h1>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" style="padding-top:40px;padding-right:40px;padding-bottom:40px;padding-left:40px">
                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                              <tr>
                                <td style="border-top:1px dotted #cccccc;padding-top:10px;padding-bottom:10px">
                                  <h2 style="color:#606060!important;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif;font-size:20px;letter-spacing:-.5px;line-height:115%;margin:0;padding:0;text-align:center">使用者</h2>
                                  <h2 style="color:#606060!important;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif;font-size:18px;letter-spacing:-.5px;line-height:115%;margin:0;padding:0;text-align:center">{{$user['name']}}</h2>
                                </td>
                              </tr>
                              <tr>
                                <td style="border-top:1px dotted #cccccc;padding-top:10px;padding-bottom:10px">
                                  <h2 style="color:#606060!important;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif;font-size:20px;letter-spacing:-.5px;line-height:115%;margin:0;padding:0;text-align:center">管理系統帳號</h2>
                                  <h2 style="color:#606060!important;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif;font-size:18px;letter-spacing:-.5px;line-height:115%;margin:0;padding:0;text-align:center">{{$user['email']}}</h2>
                                </td>
                              </tr>
                              <tr>
                                <td style="border-top:1px dotted #cccccc;padding-top:0px;padding-bottom:0px"></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" valign="middle" style="padding-right:40px;padding-bottom:40px;padding-left:40px">
                          <table border="0" cellpadding="0" cellspacing="0" style="background-color:#6dc6dd;border-collapse:separate!important;border-radius:3px">
                            <tbody>
                              <tr>
                                <td align="center" valign="middle" style="color:#ffffff;font-family:Helvetica,Arial,微軟正黑體,Microsoft Jhenghei,sans-serif;font-size:18px;letter-spacing:1px;font-weight:bold;line-height:100%;padding-top:18px;padding-right:15px;padding-bottom:15px;padding-left:15px">
                                  <a href="{{url($accessUrl.'/resetpassword/'.$code)}}" style="color:#ffffff;text-decoration:none" target="_blank">點此進入系統 重新設定密碼</a>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody></table>
                  </td>
                </tr>
                <tr>
                  <td align="center" valign="top">
                    @include('admin.emails.partials.company-info')
                  </td>
                </tr>
              </tbody></table>
            </td>
          </tr>
        </tbody>
      </table>
    </center>
  </body>
</html>