@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}">@lang('site::messages.index')</a>
            </li>
            <li class="breadcrumb-item active">@lang('site::messages.admin')</li>
        </ol>
        <h1 class="header-title mb-4"><i class="fa fa-dashboard"></i> @lang('site::messages.admin')</h1>
        <hr/>
        @alert()@endalert
        <div class="row">
            <div class="d-flex col-xl-6 align-items-stretch">

                <!-- Stats + Links -->
                <div class="card d-flex w-100 mb-4">
                    <div class="row no-gutters row-bordered row-border-light h-100">
                        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">

                            <a href="javascript:void(0)" class="card-body media align-items-center text-dark">
                                <i class="lnr lnr-chart-bars display-4 d-block text-primary"></i>
                                <span class="media-body d-block ml-3">
                          <span class="text-big font-weight-bolder">$1,342.11</span>
                          <br>
                          <small class="text-muted">Earned this month</small>
                        </span>
                            </a>

                        </div>
                        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">

                            <a href="javascript:void(0)" class="card-body media align-items-center text-dark">
                                <i class="lnr lnr-hourglass display-4 d-block text-primary"></i>
                                <span class="media-body d-block ml-3">
                          <span class="text-big">
                            <span class="font-weight-bolder">152</span> Working Hours</span>
                          <br>
                          <small class="text-muted">Spent this month</small>
                        </span>
                            </a>

                        </div>
                        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">

                            <a href="javascript:void(0)" class="card-body media align-items-center text-dark">
                                <i class="lnr lnr-checkmark-circle display-4 d-block text-primary"></i>
                                <span class="media-body d-block ml-3">
                          <span class="text-big">
                            <span class="font-weight-bolder">54</span> Tasks</span>
                          <br>
                          <small class="text-muted">Completed this month</small>
                        </span>
                            </a>

                        </div>
                        <div class="d-flex col-sm-6 col-md-4 col-lg-6 align-items-center">

                            <a href="javascript:void(0)" class="card-body media align-items-center text-dark">
                                <i class="lnr lnr-license display-4 d-block text-primary"></i>
                                <span class="media-body d-block ml-3">
                          <span class="text-big">
                            <span class="font-weight-bolder">6</span> Projects</span>
                          <br>
                          <small class="text-muted">Done this month</small>
                        </span>
                            </a>

                        </div>
                    </div>
                </div>
                <!-- / Stats + Links -->

            </div>
            <div class="d-flex col-xl-6 align-items-stretch">

                <!-- Daily progress chart -->
                <div class="card w-100 mb-4">
                    <div class="card-body">
                        <button type="button" class="btn btn-sm btn-outline-primary icon-btn float-right">
                            <i class="ion ion-md-sync"></i>
                        </button>
                        <div class="text-muted small">Working hours</div>
                        <div class="text-big">Daily Progress</div>
                    </div>
                    <div class="px-2 mt-4">
                        <div class="w-100" style="height: 120px;">
                            <canvas id="statistics-chart-1" width="541" height="120" style="display: block; width: 541px; height: 120px;"></canvas>
                        </div>
                    </div>
                </div>
                <!-- / Daily progress chart -->

            </div>

            <div class="col-xl-5">

                <!-- Tasks -->
                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <div class="card-header-title">Tasks</div>
                        <div class="card-header-elements ml-auto">
                            <button type="button" class="btn btn-default btn-xs md-btn-flat">Show more</button>
                        </div>
                    </h6>
                    <div class="card-body">
                        <p class="text-muted small">Today</p>
                        <div class="custom-controls-stacked">
                            <label class="ui-todo-item custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Buy products</span>
                                <span class="ui-todo-badge badge badge-outline-default font-weight-normal ml-2">58 mins left</span>
                            </label>
                            <label class="ui-todo-item custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Reply to emails</span>
                            </label>
                            <label class="ui-todo-item custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Write blog post</span>
                                <span class="ui-todo-badge badge badge-outline-default font-weight-normal ml-2">20 hours left</span>
                            </label>
                            <label class="ui-todo-item custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" checked="">
                                <span class="custom-control-label">Wash my car</span>
                            </label>
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="card-body">
                        <p class="text-muted small">Tomorrow</p>
                        <div class="custom-controls-stacked">
                            <label class="ui-todo-item custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Buy antivirus</span>
                            </label>
                            <label class="ui-todo-item custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-label">Jane's Happy Birthday</span>
                            </label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type your task">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-ferroli">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Tasks -->

            </div>
            <div class="col-xl-7">

                <!-- Stats -->
                <div class="row">
                    <div class="col-md-6">

                        <div class="card mb-4">
                            <h6 class="card-header with-elements border-0 pr-0 pb-0">
                                <div class="card-header-title">Revenue</div>
                                <div class="card-header-elements ml-auto">
                                    <div class="btn-group mr-3">
                                        <button type="button" class="btn btn-sm btn-default icon-btn borderless btn-round md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown">
                                            <i class="ion ion-ios-more"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" id="revenue-dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0)">Action 1</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Action 2</a>
                                        </div>
                                    </div>
                                </div>
                            </h6>
                            <div class="mt-5">
                                <div style="height:120px;">
                                    <canvas id="statistics-chart-2" width="314" height="120" style="display: block; width: 314px; height: 120px;"></canvas>
                                </div>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="text-muted small">Target</div>
                                        <strong class="text-big">$2,000.00</strong>
                                    </div>
                                    <div class="col">
                                        <div class="text-muted small">Last month</div>
                                        <strong class="text-big">$2,835.22</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="card pt-2 mb-4">
                            <div class="d-flex align-items-center position-relative mt-4" style="height:110px;">
                                <div class="w-100 position-absolute" style="height:110px;top:0;">
                                    <canvas id="statistics-chart-3" width="314" height="110" style="display: block; width: 314px; height: 110px;"></canvas>
                                </div>
                                <div class="w-100 text-center text-large">54</div>
                            </div>
                            <div class="text-center pb-2 my-3">
                                Tasks completed
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="text-muted small">Target</div>
                                        <strong class="text-big">100</strong>
                                    </div>
                                    <div class="col">
                                        <div class="text-muted small">Last month</div>
                                        <strong class="text-big">85</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="card mb-4">
                            <h6 class="card-header with-elements">
                                <div class="card-header-title">Task to Do</div>
                                <div class="card-header-elements ml-auto">
                                    <button type="button" class="btn btn-outline-secondary btn-xs icon-btn borderless">→</button>
                                </div>
                            </h6>
                            <div class="card-body d-flex justify-content-between">
                                <div class="text-large">14</div>
                                <div class="text-right small">
                                    10%
                                    <br>Last week: 12
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="card mb-4">
                            <h6 class="card-header with-elements">
                                <div class="card-header-title">Overdue tasks</div>
                                <div class="card-header-elements ml-auto">
                                    <button type="button" class="btn btn-outline-secondary btn-xs icon-btn borderless">→</button>
                                </div>
                            </h6>
                            <div class="card-body d-flex justify-content-between">
                                <div class="text-large">5</div>
                                <div class="text-right small">
                                    10%
                                    <br>Last week: 12
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- / Stats -->

            </div>
        </div>
    </div>
@endsection
