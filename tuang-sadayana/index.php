<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rehat Sejenak</title>
<link rel="stylesheet" href="/assets/brand.css">
<script src="/assets/brand.js" data-app="rehat" defer></script>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/assets/theme.php'; ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5efe6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #4a3f35;
            padding: 20px;
        }

        /* Wadah Utama */
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        /* Animasi Cangkir dan Uap */
        .cup-container {
            position: relative;
            margin-bottom: 40px;
        }

        /* Uap */
        .vapour {
            display: flex;
            position: relative;
            z-index: 1;
            padding: 0 20px;
            justify-content: center;
        }

        .vapour span {
            position: relative;
            bottom: 10px;
            display: block;
            margin: 0 5px;
            width: 8px;
            height: 80px;
            background: linear-gradient(to top, rgba(255,255,255,0), rgba(180, 140, 100, 0.3));
            border-radius: 50%;
            animation: animateVapour 4s linear infinite;
            opacity: 0;
            filter: blur(4px);
        }

        /* Mengatur jeda animasi uap agar terlihat alami */
        .vapour span:nth-child(1) { animation-delay: 0.5s; }
        .vapour span:nth-child(2) { animation-delay: 1.5s; }
        .vapour span:nth-child(3) { animation-delay: 1s; }
        .vapour span:nth-child(4) { animation-delay: 2s; }
        .vapour span:nth-child(5) { animation-delay: 2.5s; }

        @keyframes animateVapour {
            0% {
                transform: translateY(0) scaleX(1);
                opacity: 0;
            }
            15% {
                opacity: 0.6;
            }
            50% {
                transform: translateY(-50px) scaleX(1.5);
                opacity: 0.4;
            }
            95% {
                opacity: 0;
            }
            100% {
                transform: translateY(-120px) scaleX(2);
                opacity: 0;
            }
        }

        /* Cangkir */
        .cup {
            position: relative;
            width: 150px;
            height: 120px;
            background: #fff;
            border-bottom-left-radius: 40%;
            border-bottom-right-radius: 40%;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.1), 0 10px 15px rgba(0,0,0,0.05);
        }

        /* Air Teh */
        .tea {
            position: absolute;
            top: 15px;
            left: 10px;
            width: 130px;
            height: 95px;
            background: linear-gradient(to bottom, #d47a3a, #803909);
            border-bottom-left-radius: 40%;
            border-bottom-right-radius: 40%;
            overflow: hidden;
        }

        /* Efek Kilau Air */
        .tea::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
        }

        /* Gagang Cangkir */
        .handle {
            position: absolute;
            right: -35px;
            top: 25px;
            width: 45px;
            height: 65px;
            border: 12px solid #fff;
            border-left: 12px solid transparent;
            border-bottom: 12px solid transparent;
            border-radius: 50%;
            transform: rotate(35deg);
            box-shadow: 3px 0 5px rgba(0,0,0,0.05);
        }

        /* Piring Tatakan */
        .saucer {
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 25px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 15px 20px rgba(0,0,0,0.05);
        }

        /* Teks */
        .text-quote {
            font-size: 1.35rem;
            font-weight: 500;
            line-height: 1.6;
            max-width: 450px;
            margin-top: 20px;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Dark mode — latar gelap, cangkir tetap putih */
        html.dark body { background-color: #17140f; color: #cbb9a3; }
        html.dark .text-quote { color: #d8c7ad; }
        html.dark .saucer,
        html.dark .cup { box-shadow: inset 0 0 10px rgba(0,0,0,0.25), 0 10px 20px rgba(0,0,0,0.4); }
    </style>
</head>
<body>

    <div class="container">
        <!-- Area Animasi Cangkir -->
        <div class="cup-container">
            <!-- Efek Uap -->
            <div class="vapour">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
            <!-- Badan Cangkir -->
            <div class="cup">
                <div class="tea"></div>
                <div class="handle"></div>
            </div>
            <!-- Tatakan Cangkir -->
            <div class="saucer"></div>
        </div>

        <!-- Teks Kalimat -->
        <p class="text-quote">
            "Mari kita rehat sejenak dengan meminum segelas teh atau kopi hangat"
        </p>
    </div>

</body>
</html>