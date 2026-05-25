<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library ERP - SLTC | @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0d2137;
            --gold: #c9a84c;
            --gold-light: #e8c97a;
            --cream: #faf7f2;
            --white: #ffffff;
            --text: #1a2535;
            --muted: #6b7a8d;
            --danger: #c0392b;
            --success: #1a7a4a;
            --sidebar-w: 260px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'DM Sans',sans-serif; background:var(--cream); color:var(--text); min-height:100vh; display:flex; }

        /* SIDEBAR */
        .sidebar {
            width:var(--sidebar-w); background:var(--navy); min-height:100vh;
            position:fixed; left:0; top:0; z-index:100; display:flex; flex-direction:column;
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
        }
        .sidebar-brand {
            padding:28px 24px 20px;
            border-bottom:1px solid rgba(201,168,76,0.25);
        }
        .sidebar-brand .logo-icon {
            width:44px; height:44px; background:var(--gold);
            border-radius:10px; display:flex; align-items:center; justify-content:center;
            margin-bottom:12px; font-size:22px;
        }
        .sidebar-brand h1 { font-family:'Playfair Display',serif; color:var(--white); font-size:17px; line-height:1.3; }
        .sidebar-brand span { color:var(--gold); font-size:11px; font-weight:500; letter-spacing:2px; text-transform:uppercase; }

        .sidebar-nav { padding:16px 0; flex:1; }
        .nav-section { padding:8px 20px 4px; font-size:10px; font-weight:600; letter-spacing:2px; text-transform:uppercase; color:rgba(255,255,255,0.3); margin-top:8px; }
        .nav-link {
            display:flex; align-items:center; gap:12px;
            padding:11px 20px; color:rgba(255,255,255,0.7);
            text-decoration:none; font-size:14px; font-weight:400;
            transition:all 0.2s; border-left:3px solid transparent;
            margin:1px 0;
        }
        .nav-link:hover, .nav-link.active {
            color:var(--gold); background:rgba(201,168,76,0.08);
            border-left-color:var(--gold);
        }
        .nav-link .icon { font-size:16px; width:20px; text-align:center; }

        .sidebar-footer {
            padding:16px 20px; border-top:1px solid rgba(255,255,255,0.08);
            font-size:13px; color:rgba(255,255,255,0.4);
        }
        .sidebar-footer strong { color:rgba(255,255,255,0.7); display:block; }

        /* MAIN */
        .main { margin-left:var(--sidebar-w); flex:1; display:flex; flex-direction:column; min-height:100vh; }

        .topbar {
            background:var(--white); padding:0 32px;
            height:64px; display:flex; align-items:center; justify-content:space-between;
            border-bottom:1px solid #e8e0d5; position:sticky; top:0; z-index:50;
            box-shadow:0 1px 8px rgba(0,0,0,0.06);
        }
        .topbar h2 { font-family:'Playfair Display',serif; font-size:20px; color:var(--navy); }
        .topbar-right { display:flex; align-items:center; gap:16px; }
        .user-badge {
            background:var(--navy); color:var(--gold); padding:6px 14px;
            border-radius:20px; font-size:12px; font-weight:600; letter-spacing:0.5px;
        }
        .btn-logout {
            background:transparent; border:1px solid #ddd; padding:6px 14px;
            border-radius:6px; font-size:13px; color:var(--muted); cursor:pointer;
            text-decoration:none; transition:all 0.2s;
        }
        .btn-logout:hover { background:var(--danger); color:white; border-color:var(--danger); }

        .content { padding:32px; flex:1; }

        /* CARDS */
        .card {
            background:var(--white); border-radius:14px;
            box-shadow:0 2px 12px rgba(0,0,0,0.06); padding:24px;
            border:1px solid #ede8e0;
        }
        .card-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
        .card-title { font-family:'Playfair Display',serif; font-size:18px; color:var(--navy); }

        /* STATS */
        .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:28px; }
        .stat-card {
            background:var(--white); border-radius:14px; padding:22px 24px;
            border:1px solid #ede8e0; box-shadow:0 2px 10px rgba(0,0,0,0.05);
            position:relative; overflow:hidden;
        }
        .stat-card::before {
            content:''; position:absolute; top:0; left:0; right:0; height:3px;
        }
        .stat-card.books::before { background:var(--gold); }
        .stat-card.members::before { background:#2980b9; }
        .stat-card.borrowed::before { background:#8e44ad; }
        .stat-card.overdue::before { background:var(--danger); }
        .stat-num { font-family:'Playfair Display',serif; font-size:36px; color:var(--navy); line-height:1; }
        .stat-label { font-size:12px; color:var(--muted); margin-top:4px; font-weight:500; text-transform:uppercase; letter-spacing:1px; }
        .stat-icon { position:absolute; right:20px; top:50%; transform:translateY(-50%); font-size:40px; opacity:0.08; }

        /* BUTTONS */
        .btn {
            display:inline-flex; align-items:center; gap:6px;
            padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500;
            cursor:pointer; border:none; text-decoration:none; transition:all 0.2s;
        }
        .btn-primary { background:var(--navy); color:var(--white); }
        .btn-primary:hover { background:#1a3552; }
        .btn-gold { background:var(--gold); color:var(--navy); }
        .btn-gold:hover { background:var(--gold-light); }
        .btn-danger { background:var(--danger); color:white; }
        .btn-danger:hover { background:#a93226; }
        .btn-sm { padding:6px 12px; font-size:12px; }
        .btn-outline { background:transparent; border:1px solid #ddd; color:var(--text); }
        .btn-outline:hover { border-color:var(--navy); color:var(--navy); }

        /* TABLE */
        table { width:100%; border-collapse:collapse; font-size:14px; }
        thead th {
            background:#f5f0e8; padding:11px 14px; text-align:left;
            font-size:11px; font-weight:600; letter-spacing:1px; text-transform:uppercase;
            color:var(--muted); border-bottom:2px solid #ede8e0;
        }
        tbody tr { border-bottom:1px solid #f0ebe2; transition:background 0.15s; }
        tbody tr:hover { background:#fdf9f4; }
        tbody td { padding:12px 14px; color:var(--text); }

        /* BADGE */
        .badge {
            display:inline-block; padding:3px 10px; border-radius:20px;
            font-size:11px; font-weight:600; letter-spacing:0.5px;
        }
        .badge-success { background:#d4edda; color:#155724; }
        .badge-warning { background:#fff3cd; color:#856404; }
        .badge-danger { background:#f8d7da; color:#721c24; }
        .badge-info { background:#d1ecf1; color:#0c5460; }

        /* FORM */
        .form-group { margin-bottom:18px; }
        label { display:block; font-size:13px; font-weight:500; color:var(--text); margin-bottom:6px; }
        input[type=text], input[type=email], input[type=password], input[type=date], input[type=number], select, textarea {
            width:100%; padding:10px 14px; border:1px solid #ddd; border-radius:8px;
            font-family:'DM Sans',sans-serif; font-size:14px; color:var(--text);
            background:var(--white); transition:border 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            outline:none; border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,0.12);
        }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

        /* ALERT */
        .alert { padding:12px 16px; border-radius:8px; margin-bottom:20px; font-size:14px; }
        .alert-success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
        .alert-danger { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }

        /* SEARCH BAR */
        .search-bar {
            display:flex; gap:10px; margin-bottom:20px; align-items:center;
        }
        .search-bar input { max-width:300px; }

        @media(max-width:900px) {
            .stats-grid { grid-template-columns:repeat(2,1fr); }
            .form-grid { grid-template-columns:1fr; }
        }
    </style>
    @yield('styles')
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">📚</div>
        <h1>Library ERP System</h1>
        <span>SLTC Research University</span>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="icon">🏠</span> Dashboard
        </a>

        <div class="nav-section">Library</div>
        <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
            <span class="icon">📖</span> Book Management
        </a>
        <a href="{{ route('members.index') }}" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
            <span class="icon">👥</span> Member Management
        </a>
        <a href="{{ route('borrow.index') }}" class="nav-link {{ request()->routeIs('borrow.*') ? 'active' : '' }}">
            <span class="icon">🔄</span> Borrow & Return
        </a>

        <div class="nav-section">Reports</div>
        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <span class="icon">📊</span> Reports
        </a>

        
    </nav>
    <div class="sidebar-footer">
        <strong>{{ auth()->user()->username ?? 'User' }}</strong>
        {{ ucfirst(auth()->user()->role ?? 'librarian') }}
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <h2>@yield('title', 'Dashboard')</h2>
        <div class="topbar-right">
            <span class="user-badge">{{ strtoupper(auth()->user()->role ?? 'LIBRARIAN') }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </header>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</div>
</body>
</html>
