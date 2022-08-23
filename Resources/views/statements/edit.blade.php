@extends('layouts.admin')

@section('title', trans('bank-statement::general.bankStatement'))

@section('new_button')
<div class="dropup header-drop-top">
    <button type="button" class="btn btn-white btn-sm" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-chevron-down"></i>&nbsp; {{ trans('general.more_actions') }}
    </button>

    <div class="dropdown-menu" role="menu">
        @stack('button_dropdown_start')

        @stack('button_print_start')
            <a class="dropdown-item" href="{{ route('bank-statement.print', $data['account']->id) }}" target="_blank">
                {{ trans('general.print') }}
            </a>
        @stack('button_print_end')
      
        @stack('button_pdf_start')
            <a class="dropdown-item" href="{{ route('bank-statement.pdf', $data['account']->id) }}">
                {{ trans('general.download_pdf') }}
            </a>
        @stack('button_pdf_end')

        @stack('button_dropdown_end')
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                {!! Form::open([
                    'id' => 'setting',
                    'method' => 'PATCH',
                    'route' => ['bank-statement.statement.update', $data['account']->id],
                    '@submit.prevent' => 'onSubmit',
                    '@keydown' => 'form.errors.clear($event.target.name)',
                    'files' => true,
                    'role' => 'form',
                    'class' => 'form-loading-button',
                    'novalidate' => true,
                ]) !!}
                <div class="card-header">
                    <h3 class="mb-0">{{ $data['account']->name }} {{ trans('bank-statement::general.bankStatement') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{ Form::dateGroup('dateFrom',  trans('bank-statement::general.from') , 'calendar', ['id' => 'dateFrom', 'class' => 'form-control datepicker', 'show-date-format' => 'd-m-Y', 'date-format' => 'd-m-Y', 'autocomplete' => 'off', 'required' => true], setting('bank-statement.dateFrom')) }}
                        {{ Form::dateGroup('dateUntil', trans('bank-statement::general.until') , 'calendar', ['id' => 'dateUntil', 'class' => 'form-control datepicker', 'show-date-format' => 'd-m-Y', 'date-format' => 'd-m-Y', 'autocomplete' => 'off', 'required' => true], setting('bank-statement.dateUntil')) }}
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row save-buttons">
                        {{ Form::saveButtons('accounts.index') }}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        <div class="col-md-8">
            <div class="card">
                <x-bank-statement::template :data="$data" :logo="$logo"/>
            </div>
        </div>
    </div>
@endsection

@push('scripts_start')
    <script src="{{ asset('public/js/settings/settings.js?v=' . version('short')) }}"></script>
@endpush