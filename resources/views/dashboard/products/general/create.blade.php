@extends('layouts.admin')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">{{ __('Home') }}</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">{{ __('Products') }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Add Product') }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">{{ __('Add Product') }}</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{ route('admin.products.store') }}"
                                              method="post" enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{ __('Product Name') }}</label>
                                                            <input type="text" value="{{old('name')}}" id="name"
                                                                   class="form-control"
                                                                   placeholder="{{ __('Product Name') }}"
                                                                   name="name" required>
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{ __('Slug') }}</label>
                                                            <input type="text" value="{{old('slug')}}" id="slug"
                                                                   class="form-control"
                                                                   placeholder="{{ __('Slug') }}"
                                                                   name="slug" required>
                                                            @error("slug")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput4">{{ __('Product Description') }}</label>
                                                            <textarea type="text" value="{{old('description')}}" id="projectinput4"
                                                                   class="form-control"
                                                                   placeholder="{{ __('Product Description') }}"
                                                                      name="description"></textarea>
                                                            @error("description")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput5">{{ __('Short Description') }}</label>
                                                            <textarea type="text" value="{{old('short_description')}}" id="projectinput5"
                                                                   class="form-control"
                                                                   placeholder="{{ __('Short Description') }}"
                                                                      name="short_description"></textarea>
                                                            @error("short_description")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="row" id="cats_list">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label
                                                                for="categories">{{ __('Select Category') }}</label>
                                                            <select name="categories[]" id="categories"
                                                                    class="select2 form-control" multiple>
                                                                <option
                                                                    value="">{{ __('Select Category') }}</option>
                                                                @if(count($categories) > 0)
                                                                    @foreach($categories as $category)
                                                                        <option
                                                                            value="{{$category->id}}">{{$category->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error("categories")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label
                                                                for="tags">{{ __('Select Tag') }}</label>
                                                            <select name="tags[]" id="tags"
                                                                    class="select2 form-control" multiple>
                                                                <option
                                                                    value="">{{ __('Select Tag') }}</option>
                                                                @if(count($tags) > 0)
                                                                    @foreach($tags as $tag)
                                                                        <option
                                                                            value="{{$tag->id}}">{{$tag->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error("tags")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label
                                                                for="brand_id">{{ __('Select Brand') }}</label>
                                                            <select name="brand_id" id="brand_id"
                                                                    class="select2 form-control">
                                                                <option
                                                                    value="">{{ __('Select Brand') }}</option>
                                                                @if(count($brands) > 0)
                                                                    @foreach($brands as $brand)
                                                                        <option
                                                                            value="{{$brand->id}}">{{$brand->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @error("brand_id")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                   name="is_active"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success" checked/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">{{ __('Status') }}</label>
                                                            @error("is_active")
                                                            <span class="text-danger">{{$message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    </div>


                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1"
                                                            onclick="history.back();">
                                                        <i class="ft-x"></i> تراجع
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> حفظ
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('input:radio[name="type"]').change(
            function () {
                if (this.checked && this.value == '2') {
                    $('#cats_list').removeClass('hidden');
                } else {
                    $('#cats_list').addClass('hidden');
                }
            });
    </script>
@endsection
