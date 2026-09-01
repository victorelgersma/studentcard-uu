<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Cache bust -->
    <link rel="stylesheet" href="style.css?v=4" />

</head>

<body>

    <div class="container">

        <h1>Unofficial Convenience Card </h1>


        <div class="card-slider" aria-label="Card preview">
            <div class="slides">
                <img src="https://img.vjbe.net/id-front.webp" alt="Front of the Unofficial Convenience Card">
                <img src="https://img.vjbe.net/id-back.webp" alt="Back of the Unofficial Convenience Card">
            </div>

            <button class="slider-button prev" type="button" aria-label="Previous image">
                ‹
            </button>

            <button class="slider-button next" type="button" aria-label="Next image">
                ›
            </button>

            <div class="slider-dots">
                <button class="dot active" type="button" aria-label="Show front"></button>
                <button class="dot" type="button" aria-label="Show back"></button>
            </div>
        </div>

        <p class="price">
            Price: <strong>€3.50</strong>
        </p>

        <p class="intro">
            This is a laminated, pocket-sized copy of your enrollment certificate. It is <em>not</em> issued by Utrecht
            University and is <em>not</em> an official university ID card.
        </p>

        <form method="post" action="send_order.php" enctype="multipart/form-data">

            <input type="hidden" name="amount" value="3.50 EUR">
            <label>
                Your name
                <input name="name" autocomplete="name" required>
            </label>

            <label>
                Email
                <input type="email" name="email" autocomplete="email" required>
            </label>

            <label>
                Enrollment certificate (PDF)

                <input type="file" name="enrolment_certificate" accept="application/pdf,.pdf" required>

                <small>
                    Upload the PDF you downloaded from MyUU.
                </small>

                <small>
                    Privacy: Your enrollment certificate is used only to verify your student status and produce your
                    card.
                    It is not shared with third parties and will be deleted after your order has been completed.
                </small>
            </label>

            <div class="order-notice">
                <strong>How it works</strong>
                <p>
                    After you request your card, I will send you a Tikkie payment
                    request for <strong>€3.50</strong>. Your card will be professionally printed and
laminated at a commercial print shop, and we will arrange a handover. 
                </p>
            </div>

            <button type="submit">
                Request card
            </button>

        </form>

        <footer class="footer">
            Questions? email <a href="mailto:conveniencecard@vjbe.net">conveniencecard@vjbe.net</a>
        </footer>
    </div>
    <script>
        const slides = document.querySelector('.slides');
        const dots = document.querySelectorAll('.dot');

        let currentSlide = 0;

        function showSlide(index) {
            currentSlide = index;
            slides.style.transform = `translateX(-${index * 100}%)`;

            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }

        document.querySelector('.prev').addEventListener('click', () => {
            showSlide((currentSlide - 1 + dots.length) % dots.length);
        });

        document.querySelector('.next').addEventListener('click', () => {
            showSlide((currentSlide + 1) % dots.length);
        });

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showSlide(index));
        });
    </script>
</body>

</html>