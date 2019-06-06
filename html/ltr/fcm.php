<?php

function sendFCM($mess,$id) {
$url = 'https://fcm.googleapis.com/fcm/send';
$fields = array (
        'to' => $id,
        'notification' => array (
                "body" => $mess,
                "title" => "Title",
                "image" => "http://www.sclance.com/pngs/aurora-borealis-png/aurora_borealis_png_68559.png",
                "color" => "#0000ff"
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
echo $result;
}

$token = "e7ayjoWdEOo:APA91bHvvh_OYxFpZOdwaAZgXqUt-1he8-ZnR0qJIq-jqmwv-mV8Erv3ga6FBW17RKSgVPtUPyWgMoxdXHtgV88Q6TVlY0abx9Aew05XqvdRpqWhojrZKqZlA9zubu_SwTfGsL5uD4Ex";

sendFCM("Hiiii", $token);

?>
