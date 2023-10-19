<?php

/** --------------------------------------------------------------------------------
 * Este middleware verifica el tipo de rol del usuario y modifica el objeto de solicitud
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Team;

use Closure;

class UserRoleCheck {

    /**
     * Este middleware realiza las siguientes acciones:
     *   1. Verifica si el usuario es administrador
     *   2. Verifica si el usuario tiene el 'franchise_admin_role'
     *   3. Modifica el objeto de solicitud para incluir el tipo de rol del usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(auth()->user()) {
            // Verifica si el usuario es administrador
            if (auth()->user()->is_admin) {
                $request->merge(['user_role_type' => 'admin_role']);
            } 
            // Verifica si el usuario tiene el 'franchise_admin_role'
            elseif (auth()->user()->role->franchise_admin_role) {
                $request->merge(['user_role_type' => 'franchise_admin_role']);
            } 
            // Si ninguna de las condiciones se cumple, es un rol común 
            else {
                $request->merge(['user_role_type' => 'common_role']);
            }

            return $next($request);
        }
        return $next($request);
    }
}
