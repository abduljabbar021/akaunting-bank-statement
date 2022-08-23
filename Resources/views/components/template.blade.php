<div class="container" style="padding:3%">
    <div class="row"
        style="padding:3%; color: white; background-color:{{ $data['color'] }} !important; -webkit-print-color-adjust: exact">
        <div class="col-6">
            <img src="{{ $logo }}" width="150" height="150">
        </div>
        <div class="col-6 text-right" style="padding-top: 2%; font-size: 18px; font-weight: bold;">
            <p>{{ setting('company.name') }}</p>
            <p>{{ setting('company.email') }}</p>
            <p>{{ setting('company.address') }}</p>
            <p>{{ setting('company.phone') }}</p>
        </div>
    </div>

    <div class="row"
        style="opacity: 0.9; color: white; background-color:{{ $data['color'] }} !important; -webkit-print-color-adjust: exact;">
        <div class="col-12 text-center" style="padding-top: 2px;">
            <b style="font-size: 22px;">{{ trans('bank-statement::general.template.statementOf') }}</b>
            <p>{{ setting('bank-statement.dateFrom') }} {{ trans('bank-statement::general.template.todate') }} {{ setting('bank-statement.dateUntil') }}</p>
        </div> 
    </div>

    <div class="row mt-3">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="font-size: 20px">
            <h2>{{ $data['account']->name }}</h2>
            <h3>{{ trans('bank-statement::general.bankStatement') }}</h3>
        </div>
        <div class="col-6">
            <table class="table">
                <thead
                    style="background-color:{{ $data['color'] }} !important; -webkit-print-color-adjust: exact;">
                    <tr>
                        <th scope="col-6">{{ trans('bank-statement::general.template.accountSummary') }}</th>
                        <th scope="col-6"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ trans('bank-statement::general.template.openingBalance') }}</td>
                        <td>@money($data['opening'], setting('default.currency'), true)</td>
                    </tr>
                    <tr style="border-top: 2px solid {{ $data['color'] }} !important; -webkit-print-color-adjust: exact;">
                        <td>{{ trans('bank-statement::general.template.closingBalance') }}</td>
                        <td>@money($data['closing'], setting('default.currency'), true)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-10">
        <div class="col-12">
            <div class="table-responsive-md">
                <table class="table table-condensed">
                    <thead
                        style="background-color:{{ $data['color'] }} !important; -webkit-print-color-adjust: exact;">
                        <tr class="text-center">
                            <th scope="col">{{ trans('general.date') }}</th>
                            <th scope="col">{{ trans('bank-statement::general.template.description') }}</th>
                            <th scope="col">{{ trans('bank-statement::general.template.debit') }}</th>
                            <th scope="col">{{ trans('bank-statement::general.template.credit') }}</th>
                            <th scope="col">{{ trans('bank-statement::general.template.balance') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['transactions'] as $key => $a)
                            <tr class="text-center">
                                <td>@date($a->paid_at)</td>
                                <td style="white-space: normal !important;">{{ $a->description.($a->document_number ? ' ('.$a->document_number.')' : '').($a->currency_rate != 1 ? ' (c. rate '.$a->currency_rate.')' : '') }}</td>
                                @if($a->type === 'income')
                                    @php
                                        $data['debit'] += ($a->amount * $a->currency_rate);
                                        $data['balance'] += ($a->amount * $a->currency_rate);
                                        echo '<td>'.@money($a->amount, $a->currency_code, true).'</td><td></td>';
                                    @endphp
                                @else
                                    @php
                                        $data['credit'] += ($a->amount * $a->currency_rate);
                                        $data['balance'] -= ($a->amount * $a->currency_rate);
                                        echo '<td></td><td>'.@money($a->amount, $a->currency_code, true).'</td>';
                                    @endphp
                                @endif
                                <td>@money($data['balance'], setting('default.currency'), true)</td>
                            </tr>
                        @endforeach
                            <tr class="text-center text-white" style="background-color:{{ $data['color'] }} !important; -webkit-print-color-adjust: exact;">
                                <td>{{ trans('customer-statement::general.template.total') }}</td>
                                <td></td>
                                <td>@money($data['debit'], setting('default.currency'), true)</td>
                                <td>@money($data['credit'], setting('default.currency'), true)</td>
                                <td>@money($data['balance'], setting('default.currency'), true)</td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

@push('stylesheet')
    <style type="text/css">
        th {
            color: white !important;
        }
        tr{
            margin: 0 !important;
        }
        .table-condensed th, .table-condensed td{
            padding: 0.5rem !important;
        }
        tr.text-white > th, tr.text-white > td{
            color : #fff !important;
        }
    </style>
@endpush
