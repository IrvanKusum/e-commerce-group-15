
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Sora', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }
    
    /* Header Admin */
    header {
        background: linear-gradient(135deg, #003459 40%, #0077C8 100%);
        color: white;
        padding: 1rem 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    
    .header-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 3rem;
        display: grid;
        grid-template-columns: 250px 1fr auto;
        align-items: center;
        gap: 2rem;
    }
    
    /* Logo Section */
    .logo {
        font-size: 1.8rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
        color: white;
        transition: transform 0.3s;
    }
    
    .logo:hover {
        transform: scale(1.05);
    }
    
    .logo-icon {
        font-size: 2rem;
    }
    
    /* Center Menu */
    .nav-center {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        list-style: none;
    }
    
    .nav-center a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        padding: 0.7rem 1.2rem;
        border-radius: 10px;
        font-size: 0.95rem;
    }
    
    .nav-center a:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    
    .nav-center a.active {
        background: rgba(255, 255, 255, 0.3);
    }
    
    /* Right Menu */
    .nav-right {
        display: flex;
        gap: 0.8rem;
        align-items: center;
        list-style: none;
    }
    
    .btn-profile {
        background: transparent;
        border: 2px solid white;
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    
    .btn-profile:hover {
        background: rgba(202, 0, 0, 1);
        transform: translateY(-2px);
    }
    
    .btn-logout {
        background: rgba(235, 0, 0, 1);
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        color: white;
        font-size: 0.95rem;
        transition: all 0.3s;
    }
    
    .btn-logout:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }
    
    .profile-icon {
        font-size: 1.2rem;
    }
    
    @media (max-width: 1024px) {
        .header-container {
            grid-template-columns: 1fr;
            gap: 1rem;
            text-align: center;
        }
        
        .nav-center {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .nav-right {
            justify-content: center;
        }
    }
</style>

<header>
    <div class="header-container">
        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <span class="logo-icon">⚙️</span>
            <span>Admin Panel</span>
        </a>
        
        <!-- Center Menu -->
        <ul class="nav-center">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.stores') }}" class="{{ request()->routeIs('admin.stores') ? 'active' : '' }}">
                    Toko
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    Users
                </a>
            </li>
        </ul>
        
        <!-- Right Menu -->
        <ul class="nav-right">
            <li>
                <a href="{{ route('profile') }}" class="btn-profile">
                    <span class="profile-icon">👤</span>
                    <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" class="btn-logout"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</header>