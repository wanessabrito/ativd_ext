<?php
header('Content-Type: application/json'); // Garante que o retorno seja JSON

$apiKey = "ac88b4232557cda1abd49a4a53bcf75dd465bede";
$url = "https://api.waqi.info/feed/here/?token=ac88b4232557cda1abd49a4a53bcf75dd465bede";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo json_encode(['error' => 'Erro na requisição: ' . curl_error($ch)]);
    curl_close($ch);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);

if ($data && $data['status'] === 'ok') {
    $response = [
        'aqi' => $data['data']['aqi'], // Índice de Qualidade do Ar
        'pm25' => $data['data']['iaqi']['pm25']['v'] ?? null, // Concentração de PM2.5
        'co' => $data['data']['iaqi']['co']['v'] ?? null,     // Concentração de CO
    ];
    echo json_encode($response); // Retorna JSON
} else {
    echo json_encode(['error' => 'Erro ao obter os dados da API']);
}
?>
