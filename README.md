# USSD_BASED_MBI_CALCULATOR
This is the repository for USSD and SMS based Mini-Project of MBI Calculator

# BMI USSD & SMS Application

A simple USSD and SMS application that enables users to register and calculate their Body Mass Index (BMI) via basic mobile phones without internet access.

---

## Overview

This app provides a text-based interface where users can:

- Register using their phone number, name, and a PIN.
- Calculate their BMI by entering height and weight.
- Receive BMI results and personalized health recommendations via SMS.

---

## BMI Categories (WHO Standards)

| Category      | BMI Range       |
|---------------|-----------------|
| Underweight   | < 18.5          |
| Normal weight | 18.5 – 24.9     |
| Overweight    | 25.0 – 29.9     |
| Obesity       | ≥ 30.0          |

---

## Features

### User Registration

- Prompt unregistered users to enter their name.
- Create and confirm a PIN.
- Auto-register phone number.
- Send confirmation SMS upon successful registration.

### BMI Calculation

- Input height (meters).
- Input weight (kilograms).
- Preview details with options to:
  - Confirm and calculate BMI.
  - Cancel session.
  - Go back to weight.
  - Return to main menu.
- Calculate BMI and store results.
- Send BMI results and recommendations via SMS.

---

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/yourusername/bmi-ussd-sms-app.git
   cd bmi-ussd-sms-app

