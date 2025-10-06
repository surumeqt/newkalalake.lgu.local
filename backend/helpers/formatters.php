<?php
function formatHearingTime($timeStr) {
    $time = date("h:i", strtotime($timeStr));
    $period = date("A", strtotime($timeStr));

    if ($period === "AM") {
        $periodText = "in the morning";
    } else {
        $periodText = "in the afternoon";
        $hour = (int)date("H", strtotime($timeStr));
        if ($hour >= 18) {
            $periodText = "in the evening";
        }
    }

    return "{$time} o'clock {$periodText}";
}
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