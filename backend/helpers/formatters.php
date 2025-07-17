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
function getAge(){
    if (isset($_POST['birthday']) && !empty($_POST['birthday'])) {
        $birthDate = new DateTime($_POST['birthday']);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
        return $age;
    }
    return null;
}
function generateRandomIds(){
    $randomNumber = random_int(100000, 999999);
    return $randomNumber;
}
function formatAddress($data) {
    $addressParts = [
        $data['houseNumber'] ?? '',
        $data['street'] ?? '',
        $data['purok'] ?? '',
        $data['barangay'] ?? '',
        $data['city'] ?? ''
    ];
    return implode(', ', array_filter($addressParts));
}