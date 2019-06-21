<?php

function sendFCM($title, $mess, $id) {
$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array (
        'to' => $id,
        'notification' => array (
                "body" => $mess,
                "title" => $title,
                "color" => "#fff"
        )
);
$fields = json_encode ( $fields );
$headers = array (
        'Authorization: key=' . "AIzaSyA0wdAAt0-uTs_JHS29Yt-gp_R4BflxzZc",
        'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
curl_close ( $ch );

}



?>
