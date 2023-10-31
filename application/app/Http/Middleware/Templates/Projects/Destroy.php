<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [destroy] precheck processes for project templates
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Templates\Projects;
use Closure;
use Log;

class Destroy {

    /**
     * This 'bulk actions' middleware does the following
     *   1. If the request was for a sinle item
     *         - single item actions must have a query string '?id=123'
     *         - this id will be merged into the expected 'ids' request array (just as if it was a bulk request)
     *   2. loop through all the 'ids' that are in the post request
     *
     * HTML for the checkbox is expected to be in this format:
     *   <input type="checkbox" name="ids[{{ $project->project_id }}]"
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //project id
        $project_id = $request->route('project');
    
        // does the project exist
        if (!$project = \App\Models\Project::Where('project_id', $project_id)->Where('project_type', 'template')->first()) {
            // no items were passed with this request
            Log::error("no items were sent with this request", ['process' => '[project templates][action-bar]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project id' => $project_id ?? '']);
            abort(409);
        }
    
        if (auth()->user()->is_team) {
            if (
                request()->input('user_role_type') == 'admin_role' || 
                (request()->input('user_role_type') == 'franchise_admin_role' && $project->franchise_id == auth()->user()->franchise_id) || 
                (request()->input('user_role_type') == 'common_role' && $project->project_creatorid == auth()->id())
            ) {
                return $next($request);
            }
        }
    
        // permission denied
        Log::error("permission denied", ['process' => '[permissions][project templates][destroy]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }
    
}
