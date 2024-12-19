# Gunakan image FrankenPHP resmi sebagai base image
FROM dunglas/frankenphp:latest

# Salin semua file aplikasi ke dalam container
COPY . /app

# Pindah ke direktori aplikasi
WORKDIR /app

# Salin file konfigurasi FrankenPHP
COPY frankenphp.yaml /etc/frankenphp.yaml

# Pastikan direktori writable memiliki izin yang tepat
RUN chmod -R 777 /app/writable

# Gunakan Caddy untuk menjalankan aplikasi
#CMD ["frankenphp", "--config", "/etc/frankenphp.yaml", "--port", "8080"]
