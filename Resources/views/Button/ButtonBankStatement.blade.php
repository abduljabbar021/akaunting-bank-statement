@stack('bank_statement_button_start')
<a href="{{ route('bank-statement.statement.edit', $bankAccount['account']->id) }}"
    class="mt-4 btn btn-white btn-block mb-4"><b>{{ trans('bank-statement::general.bankStatement') }}</b></a>
@stack('bank_statement_button_end')
