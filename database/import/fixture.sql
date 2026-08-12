-- Fixture standing in for the legacy database until the production dump
-- arrives.
--
-- The schema here is inferred from the queries in the legacy code
-- (module/hubungan_investor.php, adminpanel/modules/laporan_*.php), and the
-- tables deliberately disagree with each other in exactly the ways the real
-- ones do, so the importer's column introspection is genuinely exercised:
--
--   * laporan_tahunan            has `gambar`, no date column beyond `created`
--   * laporan_keterbukaan_informasi has `laporan_date`, no `gambar`
--   * laporan_presentasi_perusahaan has `sub_title` / `sub_title_english`
--   * laporan_rspo               has no `title_english` at all
--
-- It also includes rows that must be handled rather than crash the run:
-- a missing file on disk, a zero date, an untitled row, and status <> '2'.

DROP TABLE IF EXISTS tabel_laporan_tahunan;
CREATE TABLE tabel_laporan_tahunan (
    id_laporan_tahunan INT AUTO_INCREMENT PRIMARY KEY,
    title              VARCHAR(255),
    title_english      VARCHAR(255),
    gambar             VARCHAR(255),
    file_dokumen       VARCHAR(255),
    status             VARCHAR(2),
    created            DATETIME,
    author             VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tabel_laporan_tahunan (title, title_english, gambar, file_dokumen, status, created, author) VALUES
 ('Laporan Tahunan 2024', 'Annual Report 2024', '603AR-2024.png', '134Report-PT-Menthobi-Karyatama-Raya-YE-2024.pdf', '2', '2025-04-28 09:00:00', 'admin'),
 ('Laporan Tahunan 2023', 'Annual Report 2023', '648AR-2023.png', '10520230907-Risalah-RUPS.pdf', '2', '2024-04-25 09:00:00', 'admin'),
 ('Laporan Tahunan 2022', 'Annual Report 2022', '702cover-AR-2022.png', 'berkas-yang-hilang.pdf', '2', '2023-04-20 09:00:00', 'admin'),
 ('Draf Laporan Tahunan 2025', 'Draft Annual Report 2025', NULL, NULL, '1', '2026-01-10 09:00:00', 'admin');

DROP TABLE IF EXISTS tabel_laporan_keterbukaan_informasi;
CREATE TABLE tabel_laporan_keterbukaan_informasi (
    id_laporan_keterbukaan_informasi INT AUTO_INCREMENT PRIMARY KEY,
    title         VARCHAR(255),
    title_english VARCHAR(255),
    file_dokumen  VARCHAR(255),
    laporan_date  DATE,
    status        VARCHAR(2),
    created       DATETIME,
    author        VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tabel_laporan_keterbukaan_informasi (title, title_english, file_dokumen, laporan_date, status, created, author) VALUES
 ('Penyampaian Laporan Keuangan', 'Submission of Financial Statements', '15920241105-Penyampaian-Laporan-Keuangan.pdf', '2024-11-05', '2', '2024-11-05 10:00:00', 'admin'),
 ('Pencatatan Saham', 'Share Listing', '11220241216-Pencatatan-Saham.pdf', '2024-12-16', '2', '2024-12-16 10:00:00', 'admin'),
 ('Laporan Bulanan Pemegang Efek', 'Monthly Securities Holders Report', '15020230803-Laporan-Bulanan-Pemegang-Efek.pdf', '0000-00-00', '2', '2023-08-03 10:00:00', 'admin'),
 ('', 'Untitled row', 'kosong.pdf', '2024-01-01', '2', '2024-01-01 10:00:00', 'admin');

DROP TABLE IF EXISTS tabel_laporan_presentasi_perusahaan;
CREATE TABLE tabel_laporan_presentasi_perusahaan (
    id_laporan_presentasi_perusahaan INT AUTO_INCREMENT PRIMARY KEY,
    title             VARCHAR(255),
    title_english     VARCHAR(255),
    sub_title         VARCHAR(255),
    sub_title_english VARCHAR(255),
    gambar            VARCHAR(255),
    file_dokumen      VARCHAR(255),
    status            VARCHAR(2),
    created           DATETIME,
    author            VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tabel_laporan_presentasi_perusahaan (title, title_english, sub_title, sub_title_english, gambar, file_dokumen, status, created, author) VALUES
 ('Paparan Publik Tahunan', 'Annual Public Expose', 'Materi paparan publik', 'Public expose materials', '746contoh-paparan-publik.png', '106CONTOH-PAPARAN-PUBLIK.pdf', '2', '2025-06-10 09:00:00', 'admin');

-- No title_english column at all — the importer must fall back to the
-- Indonesian title rather than fail.
DROP TABLE IF EXISTS tabel_laporan_rspo;
CREATE TABLE tabel_laporan_rspo (
    id_laporan_rspo INT AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(255),
    file_dokumen VARCHAR(255),
    status       VARCHAR(2),
    created      DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tabel_laporan_rspo (title, file_dokumen, status, created) VALUES
 ('Laporan RSPO 2024', '110SR-MKTR-2024-(280425)-RUPS.pdf', '2', '2025-03-01 09:00:00');

DROP TABLE IF EXISTS tabel_berita;
CREATE TABLE tabel_berita (
    id_berita       INT AUTO_INCREMENT PRIMARY KEY,
    title           VARCHAR(255),
    title_english   VARCHAR(255),
    content         TEXT,
    content_english TEXT,
    gambar          VARCHAR(255),
    slug            VARCHAR(255),
    status          VARCHAR(2),
    created         DATETIME,
    author          VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tabel_berita (title, title_english, content, content_english, gambar, slug, status, created, author) VALUES
 ('MKTR Raih Penghargaan Tata Kelola', 'MKTR Wins Governance Award',
  '<p>Perseroan menerima penghargaan atas penerapan tata kelola.</p><script>alert(1)</script>',
  '<p>The Company received an award for its governance practices.</p>',
  '4853172.jpg', 'mktr-raih-penghargaan-tata-kelola', '2', '2025-09-01 08:00:00', 'admin'),
 ('Kegiatan CSR di Desa Binaan', 'CSR Activities in Partner Villages',
  '<p>Program CSR menjangkau warga sekitar kebun.</p>',
  '<p>The CSR programme reached communities around the plantation.</p>',
  '742pekerja-mktr_169.jpeg', 'kegiatan-csr-di-desa-binaan', '2', '2025-07-15 08:00:00', 'admin'),
 ('Berita Draf', 'Draft News', '<p>Belum tayang.</p>', '<p>Not published.</p>', NULL, 'berita-draf', '1', '2026-02-01 08:00:00', 'admin');
