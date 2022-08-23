<?php

return [
    'title'                    => 'Email Templates',
    'statement_remind_customer' => [
        'subject' => 'Statement reminding notice',
        'body'    => 'Dear {customer_name},' .
                     '<br /><br />' .
                     'This is a notice for your <strong>statement</strong>.' .
                     '<br /><br />' .
                     'The statement closing balance from {from_date} to {to_date} is {statement_closing_balance}.'
                     .
                     '<br /><br />' .
                     'Best Regards,' .
                     '<br />' .
                     '{company_name}',
    ],
];
