<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Hello</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            overflow: hidden;
            background: #1a1a1a;
        }

        .loading-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
        }

        .zipper-top, .zipper-bottom {
            position: absolute;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(135deg, #ffb6d9 0%, #ffc9e3 50%, #ffe5f1 100%);
            transition: transform 2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: inset 0 0 50px rgba(255, 255, 255, 0.3);
        }

        .zipper-top {
            top: 0;
            transform-origin: center top;
            clip-path: polygon(0 0, 100% 0, 100% 100%, 50% calc(100% - 15px), 0 100%);
        }

        .zipper-bottom {
            bottom: 0;
            transform-origin: center bottom;
            clip-path: polygon(0 0, 50% 15px, 100% 0, 100% 100%, 0 100%);
        }

        .loading-container.open .zipper-top {
            transform: translateY(-100%) rotateX(15deg);
        }

        .loading-container.open .zipper-bottom {
            transform: translateY(100%) rotateX(-15deg);
        }

        /* Gigi Resleting Atas */
        .zipper-teeth-top {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30px;
            z-index: 10;
            transition: opacity 0.8s ease;
        }

        /* Gigi Resleting Bawah */
        .zipper-teeth-bottom {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 30px;
            z-index: 10;
            transition: opacity 0.8s ease;
        }

        .loading-container.open .zipper-teeth-top,
        .loading-container.open .zipper-teeth-bottom {
            opacity: 0;
        }

        .tooth {
            position: absolute;
            width: 8px;
            height: 15px;
            background: #333;
            border-radius: 2px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.5);
        }

        .tooth-top {
            bottom: 0;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .tooth-bottom {
            top: 0;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        /* Slider/Pegangan Resleting */
        .zipper-slider {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90px;
            height: 70px;
            z-index: 30;
            transition: all 2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .slider-body {
            position: relative;
            width: 60px;
            height: 100%;
            background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.7);
            margin: 0 auto;
        }

        .slider-body::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 35px;
            height: 35px;
            background: #444;
            border-radius: 50%;
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.8);
        }

        .slider-body::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 15px;
            height: 15px;
            background: #666;
            border-radius: 50%;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.5);
        }

        .slider-pull {
            position: absolute;
            top: 50%;
            right: -40px;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #333 0%, #1a1a1a 100%);
            border-radius: 50%;
            box-shadow: 0 3px 10px rgba(0,0,0,0.7);
        }

        .slider-pull::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 3px solid #555;
            border-radius: 50%;
        }

        .loading-container.open .zipper-slider {
            left: 110%;
            transform: translate(-50%, -50%) scale(0.3) rotate(360deg);
            opacity: 0;
        }

        /* Track Tengah Horizontal */
        .zipper-center-track {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            width: 100%;
            height: 4px;
            background: #1a1a1a;
            z-index: 5;
            box-shadow: 0 0 10px rgba(0,0,0,0.8);
            transition: opacity 0.8s ease;
        }

        .loading-container.open .zipper-center-track {
            opacity: 0;
        }

        .loading-text {
            position: absolute;
            top: 58%;
            left: 50%;
            transform: translateX(-50%);
            color: #333;
            font-size: 20px;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(255,255,255,0.5);
            z-index: 15;
            opacity: 1;
            transition: opacity 0.8s ease;
            letter-spacing: 2px;
        }

        .loading-container.open .loading-text {
            opacity: 0;
        }

        .main-content {
            display: block;
            width: 100%;
            height: 100vh;
            background: white;
            opacity: 0;
            transition: opacity 0.8s ease;
            position: relative;
            overflow-x: hidden;
        }

        .main-content.show {
            opacity: 1;
        }

        /* Kotak pink di background */
        .kotak1, .kotak2, .kotak3 {
            position: absolute;
            border-radius: 70px;
            transform: rotate(-27deg);
        }

        .kotak1 {
            width: 500px;
            height: 650px;
            background: #ffc9e0;
            bottom: -200px;
            right: -50px;
            z-index: 1;
        }

        .kotak2 {
            width: 390px;
            height: 500px;
            background: #ffb3d4;
            bottom: -20px;
            right: -160px;
            opacity: 0.7;
            z-index: 2;
        }

        .kotak3 {
            width: 460px;
            height: 590px;
            background: #ff9cc7;
            bottom: -350px;
            right: 10px;
            opacity: 0.7;
            z-index: 3;
        }

        /* Card Login */
        .card {
            width: 400px;
            height: 500px;
            border-radius: 50px;
            box-shadow: 5px 5px 20px rgba(0,0,0,0.1);
            border: 1.5px solid #cbcbcb;
            z-index: 4;
            background: white;
        }

        .card-body p {
            color: #ff9cc7;
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin-top: 10px;
        }

        .card-body .abu {
            color: #a0a0a0;
            text-align: center;
            margin-top: -15px;
            font-size: 14px;
        }

        .form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
        }


        .form .form-control {
            padding: 10px 20px;
            border-radius: 50px;
            border: 1.5px solid #cbcbcb;
            width: 100%;
            max-width: 300px;
            margin-top: 20px;
        }

        .button {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .button .btn {
            background: #ff9cc7;
            border: none;
            width: 100px;
            border-radius: 13px;
            color: white;
            margin-top: 40px;
        }

        /* Hero Kolom Kanan */
        .hero h1 {
            font-size: 65px;
            color: #ff9cc7;
            font-weight: bold;
            margin-top: -250px;
            margin-right: 150px;
            text-align: left;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 35px;
            }
        }

        input::placeholder {
            color: rgb(128, 128, 128); 
            font-style: italic; 
        }

        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body>
    <div class="loading-container" id="loadingContainer">
        <div class="zipper-top">
            <div class="zipper-teeth-top" id="teethTop"></div>
        </div>
        
        <div class="zipper-bottom">
            <div class="zipper-teeth-bottom" id="teethBottom"></div>
        </div>
        
        <div class="zipper-center-track"></div>
        
        <div class="zipper-slider">
            <div class="slider-body"></div>
            <div class="slider-pull"></div>
        </div>
        
        

    </div>

    <div class="main-content" id="mainContent">
        <!-- Background Pink -->
        <div class="kotak1"></div>
        <div class="kotak2"></div>
        <div class="kotak3"></div>

        <!-- Konten 2 Kolom -->
        <div class="container vh-100 d-flex align-items-center position-relative" style="z-index:4;">
            <div class="row w-100">

                <!-- Kolom Login -->
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="card p-4">
                        <div class="card-body">
                            <p>Please Login</p>
                            <div class="abu">*Masukkan sesuai ketentuan</div>

                            <!-- form -->
                            <div class="form">
                                <input type="text" id="username" class="form-control" placeholder="Masukkan Username">
                                <input type="password" id="inputPassword5" class="form-control" placeholder="Masukkan Password">
                            </div>

                            <div class="button mt-3">
                                <button type="button" class="btn">Masuk</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Hero -->
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="hero text-center">
                        <h1>HELLO, <br>WELCOME!</h1>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Generate gigi-gigi resleting horizontal
        const teethTop = document.getElementById('teethTop');
        const teethBottom = document.getElementById('teethBottom');
        const spacing = 12;
        const teethCount = Math.ceil(window.innerWidth / spacing);
        
        for (let i = 0; i < teethCount; i++) {
            // Gigi atas
            const toothTop = document.createElement('div');
            toothTop.className = 'tooth tooth-top';
            toothTop.style.left = (i * spacing) + 'px';
            teethTop.appendChild(toothTop);
            
            // Gigi bawah (offset setengah spacing)
            const toothBottom = document.createElement('div');
            toothBottom.className = 'tooth tooth-bottom';
            toothBottom.style.left = (i * spacing + spacing/2) + 'px';
            teethBottom.appendChild(toothBottom);
        }

        // Trigger opening animation
        window.addEventListener('load', () => {
            setTimeout(() => {
                const container = document.getElementById('loadingContainer');
                const mainContent = document.getElementById('mainContent');
                
                container.classList.add('open');
                
                setTimeout(() => {
                    mainContent.classList.add('show');
                }, 1000);
                
                setTimeout(() => {
                    container.style.display = 'none';
                }, 2500);
            }, 1500);
        });
    </script>
</body>
</html>