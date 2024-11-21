<?php

/**
 * Create a alert for any validation 
 * @param $msg 
 * @param $type  
 */
function createAlert($msg, $type = "danger")
{
    return "<p class=\"alert alert-{$type} d-flex justify-content-between\">{$msg}<button class=\"btn-close\" data-bs-dismiss=\"alert\"></button></p>";
}

/**
 * Get old form values after submit a form 
 */
function old($field_name)
{
    return $_POST[$field_name] ?? '';
}


/**
 * Reset  form old data after a successful submit
 */
function reset_form()
{
    return $_POST = [];
}


/**
 * File Uploading Function 
 */

function move(array $files, string $path = "media/")
{
    // file manage 
    $tmp_name = $files['tmp_name'];
    $file_name = $files['name'];

    // get file extension  
    $file_arr = explode('.', $file_name);
    $file_ext =  strtolower(end($file_arr));

    // file name unique 
    $unique_filename =  time() . '_' . rand(100000, 10000000) . '_' . str_shuffle('1234567890') . '.' . $file_ext;

    // uplaod fie 
    move_uploaded_file($tmp_name, $path . $unique_filename);

    // return file name 
    return $unique_filename;
}




function createID($prefix = 'USER')
{
    // Use the current timestamp
    $timestamp = time();

    // Generate a random string
    $randomString = bin2hex(random_bytes(5));

    // Combine prefix, timestamp, and random string to form a unique ID
    $uniqueID = $prefix . '_' . $timestamp . '_' . $randomString;

    return $uniqueID;
}


/**
 * time ago function
 */
function timeAgo($timestamp)
{
    $timeDifference = time() - $timestamp;

    // Define time periods in seconds
    $periods = [
        31536000 => 'year',
        2592000  => 'month',
        604800   => 'week',
        86400    => 'day',
        3600     => 'hour',
        60       => 'min',
        1        => 'sec'
    ];

    foreach ($periods as $seconds => $unit) {
        if ($timeDifference >= $seconds) {
            $count = floor($timeDifference / $seconds);
            return "$count $unit" . ($count > 1 ? '' : '') . " ago";
        }
    }
    return "just now";
}
