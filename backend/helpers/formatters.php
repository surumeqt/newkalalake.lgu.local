<?php
function formatHearingDate($dateStr) {
    $date = new DateTime($dateStr);
    $day = $date->format('j');
    $suffix = getOrdinalSuffix($day);
    $month = $date->format('F');
    $year = $date->format('Y');

    return "{$day}{$suffix} day of {$month}, {$year}";
}

function getOrdinalSuffix($number) {
    if (!in_array(($number % 100), [11, 12, 13])) {
        switch ($number % 10) {
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
        }
    }
    return 'th';
}
function generateRandomIds() {
    $datePart = date('Ym');
    $randomDigit = rand(100, 999);
    return $datePart . $randomDigit;
}
function formatAddress($data) {
    $addressParts = [
        $data['houseNumber'] ?? '',
        $data['street'] ?? '',
        $data['purok'] ?? '',
        $data['barangay'] ?? '',
        $data['city'] ?? ''
    ];
    return implode(' ', array_filter($addressParts));
}