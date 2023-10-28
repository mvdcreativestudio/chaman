<?php

/** --------------------------------------------------------------------------------
 * This middleware class handles [show] precheck processes for projects
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Middleware\Projects;

use App\Models\Project;
use App\Permissions\ProjectPermissions;
use App\Repositories\ProjectRepository;
use Closure;
use Log;

class Show {

    //vars
    protected $projectpermissions;
    protected $projectmodel;
    protected $projectrepo;

    /**
     * Inject any dependencies here
     *
     */
    public function __construct(ProjectPermissions $projectpermissions, Project $projectmodel, ProjectRepository $projectrepo) {

        $this->projectpermissions = $projectpermissions;
        $this->projectmodel = $projectmodel;
        $this->projectrepo = $projectrepo;

    }

    /**
     * This middleware does the following:
     *   1. validates that the project exists
     *   2. checks users permissions to [show] the resource
     *   3. sets various visibility and permissions settings (e.g. menu items, edit buttons etc)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {

        //validate module status
        if (!config('visibility.modules.projects')) {
            abort(404, __('lang.the_requested_service_not_found'));
            return $next($request);
        }

        //project id
        $project_id = $request->route('project');

        //basic validation
        if (!$project = \App\Models\Project::Where('project_id', $project_id)->first()) {
            Log::error("project could not be found", ['process' => '[permissions][projects][destroy]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project id' => $project_id ?? '']);
            abort(404);
        }

        switch (request()->input('user_role_type')) {
            case 'common_role':
                $hasAccess = $this->projectmodel::where('project_id', $project->project_id)
                    ->where(function ($query) {
                        $query->where('project_creatorid', auth()->id())
                            ->orWhereHas('assigned', function ($q) {
                                $q->where('projectsassigned_userid', auth()->id());
                            })
                            ->orWhereHas('managers', function ($q) {
                                $q->where('projectsmanager_userid', auth()->id());
                            });
                    })->where('franchise_id', auth()->user()->franchise_id)
                    ->exists();
        
                if (!$hasAccess) {
                    Log::error("permission denied", ['process' => '[permissions][projects][show]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project id' => $project->project_id ?? '']);
                    abort(403, 'Permission Denied.');
                }
                break;
        }
        

        //friendly format
        $projects = $this->projectrepo->search($project_id);
        $project = $projects->first();

        //frontend
        $this->fronteEnd($project);

        //permission: does user have permission to view this project
        if ($this->projectpermissions->check('view', $project)) {
            //permission granted
            return $next($request);
        }

        Log::error("permission denied", ['process' => '[permissions][projects][show]', 'ref' => config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'project id' => $project_id ?? '']);
        abort(403);
    }

    /*
     * various frontend and visibility settings
     */
    private function fronteEnd($project = '') {

        //defaults
        config([
            'visibility.projects_d3_vendor' => true,
            'visibility.project_show_custom_fields' => false,
        ]);

        //all users
        if ($this->projectpermissions->check('view', $project)) {
            config([
                'settings.project_permissions_view_tasks' => true,
                'settings.project_permissions_view_milestones' => true,
                'settings.project_permissions_view_files' => true,
                'settings.project_permissions_view_comments' => true,
                'settings.project_permissions_view_timesheets' => true,
                'settings.project_permissions_view_invoices' => true,
                'settings.project_permissions_view_payments' => true,
                'settings.project_permissions_view_expenses' => true,
                'settings.project_permissions_view_tickets' => true,
                'settings.project_permissions_view_notes' => true,
            ]);
        }
        

        //team permissions
        if (auth()->user()->is_team) {

            if ($this->projectpermissions->check('edit', $project)) {
                config([
                    'visibility.edit_project_button' => true,
                ]);
            }
            if ($this->projectpermissions->check('delete', $project)) {
                config([
                    'visibility.delete_project_button' => true,
                ]);
            }
            if (auth()->user()->role->role_projects_billing >= 1) {
                config([
                    'visibility.project_billing_summary' => true,
                ]);
            }
        }

        //client permissions
        if (auth()->user()->is_client) {
            config([
                'visibility.project_billing_summary' => true,
            ]);
        }

        //show we show the customer fields left panel section
        $count = \App\Models\CustomField::where('customfields_type', 'projects')->where('customfields_standard_form_status', 'enabled')->where('customfields_status', 'enabled')->count();
        if ($count > 0) {
            config([
                'visibility.project_show_custom_fields' => true,
            ]);
        }

        //the cover image
        if (config('system.settings_projects_cover_images') == 'enabled') {
            config([
                'visibility.project_cover_image' => true,
            ]);
            //do we have a cover image
            if (!checkCoverImage($project->project_cover_directory, $project->project_cover_filename)) {
                config([
                    'visibility.project_cover_image_current' => 'hidden',
                ]);
            }
        }

        //cover images - editing
        if (config('system.settings_projects_cover_images') == 'enabled' && $this->projectpermissions->check('edit', $project)) {
            config([
                'visibility.edit_project_cover_image' => true,
            ]);
        }

    }

}
