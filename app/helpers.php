<?php

use Carbon\Carbon;

if (!function_exists('formatTanggalIndonesia')) {
    function formatTanggalIndonesia($datetime, $withTime = true)
    {
        $carbon = Carbon::parse($datetime)->timezone('Asia/Jakarta');
        
        if ($withTime) {
            return $carbon->format('d M Y H:i') . ' WIB';
        }
        
        return $carbon->format('d M Y');
    }
}