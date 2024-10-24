<?php

namespace App\Http\Controllers;

use App\Models\EspecialidadModel;
use Illuminate\Support\Facades\Hash;

use App\Models\RolModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GestionUsers extends Controller
{
    //

    public function index()
    {
        $usuarios = User::all();
        $especialidades = EspecialidadModel::all();
        $roles = RolModel::all();
        return view('users_gestion', [
            'usuarios' => $usuarios,
            'especialidades' => $especialidades,
            'roles' => $roles
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $usuario = User::find($id);
        if ($usuario) {
            $usuario->especialidad_id = $request->especialidad_id;
            $usuario->matricula = $request->matricula;
            $usuario->rol_id = $request->rol_id;
            $usuario->save();

            return response()->json(['success' => true]);
        }
    }
    public function ValidateUser(Request $request, $id)
    {
        $usuario = User::find($id);
        if ($usuario) {
            if ($usuario->validated) {
                $usuario->validated = 0;
                $usuario->save();
                return redirect()->route('users.gest')->with('success', 'Usuario invalidado correctamente.');
            } else {
                $usuario->validated = 1;
                $usuario->save();
                return redirect()->route('users.gest')->with('success', 'Usuario validado correctamente.');
            }
        }
    }
    public function requestPassword(Request $request)
    {
        $email = $request->input('addEmail');

        // Obtenemos el primer usuario que coincida con el email
        $usuario = User::where('email', $email)->first();

        if ($usuario) {
            // Actualizamos el campo requestsPassword a 1
            $usuario->requestsPassword = 1;
            $usuario->save(); // Guardamos los cambios
        }
        return redirect()->route('login')->with('success', 'Solicitud enviada correctamente, por favor envie un ticket para agilizar el proceso.');
    }

    public function passwordUser(Request $request)
    {

        // Obtener el ID del usuario
        $id = $request->input('id'); // Asegúrate de que el ID se pase desde el modal


        // Buscar al usuario
        $usuario = User::find($id);
        if ($usuario) {
            // Cambiar la contraseña
            $usuario->password = Hash::make($request->input('addPassword'));
            $usuario->requestsPassword = 0;
            $usuario->save();

            return redirect()->route('users.gest')->with('success', 'Contraseña cambiada correctamente.');
        }

        return redirect()->route('users.gest')->with('error', 'Usuario no encontrado.');
    }
}
