<?php
/*
Plugin Name: Car Loan Calculator
Description: A beautiful car loan calculator plugin with custom styling.
Version: 1.0
Author: Al Amin Robin
*/

function car_loan_calculator_enqueue_scripts() {
    wp_enqueue_style('car-loan-calculator-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('car-loan-calculator-script', plugins_url('js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'car_loan_calculator_enqueue_scripts');

function car_loan_calculator_shortcode() {
    ob_start(); ?>
    <div class="calculator-container">
        <div class="calculator-form">
            <h2>Car Loan Calculator</h2>
            <input type="number" id="vehicle-price" class="calculator-input" placeholder="Vehicle Price ($)">
            <input type="number" id="down-payment" class="calculator-input" placeholder="Down Payment ($)">
            <input type="number" id="trade-in" class="calculator-input" placeholder="Trade-In Value ($) (Optional)">
            <input type="number" id="interest-rate" class="calculator-input" placeholder="Annual Interest Rate (%)">
            <input type="number" id="loan-term" class="calculator-input" placeholder="Loan Term (Months)">
            <button id="calculate-btn" class="action-btn">Calculate</button>
        </div>
        <div class="calculator-result">
            <div class="estimation">
                <h3>Loan Details</h3>
                <div id="monthly-payment">Monthly Payment: $0.00</div>
                <div id="total-loan">Total Loan Amount: $0.00</div>
                <div id="total-interest">Total Interest Paid: $0.00</div>
                <div id="total-payment">Total Payment: $0.00</div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('car_loan_calculator', 'car_loan_calculator_shortcode');
?>
