<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Behavior Dashboard</title>

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #1f1f2e;
            min-height: 100vh;
            color: white;
            border-top-right-radius: 30px;
            border-bottom-right-radius: 30px;
            padding: 30px 20px;
            position: fixed;
            transition: all 0.3s;
        }

        .sidebar h4 {
            margin-bottom: 50px;
            font-weight: 600;
            color: #f4b400;
            letter-spacing: 1px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            margin-bottom: 10px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .sidebar a.active, .sidebar a:hover {
            background: #f4b400;
            color: #1f1f2e;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        /* Main content */
        .main-content {
            margin-left: 270px;
            padding: 40px;
        }

        /* Top bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .top-bar .search-input {
            width: 220px;
        }

        /* Professional dropdown button */
        .dropdown-toggle-custom {
            background: #f4b400;
            color: #1f1f2e;
            font-weight: 500;
            padding: 6px 20px;
            border-radius: 50px;
            border: none;
            transition: all 0.2s;
        }

        .dropdown-toggle-custom:hover {
            background: #e0a800;
            color: #fff;
        }

        .dropdown-menu-end {
            border-radius: 15px;
            padding: 0.5rem 0;
            min-width: 180px;
        }

        .dropdown-item i {
            margin-right: 10px;
        }

        .dropdown-item:hover {
            background: #f4b400;
            color: #1f1f2e;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>Behavior System</h4>

    @if(auth()->user()->role->name == 'Admin')
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Employees
        </a>
        <a href="{{ route('interactions.index') }}" class="{{ request()->routeIs('interactions.*') ? 'active' : '' }}">
            <i class="bi bi-chat-dots"></i> Interactions
        </a>
        <a href="{{ route('feedbacks.index') }}" class="{{ request()->routeIs('feedbacks.*') ? 'active' : '' }}">
            <i class="bi bi-file-text"></i> Feedback
        </a>
    @endif

    @if(auth()->user()->role->name == 'Employee')
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> My Dashboard
        </a>
    @endif
</div>

<!-- MAIN CONTENT -->
<div class="main-content">
    <!-- TOP BAR -->
    <div class="top-bar">
        <h2>Employee Behavior Dashboard</h2>
        <div class="d-flex gap-3 align-items-center">
            <input type="text" id="searchInput" class="form-control rounded-pill search-input" placeholder="Search employee...">

            <!-- PROFESSIONAL DROPDOWN -->
            <div class="dropdown">
                <button class="dropdown-toggle dropdown-toggle-custom" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ auth()->user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- DYNAMIC CONTENT -->
    @yield('content')
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>