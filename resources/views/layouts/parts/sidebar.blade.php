<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand" href="/">
            <img src="{{ Storage::url(websiteLog()) }}" alt="" />
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link has-arrow  {{ request()->is('/dashboard') ? 'active' : '' }} "
                    href="{{ url('/dashboard') }}">
                    <i class="nav-icon icon-xs me-2 fa fa-home"></i> Dashboard
                </a>

            </li>


            <!-- Nav item -->
            <li class="nav-item">
                <div class="navbar-heading text-white">Main</div>
            </li>

            <!--Nav Bar Hooks - Do not delete!!-->
            @can('answer-list')<li class="nav-item">
                <a href="{{ url('answers-list') }}"
                    class="nav-link {{request()->is('answers-list') ? 'active' : ''}}"><i
                        class="nav-icon icon-xs me-2 fa fa-list"></i> {{__('Check Answer')}}</a>
            </li>@endcan

            @can('question-list')<li class="nav-item">
                <a href="{{ url('questions') }}" class="nav-link {{request()->is('questions') ? 'active' : ''}}"><i
                        class="nav-icon icon-xs me-2 fa fa-list"></i> {{__('Questions')}}</a>
            </li>@endcan
            @can('quiz-list')<li class="nav-item">
                <a href="{{ url('quizzes') }}" class="nav-link {{request()->is('quizzes') ? 'active' : ''}}"><i
                        class="nav-icon icon-xs me-2 fa fa-list"></i> {{__('Quizzes')}}</a>
            </li>@endcan
            @can('classroom-list')<li class="nav-item">
                <a href="{{ url('classrooms') }}" class="nav-link {{request()->is('classrooms') ? 'active' : ''}}"><i
                        class="nav-icon icon-xs me-2 fa fa-list"></i> {{__('Classrooms')}}</a>
            </li>@endcan
            @can('student-list')<li class="nav-item">
                <a href="{{ url('students') }}" class="nav-link {{request()->is('students') ? 'active' : ''}}"><i
                        class="nav-icon icon-xs me-2 fa fa-list"></i> {{__('Students')}}</a>
            </li>@endcan

            @if (auth()->user()->hasRole('admin'))
            @if (auth()->user()->can('user-list') || auth()->user()->can('role-list') ||
            auth()->user()->can('permission-list'))
            <li class="nav-item">
                <a class="nav-link has-arrow  collapsed" href="#!" data-bs-toggle="collapse"
                    data-bs-target="#navAuthentication" aria-expanded="false" aria-controls="navAuthentication">
                    <i class="nav-icon icon-xs me-2 fa fa-lock">
                    </i> Authentication
                </a>
                <div id="navAuthentication"
                    class="collapse {{ request()->is('admin/users') || request()->is('admin/roles') || request()->is('admin/permissions') || request()->is('admin/site_settings') ? 'show' : '' }}"
                    data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        @can('user-list')
                        <li class="nav-item">
                            <a href="{{ url('/admin/users') }}"
                                class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}"><i
                                    class="nav-icon fa fa-user icon-xs me-2"></i> Users</a>
                        </li>
                        @endcan
                        @can('role-list')
                        <li class="nav-item">
                            <a href="{{ url('/admin/roles') }}"
                                class="nav-link {{ request()->is('admin/roles') ? 'active' : '' }}"><i
                                    class="nav-icon fa fa-user-tag icon-xs me-2"></i> Roles</a>
                        </li>
                        @endcan
                        {{-- @can('permission-list')
                        <li class="nav-item">
                            <a href="{{ url('/admin/permissions') }}"
                                class="nav-link {{ request()->is('admin/permissions') ? 'active' : '' }}"><i
                                    class="nav-icon fa fa-key icon-xs me-2"></i> Permissions</a>
                        </li>
                        @endcan
                        @can('siteSetting-edit')
                        <li class="nav-item">
                            <a href="{{ url('/admin/site_settings') }}"
                                class="nav-link {{ request()->is('admin/site_settings') ? 'active' : '' }}"><i
                                    class="nav-icon fa fa-cog icon-xs me-2"></i> Site settings</a>
                        </li>
                        @endcan --}}
                    </ul>
                </div>
            </li>
            @endif

            @endif

        </ul>

    </div>
</nav>
