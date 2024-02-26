<aside class="left-sidebar" id="js-trigger-nav-team">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" id="main-scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav" id="main-sidenav">
            <ul id="sidebarnav" data-modular-id="main_menu_team">



                <!--home-->
                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role' || request()->input('user_role_type') == 'common_role')
                <li class="sidenav-menu-item {{ $page['mainmenu_home'] ?? '' }}" title="{{ cleanLang(__('lang.home')) }}">
                <li data-modular-id="main_menu_team_home"
                    class="sidenav-menu-item {{ $page['mainmenu_home'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.home')) }}">
                    <a class="waves-effect waves-dark" href="/home" aria-expanded="false" target="_self">
                        <i class="ti-home"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.dashboard')) }}
                        </span>
                    </a>
                </li>
                <!--home-->
                @endif

                <!--datacenter[done]-->
                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role')
                <li data-modular-id="main_menu_team_contracts"
                    class="sidenav-menu-item {{ $page['mainmenu_contracts'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="ti-menu-alt"></i>
                        <span class="hide-menu">Datacenter
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        
                        <li class="sidenav-submenu {{ $page['submenu_contracts'] ?? '' }}" id="submenu_contracts">
                            <a href="/datacenter"
                                class="{{ $page['submenu_contracts'] ?? '' }}">Inicio</a>
                        </li>
                        
                        
                        {{-- <li class="sidenav-submenu {{ $page['submenu_contracts'] ?? '' }}" id="submenu_contracts">
                            <a href="/sales"
                                class="{{ $page['submenu_contracts'] ?? '' }}">Ventas</a>
                        </li>

                        
                        <li class="sidenav-submenu {{ $page['submenu_contracts'] ?? '' }}" id="submenu_contracts">
                            <a href="/stock"
                                class="{{ $page['submenu_contracts'] ?? '' }}">Stock</a>
                        </li> --}}
                        
                    </ul>
                </li>
                @endif
                <!--datacenter-->


                {{-- <!--users[done]-->
                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role' || request()->input('user_role_type') == 'common_role')
                <li data-modular-id="main_menu_team_clients"
                    class="sidenav-menu-item {{ $page['mainmenu_customers'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="sl-icon-people"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.customers')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @if(config('visibility.modules.clients'))
                        <li class="sidenav-submenu {{ $page['submenu_customers'] ?? '' }}" id="submenu_clients">
                            <a href="/clients"
                                class="{{ $page['submenu_customers'] ?? '' }}">{{ cleanLang(__('lang.clients')) }}</a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif --}}
                <!--customers-->

                @if(request()->input('user_role_type') == 'admin_role')
                <li data-modular-id="main_menu_team_contracts"
                class="sidenav-menu-item {{ $page['mainmenu_contracts'] ?? '' }}">
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                    <i class="ti-layout-grid2"></i>
                    <span class="hide-menu">Franquicias</span>
                </a>
                    <ul aria-expanded="false" class="collapse">
                        <li class="sidenav-submenu {{ $page['submenu_contracts'] ?? '' }}"
                            id="submenu_project_contracts">
                            <a href="{{ _url('/franchises') }}"
                                class="{{ $page['submenu_contracts'] ?? '' }}">Franquicias</a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role' || request()->input('user_role_type') == 'common_role')
                <li data-modular-id="main_menu_team_contracts"
                class="sidenav-menu-item {{ $page['mainmenu_contracts'] ?? '' }}">
                <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                    <i class="ti-check"></i>
                    <span class="hide-menu">Objetivos</span>
                </a>
                    <ul aria-expanded="false" class="collapse">
                        <li class="sidenav-submenu {{ $page['submenu_contracts'] ?? '' }}"
                            id="submenu_project_contracts">
                            <a href="{{ _url('/objectives') }}"
                                class="{{ $page['submenu_contracts'] ?? '' }}">Objetivos</a>
                        </li>
                    </ul>
                </li>
                @endif

                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role' || request()->input('user_role_type') == 'common_role')
                    <li data-modular-id="main_menu_team_projects"
                        class="sidenav-menu-item {{ $page['mainmenu_projects'] ?? '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                            <i class="ti-folder"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.projects')) }}
                            </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            @if(config('system.settings_projects_categories_main_menu') == 'yes')
                            @foreach(config('projects_categories') as $category)
                            <li class="sidenav-submenu" id="submenu_projects">
                                <a href="{{ _url('/projects?filter_category='.$category->category_id) }}"
                                    class="{{ $page['submenu_projects_category_'.$category->category_id] ?? '' }}">{{ $category->category_name }}</a>
                            </li>
                            @endforeach
                            @else
                            <li class="sidenav-submenu {{ $page['submenu_projects'] ?? '' }}" id="submenu_projects">
                                <a href="{{ _url('/projects') }}"
                                    class="{{ $page['submenu_projects'] ?? '' }}">{{ cleanLang(__('lang.projects')) }}</a>
                            </li>
                            @endif
                            {{-- <li class="sidenav-submenu {{ $page['submenu_templates'] ?? '' }}"
                                id="submenu_project_templates">
                                <a href="{{ _url('/templates/projects') }}"
                                    class="{{ $page['submenu_templates'] ?? '' }}">{{ cleanLang(__('lang.templates')) }}</a>
                            </li> --}}
                        </ul>
                    </li>
                @endif
                <!--projects-->


                <!--tasks[done]-->
                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role' || request()->input('user_role_type') == 'common_role')
                    <li data-modular-id="main_menu_team_tasks"
                        class="sidenav-menu-item {{ $page['mainmenu_tasks'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.tasks')) }}">
                        <a class="waves-effect waves-dark" href="/tasks" aria-expanded="false" target="_self">
                            <i class="ti-menu-alt"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.tasks')) }}
                            </span>
                        </a>
                    </li>
                @endif
                <!--tasks-->

                

                <!--leads[done]-->
                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role' || request()->input('user_role_type') == 'common_role')
                    <li data-modular-id="main_menu_team_leads"
                        class="sidenav-menu-item {{ $page['mainmenu_leads'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.leads')) }}">
                        <a class="waves-effect waves-dark" href="/leads" aria-expanded="false" target="_self">
                            <i class="sl-icon-call-in"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.leads')) }}
                            </span>
                        </a>
                    </li>
                @endif
                <!--leads-->

                <!--products-->

                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role')
                    <li data-modular-id="main_menu_team_products"
                        class="sidenav-menu-item {{ $page['mainmenu_products'] ?? '' }} menu-tooltip menu-with-tooltip"
                        title="{{ cleanLang(__('lang.products')) }}">
                        <a class="waves-effect waves-dark" href="/products" aria-expanded="false" target="_self">
                            <i class="ti-package"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.products')) }}
                            </span>
                        </a>
                    </li>
                @endif
                <!--products-->
                

                <!--sales-->
                {{-- @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role' || request()->input('user_role_type') == 'common_role')
                    <li data-modular-id="main_menu_team_billing"
                        class="sidenav-menu-item {{ $page['mainmenu_sales'] ?? '' }}">
                        <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                            <i class="ti-wallet"></i>
                            <span class="hide-menu">{{ cleanLang(__('lang.sales')) }}
                            </span>
                        </a>
                        <ul aria-expanded="false" class="collapse">
                            <li class="sidenav-submenu {{ $page['submenu_invoices'] ?? '' }}" id="submenu_invoices">
                                <a href="/invoices"
                                    class=" {{ $page['submenu_invoices'] ?? '' }}">{{ cleanLang(__('lang.invoices')) }}</a>
                            </li>
                            <li class="sidenav-submenu {{ $page['submenu_payments'] ?? '' }}" id="submenu_payments">
                                <a href="/payments"
                                    class=" {{ $page['submenu_payments'] ?? '' }}">{{ cleanLang(__('lang.payments')) }}</a>
                            </li>
                             <li class="sidenav-submenu {{ $page['submenu_estimates'] ?? '' }}" id="submenu_estimates">
                                <a href="/estimates"
                                    class=" {{ $page['submenu_estimates'] ?? '' }}">{{ cleanLang(__('lang.estimates')) }}</a>
                            </li>
                            <li class="sidenav-submenu {{ $page['submenu_subscriptions'] ?? '' }}"
                                id="submenu_subscriptions">
                                <a href="/subscriptions"
                                    class=" {{ $page['submenu_subscriptions'] ?? '' }}">{{ cleanLang(__('lang.subscriptions')) }}</a>
                            </li> 
                            <li class="sidenav-submenu {{ $page['submenu_products'] ?? '' }}" id="submenu_products">
                                <a href="/products"
                                    class=" {{ $page['submenu_products'] ?? '' }}">{{ cleanLang(__('lang.products')) }}</a>
                            </li>
                            <li class="sidenav-submenu {{ $page['submenu_expenses'] ?? '' }}" id="submenu_expenses">
                                <a href="/expenses"
                                    class=" {{ $page['submenu_expenses'] ?? '' }}">{{ cleanLang(__('lang.expenses')) }}</a>
                            </li>
                        </ul>
                    </li>
                @endif --}}
                <!--billing-->

                {{-- <!--PEDIDOS RRSS HARDCODEAO-->
                @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role' || request()->input('user_role_type') == 'common_role')
                <li data-modular-id="main_menu_team_clients"
                    class="sidenav-menu-item {{ $page['mainmenu_customers'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="ti-instagram"></i>
                        <span class="hide-menu">Pedidos RRSS
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        
                        <li class="sidenav-menu-item {{ $page['mainmenu_messages'] ?? '' }} menu-tooltip menu-with-tooltip" id="submenu_contacts">
                            <a href="/conversations"
                                class="{{ $page['submenu_customers'] ?? '' }}">Conversaciones</a>
                        </li>
                        
                        
                        <li class="sidenav-submenu {{ $page['submenu_contacts'] ?? '' }}" id="submenu_contacts">
                            <a href="/conversations/settings"
                                class="{{ $page['submenu_contacts'] ?? '' }}">Configuración</a>
                        </li>

                        <li class="sidenav-submenu {{ $page['submenu_contacts'] ?? '' }}" id="submenu_contacts">
                            <a href="/users"
                                class="{{ $page['submenu_contacts'] ?? '' }}">Rechazados</a>
                        </li>

                        <li class="sidenav-submenu {{ $page['submenu_contacts'] ?? '' }}" id="submenu_contacts">
                            <a href="/users"
                                class="{{ $page['submenu_contacts'] ?? '' }}">Completados</a>
                        </li>
                        
                    </ul>
                </li>
                @endif
                <!--PEDIDOS RRSS--> --}}


                <!--proposals [multiple]-->
                @if(config('visibility.modules.proposals') && auth()->user()->role->role_templates_proposals > 0)
                <!--multipl menu---->
                <li data-modular-id="main_menu_team_proposals"
                    class="sidenav-menu-item {{ $page['mainmenu_proposals'] ?? '' }}">
                    <!--multiple menu---->
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="ti-bookmark-alt"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.proposals')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li class="sidenav-submenu {{ $page['submenu_proposals'] ?? '' }}" id="submenu_proposals">
                            <a href="{{ _url('/proposals') }}"
                                class="{{ $page['submenu_proposals'] ?? '' }}">{{ cleanLang(__('lang.proposals')) }}</a>
                        </li>
                        <li class="sidenav-submenu {{ $page['submenu_proposal_templates'] ?? '' }}"
                            id="submenu_proposal_templates">
                            <a href="{{ _url('/templates/proposals') }}"
                                class="{{ $page['submenu_templates'] ?? '' }}">{{ cleanLang(__('lang.templates')) }}</a>
                        </li>
                    </ul>
                </li>
                @endif
                <!--proposals-->

                <!--proposals [single]---->
                @if(config('visibility.modules.proposals') && auth()->user()->role->role_templates_proposals == 0)
                <li data-modular-id="main_menu_team_proposals"
                    class="sidenav-menu-item {{ $page['mainmenu_proposals'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.proposals')) }}">
                    <a class="waves-effect waves-dark p-r-20" href="/proposals" aria-expanded="false" target="_self">
                        <i class="ti-bookmark-alt"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.proposals')) }}
                        </span>
                    </a>
                </li>
                @endif


                <!--contracts [multiple]-->
                @if(config('visibility.modules.contracts') && auth()->user()->role->role_templates_contracts > 0)
                <!--multipl menu-->
                <li data-modular-id="main_menu_team_contracts"
                    class="sidenav-menu-item {{ $page['mainmenu_contracts'] ?? '' }}">
                    <!--multiple menu-->
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="ti-write"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.contracts')) }}
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li class="sidenav-submenu {{ $page['submenu_contracts'] ?? '' }}" id="submenu_contracts">
                            <a href="{{ _url('/contracts') }}"
                                class="{{ $page['submenu_contracts'] ?? '' }}">{{ cleanLang(__('lang.contracts')) }}</a>
                        </li>
                        <li class="sidenav-submenu {{ $page['submenu_contract_templates'] ?? '' }}"
                            id="submenu_contract_templates">
                            <a href="{{ _url('/templates/contracts') }}"
                                class="{{ $page['submenu_templates'] ?? '' }}">{{ cleanLang(__('lang.templates')) }}</a>
                        </li>
                    </ul>
                </li>
                @endif
                <!--contracts-->

                <!--contracts [single]-->
                @if(config('visibility.modules.contracts') && auth()->user()->role->role_templates_contracts == 0)
                <li data-modular-id="main_menu_team_contracts"
                    class="sidenav-menu-item {{ $page['mainmenu_contracts'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.contracts')) }}">
                    <a class="waves-effect waves-dark p-r-20" href="/contracts" aria-expanded="false" target="_self">
                        <i class="ti-write"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.contracts')) }}
                        </span>
                    </a>
                </li>
                @endif


                <!--affiliates-->
                @if(auth()->user()->is_admin && config('settings.custom_modules.cs_affiliate'))
                <li class="sidenav-menu-item {{ $page['mainmenu_cs_affiliates'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="sl-icon-badge"></i>
                        <span class="hide-menu">@lang('lang.affiliates')
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li class="sidenav-submenu {{ $page['submenu_templates'] ?? '' }}"
                            id="submenu_cs_affiliate_users">
                            <a href="{{ _url('/cs/affiliates/users') }}"
                                class="{{ $page['submenu_cs_affiliate_users'] ?? '' }}">@lang('lang.users')</a>
                        </li>
                        <li class="sidenav-submenu {{ $page['submenu_templates'] ?? '' }}"
                            id="submenu_cs_affiliate_projects">
                            <a href="{{ _url('/cs/affiliates/projects') }}"
                                class="{{ $page['submenu_cs_affiliate_projects'] ?? '' }}">@lang('lang.projects')</a>
                        </li>
                        <li class="sidenav-submenu {{ $page['submenu_templates'] ?? '' }}"
                            id="submenu_cs_affiliate_earnings">
                            <a href="{{ _url('/cs/affiliates/earnings') }}"
                                class="{{ $page['submenu_cs_affiliate_earnings'] ?? '' }}">@lang('lang.earnings')</a>
                        </li>
                    </ul>
                </li>
                @endif
                <!--affiliates-->


                <!--messaging-->
                @if(config('visibility.modules.messages'))
                <li data-modular-id="main_menu_team_messages"
                    class="sidenav-menu-item {{ $page['mainmenu_messages'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.messages')) }}">
                    <a class="waves-effect waves-dark p-r-20" href="/messages" aria-expanded="false" target="_self">
                        <i class="sl-icon-bubbles"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.messages')) }}
                        </span>
                    </a>
                </li>
                @endif

                <!--[MODULES] - dynamic menu-->
                {!! config('module_menus.main_menu_team') !!}

                <!--spaces-->
                @if(config('visibility.modules.spaces'))
                <li data-modular-id="main_menu_team_spaces hidden"
                    class="sidenav-menu-item {{ $page['mainmenu_spaces'] ?? '' }}">
                    <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                        <i class="ti-layers"></i>
                        <span class="hide-menu">@lang('lang.spaces')
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        @if(config('system.settings2_spaces_user_space_status') == 'enabled')
                        <li class="sidenav-submenu {{ $page['submenu_spaces_my'] ?? '' }}" id="submenu_spaces_my">
                            <a href="{{ _url('/spaces/'.auth()->user()->space_uniqueid) }}"
                                class="{{ $page['submenu_spaces_my'] ?? '' }}">
                                {{ config('system.settings2_spaces_user_space_menu_name') }}
                            </a>
                        </li>
                        @endif
                        @if(config('system.settings2_spaces_team_space_status') == 'enabled')
                        <li class="sidenav-submenu {{ $page['submenu_spaces_team'] ?? '' }}" id="submenu_spaces_team">
                            <a href="{{ _url('/spaces/'.config('system.settings2_spaces_team_space_id')) }}"
                                class="{{ $page['submenu_spaces_team'] ?? '' }}">
                                {{ config('system.settings2_spaces_team_space_menu_name') }}
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                <!--spaces-->


                <!--tickets-->
                @if(config('visibility.modules.tickets'))
                <li class="sidenav-menu-item {{ $page['mainmenu_tickets'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.tickets')) }}">
                    <a class="waves-effect waves-dark" href="/tickets" aria-expanded="false" target="_self">
                        <i class="ti-comments"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.support')) }}
                        </span>
                    </a>
                </li>
                @endif
                <!--tickets-->


                <!--knowledgebase-->
                @if(config('visibility.modules.knowledgebase'))
                <li data-modular-id="main_menu_team_knowledgebase"
                    class="sidenav-menu-item {{ $page['mainmenu_kb'] ?? '' }} menu-tooltip menu-with-tooltip"
                    title="{{ cleanLang(__('lang.knowledgebase')) }}">
                    <a class="waves-effect waves-dark p-r-20" href="/knowledgebase" aria-expanded="false"
                        target="_self">
                        <i class="sl-icon-docs"></i>
                        <span class="hide-menu">{{ cleanLang(__('lang.knowledgebase')) }}
                        </span>
                    </a>
                </li>
                @endif
                <!--knowledgebase-->
                
                

                <!--other-->
                @if(auth()->user()->is_team)
                    @if(request()->input('user_role_type') == 'admin_role' || request()->input('user_role_type') == 'franchise_admin_role')
                        <li data-modular-id="main_menu_team_team"
                            class="sidenav-menu-item {{ $page['mainmenu_settings'] ?? '' }}">
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0);" aria-expanded="false">
                                <i class="ti-panel"></i>
                                <span class="hide-menu">{{ cleanLang(__('lang.other')) }}
                                </span>
                            </a>
                            <ul aria-expanded="false" class="position-top collapse">
                                <li class="sidenav-submenu mainmenu_team {{ $page['submenu_team'] ?? '' }}" id="submenu_team">
                                    <a href="/team"
                                        class="{{ $page['submenu_team'] ?? '' }}">{{ cleanLang(__('lang.team_members')) }}</a>
                                </li>
                                @if(config('visibility.modules.timesheets'))
                                <li class="sidenav-submenu mainmenu_timesheets {{ $page['submenu_timesheets'] ?? '' }}"
                                    id="submenu_timesheets">
                                    <a href="/timesheets"
                                        class="{{ $page['submenu_timesheets'] ?? '' }}">{{ cleanLang(__('lang.time_sheets')) }}</a>
                                </li>
                                @endif
                                {{-- @if(auth()->user()->is_admin)
                                <li class="sidenav-submenu mainmenu_settings {{ $page['submenu_settings'] ?? '' }}"
                                    id="submenu_settings">
                                    <a href="/settings"
                                        class="{{ $page['submenu_settings'] ?? '' }}">{{ cleanLang(__('lang.settings')) }}</a>
                                </li>
                                @endif --}}
                            </ul>
                        </li>
                    @endif
                @endif

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>