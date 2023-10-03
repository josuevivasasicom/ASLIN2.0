<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://asicomsystems.ipzmarketing.com/api/v1/send_emails",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{
        \"from\":{
            \"email\":\"grupodiemsa@grupodiemsa.com\",
            \"name\":\"string\"
        },
        \"to\":[
            {
                \"email\":\"erick.leo.malagon@gmail.com\",
                \"name\":\"string\"
            }],
            \"subject\":\"My subject\",
            \"html_part\":\"<html>\\n<head></head>\\n<body><p>My html content.</p></body>\\n</html>\\n\",
            \"text_part\":\"Esto es una prueba de email .\",
            \"text_part_auto\":true,
            \"headers\":
            {
                \"X-CustomHeader\":\"Header value\"
            },
            \"smtp_tags\":
            [
                \"string\"
            ],
            \"attachments\":[
                
            ]
        }",
    CURLOPT_HTTPHEADER => array(
        "content-type: application/json",
        "x-auth-token: 7d_p3uUq_N1QmAKeNaFk4AeL3XXdqnNfxtQ9_7aU"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
