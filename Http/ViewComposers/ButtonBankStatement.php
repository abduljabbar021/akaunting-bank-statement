<?php

namespace Modules\BankStatement\Http\ViewComposers;

use Illuminate\View\View;

class ButtonBankStatement
{

    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $bankAccount = $view->getData();
        
        $view->getFactory()->startPush('account_address_end', view('bank-statement::Button.ButtonBankStatement', compact('bankAccount')));
    }
}
