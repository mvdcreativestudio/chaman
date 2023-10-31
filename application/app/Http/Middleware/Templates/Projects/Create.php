<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [create] precheck processes for project templates
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Templates\Projects;
use Closure;
use Log;

class Create {

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

        //frontend
        $this->fronteEnd();

        //permission: does user have permission create projects
        if (request('user_role_type') == 'franchise_admin_role' || request('user_role_type') == 'admin_role' || request('user_role_type') == 'common_role') {
            return $next($request);
        }

        //permission denied
        Log::error("permission denied", ['process' => '[project templates][create]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
        abort(403);
    }

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd() {

        //defaults
        config([
            'visibility.project_show_project_option' => true,
        ]);

    }
}
