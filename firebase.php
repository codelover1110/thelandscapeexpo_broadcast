<?php
    $serverKey = 'AAAAq33pIeo:APA91bHEIz05h_ENYhuaGyfTpXHDQr4JXzRQLKYCZYa9ZcIJ2yi9kSnsVJWUH41v_9tAHyq74p5jgqyy8rqO7Iqi89-0OIPGYY1vRJ_OoC739_PHIyEyst54Z7Qg_xzpgIz-WFOi7p48';

    $topic = 'broad_messages';
    $data = ['field' => 'broad_messages'];

    // Prepare the FCM request payload
    $payload = [
        'data' => $data,
        'notification' => [
            'title' => 'New Message',
            'body' => $message,
            'android_channel_id' => 'tle_channel',
            'sound' => 'Tri-tone',
        ],
        'to' => '/topics/' . $topic,
    ];

    // Prepare the headers
    $headers = [
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json',
    ];

    // Initialize cURL session
    $ch = curl_init('https://fcm.googleapis.com/fcm/send');

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Adjust this if needed

    // Set the POST data
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    // Execute cURL request
    $result = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Check the response
    if ($result !== false) {
        echo 'Message sent successfully!';
    } else {
        echo 'Failed to send the message.';
    }
?>