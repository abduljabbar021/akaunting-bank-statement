<?php

return [

    'name'              => 'Customer Statement',
    'description'       => 'This is my awesome module',
    'bankStatement'     => 'Bank Statement',
    'sendEmail'         => 'Send Email',
    'from'              => 'From Date',
    'until'             => 'Until Date',
    'statementDates'    => 'Statement Dates',

    'template' => [
        'statementOf'   => 'Statement of Account',
        'to'            => 'To',
        'todate'        => 'to',
        'accountSummary'=> 'Account Summary',
        'openingBalance'=> 'Opening Balance',
        'invoiceAmount' => 'Invoice Amount',
        'amountPaid'    => 'Amount Paid',
        'closingBalance'=> 'Closing Balance',
        'description'   => 'Description',
        'debit'         => 'Debit',
        'credit'        => 'Credit',
        'balance'       => 'Balance',
        'total'         => 'Total',

    ],

    'error' => [
        'dates'      => 'Error: Wrong Dates! "Until Date" must be higher than the "From Date"!',
    ],

];