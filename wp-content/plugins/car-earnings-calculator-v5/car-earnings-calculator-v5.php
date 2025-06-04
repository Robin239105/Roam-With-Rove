<?php
/*
Plugin Name: Car Earnings Calculator
Description: A beautiful car earnings calculator with custom styling.
Version: 5.0
Author: Al Amin Robin
Author URL: https://wpdevfreaks.com
*/

function car_earnings_calculator_v5_enqueue_scripts() {
    wp_enqueue_style('car-earnings-calculator-v5-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('car-earnings-calculator-v5-script', plugins_url('js/script.js', __FILE__), array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'car_earnings_calculator_v5_enqueue_scripts');

function car_earnings_calculator_v5_shortcode() {
    ob_start(); ?>
    <div class="calculator-container">
        <div class="calculator-form">
            <div class="car-type">
                <button class="car-type-btn active" data-type="Sedan">Sedan</button>
                <button class="car-type-btn" data-type="SUV">SUV</button>
                <button class="car-type-btn" data-type="Pickup">Pickup</button>
                <button class="car-type-btn" data-type="Van">Van</button>
                <button class="car-type-btn" data-type="Luxury">Luxury</button>
            </div>
            <div class="cohosting-plan-label">Car Type</div>
            <select id="make" class="calculator-input">
                <option value="">Make</option>
                <option value="Audi">Audi</option>
                <option value="BMW">BMW</option>
                <option value="Chevrolet">Chevrolet</option>
                <option value="Ford">Ford</option>
                <option value="Honda">Honda</option>
                <option value="Hyundai">Hyundai</option>
                <option value="Lexus">Lexus</option>
                <option value="Mercedes Benz">Mercedes Benz</option>
                <option value="Nissan">Nissan</option>
                <option value="Toyota">Toyota</option>
                <option value="Volkswagen">Volkswagen</option>
            </select>
            <input type="text" id="model" class="calculator-input" placeholder="Model">
            <input type="text" id="year" class="calculator-input" placeholder="Year">
            <div class="inline-fields">
                <input type="number" id="days" class="calculator-input" placeholder="Days Run Per Month">
                <input type="number" id="rate" class="calculator-input" placeholder="Base Rate/Day" value="0.00">
            </div>
            <div class="cohosting-plan-label">Co-Hosting Plan</div>
            <div class="cohosting-plan">
                <button id="full-service" class="plan-btn active">Full Service (30% Fee)</button>
                <button id="backend" class="plan-btn">Backend (15% Fee)</button>
            </div>
            <div class="note"><em>Note: All-inclusive option where we manage everything—cleaning, maintenance, bookings, and customer support—with precision.</em></div>
        </div>
        <div class="calculator-result">
            <div class="estimation">
                <h3>Earning Estimation</h3>
                <div id="estimated-earnings">$0.00/Year</div>
                <div class="estimate-note"><em>This estimate is for general guidance only and not a guarantee of earnings. Actual income may vary based on market trends, vehicle specifics, demand, and pricing. Use it as a reference, not financial advice.</em></div>
            </div>
            <div class="action-buttons">
                <a href="https://roamwithrove.com/contact/" class="action-btn">Get Started Today</a>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('car_earnings_calculator', 'car_earnings_calculator_v5_shortcode');
?>
