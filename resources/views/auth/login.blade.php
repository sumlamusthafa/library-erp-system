<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – Library ERP | SLTC</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0d2137; --gold: #c9a84c; --gold-light: #e8c97a;
            --cream: #faf7f2; --white: #ffffff;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family:'DM Sans',sans-serif; min-height:100vh;
            display:flex; background:var(--navy);
        }
        .left-panel {
            width:45%; background:var(--navy); display:flex; flex-direction:column;
            justify-content:center; align-items:center; padding:60px;
            position:relative; overflow:hidden;
        }
        .left-panel::before {
            content:''; position:absolute; inset:0;
            background: radial-gradient(ellipse at 30% 60%, rgba(201,168,76,0.12) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 20%, rgba(201,168,76,0.06) 0%, transparent 50%);
        }
        .left-panel::after {
            content:''; position:absolute; bottom:-100px; right:-100px;
            width:400px; height:400px; border:1px solid rgba(201,168,76,0.1);
            border-radius:50%;
        }
        .brand { position:relative; z-index:1; text-align:center; }
        .brand-icon {
            width:80px; height:80px; background:rgba(201,168,76,0.15);
            border:2px solid var(--gold); border-radius:20px;
            display:flex; align-items:center; justify-content:center;
            font-size:38px; margin:0 auto 24px;
        }
        .brand h1 {
            font-family:'Playfair Display',serif; color:var(--white);
            font-size:36px; line-height:1.2; margin-bottom:12px;
        }
        .brand h1 span { color:var(--gold); }
        .brand p { color:rgba(255,255,255,0.45); font-size:14px; line-height:1.6; max-width:280px; }
        .features { margin-top:48px; display:flex; flex-direction:column; gap:16px; width:100%; max-width:280px; }
        .feature {
            display:flex; align-items:center; gap:12px;
            color:rgba(255,255,255,0.5); font-size:13px;
        }
        .feature-dot {
            width:28px; height:28px; background:rgba(201,168,76,0.15);
            border-radius:8px; display:flex; align-items:center; justify-content:center;
            font-size:13px; flex-shrink:0;
        }

        .right-panel {
            flex:1; background:var(--cream); display:flex; align-items:center;
            justify-content:center; padding:60px;
            border-radius:40px 0 0 40px; margin:20px 0 20px auto;
        }
        .login-box { width:100%; max-width:380px; }
        .login-box h2 {
            font-family:'Playfair Display',serif; font-size:30px;
            color:var(--navy); margin-bottom:6px;
        }
        .login-box p { color:#6b7a8d; font-size:14px; margin-bottom:32px; }
        .form-group { margin-bottom:18px; }
        label { display:block; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase; color:#8a95a0; margin-bottom:8px; }
        input {
            width:100%; padding:13px 16px; border:1.5px solid #e0d8ce;
            border-radius:10px; font-family:'DM Sans',sans-serif; font-size:15px;
            background:var(--white); color:var(--navy); transition:all 0.2s;
        }
        input:focus { outline:none; border-color:var(--gold); box-shadow:0 0 0 4px rgba(201,168,76,0.1); }
        .btn-login {
            width:100%; padding:14px; background:var(--navy); color:var(--white);
            border:none; border-radius:10px; font-family:'DM Sans',sans-serif;
            font-size:15px; font-weight:600; cursor:pointer; transition:all 0.2s;
            letter-spacing:0.5px; margin-top:8px;
        }
        .btn-login:hover { background:#1a3552; transform:translateY(-1px); box-shadow:0 8px 20px rgba(13,33,55,0.25); }
        .error { background:#fde8e8; border:1px solid #f5c0c0; color:#721c24; padding:12px 16px; border-radius:8px; font-size:13px; margin-bottom:18px; }
        .demo-creds {
            margin-top:24px; padding:14px; background:rgba(201,168,76,0.1);
            border:1px solid rgba(201,168,76,0.25); border-radius:10px; font-size:12px; color:#6b7a8d;
        }
        .demo-creds strong { color:var(--navy); display:block; margin-bottom:6px; }
        .cred-row { display:flex; justify-content:space-between; padding:2px 0; }
    </style>
</head>
<body>
<div class="left-panel">
    <div class="brand">
        <div class="brand-icon">📚</div>
        <h1>Library<br><span>ERP System</span></h1>
        <p>SLTC Research University </p>
        <div class="features">
            <div class="feature"><div class="feature-dot">📖</div>Book Management</div>
            <div class="feature"><div class="feature-dot">👥</div>Member Management</div>
            <div class="feature"><div class="feature-dot">🔄</div>Borrow & Return Tracking</div>
            <div class="feature"><div class="feature-dot">📊</div>Reports & Analytics</div>
        </div>
    </div>
</div>

<div class="right-panel">
    <div class="login-box">
        <h2>Welcome back</h2>
        <p>Sign in to access the Library Management System</p>

        @if($errors->any())
            <div class="error">❌ {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Enter username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn-login">Sign In →</button>
        </form>

        <div class="demo-creds">
            <strong>🔑 Demo Credentials</strong>
            <div class="cred-row"><span>Admin:</span><span>admin / admin123</span></div>
            <div class="cred-row"><span>Librarian:</span><span>librarian / lib123</span></div>
            <div class="cred-row"><span>Member:</span><span>member / mem123</span></div>
        </div>
    </div>
</div>
</body>
</html>
