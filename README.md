# SKKPD - Sistem Kredit Kegiatan Peserta Didik

## Overview

SKKPD adalah sistem penilaian kegiatan peserta didik berbasis poin yang dirancang untuk SMK TI Bali Global Denpasar. Sistem ini bertujuan untuk meningkatkan soft skills, kesiapan kerja, dan jiwa wirausaha siswa melalui berbagai kegiatan terstruktur.

## Features

- 🎯 Manajemen Poin Kegiatan
- 👥 Pengelolaan Data Siswa
- 📚 Kategorisasi Kegiatan
- 📊 Tracking Progress Siswa
- 🏆 Manajemen Sertifikat

## System Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Modern web browser

## Installation

1. Clone repository:

```bash
git clone https://github.com/yourusername/skkpd.git
```

2. Import database:

```bash
mysql -u username -p database_name < database/skkpd.sql
```

3. Configure database connection:

- Edit `koneksi.php` with your database credentials

```php
$koneksi = mysqli_connect("localhost", "username", "password", "database_name");
```

4. Set up web server:

- Point your web server to the project directory
- Ensure proper permissions are set

## Project Structure

```
skkpd/
├── bootstrap/
│   └── bootstrap.css
├── css/
├── images/
├── tambah/
├── ubah/
├── tampilan/
├── koneksi.php
├── login.php
└── README.md
```

## Modules

1. **Siswa Management**

   - CRUD operations for student data
   - View student activities and points

2. **Kegiatan Management**

   - Manage activity categories
   - Track student participation
   - Point allocation

3. **User Management**
   - Operator access control
   - Student login system
   - Role-based permissions

## Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- SMK TI Bali Global Denpasar
- Bootstrap Team
- Contributors and Maintainers
