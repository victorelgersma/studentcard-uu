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
<style>
    .campaign-banner {
        text-align: center;
        font-size: 13px;
        color: #666;
        margin: 0 0 15px;
    }

    .campaign-banner a {
        color: #222;
        font-weight: 600;
        text-decoration: underline;
    }

    .campaign-banner a:hover {
        color: #444;
    }

        .sale-banner {
        text-align: center;
        background: linear-gradient(90deg, #ff6b6b, #feca57);
        color: #fff;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 14px;
        padding: 10px 14px;
        border-radius: 8px;
        margin: 0 0 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .price-old {
        text-decoration: line-through;
        color: #999;
        font-size: 16px;
        margin-right: 6px;
    }

    .price-new {
        color: #1a7f37;
        font-size: 22px;
    }

        .faq {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .faq h2 {
        font-size: 16px;
        margin: 0 0 12px;
    }

    .faq-item {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 10px 14px;
    }

    .faq-item summary {
        cursor: pointer;
        font-weight: 600;
        list-style: none;
    }

    .faq-item summary::-webkit-details-marker {
        display: none;
    }

    .faq-item summary::before {
        content: "+";
        display: inline-block;
        width: 1em;
        color: #666;
    }

    .faq-item[open] summary::before {
        content: "–";
    }

    .faq-item p {
        margin: 10px 0 0;
        line-height: 1.5;
        color: #444;
    }
</style>
<body>

    <div class="container">

    <p class="campaign-banner">
    A <a href="https://agoodidea.vjbe.net/" target="_blank" rel="noopener">Good ID(ea)</a> initiative
</p>
        <h1>Unofficial Convenience Card </h1>


        <div class="sale-banner">🎉 September Sale — Free All Month 🎉</div>
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
    Price: <span class="price-old">€3.50</span> <strong class="price-new">FREE</strong>
</p>

        <p class="intro">
            This is a laminated, pocket-sized copy of your enrollment certificate. It is <em>not</em> issued by Utrecht
            University and is <em>not</em> an official university ID card. However, it does allow you to gain access to university buildings, including the botanical gardens, without a smartphone.
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


            <button type="submit">
                Request card
            </button>

        </form>
                <div class="faq">
            <h2>FAQ</h2>
            <details class="faq-item">
                <summary>Where do I find my enrolment certificate?</summary>
                <p>
                    See our <a href="https://enrolmentwhere.vjbe.net/" target="_blank" rel="noopener">step-by-step screenshots</a> showing exactly where to find it.
                </p>
            </details>
            <details class="faq-item">
                <summary>What happens after I request a card?</summary>
                <p>
                 The <a href="https://agoodidea.vjbe.net">Good ID(ea)</a> team will print and laminate your card for free, after which they will contact you to arrange a handover. This will probably be at Drift or the Parnassos Culture Café.
                </p>
            </details>
        </div>

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