<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        html {
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Kotak pink di background */
        .kotak1,
        .kotak2,
        .kotak3 {
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
            box-shadow: 5px 5px 20px rgba(0, 0, 0, 0.1);
            border: 1.5px solid #cbcbcb;
            z-index: 4;
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
    </style>
</head>

<body>

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
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Masukkan Username" name="nama" value="{{ old('nama') }}" required
                                    autofocus>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan Password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="button mt-3">
                                    <button type="submit" class="btn">Masuk</button>
                                </div>
                            </form>
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

</body>

</html>
