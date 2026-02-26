<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment Integration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <h1>Razorpay Payment Integration</h1>
    <button id="payButton">Pay Now</button>

    <script>
        $(document).ready(function() {
            $('#payButton').click(function() {
                $.ajax({
                    url: 'create_order.php', // Your server-side script to create order
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        var options = {
                            "key": "rzp_test_A87nm1TrwNtWIO", // Replace with your Razorpay Key ID
                            "amount": response.amount, // Amount in paise
                            "currency": "INR",
                            "order_id": response.order_id, // Order ID obtained from server
                            "name": "Your Company Name",
                            "description": "Test Transaction",
                            "handler": function (response) {
                                // Send payment details to your server for verification
                                $.ajax({
                                    url: 'verify_payment.php',
                                    method: 'POST',
                                    data: {
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_signature: response.razorpay_signature
                                    },
                                    success: function(response) {
                                        alert('Payment successful');
                                    },
                                    error: function() {
                                        alert('Payment verification failed');
                                    }
                                });
                            },
                            "prefill": {
                                "name": "John Doe",
                                "email": "john.doe@example.com",
                                "contact": "9999999999"
                            },
                            "theme": {
                                "color": "#3399cc"
                            }
                        };
                        var paymentObject = new Razorpay(options);
                        paymentObject.open();
                    },
                    error: function() {
                        alert('Could not create order. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
