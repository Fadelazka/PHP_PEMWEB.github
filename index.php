<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$loggedInUser = $isLoggedIn ? $_SESSION['username'] : '';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DDEL TIKET | Pemesanan Tiket Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        corePlugins: { preflight: false },
        theme: {
          extend: {
            colors: { primary: '#2b6c94', secondary: '#f39c12' },
            borderRadius: { '3xl': '1.5rem', '4xl': '2rem' }
          }
        }
      }
    </script>
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font-family: "Quicksand", sans-serif; background: #f0f5fa; color: #2d3e50; line-height: 1.6; }
      .navbar { background: white; padding: 1rem 5%; box-shadow: 0 4px 12px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; position: sticky; top: 0; z-index: 10; }
      .logo { font-size: 1.8rem; font-weight: 700; color: #2b6c94; cursor: pointer; }
      .logo i { color: #f39c12; margin-right: 5px; }
      .nav-links { display: flex; gap: 2rem; align-items: center; flex-wrap: wrap; }
      .nav-links a { text-decoration: none; color: #2d3e50; font-weight: 600; transition: 0.2s; cursor: pointer; }
      .nav-links a:hover { color: #2b6c94; }
      .btn-outline { border: 2px solid #2b6c94; padding: 0.5rem 1.2rem; border-radius: 50px; color: #2b6c94; font-weight: 600; transition: 0.2s; background: transparent; cursor: pointer; }
      .btn-outline:hover { background: #2b6c94; color: white; }
      .hero { background: linear-gradient(rgba(0, 40, 70, 0.6), rgba(0, 40, 70, 0.6)), url("https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&q=80") center/cover no-repeat; min-height: 400px; display: flex; align-items: center; justify-content: center; text-align: center; color: white; padding: 3rem 1rem; }
      .hero-content h1 { font-size: 3rem; margin-bottom: 0.5rem; text-shadow: 2px 2px 5px rgba(0,0,0,0.5); min-height: 120px; }
      .cursor { display: inline-block; width: 4px; margin-left: 2px; background-color: #f39c12; animation: blink 0.7s infinite; }
      @keyframes blink { 0%, 50% { opacity: 1; } 51%, 100% { opacity: 0; } }
      .hero-content p { font-size: 1.2rem; margin-bottom: 2rem; }
      .search-box { background: white; border-radius: 60px; padding: 0.5rem 0.5rem 0.5rem 2rem; display: inline-flex; align-items: center; flex-wrap: wrap; gap: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
      .search-box input { border: none; padding: 0.8rem 0; font-size: 1rem; min-width: 250px; outline: none; }
      .search-box button { background: #f39c12; border: none; padding: 0.8rem 2rem; border-radius: 50px; color: white; font-weight: bold; cursor: pointer; transition: 0.2s; }
      .search-box button:hover { background: #e67e22; }
      .section-title { text-align: center; margin: 3rem 0 2rem; font-size: 2.2rem; font-weight: 700; color: #1e3c5c; position: relative; }
      .section-title:after { content: ""; display: block; width: 100px; height: 4px; background: #f39c12; margin: 0.8rem auto; border-radius: 2px; }
      .destinasi-container { max-width: 1300px; margin: 0 auto; padding: 0 20px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; }
      .card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; cursor: pointer; border: 2px solid transparent; }
      .card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); border-color: #f39c12; }
      .card-img { height: 180px; background: linear-gradient(145deg, #2b6c94, #3b9c9c); display: flex; align-items: flex-start; justify-content: space-between; padding: 12px; color: white; font-weight: bold; position: relative; }
      .card-img img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; }
      .card-img::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 50%; background: linear-gradient(to top, rgba(0,0,0,0.6), transparent); z-index: 2; }
      .rating { background: rgba(0,0,0,0.6); padding: 4px 10px; border-radius: 50px; font-size: 0.9rem; z-index: 3; position: relative; display: flex; align-items: center; }
      .card-content { padding: 20px; }
      .card-content h3 { font-size: 1.4rem; margin-bottom: 5px; color: #1e3c5c; }
      .location { color: #6c7a89; margin-bottom: 12px; font-size: 0.95rem; }
      .location i { color: #f39c12; width: 20px; }
      .price { font-size: 1.5rem; font-weight: 700; color: #2b6c94; margin: 10px 0; }
      .price small { font-size: 0.9rem; font-weight: 400; color: #7f8c8d; }
      .btn-card { background: #f39c12; color: white; border: none; padding: 10px 0; width: 100%; border-radius: 12px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: 0.2s; margin-top: 10px; }
      .btn-card:hover { background: #e67e22; }
      .paket-section { background: white; padding: 3rem 5%; margin-top: 2rem; }
      .paket-container { max-width: 1300px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; }
      .paket-card { background: #f8fafc; padding: 2rem; border-radius: 20px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.05); position: relative; overflow: hidden; cursor: pointer; transition: all 0.3s; }
      .paket-card:hover { background: white; box-shadow: 0 15px 30px rgba(0,0,0,0.1); transform: translateY(-5px); }
      .paket-card i { font-size: 2.5rem; color: #f39c12; margin-bottom: 1rem; z-index: 2; position: relative; }
      .kontak-section { background: #1e3c5c; color: white; padding: 3rem 5%; }
      .kontak-container { max-width: 1300px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; }
      .kontak-item i { margin-right: 10px; color: #f39c12; }
      .toast { visibility: hidden; min-width: 250px; background: #2b6c94; color: white; text-align: center; border-radius: 50px; padding: 16px; position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 300; box-shadow: 0 5px 15px rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s, visibility 0.3s; }
      .toast.show { visibility: visible; opacity: 1; }
      @media (max-width: 800px) { .hero-content h1 { font-size: 2.2rem; } }
      .page-view { display: none; }
      .page-view.active { display: block; animation: fadeIn 0.4s ease-in-out; }
      @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
      .tw-input { width: 100%; padding: 12px 16px; border: 1px solid #d1d5db; border-radius: 8px; outline: none; transition: 0.2s; }
      .tw-input:focus { border-color: #f39c12; box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.2); }
      .tw-label { display: block; font-weight: 600; margin-bottom: 6px; color: #374151; }
    </style>
</head>
<body>

<div id="page-home" class="page-view active">
    <nav class="navbar">
        <div class="logo" onclick="navigateTo('page-home')">
            <i class="fas fa-compass"></i> DDELTIKET!
        </div>
        <div class="nav-links">
            <a onclick="scrollToSection('beranda')">Beranda</a>
            <a onclick="scrollToSection('destinasi')">Destinasi</a>
            <a onclick="scrollToSection('paket')">Paket</a>
            <a onclick="scrollToSection('kontak')">Kontak</a>
            <?php if ($isLoggedIn): ?>
                <span class="text-primary font-bold"><i class="fas fa-user-check"></i> Halo, <?= htmlspecialchars($loggedInUser) ?></span>
                <a href="proses/logout.php" class="btn-outline" style="background:#e74c3c; border-color:#e74c3c; color:white;">Logout</a>
            <?php else: ?>
                <a class="btn-outline" id="navMasukBtn" onclick="navigateTo('page-auth')">
                    <i class="fas fa-user"></i> Masuk
                </a>
            <?php endif; ?>
        </div>
    </nav>

    <section class="hero" id="beranda">
        <div class="hero-content">
            <h1><span id="typing-text"></span><span class="cursor">|</span></h1>
            <p>Liburan murah, seru, dan destinasi bagus? di DDELTIKET aja!</p>
            <div class="search-box">
                <input type="text" placeholder="Cari destinasi atau aktivitas..." id="searchInput" />
                <button onclick="search()"><i class="fas fa-search"></i> Cari</button>
            </div>
        </div>
    </section>

    <h2 class="section-title" id="destinasi">Destinasi Populer</h2>
    <div class="destinasi-container" id="destinasiContainer"></div>

    <section class="paket-section" id="paket">
        <h2 class="section-title">Paket Wisata Spesial</h2>
        <div class="paket-container" id="paketContainer"></div>
    </section>

    <section class="kontak-section" id="kontak">
        <div class="kontak-container">
            <div class="kontak-item"><i class="fas fa-map-marker-alt"></i> Jl. Nakula Kec. Tegal Timur</div>
            <div class="kontak-item"><i class="fas fa-phone"></i> +62 851 6586 8864</div>
            <div class="kontak-item"><i class="fas fa-envelope"></i> info@ddeltiket.id</div>
            <div class="kontak-item">
                <a href="https://instagram.com/ddeltiket" target="_blank" class="text-white hover:text-[#f39c12] transition">
                    <i class="fab fa-instagram"></i> @ddeltiket
                </a>
            </div>
        </div>
    </section>
</div>

<div id="page-auth" class="page-view min-h-screen bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&q=80');">
    <div class="min-h-screen bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative">
            <button onclick="navigateBack()" class="absolute top-4 left-4 text-gray-500 hover:text-gray-800 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </button>
            
            <div class="p-8 pt-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#1e3c5c]" id="authTitle">Selamat Datang</h2>
                    <p class="text-gray-500 mt-2" id="authSubtitle">Masuk untuk melanjutkan pemesanan tiket Anda.</p>
                </div>

                <form id="authForm" onsubmit="handleAuth(event)">
                    <div id="registerFields" class="hidden mb-4">
                        <label class="tw-label">Nama Lengkap</label>
                        <input type="text" id="authName" class="tw-input" placeholder="Masukkan nama Anda" />
                    </div>
                    <div class="mb-4">
                        <label class="tw-label">Alamat Email</label>
                        <input type="email" id="authEmail" required class="tw-input" placeholder="email@contoh.com" />
                    </div>
                    <div class="mb-4">
                        <label class="tw-label">Kata Sandi</label>
                        <input type="password" id="authPassword" required class="tw-input" placeholder="••••••••" />
                    </div>
                    <div id="rememberMeField" class="mb-6 flex items-center gap-2">
                        <input type="checkbox" id="rememberMe" />
                        <label for="rememberMe" class="text-sm text-gray-600">Ingat Saya</label>
                        <div class="text-right mt-2">
                    <a href="lupa_password.php" class="text-sm text-[#2b6c94] hover:underline">Lupa Sandi?</a>
                    </div>
                    </div>
                    <button type="submit" class="w-full bg-[#f39c12] hover:bg-[#e67e22] text-white font-bold py-3 rounded-xl transition shadow-lg text-lg">
                        <span id="authBtnText">Masuk Sekarang</span>
                    </button>
                </form>

                <div class="mt-6 text-center border-t border-gray-200 pt-6">
                    <p class="text-gray-600" id="authToggleText">
                        Belum punya akun? 
                        <button type="button" onclick="toggleAuthMode()" class="text-[#2b6c94] font-bold hover:underline">Daftar di sini</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="page-destinasi" class="page-view bg-gray-50 min-h-screen pb-12">
    <div class="bg-white shadow-sm p-4 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto flex items-center">
            <button onclick="navigateTo('page-home')" class="text-[#2b6c94] font-bold hover:text-[#1e3c5c]">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
            </button>
        </div>
    </div>
    <div class="max-w-6xl mx-auto px-4 mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div id="destHeroImg" class="h-80 bg-gradient-to-r from-blue-500 to-teal-400 bg-cover bg-center"></div>
                <div class="p-8">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 id="destTitle" class="text-4xl font-bold text-[#1e3c5c] mb-2">Nama Destinasi</h1>
                            <p id="destLocation" class="text-gray-500 text-lg"><i class="fas fa-map-marker-alt text-[#f39c12]"></i> Lokasi</p>
                        </div>
                        <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full font-bold flex items-center">
                            <i class="fas fa-star text-yellow-500 mr-2"></i> <span id="destRating">5.0</span>
                        </div>
                    </div>
                    <hr class="my-6 border-gray-200" />
                    <h3 class="text-xl font-bold mb-3">Deskripsi Lengkap</h3>
                    <p id="destDesc" class="text-gray-600 leading-relaxed text-lg">Deskripsi panjang destinasi akan muncul di sini.</p>
                </div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-lg p-6 border-t-4 border-[#2b6c94]">
                <h3 class="text-2xl font-bold text-[#1e3c5c] mb-6"><i class="fas fa-ticket-alt text-[#f39c12]"></i> Pesan Tiket</h3>
                <div class="space-y-4">
                    <div><label class="tw-label">Tanggal Kunjungan</label><input type="date" id="bookDate" class="tw-input" /></div>
                    <div><label class="tw-label">Jumlah Tiket</label><input type="number" id="bookQty" min="1" value="1" class="tw-input" onchange="calculateDestTotal()" /></div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-3">
                        <label class="flex items-center space-x-3 cursor-pointer"><input type="checkbox" id="bookGuide" class="w-5 h-5 text-blue-600 rounded" onchange="calculateDestTotal()"><span class="text-gray-700">Pemandu Wisata (+Rp 75.000)</span></label>
                        <label class="flex items-center space-x-3 cursor-pointer"><input type="checkbox" id="bookMeal" class="w-5 h-5 text-blue-600 rounded" onchange="calculateDestTotal()"><span class="text-gray-700">Makan Siang (+Rp 50.000)</span></label>
                    </div>
                    <div><label class="tw-label">Metode Pembayaran</label><select id="destPaymentMethod" class="tw-input bg-gray-50"><option value="transfer">Transfer Bank (BCA/Mandiri/BNI)</option><option value="ewallet">E-Wallet (GoPay/OVO/Dana)</option><option value="qris">QRIS</option></select></div>
                    <div class="bg-[#f6fafd] p-4 rounded-xl border border-blue-100 mt-4">
                        <div class="flex justify-between items-center mb-2 text-gray-600"><span>Harga Tiket</span><span id="bookPricePer">Rp 0</span></div>
                        <div class="flex justify-between items-center text-xl font-bold text-[#1e3c5c] border-t border-gray-200 pt-3 mt-2"><span>Total Tagihan</span><span id="bookTotal">Rp 0</span></div>
                    </div>
                    <button onclick="processPayment('destinasi')" class="w-full bg-[#2b6c94] hover:bg-[#1e4f6e] text-white font-bold py-4 rounded-xl shadow-lg transition flex justify-center items-center text-lg mt-4"><i class="fas fa-lock mr-2"></i> Bayar & Booking Sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="page-paket" class="page-view bg-gray-50 min-h-screen pb-12">
    <div class="bg-white shadow-sm p-4 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto flex items-center">
            <button onclick="navigateTo('page-home')" class="text-[#2b6c94] font-bold hover:text-[#1e3c5c]"><i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda</button>
        </div>
    </div>
    <div class="max-w-6xl mx-auto px-4 mt-8">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col md:flex-row">
            <div class="w-full md:w-3/5 p-8 lg:p-12 bg-[#1e3c5c] text-white relative bg-cover bg-center" style="background-image: linear-gradient(rgba(30, 60, 92, 0.9), rgba(30, 60, 92, 0.9)), url('https://images.unsplash.com/photo-1596751303335-cb442b109e4d?q=80&w=800&auto=format&fit=crop');">
                <div class="absolute top-0 right-0 opacity-10 text-9xl mt-10 mr-10" id="pkgIconBg"><i class="fas fa-users"></i></div>
                <div class="relative z-10">
                    <div class="inline-block bg-[#f39c12] text-white px-4 py-1 rounded-full text-sm font-bold tracking-wider mb-6">PAKET SPESIAL</div>
                    <h1 id="pkgTitle" class="text-4xl lg:text-5xl font-bold mb-4">Nama Paket</h1>
                    <p id="pkgFitur" class="text-xl text-blue-200 mb-8"><i class="fas fa-check-circle mr-2"></i>Fitur utama paket</p>
                    <div class="bg-white/10 p-6 rounded-2xl backdrop-blur-sm mb-6"><h3 class="text-xl font-bold mb-3 flex items-center"><i class="fas fa-info-circle text-[#f39c12] mr-3"></i> Deskripsi Paket</h3><p id="pkgDesc" class="text-gray-200 leading-relaxed">Deskripsi detail mengenai paket wisata ini.</p></div>
                    <div class="bg-yellow-500/20 p-6 rounded-2xl border border-yellow-500/30 backdrop-blur-sm"><h3 class="text-xl font-bold mb-3 text-yellow-300 flex items-center"><i class="fas fa-lightbulb mr-3"></i> Tips & Rekomendasi</h3><p id="pkgSaran" class="text-gray-200 leading-relaxed">Saran persiapan untuk memaksimalkan liburan Anda.</p></div>
                </div>
            </div>
            <div class="w-full md:w-2/5 p-8 lg:p-12 bg-white flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-[#1e3c5c] mb-6">Detail Reservasi Paket</h2>
                <div class="space-y-5">
                    <div><label class="tw-label">Pilih Tanggal Keberangkatan</label><input type="date" id="pkgDate" class="tw-input bg-gray-50" /></div>
                    <div><label class="tw-label">Informasi Kontak Pemesan</label><input type="text" placeholder="Nama Lengkap" class="tw-input mb-3" /><input type="text" placeholder="Nomor WhatsApp" class="tw-input" /></div>
                    <div><label class="tw-label">Metode Pembayaran</label><select id="pkgPaymentMethod" class="tw-input bg-gray-50"><option value="transfer">Transfer Bank (BCA/Mandiri/BNI)</option><option value="cc">Kartu Kredit / Debit</option><option value="qris">QRIS (Scan Langsung)</option></select></div>
                    <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100 mt-6"><p class="text-gray-500 text-sm mb-1">Total Biaya Paket</p><p id="pkgPrice" class="text-3xl font-bold text-[#2b6c94]">Rp 0</p></div>
                    <button onclick="processPayment('paket')" class="w-full bg-[#f39c12] hover:bg-[#e67e22] text-white font-bold py-4 rounded-xl shadow-lg transition text-lg mt-4 flex justify-center items-center"><i class="fas fa-shield-alt mr-2"></i> Konfirmasi & Bayar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toast" class="toast">Pesan berhasil ditambahkan</div>

<script>
// Data Destinasi & Paket (hardcode)
const destinations = [
    { id: 1, name: "Pantai Kuta", location: "Bali", price: 50000, rating: 4.8, imgUrl: "Kuta Beach in Lombok.jpg", description: "Nikmati keindahan sunset dan ombak yang mempesona di Pantai Kuta. Tempat sempurna untuk berselancar, berjemur, atau sekadar menikmati kelapa muda di pinggir pantai bersama orang tersayang." },
        { id: 2, name: "Gunung Bromo", location: "Jawa Timur", price: 75000, rating: 4.9, imgUrl: "mount bromo, java island - indonesia.jpg", description: "Saksikan pemandangan matahari terbit (sunrise) yang paling spektakuler di atas lautan pasir Gunung Bromo. Pengalaman offroad menggunakan Jeep yang tak terlupakan." },
        { id: 3, name: "Candi Borobudur", location: "Jawa Tengah", price: 40000, rating: 4.7, imgUrl: "Borobudur.jpg", description: "Jelajahi keagungan Candi Buddha terbesar di dunia peninggalan Dinasti Syailendra. Pelajari ribuan panel relief yang menceritakan perjalanan kehidupan." },
        { id: 4, name: "Museum Nasional", location: "Jakarta", price: 25000, rating: 4.5, imgUrl: "Museum Nasional, Jakarta.jpg", description: "Pusat koleksi sejarah dan budaya Nusantara dari zaman prasejarah hingga masa modern. Destinasi yang sangat cocok untuk wisata edukasi keluarga." },
        { id: 5, name: "Taman Safari", location: "Bogor", price: 95000, rating: 4.8, imgUrl: "download.jpg", description: "Berkendara menyusuri habitat satwa liar dari berbagai belahan dunia. Nikmati interaksi langsung memberi makan hewan dari kaca mobil Anda." },
        { id: 6, name: "Raja Ampat", location: "Papua Barat", price: 150000, rating: 5.0, imgUrl: "Raja Ampat.jpg", description: "Kepingan surga yang jatuh di bumi. Raja Ampat menawarkan gugusan pulau karang menawan dan kekayaan biota laut bawah air nomor satu di dunia untuk diving." }
      ];

      const paketWisata = [
        { id: 1, nama: "Paket Keluarga", harga: 350000, icon: "fa-users", fitur: "Tiket 4 orang + makan siang", imgUrl: "Kuta Beach in Lombok.jpg",desc: "Nikmati kemudahan liburan santai bersama keluarga tercinta tanpa pusing memikirkan akomodasi dasar. Kami urus tiket masuk dan hidangan makan siang yang lezat.", saran: "Bawa pakaian ganti ekstra untuk anak-anak, sedia obat-obatan pribadi, dan jangan lupa topi serta tabir surya." },
        { id: 2, nama: "Paket Romantis", harga: 275000, icon: "fa-heart", fitur: "Tiket 2 orang + makan malam", desc: "Ciptakan momen tak terlupakan berdua bersama pasangan. Meliputi akses VIP ke destinasi dan ditutup dengan makan malam romantis dengan pemandangan indah.", saran: "Kenakan pakaian yang nyaman namun rapi. Bawa kamera atau siapkan memori HP untuk mengabadikan momen berdua." },
        { id: 3, nama: "Paket Group", harga: 1250000, icon: "fa-people-group", fitur: "Tiket 10 orang + bus + guide", desc: "Pilihan terbaik untuk rombongan kantor, reuni, atau arisan. Harga super hemat sudah termasuk transportasi bus nyaman dan pemandu wisata profesional yang ceria.", saran: "Tentukan satu koordinator rombongan, sepakati titik kumpul dan waktu yang tepat agar perjalanan sesuai jadwal." },
        { id: 4, nama: "Paket Backpacker", harga: 150000, icon: "fa-backpack", fitur: "Tiket + transport lokal", desc: "Eksplorasi destinasi unggulan dengan cara paling otentik. Menggunakan moda transportasi lokal yang menyatu dengan masyarakat sekitar.", saran: "Bawa barang seringkas mungkin dalam satu ransel. Siapkan uang tunai pecahan kecil dan selalu sedia botol minum." }
      ];

// State
let isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;
let activeDestPrice = 0;
let historyPage = 'page-home';

// Fungsi Navigasi
function navigateTo(pageId) {
    document.querySelectorAll('.page-view').forEach(p => p.classList.remove('active'));
    document.getElementById(pageId).classList.add('active');
    window.scrollTo(0, 0);
}
function navigateBack() { navigateTo(historyPage); }
function scrollToSection(id) {
    if(document.getElementById('page-home').classList.contains('active')) {
        document.getElementById(id).scrollIntoView({ behavior: "smooth" });
    } else {
        navigateTo('page-home');
        setTimeout(() => document.getElementById(id).scrollIntoView({ behavior: "smooth" }), 300);
    }
}

// Render data home
function renderHome() {
    const destCont = document.getElementById("destinasiContainer");
    destCont.innerHTML = "";
    destinations.forEach(dest => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
            <div class="card-img"><img src="${dest.imgUrl}" alt="${dest.name}"><span class="rating"><i class="fas fa-star" style="color:gold; margin-right: 4px;"></i> ${dest.rating}</span></div>
            <div class="card-content"><h3>${dest.name}</h3><div class="location"><i class="fas fa-map-marker-alt"></i> ${dest.location}</div><div class="price">Rp ${dest.price.toLocaleString("id-ID")} <small>/ tiket</small></div><button class="btn-card mt-3"><i class="fas fa-bolt"></i> Pesan Sekarang</button></div>
        `;
        card.onclick = () => openDestinasiPage(dest);
        destCont.appendChild(card);
    });

    const pakCont = document.getElementById("paketContainer");
    pakCont.innerHTML = "";
    paketWisata.forEach(paket => {
        const card = document.createElement("div");
        card.className = "paket-card";
        card.innerHTML = `<i class="fas ${paket.icon}"></i><h3 class="text-xl font-bold mt-2 text-[#1e3c5c]">${paket.nama}</h3><p class="text-gray-500 mt-1">${paket.fitur}</p><div style="font-size:1.5rem; color:#2b6c94; margin:1rem 0; font-weight:bold;">Rp ${paket.harga.toLocaleString("id-ID")}</div><button class="btn-outline w-full hover:bg-[#2b6c94] hover:text-white">Lihat & Pesan</button>`;
        card.onclick = () => openPaketPage(paket);
        pakCont.appendChild(card);
    });
}

function openDestinasiPage(dest) {
    if (!isLoggedIn) { showToast("Silakan Login terlebih dahulu.", true); historyPage = 'page-home'; navigateTo('page-auth'); return; }
    document.getElementById('destHeroImg').style.backgroundImage = `url('${dest.imgUrl}')`;
    document.getElementById('destTitle').textContent = dest.name;
    document.getElementById('destLocation').innerHTML = `<i class="fas fa-map-marker-alt text-[#f39c12] mr-2"></i> ${dest.location}`;
    document.getElementById('destRating').textContent = dest.rating;
    document.getElementById('destDesc').textContent = dest.description;
    document.getElementById('bookPricePer').textContent = `Rp ${dest.price.toLocaleString('id-ID')} / org`;
    const today = new Date().toISOString().split("T")[0];
    document.getElementById('bookDate').min = today;
    document.getElementById('bookDate').value = today;
    document.getElementById('bookQty').value = 1;
    document.getElementById('bookGuide').checked = false;
    document.getElementById('bookMeal').checked = false;
    activeDestPrice = dest.price;
    calculateDestTotal();
    navigateTo('page-destinasi');
}

function openPaketPage(paket) {
    if (!isLoggedIn) { showToast("Silakan Login terlebih dahulu.", true); historyPage = 'page-home'; navigateTo('page-auth'); return; }
    document.getElementById('pkgTitle').textContent = paket.nama;
    document.getElementById('pkgFitur').innerHTML = `<i class="fas fa-check-circle mr-2"></i> ${paket.fitur}`;
    document.getElementById('pkgDesc').textContent = paket.desc;
    document.getElementById('pkgSaran').textContent = paket.saran;
    document.getElementById('pkgIconBg').innerHTML = `<i class="fas ${paket.icon}"></i>`;
    document.getElementById('pkgPrice').textContent = `Rp ${paket.harga.toLocaleString('id-ID')}`;
    const today = new Date().toISOString().split("T")[0];
    document.getElementById('pkgDate').min = today;
    document.getElementById('pkgDate').value = today;
    navigateTo('page-paket');
}

function calculateDestTotal() {
    let qty = parseInt(document.getElementById('bookQty').value) || 1;
    if(qty < 1) { document.getElementById('bookQty').value = 1; qty = 1; }
    const base = activeDestPrice * qty;
    const guide = document.getElementById('bookGuide').checked ? 75000 : 0;
    const meal = document.getElementById('bookMeal').checked ? 50000 : 0;
    const total = base + guide + meal;
    document.getElementById('bookTotal').textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

function processPayment(type) {
    showToast("Memproses pembayaran...", false);
    setTimeout(() => { showToast(`✅ Pembayaran ${type === 'destinasi' ? 'Tiket' : 'Paket'} Berhasil!`, false); navigateTo('page-home'); }, 1500);
}

// Authentication
let isRegistering = false;
function toggleAuthMode() {
    isRegistering = !isRegistering;
    document.getElementById('registerFields').classList.toggle('hidden', !isRegistering);
    document.getElementById('rememberMeField').classList.toggle('hidden', isRegistering);
    document.getElementById('authTitle').textContent = isRegistering ? "Daftar Akun Baru" : "Selamat Datang";
    document.getElementById('authSubtitle').textContent = isRegistering ? "Isi data diri Anda untuk membuat akun." : "Masuk untuk melanjutkan pemesanan tiket Anda.";
    document.getElementById('authBtnText').textContent = isRegistering ? "Buat Akun Sekarang" : "Masuk Sekarang";
    document.getElementById('authToggleText').innerHTML = isRegistering ? 
        `Sudah punya akun? <button type="button" onclick="toggleAuthMode()" class="text-[#2b6c94] font-bold hover:underline">Masuk di sini</button>` :
        `Belum punya akun? <button type="button" onclick="toggleAuthMode()" class="text-[#2b6c94] font-bold hover:underline">Daftar di sini</button>`;
}

async function handleAuth(e) {
    e.preventDefault();
    const email = document.getElementById('authEmail').value;
    const password = document.getElementById('authPassword').value;
    const remember = document.getElementById('rememberMe')?.checked ? 1 : 0;

    if (isRegistering) {
        const username = document.getElementById('authName').value;
        if (!username) { showToast("Nama lengkap harus diisi", true); return; }
        const formData = new FormData();
        formData.append('username', username);
        formData.append('email', email);
        formData.append('password', password);
        const response = await fetch('proses/prosesRegister.php', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const result = await response.json();
        if (result.status === 'success') {
            showToast(result.message, false);
            toggleAuthMode(); // beralih ke mode login
            document.getElementById('authEmail').value = email;
            document.getElementById('authPassword').value = '';
        } else {
            showToast(result.message, true);
        }
    } else {
        const formData = new FormData();
        formData.append('username', email); // karena di form login, email diinput sebagai username (bisa pakai email atau username, tapi di backend menggunakan username)
        formData.append('password', password);
        formData.append('remember', remember);
        const response = await fetch('proses/prosesLogin.php', { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const result = await response.json();
        if (result.status === 'success') {
            isLoggedIn = true;
            showToast("Login berhasil! Selamat datang.", false);
            // Reload halaman agar session tersimpan dan navbar berubah
            window.location.href = 'index.php';
        } else {
            showToast(result.message, true);
        }
    }
}

function showToast(message, isError = false) {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.style.backgroundColor = isError ? "#e74c3c" : "#27ae60";
    toast.classList.add("show");
    setTimeout(() => toast.classList.remove("show"), 3000);
}
function search() { const val = document.getElementById('searchInput').value; if(val) showToast(`Mencari "${val}"...`, false); else showToast("Masukkan kata kunci pencarian.", true); }

// Typing effect
const typingElement = document.getElementById("typing-text");
const phrases = ["Bingung Liburan Kemana?", "Di DDELTIKET Aja!", "Pesan Tiket Cepat & Mudah Ga Ribet!"];
let phraseIdx = 0, charIdx = 0, isDeleting = false;
function typeEffect() {
    const cur = phrases[phraseIdx];
    typingElement.textContent = isDeleting ? cur.substring(0, charIdx - 1) : cur.substring(0, charIdx + 1);
    charIdx += isDeleting ? -1 : 1;
    let speed = isDeleting ? 50 : 120;
    if(!isDeleting && charIdx === cur.length) { isDeleting = true; speed = 1500; }
    else if(isDeleting && charIdx === 0) { isDeleting = false; phraseIdx = (phraseIdx + 1) % phrases.length; speed = 500; }
    setTimeout(typeEffect, speed);
}
// INIT
renderHome();
setTimeout(typeEffect, 1000);
</script>
</body>
</html>