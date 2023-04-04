@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Bulk Edit
    @parent
@stop


@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <form class="form-horizontal" method="post" action="{{ route('models.bulkedit.store') }}" autocomplete="off" role="form">
                {{ csrf_field() }}

                <div class="box box-default">
                    <div class="box-header with-border">
                        <div class="box-title"><i class="fas fa-exclamation-triangle"></i>{{ trans('general.bulk_edit_about_to') }}</div>
                    </div>
                    <div class="box-body">

                        <table class="table">
                            <tbody>
                        @foreach ($models as $model)

                            <tr{!!  (($model->assets_count > 0 ) ? ' class="warning"' : ' class="success"') !!}>
                                    <td>
                                        <i class="fa {!!  (($model->assets_count > 0 ) ? 'fa-warning info' : 'fa-check success') !!}"></i>
                                        {{ $model->display_name }}  ({{ $model->model_number }})
                                        </td>
                                        <td>{{ $model->assets_count }} assets
                                    </td>
                            </tr>

                        @endforeach
                        </table>

                        <div class="col-md-12" style="padding-top: 20px;">
                            <!-- manufacturer -->
                            @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id'])

                            <!-- category -->
                            @include ('partials.forms.edit.category-select', ['translated_name' => trans('admin/categories/general.category_name'), 'fieldname' => 'category_id', 'required' => 'true', 'category_type' => 'asset'])

                            <!-- custom fields -->
                            <div class="form-group {{ $errors->has('fieldset_id') ? ' has-error' : '' }}">
                                <label for="category_id" class="col-md-3 control-label">
                                    {{ trans('admin/models/general.fieldset') }}
                                </label>
                                <div class="col-md-7">
                                    {{ Form::select('fieldset_id', $fieldset_list , old('fieldset_id', 'NC'), array('class'=>'select2 js-fieldset-field', 'style'=>'width:350px')) }}
                                    {!! $errors->first('fieldset_id', '<span class="alert-msg" aria-hidden="true"><br><i class="fas fa-times"></i> :message</span>') !!}
                                </div>
                            </div>

                            <!-- depreciation -->

                            <div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
                                <label for="category_id" class="col-md-3 control-label">
                                    {{ trans('general.depreciation') }}
                                </label>
                                <div class="col-md-7">
                                    {{ Form::select('depreciation_id', $depreciation_list , old('depreciation_id', 'NC'), array('class'=>'select2', 'style'=>'width:350px')) }}
                                    {!! $errors->first('depreciation_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                </div>
                            </div>

                            <!-- requestable -->
                                <div class="form-group {{ $errors->has('requestable') ? 'has-error' : '' }}">
                                <div class="col-md-7 col-md-offset-3">


                                    <div class="checkbox">
                                        <label for="requestable" class="form-control">
                                            {{ Form::radio('requestable', '', true, ['aria-label'=>'requestable']) }} {{  trans('admin/hardware/general.requestable_status_warning')}}<br>
                                            {{ Form::radio('requestable', '1', old('requestable'), ['aria-label'=>'requestable']) }}  {{  trans('admin/hardware/general.requestable')}} <br>
                                            {{ Form::radio('requestable', '0', old('requestable'), ['aria-label'=>'requestable']) }}  {{  trans('admin/hardware/general.not_requestable')}}

                                        </label>
                                    </div>

                                </div>
                                </div>

                            @foreach ($models as $model)
                                <input type="hidden" name="ids[{{ $model->id }}]" value="{{ $model->id }}">
                            @endforeach
                        </div>
                    </div> <!--/.box-body-->

                    <div class="text-right box-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>
                </div> <!--/.box.box-default-->
            </form>
        </div> <!--/.col-md-8-->
    </div>
@stop
