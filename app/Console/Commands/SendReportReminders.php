<?php

namespace App\Console\Commands;

use App\Models\EstadoAlertaModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
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
        $alerts = AlertModel::join('estado_alerta as ea', 'alertas.id', '=', 'ea.alerta_id')
            ->where('ea.estado_id', 1) // Busca los que tienen estado_id = 1
            ->whereMonth('alertas.fecha_objetivo', Carbon::now()->month) // Filtra por mes actual
            ->whereYear('alertas.fecha_objetivo', Carbon::now()->year)  // Filtra por año actual
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('estado_alerta as ea2')
                    ->whereColumn('ea2.alerta_id', 'alertas.id')
                    ->where('ea2.estado_id', 9); // Excluye los que tienen estado_id = 10
            })
            ->select('alertas.*', 'ea.estado_id') // Selecciona los campos necesarios
            ->get();



        foreach ($alerts as $alert) {
            // Enviar el correo usando el Mailable creado
            if ($alert->is_in_alephoo == 1) {
                $email = PersonaAlephooModel::find($alert->persona_id)->contacto_email_direccion;
            } else {
                $email = PersonaLocalModel::find($alert->persona_id)->email;
            }
            Mail::to($email)->send(new ReportReminderMail($alert));

            /*$estadoAnterior = EstadoAlertaModel::where('alerta_id', '=', $alert->id)
            ->where('estado_id','=',1)->first();
            $estadoAnterior->delete();
            log::info($estadoAnterior);*/

            $estadoNuevo = new EstadoAlertaModel();
            $estadoNuevo->estado_id = 9;
            $estadoNuevo->alerta_id = $alert->id;
            $estadoNuevo->save();
        }

        $this->info('Recordatorios enviados exitosamente.');

        $alertsExpired = AlertModel::join('estado_alerta as ea', 'alertas.id', '=', 'ea.alerta_id')
            ->where('ea.estado_id', 1) // Busca los que tienen estado_id = 1
            ->where('alertas.fecha_objetivo', '<', Carbon::now()->startOfMonth()) // Filtra por fechas anteriores al inicio del mes actual
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('estado_alerta as ea2')
                    ->whereColumn('ea2.alerta_id', 'alertas.id')
                    ->where('ea2.estado_id', 2);
            })
            ->select('alertas.*', 'ea.estado_id') // Selecciona los campos necesarios
            ->get();

        foreach ($alertsExpired as $alert) {
            if ($alertsExpired) {
                $estadoNuevo = new EstadoAlertaModel();
                $estadoNuevo->estado_id = 2;
                $estadoNuevo->alerta_id = $alert->id;
                $estadoNuevo->save();
            }
        }

        log::info($alertsExpired);

        return 0;
    }
}
