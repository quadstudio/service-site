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
        <h1 class="header-title mb-4">{{$product->name}}</h1>
        @alert()@endalert
        <div class=" border p-3 mb-2">
            <a href="{{route('admin.products.edit', $product)}}"
               class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-pencil"></i>
                <span>@lang('site::messages.edit')</span>
            </a>
            <a href="{{route('admin.products.images', $product)}}"
               class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-@lang('site::image.icon')"></i>
                <span>@lang('site::image.images')</span> <span
                        class="badge badge-light">{{$product->images()->count()}}</span>
            </a>
            <a href="{{route('admin.products.analogs', $product)}}"
               class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-@lang('site::analog.icon')"></i>
                <span>@lang('site::analog.analogs')</span>
                <span class="badge badge-light product-analogs-count">{{$product->analogs()->count()}}</span>
            </a>
            <a href="{{route('admin.products.relations', $product)}}"
               class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-@lang('site::relation.icon')"></i>
                <span>@lang('site::relation.header.relations')</span>
                <span class="badge badge-light product-relations-count">{{$product->relations()->count()}}</span>
            </a>
            <a href="{{route('admin.products.back_relations', $product)}}"
               class="btn btn-ferroli d-block d-sm-inline mr-0 mr-sm-1 mb-1 mb-sm-0">
                <i class="fa fa-@lang('site::relation.back_icon')"></i>
                <span>@lang('site::relation.header.back_relations')</span>
                <span class="badge badge-light product-back-relations-count">{{$product->back_relations()->count()}}</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="d-block d-sm-inline btn btn-secondary">
                <i class="fa fa-reply"></i>
                <span>@lang('site::messages.back')</span>
            </a>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-5">

                <!-- Project details -->
                <div class="card mb-2">
                    <h6 class="card-header">@lang('site::product.card')</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <a href="{{route('products.show', $product)}}">
                                <i class="fa fa-folder-open"></i>
                                @lang('site::messages.open') @lang('site::messages.in_front')
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.name')</div>
                            <div>{{ $product->name }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.sku')</div>
                            <div>{{ $product->sku }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.old_sku')</div>
                            <div>{{ $product->old_sku }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.brand_id')</div>
                            <div>{{ $product->brand->name }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.type_id')</div>
                            <div>{{ $product->type->name }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.quantity')</div>
                            <div>{{ $product->quantity }}</div>
                        </li>
                        @if($product->mounted($product->id)->exists())
                            <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                                <div class="text-muted">@lang('site::mounting_bonus.header.mounting_bonus')</div>
                                <div>

                                    @if($product->mounting_bonus)
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-sm py-0 btn-ferroli dropdown-toggle"
                                                    type="button"
                                                    id="dropdownMenuButton"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ $product->mounting_bonus->value }} + {{ $product->mounting_bonus->social }}
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    <a class="dropdown-item"
                                                       href="{{route('admin.mounting-bonuses.edit', $product->mounting_bonus)}}">
                                                        <i class="fa fa-pencil"></i> @lang('site::messages.edit')
                                                    </a>
                                                <button class="dropdown-item btn-row-delete"
                                                        data-form="#mounting-bonus-delete-form-{{$product->mounting_bonus->id}}"
                                                        data-btn-delete="@lang('site::messages.delete')"
                                                        data-btn-cancel="@lang('site::messages.cancel')"
                                                        data-label="@lang('site::messages.delete_confirm')"
                                                        data-message="@lang('site::messages.delete_sure') @lang('site::mounting_bonus.mounting_bonus')? "
                                                        data-toggle="modal" data-target="#form-modal"
                                                        title="@lang('site::messages.delete')">
                                                    <i class="fa fa-close"></i>
                                                    @lang('site::messages.delete')
                                                </button>

                                            </div>
                                        </div>
                                        <form id="mounting-bonus-delete-form-{{$product->mounting_bonus->id}}"
                                              action="{{route('admin.mounting-bonuses.destroy', $product->mounting_bonus)}}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    @else
                                        <a class="btn btn-sm btn-ferroli py-0" href="{{route('admin.mounting-bonuses.create', ['product_id' => $product->id])}}">
                                            <i class="fa fa-plus"></i> @lang('site::messages.add')
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::messages.created_at')</div>
                            <div>{{ $product->created_at ? $product->created_at->format('d.m.Y H:i') : null }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::messages.updated_at')</div>
                            <div>{{ $product->updated_at ? $product->updated_at->format('d.m.Y H:i') : null }}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::order.orders')</div>
                            <div>{{$product->order_items()->count()}}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::serial.serials')</div>
                            <div>{{$product->serials()->count()}}</div>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.enabled')</div>
                            <div>@bool(['bool' => $product->enabled == 1])@endbool</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.active')</div>
                            <div>@bool(['bool' => $product->active == 1])@endbool</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.warranty')</div>
                            <div>@bool(['bool' => $product->warranty == 1])@endbool</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.service')</div>
                            <div>@bool(['bool' => $product->service == 1])@endbool</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.description')</div>
                            <div>{!! $product->description !!}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.equipment_id')</div>
                            <div>
                                @if($product->equipment)
                                    <a href="{{route('admin.equipments.show', $product->equipment)}}">{{$product->equipment->name}}</a>
                                @endif
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.h1')</div>
                            <div>{!! $product->h1 !!}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.title')</div>
                            <div>{!! $product->title !!}</div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                            <div class="text-muted">@lang('site::product.metadescription')</div>
                            <div>{!! $product->metadescription !!}</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big">{{$prices->count()}}</span>
                            @lang('site::price.prices')
                        </span>
                    </h6>
                    <div class="card-body">
                        <table class="table table-sm ">
                            <tbody>
                            @foreach($prices as $price)
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
                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big"
                                  id="images-count">{{$product->images()->count()}}</span>
                            @lang('site::image.images')
                        </span>
                        <div class="card-header-elements ml-auto">
                            <a href="{{route('admin.products.images', $product)}}" class="btn btn-light btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </div>
                    </h6>
                    <div class="card-body p-3">
                        <div class="row no-gutters" data-target="{{route('admin.products.images.sort', $product)}}"
                             id="sort-list">
                            @foreach($product->images()->orderBy('sort_order')->get() as $image)
                                @include('site::admin.product.show.image')
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big product-analogs-count">
                                {{$product->analogs()->count()}}
                            </span>
                            @lang('site::analog.analogs')
                        </span>
                        <div class="card-header-elements ml-auto">
                            <a href="{{route('admin.products.analogs', $product)}}" class="btn btn-light btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </div>
                    </h6>
                    <div class="card-body p-3">
                        <ul class="list-group list-group-flush" id="product-analogs-list">
                            @foreach($product->analogs as $analog)
                                @include('site::admin.product.show.analog')
                            @endforeach
                        </ul>
                    </div>

                </div>

                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big product-back-relations-count">
                                {{$product->back_relations()->count()}}
                            </span>
                            @lang('site::relation.header.back_relations')
                        </span>
                        <div class="card-header-elements ml-auto">
                            <a href="{{route('admin.products.back_relations', $product)}}" class="btn btn-light btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </div>
                    </h6>
                    <div class="card-body p-3">
                        <ul class="list-group list-group-flush" id="product-back-relations-list">
                            @foreach($product->back_relations()->orderBy('name')->get() as $relation)
                                @include('site::admin.product.show.back_relation')
                            @endforeach
                        </ul>
                    </div>

                </div>

                <div class="card mb-2">
                    <h6 class="card-header with-elements">
                        <span class="card-header-title">
                            <span class="badge badge-warning text-big product-relations-count">
                                {{$product->relations()->count()}}
                            </span>
                            @lang('site::relation.header.relations')
                        </span>
                        <div class="card-header-elements ml-auto">
                            <a href="{{route('admin.products.relations', $product)}}" class="btn btn-light btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </div>
                    </h6>
                    <div class="card-body p-3">
                        <ul class="list-group list-group-flush" id="product-relations-list">
                            @foreach($product->relations()->orderBy('name')->get() as $relation)
                                @include('site::admin.product.show.relation')
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


