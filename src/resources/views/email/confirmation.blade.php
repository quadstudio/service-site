<!DOCTYPE html>
<html>
<head>
    <title>@lang('site::user.confirm_title')</title>
</head>
<body>
<h1>@lang('site::user.confirm_h1')</h1>
<p>@lang('site::user.confirm_text', ['url' => url("register/confirm/{$user->verify_token}")])</p>
</body>
</html>