<?php

namespace App\Http\Middleware\Templates\Projects;
use Closure;
use Log;

class Show {

    /**
     * This middleware does the following
     *   1. validates that the project exists
     *   2. checks users permissions to [view] the project
     *   3. modifies the request object as needed
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //project id
        $project_id = $request->route('project');
    
        //frontend
        $this->fronteEnd();
    
        //does the project exist
        if ($project_id == '' || !$project = \App\Models\Project::Where('project_id', $project_id)->Where('project_type', 'template')->first()) {
            abort(404);
        }
    
        switch (request()->input('user_role_type')) {
            case 'admin_role':
                // Para admin_role, no hay restricciones adicionales
                return $next($request);
                break;
    
            case 'franchise_admin_role':
                // Solo muestra proyectos de su franquicia
                if ($project->franchise_id == auth()->user()->franchise_id) {
                    return $next($request);
                }
                break;
    
            case 'common_role':
                // Solo muestra proyectos que el usuario ha creado
                if ($project->project_creatorid == auth()->id()) {
                    return $next($request);
                }
                break;
    
            default:
                // Si no se encuentra en ninguna de las anteriores, denegar el acceso
                Log::error("permission denied", ['process' => '[project templates][show]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
                abort(403);
        }
    
        //permission denied
        Log::error("permission denied", ['process' => '[project templates][show]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
    

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        // team permissions
        if (auth()->user()->is_team) {
            $user_role_type = request()->input('user_role_type');
    
            switch ($user_role_type) {
                case 'admin_role':
                    // Si es admin, tiene todos los permisos
                    config([
                        'visibility.edit_project_button' => true,
                        'visibility.delete_project_button' => true,
                    ]);
                    break;
    
                case 'franchise_admin_role':
                    // Consultamos el proyecto
                    $project_id = request()->route('project');
                    $project = \App\Models\Project::Where('project_id', $project_id)->first();
                    if ($project && $project->franchise_id == auth()->user()->franchise_id) {
                        config([
                            'visibility.edit_project_button' => true,
                            'visibility.delete_project_button' => true,
                        ]);
                    }
                    break;
    
                case 'common_role':
                    // Consultamos el proyecto
                    $project_id = request()->route('project');
                    $project = \App\Models\Project::Where('project_id', $project_id)->first();
                    if ($project && $project->project_creatorid == auth()->id()) {
                        config([
                            'visibility.edit_project_button' => true,
                            'visibility.delete_project_button' => true,
                        ]);
                    }
                    break;
            }
        }
    }
    

}
