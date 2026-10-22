<?php

namespace App\Support;

class Teks
{
    /** Hapus tag HTML dari kolom teks yang disebutkan (pertahanan lapis kedua terhadap XSS). */
    public static function bersih(array $data, array $kolom): array
    {
        foreach ($kolom as $k) {
            if (isset($data[$k]) && is_string($data[$k])) {
                $data[$k] = trim(strip_tags($data[$k]));
            }
        }

        return $data;
    }

    /**
     * Sanitasi nilai untuk ekspor spreadsheet / CSV demi mencegah Formula Injection (CSV Injection).
     * Jika diawali tanda '=', '+', '-', '@', tab, atau return, tambahkan tanda kutip satu (').
     */
    public static function amankanFormulaCsv(mixed $nilai): string
    {
        $str = (string) $nilai;
        if ($str !== '' && in_array($str[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'".$str;
        }

        return $str;
    }

    /**
     * Samarkan nama siswa untuk mencegah kebocoran PII pada endpoint publik.
     * Contoh: "Budi Santoso" -> "B*** S******"
     */
    public static function maskNama(?string $nama): string
    {
        if (! $nama) {
            return '';
        }

        $words = preg_split('/\s+/', trim($nama));
        $masked = [];

        foreach ($words as $word) {
            $len = mb_strlen($word);
            if ($len <= 1) {
                $masked[] = $word;
            } elseif ($len === 2) {
                $masked[] = mb_substr($word, 0, 1).'*';
            } else {
                $masked[] = mb_substr($word, 0, 1).str_repeat('*', $len - 1);
            }
        }

        return implode(' ', $masked);
    }

    /**
     * Escape karakter wildcard SQL LIKE (\, %, _) untuk mencegah scanning wildcard tak terkontrol.
     */
    public static function escapeLike(string $value): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $value);
    }
}
