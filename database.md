/**
[SimaSek Database]

@ Table Admin
    - id
    - email
    - password

@ Table Siswa
    - id
    - email
    - password
    - nama lengkap
    - tempat lahir
    - tanggal lahir
    - alamat
    - nis

Format NIS: tahun masuk + siswa keberapa

Admin default:

**/
CREATE TABLE user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    role varchar(100) NOT NULL,
    email varchar(100) NOT NULL,
    password varchar(100) NOT NULL,
    nama_lengkap varchar(100) NOT NULL,
    tempat_lahir varchar(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat varchar(100) NOT NULL,
    nis decimal(8,0) NOT NULL
);

INSERT INTO user(role, email, password, nama_lengkap, tempat_lahir, tanggal_lahir, alamat, nis) VALUES
("siswa", "oliver@simasek.edu", "0cc175b9c0f1b6a831c399e269772661", "Oliver Marvel Jonathan", "Pontianak", "1998-04-03", "Jl. Sudirman, Jakarta Pusat", 1235),
("admin", "bryan@simasek.edu", "0cc175b9c0f1b6a831c399e269772661", "Bryan Geraldo Lim", "Pontianak", "1998-04-03", "Jl. Menteng, Jakarta Pusat", 1234)