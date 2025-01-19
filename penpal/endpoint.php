<?php
function capturePaypalPayment($orderId, $clientId, $secret)
{
    $url = 'https://api.sandbox.paypal.com/v2/checkout/orders/' . $orderId . '/capture';

    // Get the PayPal access token
    $accessToken = getPaypalAccessToken($clientId, $secret);

    // Prepare the HTTP options for the capture endpoint
    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json',
            ],
            'content' => '', // POST request body can be empty for this endpoint
        ],
    ];

    $context = stream_context_create($options);

    // Send the request to capture the payment
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
    error_log('Failed to capture the payment. Please try again.');
        return [
            'error' => 'Failed to capture the payment. Please try again.',
        ];
    }
  error_log(json_decode($response, true));

    // Parse and return the response
    return json_decode($response, true);
}

function getPaypalAccessToken($clientId, $secret)
{
    $url = 'https://api.sandbox.paypal.com/v1/oauth2/token';
    $auth = base64_encode($clientId . ':' . $secret);

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => [
                'Authorization: Basic ' . $auth,
                'Content-Type: application/x-www-form-urlencoded',
            ],
            'content' => http_build_query(['grant_type' => 'client_credentials']),
        ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        die(json_encode(['error' => 'Failed to fetch the access token.']));
    }

    $data = json_decode($response, true);
    return $data['access_token'] ?? null;
}

// Usage Example
$clientId = 'Ae15xLTKadxt1n17OTKnYK9GKc6TTcqvBM5CHt1IXAAKKwlTtx_RJ82ndJssVjy8ioL6Hw3bxz2teIqU';
$secret = 'EMjg27FzMOTXDCQQpMlVTcPrUE9Tk8PvWC85dHIHLAfif3pV9q6tv0PJLzkWBC4dQ4EyNh9NOEw06Q5A';
$orderId = 'REPLACE_WITH_ORDER_ID';

$response = capturePaypalPayment($orderId, $clientId, $secret);
if (isset($response['error'])) {
    echo 'Error: ' . $response['error'];
} else {
    echo 'Capture Response: ';
    print_r($response);
}
?>
