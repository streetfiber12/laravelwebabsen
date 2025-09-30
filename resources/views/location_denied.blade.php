<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f8d7da; color: #721c24; margin: 0; flex-direction: column; text-align: center; }
        .container { background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #721c24; }
        p { color: #721c24; }
        .refresh-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        .refresh-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Akses Ditolak!</h1>
        <p>Anda tidak berada di lokasi yang diizinkan untuk mengakses website ini.</p>
        <p>Jarak Anda dari lokasi yang diizinkan: **{{ $distance ?? 'N/A' }} meter**.</p>
        <p>Radius yang diizinkan: **{{ $allowed_radius ?? 'N/A' }} meter**.</p>
        <p>Silakan kembali ke area yang ditentukan (SMA 1) untuk melanjutkan.</p>
        <button class="refresh-button" onclick="window.location.reload();">Coba Lagi</button>
    </div>
</body>
</html>