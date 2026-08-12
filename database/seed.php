<?php
/**
 * Development seed data.
 *
 * Idempotent: re-running updates rather than duplicating. Never run against
 * production — the admin credentials here are well known.
 */

use Mktr\Core\Database;

if (!defined('BASE_DIR')) {
    exit("seed.php must be run through database/migrate.php --seed\n");
}

$db  = Database::instance();
$now = date('Y-m-d H:i:s');

/* ---- users ------------------------------------------------------------- */

$users = [
    ['admin',  'Administrator', 'admin@mktr.co.id',  1, 'admin123'],
    ['editor', 'Editor Konten', 'editor@mktr.co.id', 2, 'editor123'],
];

foreach ($users as $row) {
    list($username, $name, $email, $roleId, $password) = $row;

    $existing = $db->selectOne('SELECT id FROM users WHERE username = ? LIMIT 1', [$username]);

    if ($existing === null) {
        $db->insert(
            'INSERT INTO users (role_id, name, username, email, password, status, created_at)
             VALUES (?, ?, ?, ?, ?, 1, ?)',
            [$roleId, $name, $username, $email, password_hash($password, PASSWORD_DEFAULT), $now]
        );
    }
}

$adminId = (int) $db->scalar('SELECT id FROM users WHERE username = ? LIMIT 1', ['admin']);

/*
 * Everything past this point is demo content, and it must never be layered on
 * top of imported production data — the two would sit side by side and the
 * site would show duplicate reports. Once anything carries a legacy_ref the
 * database is considered real, and only the accounts above are seeded.
 */
$imported = (int) $db->scalar(
    "SELECT (SELECT COUNT(*) FROM posts WHERE legacy_ref LIKE 'tabel_%')
          + (SELECT COUNT(*) FROM documents WHERE legacy_ref LIKE 'tabel_%')
          + (SELECT COUNT(*) FROM pages WHERE legacy_ref LIKE 'tabel_%')"
);

if ($imported > 0) {
    echo "          imported data present ({$imported} rows) — demo content skipped\n";
    return;
}

/* ---- media ------------------------------------------------------------- */
/*
 * Point at images already in the repository so the seeded posts render with
 * real photographs rather than placeholders.
 */

$images = [
    ['/images/post/4853172.jpg',             'Kegiatan operasional pabrik kelapa sawit'],
    ['/images/post/742pekerja-mktr_169.jpeg', 'Pekerja MKTR di area perkebunan'],
    ['/images/post/2977a.jpg',                'Area perkebunan kelapa sawit MKTR'],
    ['/images/post/6042.png',                 'Dokumentasi kegiatan perusahaan'],
];

$mediaIds = [];

foreach ($images as $image) {
    list($path, $alt) = $image;

    $existing = $db->selectOne('SELECT id FROM media WHERE path = ? LIMIT 1', [$path]);

    if ($existing !== null) {
        $mediaIds[] = (int) $existing['id'];
        continue;
    }

    $absolute = BASE_DIR . $path;
    $size     = is_file($absolute) ? (int) filesize($absolute) : 0;
    $width    = null;
    $height   = null;

    if (is_file($absolute)) {
        $info = @getimagesize($absolute);
        if ($info !== false) {
            $width  = (int) $info[0];
            $height = (int) $info[1];
        }
    }

    $mediaIds[] = $db->insert(
        'INSERT INTO media (path, filename, mime, size, width, height, alt, folder, uploaded_by, created_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [$path, basename($path), 'image/jpeg', $size, $width, $height, $alt, 'seed', $adminId, $now]
    );
}

/* ---- posts ------------------------------------------------------------- */

$posts = [
    [
        'slug'      => 'mktr-konsisten-jalankan-praktik-tata-kelola-berkelanjutan',
        'status'    => 'published',
        'published' => '-3 days',
        'id' => [
            'title'   => 'MKTR Konsisten Jalankan Praktik Tata Kelola Berkelanjutan',
            'excerpt' => 'Perseroan menegaskan komitmennya pada praktik agronomi terbaik dan tata kelola yang transparan bagi seluruh pemangku kepentingan.',
            'body'    => '<p>PT Menthobi Karyatama Raya Tbk (MKTR) kembali menegaskan komitmennya untuk menjalankan praktik tata kelola perusahaan yang baik di seluruh lini operasional. Komitmen ini diwujudkan melalui penerapan standar agronomi terbaik, pengelolaan lingkungan yang bertanggung jawab, serta keterbukaan informasi kepada publik dan pemegang saham.</p><h2>Fokus pada Keberlanjutan</h2><p>Sepanjang tahun berjalan, Perseroan memperkuat program keberlanjutan yang mencakup konservasi kawasan bernilai konservasi tinggi, pengelolaan limbah pabrik, serta pemberdayaan masyarakat di sekitar wilayah operasional.</p><p>Manajemen menyatakan bahwa penerapan tata kelola yang konsisten merupakan fondasi bagi penciptaan nilai tambah jangka panjang.</p>',
        ],
        'en' => [
            'title'   => 'MKTR Maintains Consistent Sustainable Governance Practices',
            'excerpt' => 'The Company reaffirms its commitment to agronomic best practice and transparent governance for all stakeholders.',
            'body'    => '<p>PT Menthobi Karyatama Raya Tbk (MKTR) has reaffirmed its commitment to sound corporate governance across every part of its operations, through agronomic best practice, responsible environmental management, and open disclosure to the public and shareholders.</p><h2>A Focus on Sustainability</h2><p>Through the year the Company strengthened sustainability programmes covering the conservation of high conservation value areas, mill waste management, and community empowerment around its operating areas.</p>',
        ],
    ],
    [
        'slug'      => 'pemberdayaan-karyawan-dan-masyarakat-sekitar-kebun',
        'status'    => 'published',
        'published' => '-12 days',
        'id' => [
            'title'   => 'Pemberdayaan Karyawan dan Masyarakat Sekitar Kebun',
            'excerpt' => 'Program pelatihan dan bantuan sosial menjangkau ratusan penerima manfaat di wilayah operasional Perseroan.',
            'body'    => '<p>Perseroan menjalankan rangkaian program pemberdayaan yang ditujukan bagi karyawan maupun masyarakat di sekitar wilayah operasional. Program ini mencakup pelatihan keterampilan, peningkatan kapasitas kelompok tani plasma, serta penyaluran bantuan sosial.</p><p>Kegiatan ini merupakan bagian dari komitmen tanggung jawab sosial Perseroan yang dijalankan secara berkelanjutan setiap tahun.</p>',
        ],
        'en' => [
            'title'   => 'Empowering Employees and Surrounding Communities',
            'excerpt' => 'Training programmes and social assistance reached hundreds of beneficiaries across the Company\'s operating areas.',
            'body'    => '<p>The Company runs a series of empowerment programmes for both employees and the communities around its operating areas, covering skills training, capacity building for plasma farmer groups, and the distribution of social assistance.</p>',
        ],
    ],
    [
        'slug'      => 'laporan-keberlanjutan-terbaru-telah-terbit',
        'status'    => 'published',
        'published' => '-25 days',
        'id' => [
            'title'   => 'Laporan Keberlanjutan Terbaru Telah Terbit',
            'excerpt' => 'Laporan memuat capaian kinerja lingkungan, sosial, dan tata kelola Perseroan sepanjang periode pelaporan.',
            'body'    => '<p>Perseroan menerbitkan Laporan Keberlanjutan terbaru yang memuat capaian kinerja lingkungan, sosial, dan tata kelola. Laporan ini disusun mengacu pada standar pelaporan yang berlaku dan dapat diunduh melalui halaman Hubungan Investor.</p>',
        ],
        'en' => [
            'title'   => 'Latest Sustainability Report Now Available',
            'excerpt' => 'The report covers the Company\'s environmental, social and governance performance for the reporting period.',
            'body'    => '<p>The Company has published its latest Sustainability Report, covering environmental, social and governance performance. The report follows the applicable reporting standards and can be downloaded from the Investor Relations section.</p>',
        ],
    ],
    [
        'slug'      => 'agenda-rups-tahunan-akan-segera-diumumkan',
        'status'    => 'draft',
        'published' => null,
        'id' => [
            'title'   => 'Agenda RUPS Tahunan Akan Segera Diumumkan',
            'excerpt' => 'Draf pengumuman agenda Rapat Umum Pemegang Saham Tahunan.',
            'body'    => '<p>Naskah ini masih berstatus draf dan belum dipublikasikan.</p>',
        ],
        'en' => [
            'title'   => 'Annual GMS Agenda To Be Announced',
            'excerpt' => 'Draft announcement of the Annual General Meeting of Shareholders agenda.',
            'body'    => '<p>This item is still a draft and has not been published.</p>',
        ],
    ],
    [
        'slug'      => 'jadwal-paparan-publik-tahun-ini',
        'status'    => 'scheduled',
        'published' => '+7 days',
        'id' => [
            'title'   => 'Jadwal Paparan Publik Tahun Ini',
            'excerpt' => 'Pengumuman terjadwal mengenai pelaksanaan paparan publik Perseroan.',
            'body'    => '<p>Perseroan akan menyelenggarakan paparan publik sesuai jadwal yang telah ditetapkan. Materi paparan akan tersedia pada halaman Hubungan Investor.</p>',
        ],
        'en' => [
            'title'   => 'Public Expose Schedule for This Year',
            'excerpt' => 'A scheduled announcement regarding the Company\'s public expose.',
            'body'    => '<p>The Company will hold its public expose on the announced schedule. Materials will be available in the Investor Relations section.</p>',
        ],
    ],
];

foreach ($posts as $index => $post) {
    $publishedAt = $post['published'] === null ? null : date('Y-m-d H:i:s', (int) strtotime($post['published']));
    $coverId     = isset($mediaIds[$index]) ? $mediaIds[$index] : (isset($mediaIds[0]) ? $mediaIds[0] : null);

    $existing = $db->selectOne('SELECT id FROM posts WHERE slug = ? LIMIT 1', [$post['slug']]);

    if ($existing === null) {
        $postId = $db->insert(
            'INSERT INTO posts (category_id, cover_media_id, slug, status, published_at, author_id, created_at, updated_at)
             VALUES (1, ?, ?, ?, ?, ?, ?, ?)',
            [$coverId, $post['slug'], $post['status'], $publishedAt, $adminId, $now, $now]
        );
    } else {
        $postId = (int) $existing['id'];
        $db->affected(
            'UPDATE posts SET cover_media_id = ?, status = ?, published_at = ?, updated_at = ? WHERE id = ?',
            [$coverId, $post['status'], $publishedAt, $now, $postId]
        );
    }

    foreach (['id', 'en'] as $localeCode) {
        $t = $post[$localeCode];

        $db->run(
            'INSERT INTO post_translations (post_id, locale, title, excerpt, body, meta_title, meta_description)
             VALUES (?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                title = VALUES(title), excerpt = VALUES(excerpt), body = VALUES(body),
                meta_title = VALUES(meta_title), meta_description = VALUES(meta_description)',
            [$postId, $localeCode, $t['title'], $t['excerpt'], $t['body'], $t['title'], $t['excerpt']]
        );
    }
}

/* ---- investor documents ------------------------------------------------ */
/*
 * Points at PDFs and cover images that already exist in the repository, so the
 * seeded pages render real reports rather than placeholders. Media rows are
 * registered as external: deleting them must never unlink the source files.
 */

$documentSeeds = [
    // [category slug, ID title, EN title, pdf, cover, date, status]
    ['laporan-tahunan', 'Laporan Tahunan 2024', 'Annual Report 2024',
     '/dokumen/134Report-PT-Menthobi-Karyatama-Raya-YE-2024.pdf', '/images/post/603AR-2024.png', '2025-04-28', 'published'],
    ['laporan-tahunan', 'Laporan Tahunan 2023', 'Annual Report 2023',
     '/dokumen/10520230907-Risalah-RUPS.pdf', '/images/post/648AR-2023.png', '2024-04-25', 'published'],
    ['laporan-keberlanjutan', 'Laporan Keberlanjutan 2024', 'Sustainability Report 2024',
     '/dokumen/110SR-MKTR-2024-(280425)-RUPS.pdf', '/images/post/52SR-2024.png', '2025-04-28', 'published'],
    ['laporan-keberlanjutan', 'Laporan Keberlanjutan 2023', 'Sustainability Report 2023',
     '/dokumen/110SR-MKTR-2024-(280425)-RUPS.pdf', '/images/post/480SR-2023.png', '2024-04-26', 'published'],
    ['keterbukaan-informasi', 'Penyampaian Laporan Keuangan Interim', 'Submission of Interim Financial Statements',
     '/dokumen/15920241105-Penyampaian-Laporan-Keuangan.pdf', null, '2024-11-05', 'published'],
    ['keterbukaan-informasi', 'Pencatatan Saham', 'Share Listing',
     '/dokumen/11220241216-Pencatatan-Saham.pdf', null, '2024-12-16', 'published'],
    ['keterbukaan-informasi', 'Laporan Bulanan Pemegang Efek', 'Monthly Securities Holders Report',
     '/dokumen/15020230803-Laporan-Bulanan-Pemegang-Efek.pdf', null, '2023-08-03', 'published'],
    ['presentasi-perusahaan', 'Paparan Publik Tahunan', 'Annual Public Expose',
     '/dokumen/106CONTOH-PAPARAN-PUBLIK.pdf', '/images/post/746contoh-paparan-publik.png', '2025-06-10', 'published'],
    // Not visible on the front-end — proves the workflow filters, as with posts.
    ['laporan-keuangan', 'Laporan Keuangan Kuartal Berjalan (draf)', 'Current Quarter Financial Report (draft)',
     '/dokumen/15920241105-Penyampaian-Laporan-Keuangan.pdf', null, '2026-01-31', 'draft'],
];

$categoryIds = [];
foreach ($db->select('SELECT id, slug FROM document_categories') as $row) {
    $categoryIds[(string) $row['slug']] = (int) $row['id'];
}

$registerExternal = function (?string $path, string $kind) use ($db, $now, $adminId) {
    if ($path === null) {
        return null;
    }

    $existing = $db->selectOne('SELECT id FROM media WHERE path = ? LIMIT 1', [$path]);
    if ($existing !== null) {
        return (int) $existing['id'];
    }

    $absolute = BASE_DIR . $path;
    $size     = is_file($absolute) ? (int) filesize($absolute) : 0;
    $width    = null;
    $height   = null;

    if ($kind === 'image' && is_file($absolute)) {
        $info = @getimagesize($absolute);
        if ($info !== false) {
            $width  = (int) $info[0];
            $height = (int) $info[1];
        }
    }

    return $db->insert(
        'INSERT INTO media (path, filename, mime, kind, size, width, height, alt, folder, is_external, uploaded_by, created_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?)',
        [
            $path,
            basename($path),
            $kind === 'image' ? 'image/jpeg' : 'application/pdf',
            $kind,
            $size,
            $width,
            $height,
            null,
            'seed',
            $adminId,
            $now,
        ]
    );
};

foreach ($documentSeeds as $index => $seed) {
    list($slug, $titleId, $titleEn, $pdf, $cover, $date, $docStatus) = $seed;

    if (!isset($categoryIds[$slug])) {
        continue;
    }

    $ref      = 'seed:' . $slug . ':' . $index;
    $fileId   = $registerExternal($pdf, 'document');
    $coverId  = $registerExternal($cover, 'image');
    $existing = $db->selectOne('SELECT id FROM documents WHERE legacy_ref = ? LIMIT 1', [$ref]);

    $publishedAt = $docStatus === 'published' ? $date . ' 09:00:00' : null;

    if ($existing === null) {
        $documentId = $db->insert(
            'INSERT INTO documents
                (category_id, file_media_id, cover_media_id, document_date, year, sort, status, published_at, legacy_ref, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?)',
            [$categoryIds[$slug], $fileId, $coverId, $date, (int) date('Y', (int) strtotime($date)), $docStatus, $publishedAt, $ref, $now, $now]
        );
    } else {
        $documentId = (int) $existing['id'];
        $db->affected(
            'UPDATE documents SET category_id = ?, file_media_id = ?, cover_media_id = ?, document_date = ?,
                    year = ?, status = ?, published_at = ?, updated_at = ? WHERE id = ?',
            [$categoryIds[$slug], $fileId, $coverId, $date, (int) date('Y', (int) strtotime($date)), $docStatus, $publishedAt, $now, $documentId]
        );
    }

    foreach (['id' => $titleId, 'en' => $titleEn] as $localeCode => $title) {
        $db->run(
            'INSERT INTO document_translations (document_id, locale, title, description)
             VALUES (?, ?, ?, NULL)
             ON DUPLICATE KEY UPDATE title = VALUES(title)',
            [$documentId, $localeCode, $title]
        );
    }
}
