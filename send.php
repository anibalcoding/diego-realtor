<?php
$to = 'dcortesrealty@gmail.com';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$form_type = isset($_POST['form_type']) ? $_POST['form_type'] : 'unknown';

function clean($val) {
    return htmlspecialchars(strip_tags(trim($val)));
}

if ($form_type === 'seller') {
    $first_name      = clean($_POST['first_name'] ?? '');
    $last_name       = clean($_POST['last_name'] ?? '');
    $email           = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone           = clean($_POST['phone'] ?? '');
    $property_address = clean($_POST['property_address'] ?? '');

    $subject = "New Home Valuation Request — {$first_name} {$last_name}";

    $body  = "New seller inquiry from your website:\n\n";
    $body .= "Name:             {$first_name} {$last_name}\n";
    $body .= "Email:            {$email}\n";
    $body .= "Phone:            {$phone}\n";
    $body .= "Property Address: {$property_address}\n";

} elseif ($form_type === 'buyer') {
    $first_name  = clean($_POST['first_name'] ?? '');
    $last_name   = clean($_POST['last_name'] ?? '');
    $email       = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $phone       = clean($_POST['phone'] ?? '');
    $looking_for = clean($_POST['looking_for'] ?? '');
    $notes       = clean($_POST['notes'] ?? '');

    $subject = "New Buyer Call Request — {$first_name} {$last_name}";

    $body  = "New buyer inquiry from your website:\n\n";
    $body .= "Name:         {$first_name} {$last_name}\n";
    $body .= "Email:        {$email}\n";
    $body .= "Phone:        {$phone}\n";
    $body .= "Looking for:  {$looking_for}\n";
    $body .= "Notes:\n{$notes}\n";

} else {
    header('Location: index.html');
    exit;
}

$headers  = "From: website@diegocortesrealty.com\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

$sent = mail($to, $subject, $body, $headers);

if ($sent) {
    header('Location: thank-you.html');
} else {
    header('Location: index.html?error=1');
}
exit;
?>
