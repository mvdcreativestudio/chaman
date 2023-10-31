<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [edit] precheck processes for project templates
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Templates\Projects;
use Closure;
use Log;

class Edit {

    /**
     * This middleware does the following
     *   2. checks users permissions to [view] projects
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
            Log::error("project could not be found", ['process' => '[project templates][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project id' => $project_id ?? '']);
            abort(404);
        }
    
        switch (request()->input('user_role_type')) {
            case 'admin_role':
                // Para admin_role, no hay restricciones adicionales
                return $next($request);
                break;
    
            case 'franchise_admin_role':
                // Solo edita proyectos de su franquicia
                if ($project->franchise_id == auth()->user()->franchise_id) {
                    return $next($request);
                }
                break;
    
            case 'common_role':
                // Solo edita proyectos que el usuario ha creado
                if ($project->project_creatorid == auth()->id()) {
                    return $next($request);
                }
                break;
    
            default:
                // Si no se encuentra en ninguna de las anteriores, denegar el acceso
                Log::error("permission denied", ['process' => '[project templates][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
                abort(403);
        }
    
        //permission denied
        Log::error("permission denied", ['process' => '[permissions][project templates][edit]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
    

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        //some settings
        config([
            'settings.project' => true,
            'settings.bar' => true,
        ]);
    }
}
