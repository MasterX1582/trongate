            <section class="container stage" id="examples">
                <h1>Choose Your Payment Method</h1>
                <div class="row">
                    <div class="column"><h3><img src="images/cart.svg" alt="cart"> Your Cart</h3></div>
                </div>
                <div class="row">
                    <div class="column">Lifetime Membership</div>
                    <div class="column"><?= $item->item_price ?></div>
                </div>
                <div class="row" id="subtotal-row">
                    <div class="column">SubTotal</div>
                    <div class="column"><?= $item->item_price ?></div>
                </div>
                <div class="row" id="discount-row" style="display: none;">
                    <div class="column">Discount</div>
                    <div class="column">$<span id="discount"></span></div>
                </div>
                <div class="row">
                    <div class="column"><h2>Payment Method</h2></div>
                    <div class="column">USD $<span id="grand-total" class="grand-total"><?= $item->item_price ?></span></div>
                </div>
                <div class="row">
                    <div class="column">
                        <button onclick="selectPaymentOption('Paypal')" id="paypal-btn" class="button button-outline">Paypal</button>
                        <button onclick="selectPaymentOption('Crypto')" id="crypto-btn" class="button button-outline">Crypto</button>
                    </div>
                    <div class="column">
                        <button id="next-btn-paypal" style="display: none;" class="button button-success">Next (Paypal)</button>
                        <button id="next-btn-crypto" style="display: none;" class="button button-success">Next (Crypto)</button>
                    </div>
                </div>
                <div class="row" id="crypto">
                    <div class="column">
                        <img src="images/crypto_logos/bitcoin.png" alt="bitcoin"><br>
                        Bitcoin
                    </div>
                    <div class="column">
                        <img src="images/crypto_logos/ethereum.png" alt="ethereum"><br>
                        Ethereum
                    </div>
                    <div class="column">
                        <img src="images/crypto_logos/xrp.png" alt="xrp"><br>
                        XRP
                    </div>
                    <div class="column">
                        <img src="images/crypto_logos/bitcoin_cash.png" alt="bitcoin cash"><br>
                        Bitcoin Cash
                    </div>
                    <div class="column">
                        <img src="images/crypto_logos/tron.png" alt="tron"><br>
                        Tron
                    </div>
                    <div class="column">
                        <img src="images/crypto_logos/litecoin.png" alt="litecoin"><br>
                        Litecoin
                    </div>
                    <div class="column">
                        <img src="images/crypto_logos/dash.png" alt="dash"><br>
                        Dash
                    </div>
                    <div class="column">
                        <img src="images/crypto_logos/ethereum_classic.png" alt="ethereum classic"><br>
                        Ethereum Classic
                    </div>
                </div>
                <div class="row">
                    <div class="column" id="paypal-info">NOTE: Paypal accepts all major credit and debit cards (no need to have a Paypal account). Crypto payments are processed by CoinPayments.net.</div>
                </div>
            </section>
        <style>
        body {
            background-image: url(images/neon.jpg);
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        h1 {
            margin: 1em;
        }
        .navigation {
            background: black;
        }
        .navigation a:link, .navigation a:active, .navigation a:visited {
            color: #eee;
        }
        .navigation a:hover {
            color: #fff;
            text-decoration: underline;
        }
        .container {
            min-width: 1080px;
        }
        .stage {
            background: white;
            color: black;
            text-align: center;
            min-height: 100vh;
        }

        .stage .row:nth-child(2), .stage .row:nth-child(7), .stage .row:nth-child(8) {
            border: 0;
            margin-top: 1.4em;
        }

        .row {
            max-width: 700px;
            font-size: 1.2em;
            font-weight: bold;
            border-top: 1px #ddd solid;
            padding: 1em 0em !important;
            margin: 0 auto;
        }

        .row div:nth-child(1) {
            text-align: left;
        }

        .row div:nth-child(2) {
            text-align: right;
        }

        .grand-total {
            color: green;
            font-size: 2em;
        }

        .button-success {
            background: green;
            border: 1px green solid;
        }

        #crypto div {
            text-align: center;
            font-size: 0.8em;
        }

        #paypal-info {
            text-align: center;
        }

        .button:focus, .button:hover, button:focus, button:hover, input[type='button']:focus, input[type='button']:hover, input[type='reset']:focus, input[type='reset']:hover, input[type='submit']:focus, input[type='submit']:hover {
            background-color: #9b4dca;
            border-color: #9b4dca;
        }

        </style>

        <script>

            var price = <?= $item->item_price ?>;
            var discount = <?= $item->price_discount ?>;

            function selectPaymentOption(paymentOption) {

                if (paymentOption == 'Paypal') {
                    document.getElementById("next-btn-paypal").style.display = 'inline';
                    document.getElementById("next-btn-crypto").style.display = 'none';
                    document.getElementById("crypto").style.display = 'none';
                    document.getElementById("paypal-btn").className = "button";
                    document.getElementById("crypto-btn").className = "button button-outline";
                    document.getElementById("paypal-info").style.display = 'block';
                    document.getElementById("subtotal-row").style.display = 'flex';
                    document.getElementById("discount-row").style.display = 'none';
                    document.getElementById("grand-total").innerHTML = price;
                }

                if (paymentOption == 'Crypto') {
                    document.getElementById("next-btn-crypto").style.display = 'inline';
                    document.getElementById("next-btn-paypal").style.display = 'none';
                    document.getElementById("crypto").style.display = 'flex';
                    document.getElementById("paypal-btn").className = "button button-outline";
                    document.getElementById("crypto-btn").className = "button";
                    document.getElementById("paypal-info").style.display = 'none';
                    document.getElementById("subtotal-row").style.display = 'none';
                    document.getElementById("discount-row").style.display = 'flex';
                    document.getElementById("discount").innerHTML = discount;
                    document.getElementById("grand-total").innerHTML = price-discount;
                }

            }
        </script>			