<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Contact Form Captcha</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="contact-form">
        <h2>CONTACT US</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Enter Your Name" required />
            <input type="text" name="phone" placeholder="Phone Number" required />
            <input type="email" name="email" placeholder="Your Email Address" required />
            <textarea name="message" placeholder="Your Message Here" required></textarea>
            <!-- ReCaptcha integration -->
            <div class="g-recaptcha" data-sitekey="copy/paste key from reCAPTCHA here"></div>
            <input type="submit" name="submit" value="Send Message" id="submit-btn" />
        </form>
        <!-- Display Status of Form submission -->
        <div class="status">
            <?php
            if (isset($_POST['submit'])) {
                $user_name = $_POST['name'];
                $user_phone = $_POST['phone'];
                $user_email = $_POST['email'];
                $user_message = $_POST['message'];

                $from_email = 'from@email.com';
                $email_subject = "New Contact Form Message";
                $email_body = "Name: $user_name.\n" .
                    "Phone No: $user_phone.\n" .
                    "Email: $user_email.\n" .
                    "Message: $user_message.\n" .

                    $to_email = 'to@email.com';

                $headers = "From: $from_email \r\n";
                $headers .= "Reply-To: $user_email \r\n";

                $secretKey = "copy/paste secret key from reCAPTCHA here";
                $responseKey = $_POST['g-recaptcha-response'];
                $userIP = $_SERVER['REMOTE_ADDR'];
                $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";

                $response = file_get_contents($url);
                $response = json_decode($response);

                if ($response->success) {
                    mail(
                        $to_email,
                        $email_subject,
                        $email_body,
                        $headers
                    );
                    echo "Message Sent Successfully!";
                } else {
                    echo
                        "<span>Invalid Captcha, Please Try Again!</span>";
                }
            } ?>
        </div>
    </div>
</body>

</html>