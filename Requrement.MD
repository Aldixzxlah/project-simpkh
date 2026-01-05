### Requirement Desain Frontend untuk SIMPKH

Berikut adalah **requirement dan spesifikasi desain frontend** untuk Sistem Informasi Manajemen Pengelolaan Kehutanan (SIMPKH). Desain ini fokus pada pengalaman pengguna yang modern, intuitif, dan berorientasi pada peta interaktif sebagai elemen utama. Data statistik hutan diambil dari data terbaru Kementerian Lingkungan Hidup dan Kehutanan (KLHK) dan FAO (2025): luas lahan berhutan **95,97 juta hektare** (sekitar 51% daratan Indonesia), dengan distribusi utama di Papua (~32 juta ha), Kalimantan (~31,1 juta ha), Sumatera (~16 juta ha), dan Sulawesi (~10,8 juta ha). Target kawasan hutan nasional mencapai sekitar 118,2 juta hektare.

#### Prinsip Desain Umum
- **Tema Warna**: Dominan hijau (#166534 untuk hutan primer, #22c55e untuk aksi positif, #dcfce7 untuk background). Aksen biru/abu untuk netral.
- **Framework CSS**: Tailwind CSS (untuk responsif cepat dan modern).
- **Library Peta**: Leaflet.js (ringan, gratis, mudah integrasi drawing tool).
- **Interaktivitas**: Alpine.js atau Vue.js minimal untuk toggle sidebar, modal, tab.
- **Responsif**: Mobile-first (sidebar collapsible di mobile).
- **Bahasa**: Indonesia sebagai default.
- **Aksesibilitas**: Kontras tinggi, alt text pada gambar, keyboard navigation.
- **Font**: Google Fonts – Inter atau Poppins untuk modern, sans-serif.

#### Halaman Utama
1. **Login Page**
   - Background full-screen foto hutan Indonesia (unsplash atau stock resmi KLHK).
   - Form login sederhana: Email, Password, Checkbox "Ingat saya", link "Lupa password".
   - Tombol login hijau besar.
   - Footer: Logo SIMPKH + tagline "Manajemen Kehutanan Berkelanjutan".
   - Setelah login → redirect ke Dashboard.

2. **Dashboard Utama (Post-Login – Sama untuk User & Admin)**
   - Layout: 
     - Sidebar kiri (collapsible, lebar 300-400px saat expand).
     - Panel statistik (fixed di kiri atas peta, scrollable).
     - Peta interaktif (80-90% layar kanan).
   - **Sidebar Menu**:
     - Logo SIMPKH + nama user/role.
     - Menu: Dashboard (active), Ajukan Laporan Baru, Riwayat Laporan, Kelola Data Hutan (hanya visible untuk Admin), Kelola User/Transaksi (Admin only), Logout.
     - Toggle collapse untuk mobile.
   - **Panel Statistik** (card putih dengan shadow):
     - Header: "Statistik Hutan Indonesia (Data 2025)"
     - Card besar: Luas Berhutan 95,97 Juta Ha | ~51% Daratan.
     - Tabel sederhana: Distribusi per pulau/provinsi (Papua, Kalimantan, dll).
     - Chart kecil (pie/bar): Jenis vegetasi (primer, sekunder, tanaman).
     - Tombol "Update Data" (hanya Admin).
   - **Peta Interaktif**:
     - Base layer: OpenStreetMap atau Esri Satellite.
     - Layer utama: GeoJSON tutupan lahan hutan (sumber: KLHK/LapakGIS, warna hijau gradasi).
     - Fitur: Zoom, search location, layer control (toggle hutan primer/sekunder/konservasi/deforestasi).
     - Popup saat klik polygon: Nama provinsi, luas, jenis vegetasi, status.
     - Drawing tool (Leaflet.Draw): User bisa gambar polygon untuk select area pengajuan laporan.
     - Legend di pojok kanan bawah.

3. **Halaman Ajukan Laporan Baru (User)**
   - Integrasi dengan peta dashboard (bisa modal besar atau halaman terpisah).
   - Form multi-step:
     - Step 1: Pilih area di peta (drawing polygon → auto hitung luas).
     - Step 2: Detail perusahaan (nama, alamat, NPWP, kontak).
     - Step 3: Keperluan (dropdown: Industri Kayu, Pertambangan, Pariwisata, dll).
     - Step 4: Alasan penggunaan + estimasi dampak vegetasi (textarea panjang).
     - Step 5: Upload dokumen (multiple file: PDF, gambar site plan).
   - Validasi: Field wajib, luas area tidak melebihi batas, alasan harus logis (bisa tambah warning jika kata kunci merusak).
   - Tombol Preview → Submit (kirim draft).

4. **Halaman Riwayat Laporan & Transaksi (User/Admin)**
   - Tabel responsif: No, Tanggal, Lokasi, Status (pending/approved/rejected/paid), Aksi (lihat detail, bayar).
   - Filter & search.
   - Badge warna untuk status.

5. **Halaman Kelola Data Hutan (Admin Only)**
   - Tabel CRUD: Kolom Provinsi, Luas (ha), Jenis Vegetasi, Status Konservasi, GeoJSON (upload/edit).
   - Tombol: Tambah Baru (modal form), Edit, Hapus, Upload GeoJSON massal.
   - Preview peta per baris data.

#### Elemen Tambahan
- Notifikasi toast (sukses/error).
- Loading spinner saat load peta/data.
- Dark mode toggle (opsional).
- Footer tetap: Copyright + link sumber data KLHK.

Desain ini siap diimplementasikan dengan HTML + Tailwind + Leaflet. Selanjutnya bisa dijadikan template Blade di Laravel. Kalau sudah approve requirement ini, kita bisa lanjut buat prototype HTML statis atau langsung ke code frontend! 🌱