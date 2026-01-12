<?php
require_once __DIR__ . '/Midtrans/Config.php';
require_once __DIR__ . '/Midtrans/ApiRequestor.php';
require_once __DIR__ . '/Midtrans/CoreApi.php';
require_once __DIR__ . '/Midtrans/Transaction.php';
require_once __DIR__ . '/Midtrans/SnapApiRequestor.php';
require_once __DIR__ . '/Midtrans/Sanitizer.php';
require_once __DIR__ . '/Midtrans/Snap.php';

\Midtrans\Config::$serverKey = 'SB-Mid-server-OpsmcllFbnPzTDEIptl0vCu3';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;