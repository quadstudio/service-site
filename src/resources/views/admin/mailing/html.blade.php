<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{{$title}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="QuadStudio"/>
    <meta name="viewport"
          content="width=device-width, shrink-to-fit=no, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>

        body{
            font-family: Tahoma, Helvetica, Arial, monospace;
        }

        .content {
            background-color: #FFF;
            padding: 20px;
            border-top: 2px solid #ed9068;
        }

        a {
            font-weight: 400;
            color: #ed9068;
            text-decoration: none;
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            text-decoration: none;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            line-height: 1.6;
            border-radius: 0.25rem;
            -webkit-transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, -webkit-box-shadow 0.15s ease-in-out;
        }

        .btn-lg {
            padding: 0.5rem 1rem;
            font-size: 1.125rem;
            line-height: 1.5;
            border-radius: 0.3rem;
        }

        .btn-ferroli {
            color: #fff;
            background-color: #ed9068;
            border-color: #ed9068;
        }

        .btn-ferroli:hover {
            color: #fff;
            background-color: #d24c10;
            border-color: #d24c10;
        }

        .btn-ferroli:focus {
            -webkit-box-shadow: 0 0 0 0.2rem rgba(168, 60, 13, 0.5);
            box-shadow: 0 0 0 0.2rem rgba(168, 60, 13, 0.5);
        }

    </style>
</head>
<body>
<div class="content">
    {!!$content!!}
</div>
</body>
</html>