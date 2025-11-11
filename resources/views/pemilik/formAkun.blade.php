<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Biodata</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f5f5f5;
      padding: 40px 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

  /* Sidebar (navbar kecil kiri pink) */
  .sidebar {
    background-color: #ffb6c1;
    width: 60px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
    gap: 15px;
  }

  .sidebar a {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    background-color: transparent;
    border-radius: 8px;
    transition: background-color 0.2s;
  }

  .sidebar a:hover {
    background-color: rgba(255, 255, 255, 0.3);
  }

  .sidebar svg {
    width: 22px;
    height: 22px;
    fill: white;
  }

    .container {
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      max-width: 700px;
      width: 100%;
    }

    .profile-section {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 40px;
    }

    .profile-picture {
      position: relative;
      width: 100px;
      height: 100px;
    }

    .avatar-circle {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 4px solid #4A90E2;
      background: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .avatar-icon {
      width: 50px;
      height: 50px;
      color: #FFB6C1;
    }

    .camera-button {
      position: absolute;
      bottom: 0;
      right: 0;
      width: 30px;
      height: 30px;
      background: #FFB6C1;
      border-radius: 50%;
      border: 3px solid white;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .photo-label {
      padding: 10px 25px;
      background: white;
      border: 2px solid #e0e0e0;
      border-radius: 25px;
      color: #999;
      font-size: 14px;
    }

    .form-title {
      font-size: 20px;
      color: #999;
      margin-bottom: 30px;
      font-weight: normal;
    }

    .form-group {
      margin-bottom: 25px;
    }

    .form-label {
      display: block;
      color: #999;
      font-size: 14px;
      margin-bottom: 8px;
    }

    .form-input {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 14px;
      transition: border-color 0.3s;
    }

    .form-input:focus {
      outline: none;
      border-color: #4A90E2;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .form-textarea {
      width: 100%;
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 14px;
      resize: vertical;
      min-height: 100px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-textarea:focus {
      outline: none;
      border-color: #4A90E2;
    }

    .submit-button {
      display: block;
      margin: 40px auto 0;
      padding: 12px 60px;
      background: linear-gradient(135deg, #FFB6C1, #FFA0B4);
      color: white;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(255, 182, 193, 0.3);
    }

    .submit-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 182, 193, 0.4);
    }

    @media (max-width: 600px) {
      .form-row {
        grid-template-columns: 1fr;
      }

      .profile-section {
        flex-direction: column;
        text-align: center;
      }
    }
  </style>
</head>
<body>

    <!-- Sidebar -->
<div class="sidebar">
  <a href="#">
    <!-- Icon Home -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-4v-7H9v7H5a2 2 0 0 1-2-2z"/>
    </svg>
  </a>
</div>
  <div class="container">
    <div class="profile-section">
      <div class="profile-picture">
        <div class="avatar-circle">
          <svg class="avatar-icon" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
          </svg>
        </div>
        <div class="camera-button">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="white">
            <path d="M12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5zm0-5c-0.83 0-1.5 0.67-1.5 1.5s0.67 1.5 1.5 1.5 1.5-0.67 1.5-1.5-0.67-1.5-1.5-1.5z"/>
            <path d="M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9z"/>
          </svg>
        </div>
      </div>
      <div class="photo-label">Foto Wajib Diisi!!!</div>
    </div>

    <h2 class="form-title">Masukkan Biodata Baru</h2>

    <form>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" class="form-input">
        </div>
        <div class="form-group">
          <label class="form-label">Nama Panggilan</label>
          <input type="text" class="form-input">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Tempat, Tanggal Lahir</label>
        <input type="text" class="form-input">
      </div>

      <div class="form-group">
        <label class="form-label">Alamat Lengkap</label>
        <textarea class="form-textarea"></textarea>
      </div>

      <button type="submit" class="submit-button">Kirim</button>
    </form>
  </div>
</body>
</html>