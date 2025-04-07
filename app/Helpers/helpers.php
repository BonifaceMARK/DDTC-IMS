<?php

if (!function_exists('getStatusColor')) {
    function getStatusColor($status)
    {
        switch ($status) {
            case 'Brand New':
                return '#d4edda'; // Light green
            case 'Good Unit':
                return '#d1ecf1'; // Light blue
            case 'Demo Unit':
                return '#fff3cd'; // Light yellow
            case 'Service Unit':
                return '#f8d7da'; // Light red
            default:
                return '#f8f9fa'; // Default light grey
        }
    }
}
// Function to get the category icon
function getCategoryIcon($category)
{
    $icons = [
        "Audio Visual" => "🎵",
        "Computing Products" => "💻",
        "Document & Data Management" => "📄",
        "Retail Solution" => "🛒",
    ];

    // Return the icon if category exists, otherwise return an empty string
    return $icons[$category] ?? "";
}

// Function to get the unit status icon (if applicable in the future)
function getUnitStatusIcon($status)
{
    $icons = [
        "Brand New" => "✨",
        "Good Unit" => "👍",
        "Demo Unit" => "🔧",
        "Service Unit" => "🛠️",
    ];

    // Return the icon if status exists, otherwise return an empty string
    return $icons[$status] ?? "";
}
if (!function_exists('getSalesStatsStyles')) {
    function getSalesStatsStyles($status)
    {
        $styles = [
            'Delivered' => [
                'color' => '#d4edda', // Light green
                'icon' => '📦' // Box icon
            ],
            'Processed for Delivery' => [
                'color' => '#d1ecf1', // Light blue
                'icon' => '🚚' // Delivery truck icon
            ],
            'No Update Yet' => [
                'color' => '#f8d7da', // Light red
                'icon' => '❓' // Question mark icon
            ],
            'For Stocking Only' => [
                'color' => '#fff3cd', // Light yellow
                'icon' => '📥' // Inbox icon
            ],
            'default' => [
                'color' => '#f8f9fa', // Default light grey
                'icon' => '❓' // Question mark icon
            ],
        ];

        return $styles[$status] ?? $styles['default'];
    }
}

if (!function_exists('getPmgStatsStyles')) {
    function getPmgStatsStyles($status)
    {
        $styles = [
            'Ordered and Waiting for Arrival' => [
                'color' => '#d4edda', // Light green
                'icon' => '📦' // Box icon
            ],
            'Arrived and Endorsed to Sales' => [
                'color' => '#d1ecf1', // Light blue
                'icon' => '✔️' // Checkmark icon
            ],
            'Intransit to Provincial Office (DBIC)' => [
                'color' => '#fff3cd', // Light yellow
                'icon' => '🚚' // Delivery truck icon
            ],
            'Arrive and For Stocking' => [
                'color' => '#f8d7da', // Light red
                'icon' => '📥' // Inbox icon
            ],
            'default' => [
                'color' => '#f8f9fa', // Default light grey
                'icon' => '❓' // Question mark for unknown status
            ],
        ];

        return $styles[$status] ?? $styles['default'];
    }
}
