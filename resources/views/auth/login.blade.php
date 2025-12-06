<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FlexSport</title>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Sora', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-container {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        
        .login-side {
            background: linear-gradient(135deg, #0077C8 0%, #003459 100%);
            padding: 3rem;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-side::before {
            content: "⚽🏀🎾🏈";
            position: absolute;
            font-size: 10rem;
            opacity: 0.1;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            white-space: nowrap;
        }
        
        .logo {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .logo::before {
            content: "⚡";
            margin-right: 0.5rem;
        }
        
        .tagline {
            font-size: 1.2rem;
            font-weight: 300;
            position: relative;
            z-index: 1;
        }
        
        .sport-icons {
            margin-top: 2rem;
            font-size: 2.5rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        
        .sport-icons span {
            animation: bounce 2s infinite;
            display: inline-block;
        }
        
        .sport-icons span:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .sport-icons span:nth-child(3) {
            animation-delay: 0.4s;
        }
        
        .sport-icons span:nth-child(4) {
            animation-delay: 0.6s;
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        
        .form-side {
            padding: 3rem;
        }
        
        .form-title {
            font-size: 2rem;
            font-weight: 800;
            color: #003459;
            margin-bottom: 0.5rem;
        }
        
        .form-subtitle {
            color: #666;
            margin-bottom: 2rem;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .alert-error {
            background: #fee;
            color: #c33;
            border: 2px solid #fcc;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #003459;
        }
        
        input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #E1E5EA;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        input:focus {
            outline: none;
            border-color: #0077C8;
            box-shadow: 0 0 0 3px rgba(0, 119, 200, 0.1);
        }
        
        .btn {
            width: 100%;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #00C49A 0%, #00a882 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 196, 154, 0.4);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 196, 154, 0.6);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
        }
        
        .form-footer a {
            color: #0077C8;
            text-decoration: none;
            font-weight: 600;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }
            
            .login-side {
                padding: 2rem;
            }
            
            .logo {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-side">
                <div class="logo">FlexSport</div>
                <p class="tagline">Platform E-Commerce Olahraga Terpercaya</p>
     
            </div>
            
            <div class="form-side">
                <h1 class="form-title">🔐 Login ke FlexSport</h1>
                <p class="form-subtitle">Selamat datang kembali!</p>
                
                @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-error">
                    ❌ {{ session('error') }}
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        ❌ {{ $error }}<br>
                    @endforeach
                </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">📧 Email</label>
                        <input type="email" id="email" name="email" 
                               placeholder="nama@email.com" 
                               value="{{ old('email') }}" 
                               required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">🔑 Password</label>
                        <input type="password" id="password" name="password" 
                               placeholder="Masukkan password" 
                               required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">🚀 Login Sekarang</button>
                </form>
                
                <div class="form-footer">
                    <p>Belum punya akun? <a href="{{ route('register') }}">📝 Daftar di sini</a></p>
                    <p style="margin-top:0.5rem;"><a href="{{ route('home') }}">🏠 Kembali ke Home</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>