<?php
// ==========================================================================
// TUGAS UTS PEMROGRAMAN WEB - S1 BISNIS DIGITAL
// NAMA USAHA : SIOMAY COSTHA
// FILE       : index.php
// DESKRIPSI  : Halaman utama berisi navigasi, home, menu, pemesanan, kontak,
//              serta pemrosesan form PHP dan penghitung pengunjung.
// ==========================================================================

// --------------------------------------------------------------------------
// 1. FITUR PENGHITUNG PENGUNJUNG (VISITOR COUNTER)
// Membaca dan memperbarui data angka pada file counter.txt
// --------------------------------------------------------------------------
$nama_file_counter = "counter.txt";

if (file_exists($nama_file_counter)) {
    // Membaca angka saat ini, lalu ditambah 1
    $jumlah_kunjungan = (int) file_get_contents($nama_file_counter);
    $jumlah_kunjungan++;
    // Menyimpan angka terbaru ke counter.txt
    file_put_contents($nama_file_counter, $jumlah_kunjungan);
} else {
    // Jika file belum ada, mulai dari angka 1
    $jumlah_kunjungan = 1;
    file_put_contents($nama_file_counter, $jumlah_kunjungan);
}

// --------------------------------------------------------------------------
// 2. DAFTAR MENU & HARGA (ARRAY ASOSIATIF PHP)
// Format: "Nama Menu" => Harga (Angka Integer)
// Anda dapat dengan mudah menambah menu baru atau mengubah harga di bawah ini.
// --------------------------------------------------------------------------
$daftar_menu = [
    "Siomay Original"  => 15000,
    "Siomay Pedas"     => 17000,
    "Siomay Campur"    => 20000,
    "Siomay Jumbo"     => 25000,
    "Es Teh Manis"     => 5000,
    "Es Jeruk Segar"   => 7000
];

// --------------------------------------------------------------------------
// 3. PEMROSESAN FORM PEMESANAN (PHP NATIVE DENGAN METHOD POST)
// --------------------------------------------------------------------------
$pesan_sukses   = false;
$pesan_error    = "";
$nama_pembeli   = "";
$menu_terpilih  = "";
$jumlah_porsi   = 0;
$harga_satuan   = 0;
$total_bayar    = 0;

// Cek apakah form disubmit dengan method POST
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_pesanan"])) {
    // Mengambil data input dari $_POST dan membersihkan spasi di awal/akhir
    $input_nama   = isset($_POST["nama"]) ? trim($_POST["nama"]) : "";
    $input_menu   = isset($_POST["menu"]) ? trim($_POST["menu"]) : "";
    $input_jumlah = isset($_POST["jumlah"]) ? (int) $_POST["jumlah"] : 0;

    // Validasi data menggunakan if / else
    if (empty($input_nama)) {
        $pesan_error = "Nama pembeli wajib diisi!";
    } elseif ($input_jumlah < 1) {
        $pesan_error = "Jumlah pesanan minimal adalah 1 porsi!";
    } elseif (!array_key_exists($input_menu, $daftar_menu)) {
        $pesan_error = "Pilihan menu tidak valid!";
    } else {
        // Jika validasi lolos: hitung total harga
        $harga_satuan  = $daftar_menu[$input_menu];
        $total_bayar   = $harga_satuan * $input_jumlah;

        // Amankan data tampilan menggunakan htmlspecialchars() untuk mencegah XSS
        $nama_pembeli  = htmlspecialchars($input_nama);
        $menu_terpilih = htmlspecialchars($input_menu);
        $jumlah_porsi  = $input_jumlah;

        $pesan_sukses  = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siomay Costha - Cita Rasa Gurih & Autentik</title>
    <!-- Menghubungkan file eksternal CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- ==================== HEADER & NAVIGATION ==================== -->
    <header class="header-utama">
        <div class="kontainer header-konten">
            <div class="logo">
                <a href="#home">Siomay <span>Costha</span></a>
            </div>
            <!-- Navigasi dengan 4 link anchor (#id) -->
            <nav class="navigasi">
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#menu">Menu</a></li>
                    <li><a href="#pesan">Pesan</a></li>
                    <li><a href="#kontak">Kontak</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ==================== SECTION 1: HOME ==================== -->
    <section id="home" class="section-home">
        <div class="kontainer home-konten">
            <div class="home-teks">
                <span class="badge">Kuliner Tradisional Pilihan</span>
                <h1>Siomay Costha</h1>
                <p class="tagline">Lezatnya Ikan Tenggiri Asli, Gurihnya Saus Kacang Legendaris</p>
                <p class="deskripsi">
                    Selamat datang di <strong>Siomay Costha</strong>! Kami menyajikan siomay khas dengan resep warisan keluarga yang dibuat dari 100% daging ikan tenggiri segar pilihan. Disajikan hangat lengkap dengan bumbu kacang kental yang gurih, perasan jeruk limau segar, serta tekstur kenyal dan lembut di setiap gigitan. Cocok dinikmati bersama teman dan keluarga tercinta.
                </p>
                <div class="home-aksi">
                    <a href="#menu" class="tombol tombol-sekunder">Lihat Daftar Menu</a>
                    <a href="#pesan" class="tombol tombol-primer">Pesan Sekarang</a>
                </div>
            </div>
            <div class="home-gambar">
                <!-- CATATAN: Gambar dapat diganti dengan meletakkan file foto Anda di folder images/siomay1.jpg -->
                <img src="images/siomay1.jpg" alt="Seporsi Siomay Costha Lengkap dengan Bumbu Kacang">
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 2: MENU ==================== -->
    <section id="menu" class="section-menu">
        <div class="kontainer">
            <div class="judul-section">
                <h2>Daftar Menu & Keunggulan</h2>
                <p>Pilihan menu terbaik dengan bahan berkualitas tinggi dan harga terjangkau</p>
            </div>

            <!-- Tabel Daftar Menu dan Harga -->
            <div class="pembungkus-tabel">
                <table class="tabel-menu">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Keterangan</th>
                            <th>Harga Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $nomor = 1;
                        foreach ($daftar_menu as $nama_item => $harga_item) { 
                            // Memberikan deskripsi ringkas untuk memperkaya tabel
                            $keterangan = "Menu favorit pelanggan";
                            if ($nama_item === "Siomay Original") {
                                $keterangan = "Siomay ikan tenggiri murni + tahu + kentang + bumbu kacang";
                            } elseif ($nama_item === "Siomay Pedas") {
                                $keterangan = "Siomay dengan racikan cabai rawit pedas mantap";
                            } elseif ($nama_item === "Siomay Campur") {
                                $keterangan = "Komplit: Siomay, telur rebus, tahu, kubis, dan pare";
                            } elseif ($nama_item === "Siomay Jumbo") {
                                $keterangan = "Porsi dobel puas untuk pecinta kuliner sejati";
                            } elseif ($nama_item === "Es Teh Manis") {
                                $keterangan = "Teh melati wangi dingin segar";
                            } elseif ($nama_item === "Es Jeruk Segar") {
                                $keterangan = "Perasan jeruk asli yang manis dan menyegarkan";
                            }
                        ?>
                        <tr>
                            <td class="kolom-nomor"><?php echo $nomor++; ?></td>
                            <td class="kolom-menu"><strong><?php echo $nama_item; ?></strong></td>
                            <td class="kolom-keterangan"><?php echo $keterangan; ?></td>
                            <td class="kolom-harga">Rp <?php echo number_format($harga_item, 0, ',', '.'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- List Keunggulan Siomay Costha -->
            <div class="keunggulan-box">
                <h3>Kenapa Harus Memilih Siomay Costha?</h3>
                <ul class="daftar-keunggulan">
                    <li><strong>100% Ikan Tenggiri Segar:</strong> Tanpa campuran tepung berlebih, menghasilkan aroma dan rasa ikan yang dominan.</li>
                    <li><strong>Bumbu Kacang Khas & Kental:</strong> Dibuat dari kacang tanah tuban sangrai tanpa minyak curah, berpadu gula aren asli.</li>
                    <li><strong>Higienis, Halal & Tanpa Pengawet:</strong> Setiap porsi diproses bersih setiap hari tanpa bahan pengawet kimia.</li>
                    <li><strong>Porsi Mengenyangkan:</strong> Komposisi komplit dengan pilihan telur, tahu sutra, kubis gulung, dan pare segar.</li>
                    <li><strong>Harga Mahasiswa & Bersahabat:</strong> Kualitas premium restoran dengan harga yang ramah di kantong.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 3: PESAN ==================== -->
    <section id="pesan" class="section-pesan">
        <div class="kontainer">
            <div class="judul-section">
                <h2>Form Pemesanan Online</h2>
                <p>Silakan isi data di bawah ini untuk menghitung dan membuat pesanan Anda</p>
            </div>

            <div class="form-kartu">
                <!-- Form pemesanan dengan method POST -->
                <form action="index.php#pesan" method="POST" class="form-pemesanan">
                    
                    <!-- Input Nama Pembeli -->
                    <div class="form-grup">
                        <label for="nama">Nama Pembeli:</label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            placeholder="Contoh: Rifat Ghaisano" 
                            value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" 
                            required
                        >
                    </div>

                    <!-- Input Pilihan Menu (Dropdown Select dari Array PHP) -->
                    <div class="form-grup">
                        <label for="menu">Pilihan Menu:</label>
                        <select id="menu" name="menu" required>
                            <option value="">-- Pilih Menu Siomay / Minuman --</option>
                            <?php 
                            foreach ($daftar_menu as $nama_item => $harga_item) {
                                // Menjaga pilihan tetap terpilih setelah disubmit
                                $selected = (isset($_POST['menu']) && $_POST['menu'] === $nama_item) ? "selected" : "";
                                echo "<option value='{$nama_item}' {$selected}>{$nama_item} - Rp " . number_format($harga_item, 0, ',', '.') . "</option>";
                            } 
                            ?>
                        </select>
                    </div>

                    <!-- Input Jumlah Porsi -->
                    <div class="form-grup">
                        <label for="jumlah">Jumlah Porsi / Pcs:</label>
                        <input 
                            type="number" 
                            id="jumlah" 
                            name="jumlah" 
                            min="1" 
                            value="<?php echo isset($_POST['jumlah']) ? (int)$_POST['jumlah'] : '1'; ?>" 
                            required
                        >
                    </div>

                    <!-- Tombol Submit -->
                    <div class="form-grup">
                        <button type="submit" name="submit_pesanan" class="tombol tombol-primer tombol-blok">
                            Pesan Sekarang
                        </button>
                    </div>
                </form>

                <!-- AREA HASIL PEMROSESAN PHP (RINGKASAN PESANAN ATAU PESAN ERROR) -->
                <?php if ($pesan_sukses) { ?>
                    <div class="hasil-pesanan">
                        <div class="hasil-header">
                            <h3>Pesanan Diterima!</h3>
                            <p>Terima kasih, pesanan Anda berhasil diproses oleh sistem.</p>
                        </div>
                        <div class="hasil-rincian">
                            <div class="baris-rincian">
                                <span>Nama Pembeli:</span>
                                <strong><?php echo $nama_pembeli; ?></strong>
                            </div>
                            <div class="baris-rincian">
                                <span>Menu Pilihan:</span>
                                <strong><?php echo $menu_terpilih; ?></strong>
                            </div>
                            <div class="baris-rincian">
                                <span>Jumlah Pesanan:</span>
                                <strong><?php echo $jumlah_porsi; ?> porsi</strong>
                            </div>
                            <div class="baris-rincian">
                                <span>Harga Satuan:</span>
                                <strong>Rp <?php echo number_format($harga_satuan, 0, ',', '.'); ?></strong>
                            </div>
                            <hr class="garis-pemisah">
                            <div class="baris-rincian total">
                                <span>Total Bayar:</span>
                                <span class="angka-total">Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                        <p class="catatan-sukses">
                            Silakan tunjukkan ringkasan ini atau hubungi WhatsApp kami untuk konfirmasi pengiriman.
                        </p>
                    </div>
                <?php } elseif (!empty($pesan_error)) { ?>
                    <div class="pesan-peringatan">
                        <strong>Perhatian:</strong> <?php echo htmlspecialchars($pesan_error); ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>

    <!-- ==================== SECTION 4: KONTAK ==================== -->
    <section id="kontak" class="section-kontak">
        <div class="kontainer">
            <div class="judul-section">
                <h2>Kontak & Lokasi Kami</h2>
                <p>Kunjungi gerai kami atau hubungi nomor di bawah untuk pemesanan rombongan & katering</p>
            </div>

            <div class="kontak-grid">
                <!-- Kartu Alamat -->
                <div class="kartu-kontak">
                    <div class="ikon-kontak">&#128205;</div>
                    <h3>Alamat Gerai</h3>
                    <p>Jl. Kampus Merdeka No. 18, Kelurahan Digital, Kota Malang, Jawa Timur</p>
                    <p class="keterangan-tambahan">(Area Pujasera Dekat Fakultas Bisnis)</p>
                </div>

                <!-- Kartu Jam Buka -->
                <div class="kartu-kontak">
                    <div class="ikon-kontak">&#128337;</div>
                    <h3>Jam Operasional</h3>
                    <p><strong>Senin - Sabtu:</strong> 10.00 - 21.00 WIB</p>
                    <p><strong>Minggu:</strong> 11.00 - 20.00 WIB</p>
                    <p class="keterangan-tambahan">(Tutup pada hari libur nasional)</p>
                </div>

                <!-- Kartu WhatsApp & Telepon -->
                <div class="kartu-kontak">
                    <div class="ikon-kontak">&#128222;</div>
                    <h3>WhatsApp & Telepon</h3>
                    <p><strong>0812-3456-7890</strong></p>
                    <p>Menerima pesanan katering, arisan, rapat, dan acara kampus.</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="link-wa">Chat WhatsApp Kami &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== FOOTER ==================== -->
    <footer class="footer-utama">
        <div class="kontainer footer-konten">
            <p>&copy; <?php echo date("Y"); ?> <strong>Siomay Costha</strong> - Tugas UTS Pemrograman Web | S1 Bisnis Digital.</p>
            <!-- Menampilkan Jumlah Kunjungan dari file counter.txt -->
            <p class="counter-pengunjung">
                Total Kunjungan Halaman: <strong><?php echo $jumlah_kunjungan; ?></strong> kali
            </p>
        </div>
    </footer>

</body>
</html>
