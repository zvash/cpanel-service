<?php

namespace App\Observers;

use App\Action;
use App\Payout;
use App\Service;
use App\Transaction;

class PayoutObserver
{

    public function updating(Payout $payout)
    {
        if ($payout->is_paid != $payout->getOriginal('is_paid')) {
            if ($payout->is_paid) {
                $service = Service::where('name', 'Admin')->first();
                $actionId = $this->getWithdrawMoneyActionId();
                $serviceId = $service ? $service->id : 1;
                $transaction = new Transaction();
                $transaction->user_id = $payout->user_id;
                $transaction->service_id = $serviceId;
                $transaction->action_id = $actionId;
                $transaction->amount = $payout->amount * -1;
                $transaction->currency = $payout->currency;
                $transaction->source_type = 'payouts';
                $transaction->source_id = $payout->id;
                $transaction->description = 'Withdraw as per user payout request. ' . ($payout->description ? "({$payout->description})" : '');
                $transaction->due_date = date('Y-m-d h:i:s');
                $transaction->save();
                $payout->transaction_id = $transaction->id;
            }
        }
        return true;
    }
    /**
     * Handle the payout "created" event.
     *
     * @param  \App\Payout  $payout
     * @return void
     */
    public function created(Payout $payout)
    {

    }

    /**
     * Handle the payout "updated" event.
     *
     * @param  \App\Payout  $payout
     * @return void
     */
    public function updated(Payout $payout)
    {
        if (!$payout->is_paid && $payout->transaction_id) {
            $transactionId = $payout->transaction_id;
            $payout->transaction_id = null;
            $payout = Payout::withoutEvents(function () use ($payout) {
                $payout->save();
                return $payout;
            });
            Transaction::where('id', $transactionId)->delete();
        }
    }

    /**
     * Handle the payout "deleted" event.
     *
     * @param  \App\Payout  $payout
     * @return void
     */
    public function deleted(Payout $payout)
    {
        //
    }

    /**
     * Handle the payout "restored" event.
     *
     * @param  \App\Payout  $payout
     * @return void
     */
    public function restored(Payout $payout)
    {
        //
    }

    /**
     * Handle the payout "force deleted" event.
     *
     * @param  \App\Payout  $payout
     * @return void
     */
    public function forceDeleted(Payout $payout)
    {
        //
    }

    /**
     * @return int
     */
    private function getWithdrawMoneyActionId()
    {
        $depositMoneyAction = Action::where('name', 'withdraw-money')
            ->where('currency_type', 'money')
            ->where('action_type', 'withdraw')
            ->first();
        return $depositMoneyAction->id;
    }
}
