<?php
include_once 'myutils.php';
include_once 'sms.php';
include_once 'db.php';

class Menu
{
    protected $text;
    protected $sessionId;
    protected $phoneNumber;
    protected $conn;

    public function __construct($text, $sessionId, $phoneNumber)
    {
        $this->text = $this->middleware($text);
        $this->sessionId = $sessionId;
        $this->phoneNumber = $phoneNumber;
        $this->conn = DB::connect();
    }

    public function mainMenuUnregistered()
    {
        $response = "CON Welcome to BMI Calculator App.\n";
        $response .= "1. Register";
        echo $response;
    }

    public function registrationFlow($input)
    {
        $level = count($input);

        if ($level == 1) {
            echo "Please enter your name:";
        } elseif ($level == 2) {
            echo "CON Create PIN:";
        } elseif ($level == 3) {
            echo "CON Confirm your PIN:";
        } elseif ($level == 4) {
            if ($input[2] === $input[3]) {
                $stmt = $this->conn->prepare("INSERT INTO users (phone_number, name, pin) VALUES (?, ?, ?)");
                $stmt->execute([$this->phoneNumber, $input[1], $input[2]]); 

                $sms = new Sms($this->phoneNumber);
                $sms->sendSMS("Welcome to BMI Calculator App, {$input[1]}! You are now registered.", [$this->phoneNumber]);

                echo "END Registration successful! You will receive an SMS shortly.";
            } else {
                echo "END PINs did not match. Please dial again.";
            }
        } else {
            echo "END Invalid input. Please try again.";
        }
    }

    public function mainMenuRegistered($user)
    {
        $response="CON Hi {$user['name']}, welcome back.\n";
        $response .="1. Calculate BMI";
        echo $response;
    }

    public function bmiFlow($textArray, $user)
    {
       $level = count($textArray);

        if ($level == "1") {
            echo "CON Enter your height in meters (e.g. 1.75):";
        } elseif ($level == 2) {
            echo "CON Enter your weight in kilograms (e.g. 70):";
        } elseif ($level == 3) {
            $height = floatval($textArray[1]);
            $weight = floatval($textArray[2]);
            $response = "CON Confirm Details:\nHeight: $height m\nWeight: $weight kg\n";
            $response .= "1. Confirm & Calculate\n";
            $response .="2. Cancel\n";
            $response .=myutils::$GO_BACK.". Go Back\n";
            $response .=myutils::$GO_TO_MAIN_MENU.". Main menu";
            echo $response;
        } elseif ($level == 4) {
            $height = floatval($textArray[1]);
            $weight = floatval($textArray[2]);
            $option = $textArray[3];

            if ($option == "1") {
                $this->calculateAndSendBMI($height, $weight, $user);
            } elseif ($option == "2") {
                echo "END BMI calculation cancelled.";
            } else {
                echo "END Invalid option. Try again.";
            }
        } else {
            echo "END Invalid input. Please try again.";
        }
    }


    private function calculateAndSendBMI($height, $weight, $user)
    {
        $bmi = round($weight / ($height * $height), 2);

        if ($bmi < 18.5) {
            $category = "Underweight";
            $recommendation = "You are underweight. Eat nutritious meals.";
        } elseif ($bmi < 25) {
            $category = "Normal";
            $recommendation = "Great! You have a healthy weight.";
        } elseif ($bmi < 30) {
            $category = "Overweight";
            $recommendation = "You are overweight. Try regular exercise.";
        } else {
            $category = "Obesity";
            $recommendation = "You are obese. Seek medical guidance.";
        }

        $stmt = $this->conn->prepare("INSERT INTO bmi_records (user_id, height_m, weight_kg, bmi_value, category, recommendation) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user['user_id'], $height, $weight, $bmi, $category, $recommendation]);

        $sms = new Sms($this->phoneNumber);
        $msg = "Hello {$user['name']}, your BMI is $bmi ($category). $recommendation";
        $sms->sendSMS($msg, [$this->phoneNumber]);

        echo "END Your BMI is $bmi ($category). You will receive an SMS shortly.";
    }

   
    public function middleware($text)
    {
        return $this->goBack($this->goToMainMenu($text));
    }

    public function goBack($text)
    {
        $textArray = explode("*", $text);
        while (($index = array_search(myutils::$GO_BACK, $textArray)) !== false) {
            if ($index > 0) {
                array_splice($textArray, $index - 1, 2);
            } else {
                array_splice($textArray, $index, 1);
            }
        }
        return implode("*", $textArray);
    }

    public function goToMainMenu($text)
    {
        $textArray = explode("*", $text);
        while (($index = array_search(myutils::$GO_TO_MAIN_MENU, $textArray)) !== false) {
            $textArray = array_slice($textArray, $index + 1);
        }
        return implode("*", $textArray);
    }
}
