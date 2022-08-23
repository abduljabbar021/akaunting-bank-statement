<?php

namespace Modules\BankStatement\Http\Controllers;

use App\Abstracts\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\Models\Banking\Account;
use App\Models\Banking\Transaction;


class Main extends Controller
{
    public function __construct()
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('bank-statement::statements.edit', $this->getCompact($id));
    }

    private function getCompact($id)
    {
        $getInfo = $this->getInfo($id);
        $data = [
            'transactions' => $this->getData($id),
            'account'  => $getInfo['account'],
            'opening'  => $getInfo['opening'],
            'closing'  => $getInfo['closing'],
            'debit'  => 0,
            'credit'  => 0,
            'color'    => setting('invoice.color')
        ];
        return compact('data');
    }

    private function getInfo($id)
    {
        $account = Account::where('company_id', company_id())->where('id', $id)->first();
        
        $query = Transaction::where('company_id', company_id())->where('account_id', $id)->where('paid_at', '<', date("Y-m-d",strtotime(setting('bank-statement.dateFrom'))) ." 23:59:59")->orderBy('paid_at', 'asc');
        $subQuery = $query->toSql();
        $opening = DB::select("select sum(if(type='expense', -1, 1) * amount * currency_rate) as opening from ($subQuery) as tbl", $query->getBindings());

        $query = Transaction::where('company_id', company_id())->where('account_id', $id)->where('paid_at', '>=', date("Y-m-d",strtotime(setting('bank-statement.dateFrom'))) ." 00:00:00")->where('paid_at', '<=', date("Y-m-d",strtotime(setting('bank-statement.dateUntil'))) ." 23:59:59")->orderBy('paid_at', 'asc');
        $subQuery = $query->toSql();
        $closing = DB::select("select sum(if(type='expense', -1, 1) * amount * currency_rate) as closing from ($subQuery) as tbl", $query->getBindings());
        
        $data = [
            'account'  => $account,
            'opening'   => ($opening[0]->opening ?? 0),
            'closing'   => ($closing[0]->closing ?? 0)
        ];

        return $data;
    }

    private function getData($id)
    {
        return Transaction::leftJoin('documents', 'transactions.document_id', '=', 'documents.id')->select('transactions.*', 'documents.document_number')->where('transactions.company_id', company_id())->where('account_id', $id)->where('paid_at', '>=', date("Y-m-d",strtotime(setting('bank-statement.dateFrom'))) ." 00:00:00")->where('paid_at', '<=', date("Y-m-d",strtotime(setting('bank-statement.dateUntil'))) ." 23:59:59")->orderBy('paid_at', 'asc')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Account $account, $id)
    {
        $data= [
            'dateFrom'  => request('dateFrom'),
            'dateUntil' => request('dateUntil'),
        ];
            
        if (strtotime($data['dateUntil']) >= strtotime($data['dateFrom'])) {
            setting()->set('bank-statement', $data);

            setting()->save();
    
            $message = trans('messages.success.updated', ['type' => trans_choice('bank-statement::general.statementDates', 2)]);

            flash($message)->success();
        } else {

            $message = trans('bank-statement::general.error.dates', ['type' => trans_choice('bank-statement::general.statementDates', 2)]);

            flash($message)->error();
        }

        $response = [
            'status'   => null,
            'success'  => true,
            'error'    => false,
            'message'  => $message,
            'data'     => null,
            'redirect' => route('bank-statement.statement.edit', $id),
        ];

        return response()->json($response);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function printStatement($id)
    {
        $view = view('bank-statement::template.print_statement', $this->getCompact($id));
        return mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');
    }

    /**
     * Download the PDF file of statement.
     *
     * @param  Document $invoice
     *
     * @return Response
     */
    public function pdfStatement($id)
    {
        $view = view('bank-statement::template.print_statement', $this->getCompact($id))->render();
        $html = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html);
 
        //$pdf->setPaper('A4', 'portrait');

        $file_name = $this->getInfo($id)['account']->name . " " .  'Statement.pdf';

        return $pdf->download($file_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
    }
}
