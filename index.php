<?php
include_once 'menu.php';

$sessionId   = $_POST['sessionId'];
$phoneNumber = $_POST['phoneNumber'];
$serviceCode = $_POST['serviceCode'];
$text        = $_POST['text'];


$menu = new Menu($text, $sessionId, $phoneNumber);

$cleanedText = $menu->middleware($text);
$input = explode("*", $cleanedText);


$conn = DB::connect();


$stmt = $conn->prepare("SELECT * FROM users WHERE phone_number = ?");
$stmt->execute([$phoneNumber]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    if ($cleanedText == "") {
        $menu->mainMenuUnregistered();
    } elseif ($input[0] == "1") {
        $menu->registrationFlow($input);
    } else {
        echo "END Invalid input. Please try again.";
    }
} else {
    if ($cleanedText == "") {
        $menu->mainMenuRegistered($user);
    } elseif ($input[0] == "1") {
        $menu->bmiFlow($input, $user);
    } else {
        echo "END Invalid input. Please try again.";
    }
}
?>
