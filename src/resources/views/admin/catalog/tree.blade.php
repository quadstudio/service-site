@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin') }}">@lang('site::messages.admin')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::catalog.catalogs')</li>
        </ol>
        <h1 class="header-title m-t-0 m-b-20"><i
                    class="fa fa-@lang('site::catalog.icon')"></i> @lang('site::catalog.catalogs')</h1>
        <hr/>

        @alert()@endalert

        <div class="row">
            <div class="col-12 mb-2">
                <a class="btn btn-success" href="{{ route('admin.catalogs.create') }}" role="button">
                    <i class="fa fa-plus"></i>
                    <i class="fa fa-folder-open"></i>
                    <span>@lang('site::messages.add') @lang('site::catalog.catalog')</span>
                </a>
                <a href="{{ route('admin.catalogs.index') }}" class="btn btn-secondary">
                    <i class="fa fa-bars"></i>
                    <span>@lang('site::messages.open') @lang('site::catalog.grid')</span>
                </a>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="clt">
                    @include('site::admin.catalog.tree.tree', ['value' => $tree, 'level' => 0])
                </div>
            </div>
        </div>


    </div>
    <style>
        .tree ul {
            margin-left: 20px;
            -webkit-padding-start: 20px;
        }

        .tree li {
            list-style-type: none;
            margin: 10px;
            position: relative;
        }

        .tree li a::before {
            content: "";
            position: absolute;
            top: -6px;
            left: -10px;
            border-left: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-radius: 0 0 0 0;
            width: 10px;
            height: 15px;
        }

        .tree li a::after {
            position: absolute;
            content: "";
            top: 8px;
            left: -10px;
            border-left: 1px solid #ccc;
            border-top: 1px solid #ccc;
            border-radius: 0 0 0 0;
            width: 10px;
            height: 100%;
        }

        .tree li:last-child::after {
            display: none;
        }

        .tree li:last-child:before {
            border-radius: 0 0 0 0;
        }

        /*.tree li:last-child a:after {*/
        /*border: none;*/
        /*}*/

        ul.tree > li:first-child::before {
            display: none;
        }

        ul.tree > li:first-child::after {
            border-radius: 0 0 0 0;
        }

        .tree li a {
            border: 1px #ccc solid;
            border-radius: 0;
            padding: 2px 5px;
        }

        .tree li a:hover,
        .tree li a:hover ~ ul li a,
        .tree li a:focus,
        .tree li a:focus ~ ul li a {
            background: #BBDEFB;
            /*color: #000; */
            border: 1px solid #007bff;
        }

        .tree li a:hover + ul li::after,
        .tree li a:focus + ul li::after,
        .tree li a:hover + ul li::before,
        .tree li a:focus + ul li::before,
        .tree li a:hover + ul::before,
        .tree li a:focus + ul::before,
        .tree li a:hover + ul ul::before,
        .tree li a:focus + ul ul::before {
            border-color: #007bff; /*connector color on hover*/
        }

    </style>
@endsection
