<div class="header @@classList">
    <!-- navbar -->
    <nav class="navbar-classic navbar navbar-expand-lg">
        <a id="nav-toggle" href="#"><i class="nav-icon me-2 icon-xs fa fa-list-ul"></i></a>

        <!--Navbar nav -->
        <ul class="navbar-nav navbar-right-wrap ms-auto d-flex nav-top-wrap">
            
            <!-- List -->
            <li class="dropdown ms-2">
                <a class="rounded-circle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md avatar-indicators avatar-online">
                        <img alt="avatar" src="{{ Storage::url(auth()->user()->image) }}" class="rounded-circle" />
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <div class="px-4 pb-0 pt-2">


                        <div class="lh-1 ">
                            <h5 class="mb-1"> {{ auth()->user()->name }}</h5>
                            <span class="text-inherit fs-6">
                                @if (!empty(auth()->user()->getRoleNames()))
                                @foreach (auth()->user()->getRoleNames() as $val)
                                <label class="badge bg-dark">{{ Str::ucfirst($val) }}</label>
                                @endforeach
                                @endif
                            </span>
                        </div>
                        <div class=" dropdown-divider mt-3 mb-2"></div>
                    </div>

                    <ul class="list-unstyled">

                        {{-- <li>
                            <a class="dropdown-item" href="{{ url('/admin/profile') }}">
                                <i class="me-2 icon-xxs dropdown-item-icon far fa-user"></i>Edit
                                Profile
                            </a>
                        </li> --}}

                        <li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="me-2 icon-xxs dropdown-item-icon fa fa-sign-out-alt"></i>Sign
                                Out
                            </a>
                        </li>
                    </ul>

                </div>
            </li>
        </ul>
    </nav>
</div>
