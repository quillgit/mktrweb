<?php
/**
 * File uploads for the media library.
 *
 * The legacy CMS trusted $_FILES['gambar']['type'] (client-supplied) and kept
 * the original filename. Here the MIME type is sniffed from the file contents,
 * the extension is derived from that sniffed type rather than from the name,
 * and the stored name is randomised.
 */

namespace Mktr\Core;

class Uploader
{
    /** @var array<string,string> sniffed mime => extension */
    private static $imageTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
    ];

    /** @var array<string,string> */
    private static $documentTypes = [
        'application/pdf' => 'pdf',
    ];

    /** @var string */
    private $storagePath;

    /** @var string */
    private $publicPrefix;

    public function __construct(string $storagePath, string $publicPrefix)
    {
        $this->storagePath  = rtrim($storagePath, '/');
        $this->publicPrefix = rtrim($publicPrefix, '/');
    }

    /**
     * @param  array  $file  entry from $_FILES
     * @param  string $kind  'image' or 'document'
     * @return array{path:string,filename:string,mime:string,size:int,width:?int,height:?int}
     * @throws \RuntimeException
     */
    public function store(array $file, string $kind = 'image'): array
    {
        if (!isset($file['tmp_name'], $file['error'])) {
            throw new \RuntimeException('Berkas tidak valid.');
        }

        if ((int) $file['error'] !== UPLOAD_ERR_OK) {
            throw new \RuntimeException($this->errorMessage((int) $file['error']));
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new \RuntimeException('Berkas tidak valid.');
        }

        $maxBytes = (int) Config::get('app.max_upload_bytes', 10 * 1024 * 1024);
        $size     = (int) $file['size'];

        if ($size > $maxBytes) {
            throw new \RuntimeException(sprintf('Ukuran berkas melebihi %d MB.', (int) ($maxBytes / 1048576)));
        }

        $allowed = $kind === 'document' ? self::$documentTypes : self::$imageTypes;

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime  = (string) $finfo->file($file['tmp_name']);

        if (!isset($allowed[$mime])) {
            throw new \RuntimeException('Tipe berkas tidak diizinkan: ' . $mime);
        }

        $extension = $allowed[$mime];

        // Re-verify images actually decode, so a PDF renamed .jpg is rejected.
        $width  = null;
        $height = null;

        if ($kind === 'image') {
            $info = @getimagesize($file['tmp_name']);
            if ($info === false) {
                throw new \RuntimeException('Berkas gambar tidak dapat dibaca.');
            }
            $width  = (int) $info[0];
            $height = (int) $info[1];
        }

        $folder = date('Y/m');
        $target = $this->storagePath . '/' . $folder;

        if (!is_dir($target) && !mkdir($target, 0755, true) && !is_dir($target)) {
            throw new \RuntimeException('Gagal membuat folder penyimpanan.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extension;

        if (!move_uploaded_file($file['tmp_name'], $target . '/' . $filename)) {
            throw new \RuntimeException('Gagal menyimpan berkas.');
        }

        chmod($target . '/' . $filename, 0644);

        return [
            'path'     => $this->publicPrefix . '/' . $folder . '/' . $filename,
            'filename' => isset($file['name']) ? $this->cleanName((string) $file['name']) : $filename,
            'mime'     => $mime,
            'size'     => $size,
            'width'    => $width,
            'height'   => $height,
        ];
    }

    private function cleanName(string $name): string
    {
        $name = basename($name);
        $name = preg_replace('/[^\w.\- ]+/u', '', $name);

        return mb_substr((string) $name, 0, 190);
    }

    private function errorMessage(int $code): string
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'Ukuran berkas melebihi batas server.';
            case UPLOAD_ERR_PARTIAL:
                return 'Berkas hanya terunggah sebagian.';
            case UPLOAD_ERR_NO_FILE:
                return 'Tidak ada berkas yang diunggah.';
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
                return 'Server gagal menulis berkas.';
            default:
                return 'Gagal mengunggah berkas.';
        }
    }
}
