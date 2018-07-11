<!DOCTYPE html>
<html>
<head>
    <title>@lang('site::user.confirm_title')</title>
</head>
<body>
<h1>Спасибо бла-бла-бла</h1>
<p><a href="{{ url("register/confirm/{$user->verify_token}") }}">Подтвердить свой E-mail адрес</a></p>
</body>
</html>