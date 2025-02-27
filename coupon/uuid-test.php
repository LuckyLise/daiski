<?php
// require_once("pdo_connect.php");

function generate_short_uuid() {
    return rtrim(strtr(base64_encode(random_bytes(9)), '+/', '-_'), '=');
}

echo generate_short_uuid();
?>

<?php
// require_once("pdo_connect.php");

// function generate_unique_coupon_code($length = 10) {
//     global $host_db;
//     do {
//         $code = strtoupper(bin2hex(random_bytes($length / 2))); // 產生 10 碼隨機優惠券代碼
//         $stmt = $host_db->prepare("SELECT id FROM coupons WHERE code = :code");
//         $stmt->execute([':code' => $code]);
//         $exists = $stmt->fetch(PDO::FETCH_ASSOC);
//     } while ($exists); // 如果重複，就重新產生

//     return $code;
// }

// // 回傳優惠券代碼
// echo generate_unique_coupon_code();
?>