<div class="sidebar border-right col-md-3 col-lg-2 bg-body-tertiary border p-0">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">{{ env('APP_NAME') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column pt-lg-3 overflow-y-auto p-0">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center active gap-2" aria-current="page"
                        href="{{ route('home') }}">
                        <i class="bi bi-house-fill"></i>
                        Dashboard
                    </a>
                </li>
            </ul>

            <hr class="my-1">

            <h6
                class="sidebar-heading d-flex justify-content-between align-items-center text-body-secondary text-uppercase mb-1 mt-4 px-3">
                <span>Setting</span>
            </h6>
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('role.index') }}">
                        <i class="bi bi-person-fill-gear"></i>
                        Role
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('permission.index') }}">
                        <i class="bi bi-person-gear"></i>
                        Permission
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="{{ route('user.index') }}">
                        <i class="bi bi-person-fill"></i>
                        User
                    </a>
                </li>
            </ul>

            <hr class="my-1">

            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="nav-link d-flex align-items-center gap-2">
                            <i class="bi bi-door-closed"></i>
                            Sign out
                        </button>
                    </form>
                </li>
            </ul>

            <hr class="my-1">
        </div>
    </div>
</div>
