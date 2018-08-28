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
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.index') }}">@lang('site::product.cards')</a>
            </li>
            <li class="breadcrumb-item active">{{$product->name}}</li>
        </ol>
        <h1 class="header-title mb-4">{{$product->name()}}</h1>
        @alert()@endalert
        <div class=" border p-3 mb-4">
            <a href="{{route('admin.products.edit', $product)}}"
               class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit')</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-5">

                <!-- Project details -->
                <div class="card mb-4">
                    <h6 class="card-header">@lang('site::product.card')</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.name')</div>
                            <div>{{ $product->name }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.sku')</div>
                            <div>{{ $product->sku }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.brand_id')</div>
                            <div>{{ $product->brand->name }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.type_id')</div>
                            <div>{{ $product->type->name }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.quantity')</div>
                            <div>{{ $product->quantity }}</div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::messages.created_at')</div>
                            <div>{{ $product->created_at(true) }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::messages.updated_at')</div>
                            <div>{{ $product->updated_at(true) }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::order.orders')</div>
                            <div>{{$product->order_items()->count()}}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::serial.serials')</div>
                            <div>{{$product->serials()->count()}}</div>
                        </li>
                    </ul>
                </div>
                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">@lang('site::product.settings')</span>
                        <div class="card-header-elements ml-auto">
                            <a href="{{route('admin.products.edit', $product)}}" class="btn btn-sm btn-light">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </div>
                    </h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.enabled')</div>
                            <div>@bool(['bool' => $product->enabled == 1])@endbool</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.active')</div>
                            <div>@bool(['bool' => $product->active == 1])@endbool</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.warranty')</div>
                            <div>@bool(['bool' => $product->warranty == 1])@endbool</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.service')</div>
                            <div>@bool(['bool' => $product->service == 1])@endbool</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.description')</div>
                            <div>{!! $product->description !!}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="text-muted">@lang('site::product.equipment_id')</div>
                            <div>
                                @if($product->equipment)
                                    <a href="{{route('admin.equipments.show', $product->equipment)}}">{{$product->equipment->name}}</a>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big">{{$product->prices()->count()}}</span>
                            @lang('site::price.prices')
                        </span>
                    </h6>
                    <div class="card-body">
                        <table class="table table-sm ">
                            <tbody>
                            @foreach($product->prices as $price)
                                <tr>
                                    <td>{{$price->type->name}}</td>
                                    <td>{{$price->price}}</td>
                                    <td>{{$price->currency->name}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big" id="images-count">{{$product->images()->count()}}</span>
                            @lang('site::image.images')
                        </span>
                        <div class="card-header-elements ml-auto">
                            <a data-toggle="collapse" href="#collapseImages" role="button" aria-expanded="false"
                               aria-controls="collapseImages" class="btn btn-light btn-sm">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </h6>
                    <div class="card-body py-3 collapse" id="collapseImages">
                        <form method="POST" enctype="multipart/form-data"
                              action="{{route('admin.products.images.store', $product)}}">
                            @csrf
                            <div class="form-group form-control{{ $errors->has('path') ? ' is-invalid' : '' }}">
                                <input type="file" name="path"/>
                                <input type="hidden" name="storage" value="products"/>
                                <input type="button" class="btn btn-ferroli image-upload-button"
                                       value="@lang('site::messages.load')">

                            </div>
                            <span class="invalid-feedback">{{ $errors->first('path') }}</span>
                        </form>
                    </div>
                    <div class="card-body p-3">
                        <div class="row no-gutters" data-target="{{route('admin.products.images.sort', $product)}}" id="sort-list">
                            @foreach($product->images()->orderBy('sort_order')->get() as $image)
                                @include('site::admin.product.show.image')
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big" id="product-analogs-count">
                                {{$product->analogs()->count()}}
                            </span>
                            @lang('site::analog.analogs')
                        </span>
                        <div class="card-header-elements ml-auto">
                            <a data-toggle="collapse" href="#collapseAnalogs" role="button" aria-expanded="false"
                               aria-controls="collapseAnalogs" class="btn btn-light btn-sm">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </h6>
                    <div class="card-body py-3 collapse" id="collapseAnalogs">
                        <form id="analog-add-form"
                              method="POST"
                              action="{{ route('admin.analogs.store', $product) }}">
                            @csrf
                            <div class="form-group">
                                <select name="analog_id" class="form-control" id="analog_search"
                                        title="">

                                </select>
                                <span class="invalid-feedback">Такая деталь ужде есть в списке</span>
                                <div id="analogHelp" class="d-block form-text text-success">
                                    Введите артикул или наименование аналога
                                </div>

                            </div>
                            <button class="btn btn-ferroli"
                                    name="mirror"
                                    value="0"
                                    type="submit">
                                <i class="fa fa-check"></i> @lang('site::messages.save')
                            </button>
                            <button class="btn btn-ferroli"
                                    name="mirror"
                                    value="1"
                                    type="submit">
                                <i class="fa fa-exchange"></i> @lang('site::messages.save')
                                @lang('site::messages.mirror')
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group list-group-flush" id="product-analogs-list">
                            @foreach($product->analogs as $analog)
                                @include('site::admin.product.show.analog')
                            @endforeach
                        </ul>
                    </div>

                </div>

                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big" id="product-back-relations-count">
                                {{$product->back_relations()->count()}}
                            </span>
                            @lang('site::relation.header.back_relations')
                        </span>
                        <div class="card-header-elements ml-auto">
                            <a data-toggle="collapse" href="#collapseBackRelations" role="button"
                               aria-expanded="false"
                               aria-controls="collapseBackRelations" class="btn btn-light btn-sm">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </h6>
                    <div class="card-body py-3 collapse" id="collapseBackRelations">
                        <form class="relation-add-form"
                              method="POST"
                              action="{{ route('admin.relations.store', $product) }}">
                            <input type="hidden" name="back" value="1"/>
                            @csrf
                            <div class="form-group">
                                <select name="relation_id" class="form-control relation_search"
                                        title="">
                                </select>
                                <span class="invalid-feedback">Такое оборудование ужде есть в списке</span>
                                <div id="backRelationHelp" class="d-block form-text text-success">
                                    Введите артикул или наименование оборудования
                                </div>

                            </div>
                            <button class="btn btn-ferroli" data-target="#product-back-relations-list"
                                    type="submit">
                                <i class="fa fa-check"></i> @lang('site::messages.save')
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group list-group-flush" id="product-back-relations-list">
                            @foreach($product->back_relations()->orderBy('name')->get() as $relation)
                                @include('site::admin.product.show.relation', ['back' => 1])
                            @endforeach
                        </ul>
                    </div>

                </div>

                <div class="card mb-4">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big" id="product-relations-count">
                                {{$product->relations()->count()}}
                            </span>
                            @lang('site::relation.header.relations')
                        </span>
                        <div class="card-header-elements ml-auto">
                            <a data-toggle="collapse" href="#collapseRelations" role="button"
                               aria-expanded="false"
                               aria-controls="collapseRelations" class="btn btn-light btn-sm">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </h6>
                    <div class="card-body py-3 collapse" id="collapseRelations">
                        <form class="relation-add-form"
                              method="POST"
                              action="{{ route('admin.relations.store', $product) }}">
                            <input type="hidden" name="back" value="0"/>
                            @csrf
                            <div class="form-group">
                                <select name="relation_id" class="form-control relation_search"
                                        title="">
                                </select>
                                <span class="invalid-feedback">Такая деталь ужде есть в списке</span>
                                <div id="backRelationHelp" class="d-block form-text text-success">
                                    Введите артикул или наименование детали
                                </div>

                            </div>
                            <button class="btn btn-ferroli" data-target="#product-relations-list"
                                    type="submit">
                                <i class="fa fa-check"></i> @lang('site::messages.save')
                            </button>
                        </form>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group list-group-flush" id="product-relations-list">
                            @foreach($product->relations()->orderBy('name')->get() as $relation)
                                @include('site::admin.product.show.relation', ['back' => 0])
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


