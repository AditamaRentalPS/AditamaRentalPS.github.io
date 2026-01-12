<?php
require_once 'includes/midtrans_config.php';

// Ambil data dari form
$name        = $_POST['name'];
$phone       = $_POST['phone'];
$total_price = (int) $_POST['total_price'];

// Order ID unik
$order_id = 'ORDER-' . time();

// Parameter Snap
$params = [
  'transaction_details' => [
    'order_id' => $order_id,
    'gross_amount' => $total_price,
  ],
  'customer_details' => [
    'first_name' => $name,
    'phone' => $phone,
  ]
];

try {
  $snapToken = \Midtrans\Snap::getSnapToken($params);
  echo json_encode([
    'token' => $snapToken,
    'order_id' => $order_id
  ]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}
