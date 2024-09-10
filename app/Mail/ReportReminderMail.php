<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\AlertModel;

class ReportReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alert;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AlertModel $alert)
    {
        $this->alert = $alert;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.report_reminder')
                    ->subject('Recordatorio de Reporte Vencido');
    }
}
