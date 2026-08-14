<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nadine Restaurant</title>

    <link rel="stylesheet" href="style.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        color: #222;
        background: #faf9f6;
        line-height: 1.6;
    }


    /* =========================
   NAVBAR
========================= */

    .navbar {
        height: 80px;
        padding: 0 8%;

        display: flex;
        align-items: center;
        justify-content: space-between;

        background: #faf9f6;
        border-bottom: 1px solid #e8e5df;
    }

    .logo {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: 3px;
    }

    .nav-links {
        display: flex;
        gap: 32px;
    }

    .nav-links a {
        color: #555;
        text-decoration: none;
        font-size: 14px;
    }

    .nav-links a:hover {
        color: #000;
    }

    .nav-button {
        padding: 10px 20px;

        color: white;
        background: #222;

        text-decoration: none;
        font-size: 14px;

        border-radius: 6px;
    }


    /* =========================
   HERO
========================= */

    .hero {
        min-height: 650px;

        display: flex;
        align-items: center;

        padding: 80px 8%;

        background:
            linear-gradient(90deg,
                #faf9f6 0%,
                #faf9f6 50%,
                #eeeae2 50%);
    }

    .hero-content {
        max-width: 650px;
    }

    .eyebrow {
        display: block;

        margin-bottom: 18px;

        font-size: 12px;
        font-weight: 700;

        letter-spacing: 3px;
        color: #888;
    }

    .hero h1 {
        font-size: clamp(48px, 7vw, 86px);
        line-height: 1.05;

        letter-spacing: -3px;

        margin-bottom: 25px;
    }

    .hero p {
        max-width: 500px;

        color: #666;

        font-size: 17px;

        margin-bottom: 35px;
    }

    .hero-buttons {
        display: flex;
        gap: 12px;
    }


    /* =========================
   BUTTONS
========================= */

    .primary-button,
    .secondary-button {
        display: inline-block;

        padding: 13px 24px;

        border-radius: 6px;

        text-decoration: none;

        font-size: 14px;
        font-weight: 600;
    }

    .primary-button {
        color: white;
        background: #222;
    }

    .secondary-button {
        color: #222;
        border: 1px solid #ccc;
    }

    .primary-button:hover {
        background: #444;
    }

    .secondary-button:hover {
        background: #eee;
    }


    /* =========================
   MENU
========================= */

    .menu-section {
        padding: 110px 8%;
    }

    .section-header {
        max-width: 600px;
        margin-bottom: 50px;
    }

    .section-header h2 {
        font-size: 48px;
        line-height: 1.1;

        margin-bottom: 15px;
    }

    .section-header p {
        color: #777;
    }


    .menu-grid {
        display: grid;

        grid-template-columns:
            repeat(3, 1fr);

        gap: 25px;
    }

    .menu-card {
        background: white;

        border: 1px solid #e8e5df;
        border-radius: 10px;

        overflow: hidden;
    }

    .food-placeholder {
        height: 220px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #eeeae2;

        font-size: 70px;
    }

    .menu-info {
        padding: 25px;
    }

    .menu-info h3 {
        margin-bottom: 8px;
        font-size: 20px;
    }

    .menu-info p {
        color: #777;
        font-size: 14px;

        margin-bottom: 18px;
    }

    .price {
        font-weight: 700;
        font-size: 18px;
    }


    /* =========================
   ABOUT
========================= */

    .about {
        padding: 120px 8%;

        background: #222;
        color: white;
    }

    .about-content {
        max-width: 650px;
    }

    .about .eyebrow {
        color: #aaa;
    }

    .about h2 {
        font-size: 52px;
        line-height: 1.1;

        margin-bottom: 25px;
    }

    .about p {
        color: #bbb;

        max-width: 550px;

        margin-bottom: 30px;
    }

    .about .primary-button {
        background: white;
        color: #222;
    }


    /* =========================
   FOOTER
========================= */

    footer {
        padding: 50px 8%;

        background: #171717;

        color: #888;

        text-align: center;
    }

    .footer-logo {
        color: white;

        font-size: 20px;
        font-weight: 800;

        letter-spacing: 3px;

        margin-bottom: 8px;
    }

    footer p {
        margin-bottom: 15px;
    }


    /* =========================
   RESPONSIVE
========================= */

    @media (max-width: 800px) {

        .nav-links {
            display: none;
        }

        .hero {
            background: #faf9f6;
        }

        .menu-grid {
            grid-template-columns: 1fr;
        }

        .hero h1 {
            font-size: 52px;
        }

        .section-header h2,
        .about h2 {
            font-size: 40px;
        }
    }
</style>

<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            TEST PAGE
        </div>

        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="src/page2.php">Menu</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
        </div>

        <a href="logout.php" class="nav-button">
            Log Out
        </a>
    </nav>

    <!-- Hero -->
    <section class="hero" id="home">

        <div class="hero-content">

            <span class="eyebrow">
                GOOD FOOD • GOOD MOOD
            </span>

            <h1>
                Fresh food,<br>
                made with care.
            </h1>

            <p>
                Delicious meals made from quality ingredients,
                prepared fresh and served with love.
            </p>

            <div class="hero-buttons">
                <a href="#menu" class="primary-button">
                    View Menu
                </a>

                <a href="#about" class="secondary-button">
                    Learn More
                </a>
            </div>

        </div>

    </section>


    <!-- Featured Menu -->
    <section class="menu-section" id="menu">

        <div class="section-header">
            <span class="eyebrow">OUR FAVORITES</span>

            <h2>
                Featured Menu
            </h2>

            <p>
                A few customer favorites to get you started.
            </p>
        </div>


        <div class="menu-grid">

            <div class="menu-card">

                <div class="food-placeholder">
                    🍔
                </div>

                <div class="menu-info">
                    <h3>Classic Burger</h3>

                    <p>
                        Juicy beef patty, fresh vegetables,
                        and our signature sauce.
                    </p>

                    <span class="price">
                        ₱180
                    </span>
                </div>

            </div>


            <div class="menu-card">

                <div class="food-placeholder">
                    🍝
                </div>

                <div class="menu-info">
                    <h3>Creamy Pasta</h3>

                    <p>
                        Rich and creamy pasta prepared
                        with our special house sauce.
                    </p>

                    <span class="price">
                        ₱220
                    </span>
                </div>

            </div>


            <div class="menu-card">

                <div class="food-placeholder">
                    🍗
                </div>

                <div class="menu-info">
                    <h3>Crispy Chicken</h3>

                    <p>
                        Golden crispy chicken served with
                        our signature dipping sauce.
                    </p>

                    <span class="price">
                        ₱200
                    </span>
                </div>

            </div>

        </div>

    </section>


    <!-- About -->
    <section class="about" id="about">

        <div class="about-content">

            <span class="eyebrow">
                ABOUT US
            </span>

            <h2>
                Simple food.<br>
                Honest flavors.
            </h2>

            <p>
                We believe great food doesn't need to be complicated.
                Our kitchen focuses on fresh ingredients, familiar
                flavors, and meals worth coming back for.
            </p>

            <a href="#contact" class="primary-button">
                Visit Us
            </a>

        </div>

    </section>


    <!-- Footer -->
    <footer id="contact">

        <div class="footer-logo">
            TEST PAGE
        </div>

        <p>
            Good food, good mood.
        </p>

        <span>
            © <?php echo date("Y"); ?> TEST PAGE
        </span>

    </footer>

</body>

</html>