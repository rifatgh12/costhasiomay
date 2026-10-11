<?php

$nama_file_counter = "counter.txt";

if (file_exists($nama_file_counter)) {
    // Membaca angka saat ini, lalu ditambah 1
    $jumlah_kunjungan = (int) file_get_contents($nama_file_counter);
    $jumlah_kunjungan++;
    // Menyimpan angka terbaru ke counter.txt
    file_put_contents($nama_file_counter, $jumlah_kunjungan);
} else {
    $jumlah_kunjungan = 1;
    file_put_contents($nama_file_counter, $jumlah_kunjungan);
}


$daftar_menu = [
    "Siomay Original"  => 15000,
    "Siomay Pedas"     => 17000,
    "Siomay Campur"    => 20000,
    "Siomay Jumbo"     => 25000,
    "Es Teh Manis"     => 5000,
    "Es Jeruk Segar"   => 7000
];

$pesan_error    = "";
$nama_pembeli   = "";
$menu_terpilih  = "";
$jumlah_porsi   = 0;
$harga_satuan   = 0;
$total_bayar    = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit_pesanan"])) {
    $input_nama   = isset($_POST["nama"]) ? trim($_POST["nama"]) : "";
    $input_menu   = isset($_POST["menu"]) ? trim($_POST["menu"]) : "";
    $input_jumlah = isset($_POST["jumlah"]) ? (int) $_POST["jumlah"] : 0;

    if (empty($input_nama)) {
        $pesan_error = "Nama pembeli wajib diisi!";
    } elseif ($input_jumlah < 1) {
        $pesan_error = "Jumlah pesanan minimal adalah 1 porsi!";
    } elseif (!array_key_exists($input_menu, $daftar_menu)) {
        $pesan_error = "Pilihan menu tidak valid!";
    } else {
        $harga_satuan  = $daftar_menu[$input_menu];
        $total_bayar   = $harga_satuan * $input_jumlah;

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
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="header-utama">
        <div class="kontainer header-konten">
            <div class="logo">
                <a href="#home">Siomay <span>Costha</span></a>
            </div>
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
                <img src="images/siomay1.jpg" alt="Seporsi Siomay Costha Lengkap dengan Bumbu Kacang">
            </div>
        </div>
    </section>

    <section id="menu" class="section-menu">
        <div class="kontainer">
            <div class="judul-section">
                <h2>Daftar Menu & Keunggulan</h2>
                <p>Pilihan menu terbaik dengan bahan berkualitas tinggi dan harga terjangkau</p>
            </div>

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

    <section id="pesan" class="section-pesan">
        <div class="kontainer">
            <div class="judul-section">
                <h2>Form Pemesanan Online</h2>
                <p>Silakan isi data di bawah ini untuk menghitung dan membuat pesanan Anda</p>
            </div>

            <div class="form-kartu">
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

                    <div class="form-grup">
                        <button type="submit" name="submit_pesanan" class="tombol tombol-primer tombol-blok">
                            Pesan Sekarang
                        </button>
                    </div>
                </form>

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

    <section id="kontak" class="section-kontak">
        <div class="kontainer">
            <div class="judul-section">
                <h2>Kontak & Lokasi Kami</h2>
                <p>Kunjungi gerai kami atau hubungi nomor di bawah untuk pemesanan rombongan & katering</p>
            </div>

            <div class="kontak-grid">
                <div class="kartu-kontak">
                    <div class="ikon-kontak">&#128205;</div>
                    <h3>Alamat Gerai</h3>
                    <p>JL.H maksum, Sawangan, Depok, Jawa Barat</p>
                    <p class="keterangan-tambahan">(Deket Masjid Al Aula)</p>
                </div>

                <div class="kartu-kontak">
                    <div class="ikon-kontak">&#128337;</div>
                    <h3>Jam Operasional</h3>
                    <p><strong>Senin - Sabtu:</strong> 10.00 - 21.00 WIB</p>
                    <p><strong>Minggu:</strong> 11.00 - 20.00 WIB</p>
                    <p class="keterangan-tambahan">(Tutup pada hari libur nasional)</p>
                </div>

                <div class="kartu-kontak">
                    <div class="ikon-kontak">&#128222;</div>
                    <h3>WhatsApp & Telepon</h3>
                    <p><strong>0821-2211-6096</strong></p>
                    <p>Menerima pesanan katering, arisan, rapat, dan acara kampus.</p>
                    <a href="https://wa.me/6282122116096" target="_blank" class="link-wa">Chat WhatsApp Kami &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-utama">
        <div class="kontainer footer-konten">
            <p>&copy; <?php echo date("Y"); ?> <strong>Siomay Costha</strong> </p>
            <p class="counter-pengunjung">
                Total Kunjungan Halaman: <strong><?php echo $jumlah_kunjungan; ?></strong> kali
            </p>
        </div>
    </footer>

</body>
</html>
