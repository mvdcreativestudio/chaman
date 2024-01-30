<?php

/** -------------------------------------------------------------------------------------------------
 * TEMPLATE
 * This cronjob is envoked by by the task scheduler which is in 'application/app/Console/Kernel.php'
 * It marks invoices as overdue and also send overdue reminder email
 * @package    Grow CRM
 * @author     NextLoop
 *---------------------------------------------------------------------------------------------------*/

namespace App\Cronjobs;
use App\Repositories\InvoiceRepository;
use App\Repositories\UserRepository;

class OverdueInvoicesCron {

    public function __invoke(
        UserRepository $userrepo,
        InvoiceRepository $invoicerepo
    ) {

        //[MT] - tenants only
        if (env('MT_TPYE')) {
            if (\Spatie\Multitenancy\Models\Tenant::current() == null) {
                return;
            }
            //boot system settings
            middlwareBootSystem();
            middlewareBootMail();
        }

        //log that its run
        //Log::info("Cronjob has started", ['process' => '[foo-cron]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);

        /*--------------------------------------------------------
         * Process invoices that are already mareked as overdue
         * *-----------------------------------------------------*/
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        $invoices = \App\Models\Invoice::Where('bill_due_date', '<', $today)
            ->where('bill_overdue_reminder_sent', 'no')
            ->where('bill_status', 'overdue')
            ->take(5)->get();

        //process each one
        foreach ($invoices as $invoice) {

            //get full invoice
            if ($bills = $invoicerepo->search($invoice->bill_invoiceid)) {
                $bill = $bills->first();
            }

            //send email - only do this for invoices with an amount due
            if ($bill->invoice_balance > 0) {
                if ($user = $userrepo->getClientAccountOwner($invoice->bill_clientid)) {
                    $mail = new \App\Mail\OverdueInvoice($user, [], $bill);
                    $mail->build();
                }
            }

            //mark invoice as overdue and email sent
            $invoice->bill_overdue_reminder_sent = 'yes';
            $invoice->save();
        }

        /*--------------------------------------------------------
         * Process invoices that are not yet mareked as overdue
         * *-----------------------------------------------------*/
        //mark invoice as overdue
        $today = \Carbon\Carbon::now()->format('Y-m-d');
        $invoices = \App\Models\Invoice::Where('bill_due_date', '<', $today)
            ->where('bill_overdue_reminder_sent', 'no')
            ->whereIn('bill_status', ['due ', 'part_paid'])
            ->take(5)->get();

        //process each one
        foreach ($invoices as $invoice) {

            //get full invoice
            if ($bills = $invoicerepo->search($invoice->bill_invoiceid)) {
                $bill = $bills->first();
            }

            //send email - only do this for invoices with an amount due
            if ($bill->invoice_balance > 0) {
                if ($user = $userrepo->getClientAccountOwner($invoice->bill_clientid)) {
                    $mail = new \App\Mail\OverdueInvoice($user, [], $bill);
                    $mail->build();
                }
            }

            //mark invoice as overdue and email sent
            $invoice->bill_status = 'overdue';
            $invoice->bill_overdue_reminder_sent = 'yes';
            $invoice->save();
        }

        $invoices = \App\Models\Invoice::whereNotIn('bill_status', ['draft', 'paid'])->get();
        foreach ($invoices as $invoice) {
            $bill_due_date = \Carbon\Carbon::parse($invoice->bill_due_date);
            $today = \Carbon\Carbon::now();
            
            // Calculando la diferencia en días
            $days_until_due = $bill_due_date->diffInDays($today);
            
            // Invertir el signo si la fecha de vencimiento es anterior a la fecha actual
            if ($bill_due_date->isPast() == 1) {
                $days_until_due = -$days_until_due;
            }

            echo '--------------------------------------------------------', PHP_EOL;
           
            echo 'Invoice ID: ', $invoice->bill_invoiceid, PHP_EOL;
            echo 'Current Date: ', today(), PHP_EOL;
            echo 'Bill Due Date: ', $bill_due_date, PHP_EOL;
            echo 'Days Until Due: ', $days_until_due, PHP_EOL;
            
            
            // Luego sigue la lógica para establecer el estado de la factura
            if ($days_until_due < 0) {
                // La factura está vencida
                $invoice->bill_status = 'overdue';
                echo 'Invoice is overdue', PHP_EOL;
            } elseif ($days_until_due < 5) {
                // La factura está por vencer
                $invoice->bill_status = 'due';
                echo 'Invoice is due', PHP_EOL;
            } else {
                // La factura está en estado corriente
                $invoice->bill_status = 'current';
                echo 'Invoice is current', PHP_EOL;
            }

            echo '--------------------------------------------------------', PHP_EOL;
            $invoice->save();
            echo 'Invoice :', $invoice, PHP_EOL;
        }

        //reset last cron run data
        \App\Models\Settings::where('settings_id', 1)
            ->update([
                'settings_cronjob_has_run' => 'yes',
                'settings_cronjob_last_run' => now(),
            ]);

    }
}