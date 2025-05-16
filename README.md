BMI Calculator – USSD/SMS Application
 Overview
This project is a mobile-based BMI (Body Mass Index) calculator that works on USSD and SMS platforms, enabling users with basic feature phones (non-smartphones) to access BMI calculations. It allows users to register, input their height and weight, and receive their BMI results via SMS using Africa's Talking APIs.

Functional Features
1. User Registration
•	Users initiate the USSD session by dialing: *384*94440#
•	Required input:
o	Name
o	PIN (with confirmation)
•	After registration, the user receives a confirmation SMS.
•	The user's phone number is automatically captured by the system.
BMI Calculation
	Once registered, the user is prompted to enter the height (in meters).
	Next, the user is asked to enter the weight (in kilograms).
	The application previews the previous entered user inputs and asks him/her with the following options:
	Confirm the calculation and proceed.
	Cancel the session.
	Go back to re-enter weight.  
	Return to the main menu.
	 If confirmed, the application calculates the BMI where  BMI = weight (kg) / [height (m)]²
	Finally, the system sends the BMI result and a brief personalized recommendation via an SMS.

Business Logic Highlights
•	Ensures all required inputs are entered before calculation.
•	Validates correct PIN confirmation.
•	Stores and retrieves data efficiently from MySQL database.
•	BMI calculation accuracy is guaranteed.
•	Personalized SMS is sent with BMI category and health tip.
 Testing Instructions
1.	Start XAMPP and ensure Apache and MySQL are running.
2.	Set up the database using provided SQL schema.
3.	Update Africa’s Talking app with the Ngrok tunnel URL.
4.	Dial *384*94440# on a registered test number.
5.	Follow prompts to register and calculate BMI.
6.	Verify SMS result using Africa’s Talking dashboard or phone.
Notes
•	This application is strictly offline–accessible on basic phones.

developers:

MUGISHA Tonny 22RP03866
NTWARI Mugemangango 22RP03758


API KEY="atsk_c03b1fa9ec5104f02fbdcb25055f0ecb900af3b10d20159223bc1e194ef015dc10063957"
shortcode=4561
Alphanumeric="EightMM"
serviceCode=*384*94440#