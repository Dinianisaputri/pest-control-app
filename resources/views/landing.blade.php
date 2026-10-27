<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Starfood International - Sistem Monitoring Pest Control</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="landing-page" style="margin:0;">

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
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Rodent Bait Station</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Perangkat untuk penempatan umpan dan pengendalian tikus secara aman.</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-2.jpeg') }}" alt="Device 2" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Thermal Fogger</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Perangkat untuk menyemprotkan obat hama dalam bentuk kabut panas.</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-3.jpeg') }}" alt="Device 3" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Fly Trap</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Perangkat untuk menangkap lalat secara efektif.</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-4.jpeg') }}" alt="Device 4" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Rodent Live Trap</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Perangkat untuk menangkap tikus secara hidup.</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-5.jpeg') }}" alt="Device 5" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">ULV Fogger</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Perangkat untuk menyemprotkan obat hama dalam bentuk kabut ultra-lemah.</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-6.jpeg') }}" alt="Device 6" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Rodent Monitoring Station</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Perangkat untuk memantau keberadaan tikus di area tertentu.</p>
                </div>
            </div>

            <div style="background:white; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden;">
                <img src="{{ asset('images/device-7.jpeg') }}" alt="Device 7" style="width:100%; aspect-ratio:4/3; object-fit:cover; background:#e2e8f0;">
                <div style="padding:14px;">
                    <h3 style="font-size:14px; font-weight:700; margin:0;">Insect Light Trap (ILT)</h3>
                    <p style="font-size:12px; color:#64748b; margin:4px 0 0;">Perangkat untuk menangkap serangga menggunakan cahaya.</p>
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
                    <div class="landing-feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 8v9m0-9c-2-4-6-4-7-3 1 2 3 3 7 3Zm0 0c2-4 6-4 7-3-1 2-3 3-7 3Zm0 4-5-2m5 2 5-2M9 19l3-2 3 2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg></div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Pengendalian Lalat</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Pemasangan perangkap lalat dan Insect Light Trap di area rawan seperti penerimaan bahan baku dan ruang proses.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div class="landing-feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M7 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm10 0a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm-5-2c-4 0-7 3-7 7a5 5 0 0 0 5 5h4a5 5 0 0 0 5-5c0-4-3-7-7-7Zm-2 6h.01m5 0h.01m-4 3h2" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg></div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Pengendalian Tikus</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Penempatan Rodent Bait Station di titik strategis dalam dan luar bangunan untuk mencegah infestasi hewan pengerat.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div class="landing-feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="10.5" cy="10.5" r="6.5" stroke-width="1.7"/><path d="m15.5 15.5 5 5M8 10.5l1.7 1.7 3.3-3.5" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg></div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Inspeksi Berkala</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Pemeriksaan rutin harian terhadap seluruh titik monitoring untuk mendeteksi aktivitas hama sedini mungkin.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div class="landing-feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="5" y="4" width="14" height="17" rx="2" stroke-width="1.7"/><path d="M9 4.5h6V7H9zM8.5 11h7m-7 4h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg></div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Pencatatan & Pelaporan</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Dokumentasi tindakan, tingkat aktivitas, dan hasil pemeriksaan secara digital dan tertelusur.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div class="landing-feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m14 7 3 3m-9.5 9.5-4-4L14 5a4 4 0 0 0 5 5L9.5 19.5Z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/><path d="m14.5 14.5 5 5" stroke-linecap="round" stroke-width="1.7"/></svg></div>
                    <h3 style="font-size:16px; font-weight:700; margin:12px 0 6px;">Rekomendasi Perbaikan</h3>
                    <p style="font-size:14px; color:#64748b; margin:0;">Tindak lanjut berupa rekomendasi dan perbaikan area, dilengkapi catatan dan dokumentasi foto.</p>
                </div>
                <div style="border:1px solid #e2e8f0; border-radius:16px; padding:22px;">
                    <div class="landing-feature-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 19V5m0 14h16M7 15l4-4 3 2 5-6" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg></div>
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
                <div class="landing-feature-icon landing-feature-icon--large" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m13 2-9 12h7l-1 8 10-13h-7l1-7Z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg></div>
                <h3 style="font-size:16px; font-weight:700; margin-bottom:8px;">Real-Time & Digital</h3>
                <p style="font-size:14px; color:#64748b;">Setiap pencatatan langsung tersimpan dan dapat diakses kapan saja tanpa perlu menunggu rekap manual.</p>
            </div>
            <div style="text-align:center; padding: 24px;">
                <div class="landing-feature-icon landing-feature-icon--large" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M8 4h8l-1 6 3 3v2H6v-2l3-3-1-6Zm4 11v6" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg></div>
                <h3 style="font-size:16px; font-weight:700; margin-bottom:8px;">Tertelusur & Terdokumentasi</h3>
                <p style="font-size:14px; color:#64748b;">Setiap temuan dilengkapi catatan dan foto, sehingga riwayat penanganan mudah ditelusuri saat audit.</p>
            </div>
            <div style="text-align:center; padding: 24px;">
                <div class="landing-feature-icon landing-feature-icon--large" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 19V5m0 14h16M7 15l4-4 3 2 5-6" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7"/></svg></div>
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