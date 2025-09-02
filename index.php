<?php
session_start();
if (isset($_POST['submit'])) {
    require_once 'proccess.php';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Class Meeting OSIS SMK Pertiwi Kuningan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --light: #f8f9fa;
            --dark: #212529;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        input, select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border 0.3s;
        }
        input:focus, select:focus {
            outline: none;
            border-color: var(--primary);
        }
        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s;
            width: 100%;
        }
        button:hover {
            background-color: var(--secondary);
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .modal-content a {
            display: inline-block;
            margin-top: 1rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }
        .modal-content a:hover {
            text-decoration: underline;
        }
        .admin-link {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--dark);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .admin-link:hover {
            background: #343a40;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pendaftaran Class Meeting</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="team_name">Nama Team</label>
                <input type="text" id="team_name" name="team_name" required>
            </div>
            <div class="form-group">
                <label for="leader_phone">Nomor Penanggung Jawab (WhatsApp)</label>
                <input type="text" id="leader_phone" name="leader_phone" required placeholder="Contoh: 6281234567890">
            </div>
            <div class="form-group">
                <label for="class">Kelas</label>
                <select id="class" name="class" required>
                    <option value="" disabled selected>Pilih Kelas</option>
                    <option value="X">X</option>
                    <option value="XI">XI</option>
                </select>
            </div>
            <div class="form-group">
                <label for="major">Jurusan</label>
                <select id="major" name="major" required>
                    <option value="" disabled selected>Pilih Jurusan</option>
                    <option value="RPL">Rekayasa Perangkat Lunak</option>
                    <option value="TKJ">Teknik Komputer & Jaringan</option>
                    <option value="TKR">Teknik Kendaraan Ringan</option>
                    <option value="TSM">Teknik Sepeda Motor</option>
                    <option value="LP">Layanan Perbankan</option>
                    <option value="ACP">Axio Class Program</option>
                    <option value="KTT">Kelas Khusus Toyota</option>
                    <option value="KTY">Kelas Khusus Yamaha</option>
                </select>
            </div>
            <div class="form-group">
                <label for="class_number">Nomor Kelas</label>
                <input type="number" id="class_number" name="class_number" min="1" max="10" required placeholder="Contoh: 1 untuk RPL 1">
            </div>
            <div class="form-group">
                <label for="competition">Jenis Lomba</label>
                <select id="competition" name="competition" required>
                    <option value="" disabled selected>Pilih Lomba</option>
                    <option value="Futsal">Futsal</option>
                    <option value="Free Fire">E-Sport Free Fire</option>
                    <option value="Mobile Legends">E-Sport Mobile Legends</option>
                </select>
            </div>
            <button type="submit" name="submit">Daftar Sekarang</button>
        </form>
    </div>

    <div id="successModal" class="modal">
        <div class="modal-content">
            <h2>Pendaftaran Berhasil!</h2>
            <p>Terima kasih telah mendaftar Class Meeting OSIS SMK Pertiwi Kuningan.</p>
            <a id="whatsappLink" href="#" target="_blank">Bergabung dengan Grup WhatsApp</a>
        </div>
    </div>

    <a href="admin.php" class="admin-link">Admin</a>

    <script>
        <?php if (isset($_SESSION['show_modal'])) : ?>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('successModal');
                const whatsappLink = document.getElementById('whatsappLink');
                
                // Set WhatsApp link based on competition
                const competition = "<?php echo $_SESSION['competition'] ?? '' ?>";
                let groupLink = '';
                
                if (competition === 'Futsal') {
                    groupLink = 'https://chat.whatsapp.com/EXAMPLE_FUTSAL_GROUP';
                } else if (competition === 'Free Fire') {
                    groupLink = 'https://chat.whatsapp.com/EXAMPLE_FREEFIRE_GROUP';
                } else if (competition === 'Mobile Legends') {
                    groupLink = 'https://chat.whatsapp.com/EXAMPLE_ML_GROUP';
                }
                
                whatsappLink.href = groupLink;
                modal.style.display = 'flex';
                
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                    }
                });
                
                <?php unset($_SESSION['show_modal']); ?>
            });
        <?php endif; ?>
    </script>
</body>
</html>