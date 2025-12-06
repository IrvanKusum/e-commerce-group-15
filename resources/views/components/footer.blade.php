<footer>
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>🏅 FlexSport</h3>
                <p>Platform e-commerce olahraga terpercaya untuk semua kebutuhan Anda. Belanja mudah, cepat, dan aman!</p>
                <div class="social-links">
                    <a href="#" title="Facebook">📘</a>
                    <a href="#" title="Instagram">📷</a>
                    <a href="#" title="Twitter">🐦</a>
                    <a href="#" title="YouTube">▶️</a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>🔗 Link Cepat</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}#products">Produk</a></li>
                    <li><a href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('profile') }}">Profile</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>🏪 Untuk Seller</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('seller.setup') }}">Buka Toko</a></li>
                    <li><a href="{{ route('seller.products') }}">Kelola Produk</a></li>
                    <li><a href="{{ route('seller.orders') }}">Pesanan</a></li>
                    <li><a href="{{ route('seller.balance') }}">Saldo</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>❓ Bantuan</h3>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Cara Belanja</a></li>
                    <li><a href="#">Cara Berjualan</a></li>
                    <li><a href="#">Hubungi Kami</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} FlexSport. All rights reserved. Made with ❤️ for Sport Lovers</p>
        </div>
    </div>
</footer>