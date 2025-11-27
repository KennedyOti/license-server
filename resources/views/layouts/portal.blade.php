<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'License Server - Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar - Dark Theme -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">License<span>Server</span></div>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="bi bi-arrow-left-circle"></i>
            </button>
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="menu-divider"></li>

            @if(Auth::user()->role === 'owner')
            <li>
                <a href="{{ route('portal.companies.index') }}" class="{{ request()->routeIs('portal.companies.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Companies</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->role === 'owner')
            <li>
                <a href="{{ route('portal.users.index') }}" class="{{ request()->routeIs('portal.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Users</span>
                </a>
            </li>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'owner']))
            <li>
                <a href="{{ route('portal.products.index') }}" class="{{ request()->routeIs('portal.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Products</span>
                </a>
            </li>

            <li>
                <a href="{{ route('portal.features.index') }}" class="{{ request()->routeIs('portal.features.*') ? 'active' : '' }}">
                    <i class="bi bi-puzzle"></i>
                    <span>Features</span>
                </a>
            </li>

            <li>
                <a href="{{ route('portal.plans.index') }}" class="{{ request()->routeIs('portal.plans.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Plans</span>
                </a>
            </li>
            @endif

            <li>
                <a href="{{ route('portal.licenses.index') }}" class="{{ request()->routeIs('portal.licenses.*') ? 'active' : '' }}">
                    <i class="bi bi-key"></i>
                    <span>Licenses</span>
                </a>
            </li>

            <li class="menu-divider"></li>

            @if(in_array(Auth::user()->role, ['admin', 'owner']))
            <li>
                <a href="{{ route('portal.webhooks.index') }}" class="{{ request()->routeIs('portal.webhooks.*') ? 'active' : '' }}">
                    <i class="bi bi-hook"></i>
                    <span>Webhooks</span>
                </a>
            </li>
            @endif

            <li>
                <a href="{{ route('portal.audit_logs.index') }}" class="{{ request()->routeIs('portal.audit_logs.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Audit Logs</span>
                </a>
            </li>

            <li>
                <a href="{{ route('portal.api_docs.index') }}" class="{{ request()->routeIs('portal.api_docs.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>API Documentation</span>
                </a>
            </li>

            <li class="menu-divider"></li>

            <li>
                <a href="{{ route('portal.settings.index') }}" class="{{ request()->routeIs('portal.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>

            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content - Light Theme -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <div class="top-nav">
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="bi bi-list"></i>
            </button>

            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search companies, products, licenses...">
            </div>

            <div class="user-menu">
                <div class="notifications">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session("error") }}'
            });
        @endif

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete "${name}". This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</body>
</html>