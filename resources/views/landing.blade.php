<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starfood International - Sistem Monitoring Pest Control</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #f3f8f6 !important; color: #123b3a !important; }
        body > nav { background: #123b3a !important; }
        body > nav a { color: #d9eeeb !important; }
        body > nav a:last-child,
        body > section:first-of-type a { background: #f07f5f !important; color: white !important; }
        body > section:first-of-type { background: linear-gradient(135deg, #123b3a 0%, #155e63 60%, #1c7a7b 100%) !important; }
        body > section:first-of-type span { color: #ffd8cb !important; border-color: rgba(240,127,95,.45) !important; background: rgba(240,127,95,.15) !important; }
        body > section:first-of-type p { color: #d9eeeb !important; }
        body > section:nth-of-type(2) > div > div > div > div:first-child,
        body > section:nth-of-type(2) > div > div > div > div:nth-child(2),
        body > section:nth-of-type(2) > div > div > div > div:nth-child(3) { color: #1c7a7b !important; }
        #device { background: #e6f1ee !important; }
        #layanan { border-color: #c7dcd8 !important; }
        #device p, #layanan p, #keunggulan p { color: #52716e !important; }
        #device > div > div > div, #layanan > div > div > div { border-color: #c7dcd8 !important; }
        #keunggulan > div > div:first-child > div { background: #e0f0ed !important; }
        #keunggulan > div > div:nth-child(2) > div { background: #ffe6de !important; }
        #keunggulan > div > div:nth-child(3) > div { background: #f9e1db !important; }
        footer { background: #123b3a !important; color: #d9eeeb !important; }
        @media (max-width: 700px) {
            nav { gap: 16px; flex-wrap: wrap; }
            nav > div { gap: 12px !important; flex-wrap: wrap; justify-content: flex-end; }
            nav > div > a:not(:last-child) { display: none; }
            #pabrik { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body style="margin:0; font-family: 'Poppins', sans-serif; background: #f8fafc; color: #1e293b;">

    <nav style="background: #0f172a; padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50;">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 36px;">
        <div style="display:flex; align-items:center; gap:24px;">
            <a href="#pabrik" style="color:#cbd5e1; text-decoration:none; font-size:14px; font-weight:500;">Pabrik</a>
            <a href="#device" style="color:#cbd5e1; text-decoration:none; font-size:14px; font-weight:500;">Device</a>
            <a href="#layanan" style="color:#cbd5e1; text-decoration:none; font-size:14px; font-weight:500;">Layanan</a>
            <a href="#keunggulan" style="color:#cbd5e1; text-decoration:none; font-size:14px; font-weight:500;">Keunggulan</a>
            <a href="{{ route('login') }}" style="background:#0891b2; color:white; padding: 10px 20px; border-radius: 10px; text-decoration:none; font-weight:600; font-size:14px;">Masuk ke Sistem</a>
        </div>
    </nav>

    <section style="background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #0891b2 100%); color:white; padding: 70px 24px; text-align:center;">
        <span style="display:inline-block; background:rgba(34,211,238,0.15); border:1px solid rgba(34,211,238,0.3); color:#67e8f9; padding:6px 14px; border-radius:999px; font-size:12px; font-weight:600; letter-spacing:1px; text-transform:uppercase;">Quality Control Department</span>
        <h1 style="font-size: 34px; font-weight:800; margin: 20px 0 12px; max-width:700px; margin-left:auto; margin-right:auto;">Sistem Monitoring Pest Control Terpadu</h1>
        <p style="font-size:16px; color:#cbd5e1; max-width:600px; margin: 0 auto 28px;">Pencatatan, pemantauan, dan pelaporan aktivitas hama di seluruh area produksi Starfood International secara digital, real-time, dan terdokumentasi.</p>
        <a href="{{ route('login') }}" style="background:#0891b2; color:white; padding: 14px 30px; border-radius: 12px; text-decoration:none; font-weight:700; font-size:15px; display:inline-block;">Masuk ke Dashboard →</a>
    </section>

    <section style="max-width: 1000px; margin: -40px auto 0; padding: 0 24px 60px; position:relative; z-index:10;">
        <div style="background:white; border-radius:20px; box-shadow: 0 20px 50px rgba(15,23,42,0.12); display:grid; grid-template-columns: repeat(auto-fit, minmax(150px,1fr)); text-align:center; overflow:hidden;">
            <div style="padding: 28px 16px; border-right: 1px solid #e2e8f0;">
                <div style="font-size:30px; font-weight:800; color:#0891b2;">7</div>
                <div style="font-size:13px; color:#64748b; margin-top:4px;">Monitoring Device</div>
            </div>
            <div style="padding: 28px 16px; border-right: 1px solid #e2e8f0;">
                <div style="font-size:30px; font-weight:800; color:#0891b2;">{{ $totalTraps }}</div>
                <div style="font-size:13px; color:#64748b; margin-top:4px;">Titik Monitoring Aktif</div>
            </div>
            <div style="padding: 28px 16px;">
                <div style="font-size:30px; font-weight:800; color:#0891b2;">24/7</div>
                <div style="font-size:13px; color:#64748b; margin-top:4px;">Pemantauan Berkelanjutan</div>
            </div>
        </div>
    </section>

    <section id="pabrik" style="max-width: 1000px; margin: 0 auto; padding: 20px 24px 70px; display:grid; grid-template-columns: 1fr 1fr; gap:36px; align-items:center;">
        <div>
            <img src="{{ asset('images/pabrik.jpeg') }}" alt="Pabrik Starfood International" style="width:100%; border-radius:20px; box-shadow: 0 12px 30px rgba(15,23,42,0.1); object-fit:cover; aspect-ratio: 4/3; background:#e2e8f0;">
        </div>
        <div>
            <span style="color:#0891b2; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:1px;">Fasilitas Produksi</span>
            <h2 style="font-size:24px; font-weight:800; margin:10px 0 14px;">Pabrik Starfood International</h2>
            <p style="font-size:14px; color:#475569; line-height:1.7; margin-bottom:14px;">
                Sebagai fasilitas pengolahan produk makanan, kebersihan dan keamanan pangan menjadi prioritas utama di setiap area produksi. Kehadiran hama seperti lalat, tikus, dan serangga dapat menjadi sumber kontaminasi yang mengancam mutu produk dan keselamatan konsumen.
            </p>
            <p style="font-size:14px; color:#475569; line-height:1.7;">
                Program pengendalian hama diterapkan secara sistematis di seluruh area — mulai dari area penerimaan bahan baku, ruang proses, area packing, hingga gudang penyimpanan — guna memastikan lingkungan produksi tetap higienis dan sesuai standar keamanan pangan yang berlaku.
            </p>
        </div>
    </section>
        <section id="device" style="background:#f1f5f9; padding: 60px 24px;">
    <div style="max-width:1100px; margin:0 auto;">
        <h2 style="text-align:center; font-size:24px; font-weight:800; margin-bottom:8px;">Monitoring Device</h2>
        <p style="text-align:center; color:#64748b; margin-bottom:36px;">7 jenis perangkat monitoring yang digunakan dalam program pengendalian hama</p>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:20px;">

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-1.jpeg') }}" alt="Device 1" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Nama Device 1</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Keterangan singkat device</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-2.jpeg') }}" alt="Device 2" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Nama Device 2</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Keterangan singkat device</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-3.jpeg') }}" alt="Device 3" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Nama Device 3</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Keterangan singkat device</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-4.jpeg') }}" alt="Device 4" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Nama Device 4</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Keterangan singkat device</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-5.jpeg') }}" alt="Device 5" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Nama Device 5</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Keterangan singkat device</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-6.jpeg') }}" alt="Device 6" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Nama Device 6</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Keterangan singkat device</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-7.jpeg') }}" alt="Device 7" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Nama Device 7</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Keterangan singkat device</p>
                </div>
            </div>

        </div>
    </div>
</section>
    <section id="layanan" style="background:white; padding: 60px 24px; border-top:1px solid #e2e8f0; border-bottom:1px solid #e2e8f0;">
        <div style="max-width:1000px; margin:0 auto;">
            <h2 style="text-align:center; font-size:24px; font-weight:800; margin-bottom:8px;">Layanan Pengendalian Hama</h2>
            <p style="text-align:center; color:#64748b; margin-bottom:36px;">Cakupan pemantauan dan penanganan hama di lingkungan pabrik</p>

            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap:20px;">
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div style="font-size:26px;">🪰</div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Pengendalian Lalat</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Pemasangan perangkap lalat dan Insect Light Trap di area rawan seperti penerimaan bahan baku dan ruang proses.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div style="font-size:26px;">🐀</div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Pengendalian Tikus</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Penempatan Rodent Bait Station di titik strategis dalam dan luar bangunan untuk mencegah infestasi hewan pengerat.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div style="font-size:26px;">🔍</div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Inspeksi Berkala</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Pemeriksaan rutin harian terhadap seluruh titik monitoring untuk mendeteksi aktivitas hama sedini mungkin.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div style="font-size:26px;">📋</div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Pencatatan & Pelaporan</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Dokumentasi tindakan, tingkat aktivitas, dan hasil pemeriksaan secara digital dan tertelusur.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div style="font-size:26px;">🛠️</div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Rekomendasi Perbaikan</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Tindak lanjut berupa rekomendasi dan perbaikan area, dilengkapi catatan dan dokumentasi foto.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div style="font-size:26px;">📊</div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Laporan Berkala</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Ringkasan dan tren aktivitas hama yang dapat diunduh sebagai laporan resmi Quality Control.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="keunggulan" style="max-width:1000px; margin:0 auto; padding: 60px 24px;">
        <h2 style="text-align:center; font-size:24px; font-weight:800; margin-bottom:8px;">Keunggulan Sistem</h2>
        <p style="text-align:center; color:#64748b; margin-bottom:36px;">Mengapa monitoring pest control kami berjalan lebih tertib dan terukur</p>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap:24px;">
            <div style="text-align:center; padding: 24px;">
                <div style="width:56px; height:56px; border-radius:16px; background:#e0f2fe; display:flex; align-items:center; justify-content:center; font-size:26px; margin:0 auto 16px;">⚡</div>
                <h3 style="font-size:16px; font-weight:700; margin-bottom:8px;">Real-Time & Digital</h3>
                <p style="font-size:14px; color:#64748b;">Setiap pencatatan langsung tersimpan dan dapat diakses kapan saja tanpa perlu menunggu rekap manual.</p>
            </div>
            <div style="text-align:center; padding: 24px;">
                <div style="width:56px; height:56px; border-radius:16px; background:#dcfce7; display:flex; align-items:center; justify-content:center; font-size:26px; margin:0 auto 16px;">📌</div>
                <h3 style="font-size:16px; font-weight:700; margin-bottom:8px;">Tertelusur & Terdokumentasi</h3>
                <p style="font-size:14px; color:#64748b;">Setiap temuan dilengkapi catatan dan foto, sehingga riwayat penanganan mudah ditelusuri saat audit.</p>
            </div>
            <div style="text-align:center; padding: 24px;">
                <div style="width:56px; height:56px; border-radius:16px; background:#fef3c7; display:flex; align-items:center; justify-content:center; font-size:26px; margin:0 auto 16px;">📈</div>
                <h3 style="font-size:16px; font-weight:700; margin-bottom:8px;">Data & Analitik Terpusat</h3>
                <p style="font-size:14px; color:#64748b;">Tren aktivitas hama tersaji dalam dashboard, mendukung pengambilan keputusan yang lebih cepat dan tepat.</p>
            </div>
        </div>
    </section>

    <footer style="background:#0f172a; color:#94a3b8; text-align:center; padding: 24px; font-size:13px;">
        © {{ date('Y') }} Starfood International — Quality Control Department
    </footer>

</body>
</html>