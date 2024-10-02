@extends('layouts.mail')

@section('content')
    <table class="bg-light body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0"
           style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;"
           bgcolor="#f7fafc">
        <tbody>
        <tr>
            <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f7fafc">
                <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0"
                       style="width: 100%;">
                    <tbody>
                    <tr>
                        <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                            <!--[if (gte mso 9)|(IE)]>
                            <table align="center" role="presentation">
                                <tbody>
                                <tr>
                                    <td width="600">
                            <![endif]-->
                            <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0"
                                   style="width: 100%; max-width: 600px; margin: 0 auto;">
                                <tbody>
                                <tr>
                                    <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                        <table class="s-10 w-full" role="presentation" border="0" cellpadding="0"
                                               cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                            <tr>
                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;"
                                                    align="left" width="100%" height="40">
                                                    &#160;
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="card" role="presentation" border="0" cellpadding="0"
                                               cellspacing="0"
                                               style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;"
                                               bgcolor="#ffffff">
                                            <tbody>
                                            <tr>
                                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;"
                                                    align="left" bgcolor="#ffffff">
                                                    <table class="card-body" role="presentation" border="0"
                                                           cellpadding="0" cellspacing="0" style="width: 100%;">
                                                        <tbody>
                                                        <tr>
                                                            <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 20px;"
                                                                align="left">
                                                                <h2 class="h3"
                                                                    style="padding-top: 0; padding-bottom: 0; font-weight: 500; vertical-align: baseline; font-size: 28px; line-height: 33.6px; margin: 0;"
                                                                    align="left">
                                                                    <strong>{{$title}}</strong>
                                                                </h2>
                                                                <table class="s-2 w-full" role="presentation" border="0"
                                                                       cellpadding="0" cellspacing="0"
                                                                       style="width: 100%;" width="100%">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="line-height: 8px; font-size: 8px; width: 100%; height: 8px; margin: 0;"
                                                                            align="left" width="100%" height="8">
                                                                            &#160;
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="s-5 w-full" role="presentation" border="0"
                                                                       cellpadding="0" cellspacing="0"
                                                                       style="width: 100%;" width="100%">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;"
                                                                            align="left" width="100%" height="20">
                                                                            &#160;
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="hr" role="presentation" border="0"
                                                                       cellpadding="0" cellspacing="0"
                                                                       style="width: 100%;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="line-height: 24px; font-size: 16px; border-top-width: 1px; border-top-color: #e2e8f0; border-top-style: solid; height: 1px; width: 100%; margin: 0;"
                                                                            align="left">
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="s-5 w-full" role="presentation" border="0"
                                                                       cellpadding="0" cellspacing="0"
                                                                       style="width: 100%;" width="100%">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;"
                                                                            align="left" width="100%" height="20">
                                                                            &#160;
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div class="space-y-3">
                                                                    <p class="text-gray-700"
                                                                       style="line-height: 24px; font-size: 16px; color: #4a5568; width: 100%; margin: 0;"
                                                                       align="left">
                                                                        Dear, {{$first_name}} {{$last_name}}
                                                                    </p>
                                                                    <table class="s-3 w-full" role="presentation"
                                                                           border="0" cellpadding="0" cellspacing="0"
                                                                           style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td style="line-height: 12px; font-size: 12px; width: 100%; height: 12px; margin: 0;"
                                                                                align="left" width="100%" height="12">
                                                                                &#160;
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p class="text-gray-700"
                                                                       style="line-height: 24px; font-size: 16px; color: #4a5568; width: 100%; margin: 0;"
                                                                       align="left">
                                                                        {{__('email.content.welcome_to_juicebox', ['app_name' => env('APP_NAME')])}}
                                                                    </p>
                                                                    <table class="s-3 w-full" role="presentation"
                                                                           border="0" cellpadding="0" cellspacing="0"
                                                                           style="width: 100%;" width="100%">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td style="line-height: 12px; font-size: 12px; width: 100%; height: 12px; margin: 0;"
                                                                                align="left" width="100%" height="12">
                                                                                &#160;
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <p class="text-gray-700"
                                                                       style="line-height: 24px; font-size: 16px; color: #4a5568; width: 100%; margin: 0;"
                                                                       align="left">
                                                                        {{__('email.content.your_signup_process_is_complete')}}
                                                                    </p>
                                                                </div>
                                                                <table class="s-5 w-full" role="presentation" border="0"
                                                                       cellpadding="0" cellspacing="0"
                                                                       style="width: 100%;" width="100%">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;"
                                                                            align="left" width="100%" height="20">
                                                                            &#160;
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="hr" role="presentation" border="0"
                                                                       cellpadding="0" cellspacing="0"
                                                                       style="width: 100%;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="line-height: 24px; font-size: 16px; border-top-width: 1px; border-top-color: #e2e8f0; border-top-style: solid; height: 1px; width: 100%; margin: 0;"
                                                                            align="left">
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="s-5 w-full" role="presentation" border="0"
                                                                       cellpadding="0" cellspacing="0"
                                                                       style="width: 100%;" width="100%">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;"
                                                                            align="left" width="100%" height="20">
                                                                            &#160;
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="btn btn-primary" role="presentation"
                                                                       border="0" cellpadding="0" cellspacing="0"
                                                                       style="border-radius: 6px; border-collapse: separate !important;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="line-height: 24px; font-size: 16px; border-radius: 6px; margin: 0;"
                                                                            align="center" bgcolor="#0d6efd">
                                                                            <a href="{{$website_url}}" target="_blank"
                                                                               style="color: #ffffff; font-size: 16px; font-family: Helvetica, Arial, sans-serif; text-decoration: none; border-radius: 6px; line-height: 20px; display: block; font-weight: normal; white-space: nowrap; background-color: #0d6efd; padding: 8px 12px; border: 1px solid #0d6efd;">
                                                                                {{__('email.label.lets_go_travel')}}
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <table class="s-10 w-full" role="presentation" border="0" cellpadding="0"
                                               cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                            <tr>
                                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;"
                                                    align="left" width="100%" height="40">
                                                    &#160;
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--[if (gte mso 9)|(IE)]>
                            </td>
                            </tr>
                            </tbody>
                            </table>
                            <![endif]-->
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
