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
function getAge(string $birthday): ?int
{
    if (!empty($birthday)) {
        try {
            $birthDate = new DateTime($birthday);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;
            return $age;
        } catch (Exception $e) {
            // Log the error or handle it as appropriate for an invalid date
            error_log("Error calculating age for birthday '{$birthday}': " . $e->getMessage());
            return null; // Return null if the date is invalid
        }
    }
    return null; // Return null if birthday is empty
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
    return implode(' ', array_filter($addressParts));
}