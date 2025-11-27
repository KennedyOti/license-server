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
                <div class="user-avatar" data-bs-toggle="modal" data-bs-target="#profileModal" style="cursor: pointer;">{{ substr(Auth::user()->name, 0, 2) }}</div>
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

    <!-- Profile Modal -->
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileModalLabel">Profile Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('profile.update', Auth::user()->id) }}" class="space-y-4">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror

                            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-sm text-muted">
                                        Your email address is unverified.
                                        <button form="send-verification" class="btn btn-link p-0 text-decoration-none">Click here to re-send the verification email.</button>
                                    </p>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-danger" onclick="document.getElementById('logout-form-modal').submit();">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </div>

                        @if (session('status') === 'profile-updated')
                            <div class="alert alert-success mt-3">
                                Profile updated successfully.
                            </div>
                        @endif
                    </form>

                    <div class="mt-3">
                        <a href="{{ route('profile.edit', Auth::user()->id) }}" class="btn btn-link">Edit Full Profile</a>
                    </div>

                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display: none;">
                        @csrf
                    </form>

                    <form id="logout-form-modal" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>