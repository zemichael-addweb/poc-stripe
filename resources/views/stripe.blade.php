<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body class="body-wraper">
    <div class="container">
        <header class="mb-4 mt-4">
            <h1>
                POC for Stripe Integration
            </h1>
        </header>
        <main class="container mb-5">
            <button class="btn btn-primary payButton" id="payButton">Pay</button>
            <div class="row">
                <div class="col-md-7 col-md-offset-3">
                    <div class="card">
                        <div class="card-body container">
                            <form role="form" action="{{ route('stripe.post') }}" method="post"
                                class="require-validation" data-cc-on-file="false"
                                data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                                @csrf

                                <div class='row'>
                                    <div class='mb-4 form-group required'>
                                        <label class='control-label'>Name on Card</label>
                                        <input class='form-control' size='4' type='text'>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div class='mb-4 form-group required'>
                                        <label class='control-label'>Card Number</label>
                                        <input autocomplete='off' class='form-control card-number' size='20'
                                            type='text'>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div class='mb-4 form-group required'>
                                        <label class='control-label'>Number of users</label>
                                        <input autocomplete='off' class='form-control card-number' size='20'
                                            type='number'>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div class='mb-4 col-md-4 form-group cvc required'>
                                        <label class='control-label'>CVC</label>
                                        <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311'
                                            size='4' type='text'>
                                    </div>
                                    <div class='mb-4 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Month</label> <input
                                            class='form-control card-expiry-month' placeholder='MM' size='2'
                                            type='text'>
                                    </div>
                                    <div class='mb-4 col-md-4 form-group expiration required'>
                                        <label class='control-label'>Expiration Year</label>
                                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                            type='text'>
                                    </div>
                                </div>

                                <div class='row'>
                                    <div class='col-md-12 error form-group hide'>
                                        <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now
                                            ($100)</button>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        // Set Stripe publishable key to initialize Stripe.js
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    
    // Select payment button
    const payBtn = document.querySelector("#payButton");
    
    // Payment request handler
    payBtn.addEventListener("click", function (evt) {
        setLoading(true);
    
        createCheckoutSession().then(function (data) {
            if(data.sessionId){
                stripe.redirectToCheckout({
                    sessionId: data.sessionId,
                }).then(handleResult);
            }else{
                handleResult(data);
            }
        });
    });
        
    // Create a Checkout Session with the selected product
    const createCheckoutSession = function (stripe) {
    const csrfToken = $('[name="_token"]').val();
    return $.ajax({
        url: "{{ route('stripe.post') }}",
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        data: JSON.stringify({
            createCheckoutSession: 1,
        }),
        dataType: "json"
    });
};
    
    // Handle any errors returned from Checkout
    const handleResult = function (result) {
        if (result.error) {
            showMessage(result.error.message);
        }
        
        setLoading(false);
    };
    
    // Show a spinner on payment processing
    function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            payBtn.disabled = true;
            // document.querySelector("#spinner").classList.remove("hidden");
            // document.querySelector("#buttonText").classList.add("hidden");
        } else {
            // Enable the button and hide spinner
            payBtn.disabled = false;
            // document.querySelector("#spinner").classList.add("hidden");
            // document.querySelector("#buttonText").classList.remove("hidden");
        }
    }
    
    // Display message
    function showMessage(messageText) {
        const messageContainer = document.querySelector("#paymentResponse");
        
        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;
        
        setTimeout(function () {
            messageContainer.classList.add("hidden");
            messageText.textContent = "";
        }, 5000);
    }
    </script>
</body>

</html>