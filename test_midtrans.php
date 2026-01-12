<?php
phpinfo();
require_once __DIR__.'/includes/midtrans_config.php';

$params = [
  'transaction_details' => [
    'order_id' => 'TEST-' . time(),
    'gross_amount' => 10000,
  ]
];

echo \Midtrans\Snap::getSnapToken($params);

