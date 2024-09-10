<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\AlertModel;
use Carbon\Carbon;
use App\Mail\ReportReminderMail;
use App\Models\PersonaAlephooModel;
use App\Models\PersonaLocalModel;
use Illuminate\Support\Facades\Log;

class SendReportReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar recordatorios de reportes vencidos después de 30 días';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener reportes que no se han actualizado en los últimos 30 días
        $alerts = AlertModel::whereMonth('fecha_objetivo', Carbon::now()->month)
            ->get();

        foreach ($alerts as $alert) {
            // Enviar el correo usando el Mailable creado
            if ($alert->is_in_alephoo == 1) {
                $email = PersonaAlephooModel::find($alert->persona_id)->contacto_email_direccion;
            } else {
                $email = PersonaLocalModel::find($alert->persona_id)->email;
            }

            log::info($alerts);
            Mail::to($email)->send(new ReportReminderMail($alert));
        }

        $this->info('Recordatorios enviados exitosamente.');

        return 0;
    }
}
