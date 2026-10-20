<?php

namespace App\Support;

class Csv
{
    /**
     * Cegah penyisipan rumus (CSV/formula injection): sel teks yang diawali
     * = + - @ tab atau CR diberi awalan apostrof agar dibaca sebagai teks biasa.
     */
    public static function aman(mixed $nilai): string
    {
        $teks = (string) $nilai;

        if ($teks !== '' && in_array($teks[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $teks;
        }

        return $teks;
    }
}
