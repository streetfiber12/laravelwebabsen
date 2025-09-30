<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ $_token }}">
    <title>Verifikasi Lokasi</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f0f0f0; margin: 0; flex-direction: column; text-align: center; }
        .container { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        p { color: #666; }
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 30px; height: 30px; animation: spin 1s linear infinite; margin-top: 20px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .error { color: red; margin-top: 15px; }
        .success { color: green; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 id="status-title">Memverifikasi Lokasi Anda...</h1>
        <p id="status-text">Mohon izinkan akses lokasi di browser Anda. Kami sedang mencoba mendapatkan koordinat Anda.</p>
        <div id="loader" class="loader"></div>
        <p id="error-message" class="error" style="display:none;"></p>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const statusTitle = document.getElementById('status-title');
        const statusText = document.getElementById('status-text');
        const loader = document.getElementById('loader');
        const errorMessage = document.getElementById('error-message');

        function sendLocationToServer(latitude, longitude) {
            statusTitle.textContent = "Lokasi Ditemukan!";
            statusText.textContent = "Mengirim lokasi Anda untuk verifikasi...";
            loader.style.display = 'none';

            fetch('/geolocation-check', { // Menggunakan route khusus untuk pengiriman lokasi
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    latitude: latitude,
                    longitude: longitude
                })
            })
            .then(response => {
                if (response.ok) {
                    // Jika server merespons OK (lokasi diizinkan), reload halaman
                    // Ini akan memicu middleware lagi dan kali ini akan lolos
                    window.location.reload();
                } else {
                    // Jika server merespons error (lokasi tidak diizinkan), tampilkan pesan
                    return response.json().then(err => {
                        errorMessage.textContent = err.message || 'Akses ditolak karena lokasi tidak sesuai.';
                        errorMessage.style.display = 'block';
                        statusTitle.textContent = "Akses Ditolak";
                        statusText.textContent = "Anda tidak berada di lokasi yang diizinkan.";
                    });
                }
            })
            .catch(error => {
                console.error('Error sending location:', error);
                errorMessage.textContent = 'Terjadi kesalahan saat berkomunikasi dengan server.';
                errorMessage.style.display = 'block';
                statusTitle.textContent = "Terjadi Kesalahan";
                statusText.textContent = "Silakan coba lagi atau hubungi administrator.";
            });
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    // Lokasi berhasil didapatkan
                    sendLocationToServer(position.coords.latitude, position.coords.longitude);
                },
                function(error) {
                    // Lokasi ditolak atau tidak bisa didapatkan
                    loader.style.display = 'none';
                    statusTitle.textContent = "Akses Lokasi Ditolak!";
                    if (error.code === error.PERMISSION_DENIED) {
                        errorMessage.textContent = "Anda menolak akses lokasi. Aplikasi ini membutuhkan akses lokasi untuk berfungsi.";
                    } else if (error.code === error.POSITION_UNAVAILABLE) {
                        errorMessage.textContent = "Informasi lokasi tidak tersedia. Coba lagi.";
                    } else if (error.code === error.TIMEOUT) {
                        errorMessage.textContent = "Permintaan lokasi habis waktu. Pastikan koneksi internet stabil.";
                    } else {
                        errorMessage.textContent = "Terjadi kesalahan tidak dikenal saat mendapatkan lokasi.";
                    }
                    errorMessage.style.display = 'block';
                    statusText.textContent = "Tidak dapat melanjutkan tanpa lokasi yang valid.";
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
            );
        } else {
            // Browser tidak mendukung Geolocation API
            loader.style.display = 'none';
            statusTitle.textContent = "Browser Tidak Mendukung!";
            errorMessage.textContent = "Browser Anda tidak mendukung fitur Geolocation. Silakan gunakan browser lain.";
            errorMessage.style.display = 'block';
            statusText.textContent = "";
        }
    </script>
</body>
</html>