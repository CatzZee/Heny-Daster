<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Harap tunggu</title>
    <style>
       /* Container supaya loader + teks benar-benar di tengah layar */
            .loader-container {
            display: flex;
            flex-direction: column;   /* arah vertikal: teks di atas, loader di bawah */
            justify-content: center;  /* vertical centering */
            align-items: center;      /* horizontal centering */
            gap: 15px;                /* jarak antara teks dan loader */
            height: 100vh;            /* full page height */
            width: 100vw;             /* full page width */
            background: #f5f5f5;
            }

            /* Loader bulatan */
            .loader {
            display: flex;
            gap: 10px;
            }

            .loader div {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: linear-gradient(45deg, #aeaeae, #b5bbbf);
            animation: bounce 1s infinite ease-in-out;
            }

            /* Delay tiap lingkaran */
            .loader div:nth-child(1) { animation-delay: 0s; }
            .loader div:nth-child(2) { animation-delay: 0.2s; }
            .loader div:nth-child(3) { animation-delay: 0.4s; }
          

            /* Animasi naik turun */
            @keyframes bounce {
            0%, 80%, 100% { transform: scale(0.5); opacity: 0.5; }
            40% { transform: scale(1); opacity: 1; }
            }

            /* Teks loader */
            .loader-text {
            font-size: 60px;
            font-weight: bold;
            color: #ff9cc7;
            font-family: sans-serif;
            }




    </style>
</head>
<body>
        <div class="loader-container">
  <span class="loader-text">NEXT TO MEET YOU</span>
  <div class="loader">
    <div></div>
    <div></div>
    <div></div>
  
  </div>
</div>


    <!--<div class="spinner">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    </div>-->
</body>
</html>