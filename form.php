<?php 
include 'koneksi.php';

// Cek apakah mode edit atau tambah
$id = isset($_GET['id']) ? $_GET['id'] : "";
$nim = ""; $nama = ""; $jurusan = ""; $foto = "";

if ($id != "") {
    $query = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id='$id'");
    $data = mysqli_fetch_assoc($query);
    $nim = $data['nim'];
    $nama = $data['nama'];
    $jurusan = $data['jurusan'];
    $foto = $data['foto'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Mahasiswa - Modern UI</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS Tambahan */
        .form-card {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            font-size: 15px;
            transition: 0.3s;
            outline: none;
        }

        .form-control:focus {
            border-color: #5d5fef;
            box-shadow: 0 0 0 4px rgba(93, 95, 239, 0.1);
        }

        .file-input-wrapper {
            background: #f8f9ff;
            border: 2px dashed #d1d5ff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-save {
            flex: 2;
            background: linear-gradient(90deg, #5d5fef 0%, #8e91ff 100%);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-cancel {
            flex: 1;
            background: #f1f1f1;
            color: #666;
            text-align: center;
            padding: 14px;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 15px rgba(93,95,239,0.3); }
        .btn-cancel:hover { background: #e5e5e5; }
        
        .current-photo {
            margin-top: 10px;
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-area" style="text-align: center;">
            <h1><?php echo ($id == "") ? "Tambah Data" : "Ubah Data"; ?></h1>
            <p>Silakan isi formulir mahasiswa di bawah ini</p>
        </div>

        <div class="form-card">
            <form action="proses.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <div class="form-group">
                    <label>NIM Mahasiswa</label>
                    <input type="text" name="nim" class="form-control" placeholder="Contoh: 244051..." value="<?php echo $nim; ?>" required>
                </div>

                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" value="<?php echo $nama; ?>" required>
                </div>

                <div class="form-group">
                    <label>Jurusan</label>
                    <select name="jurusan" class="form-control" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <option value="Teknik Informatika" <?php if($jurusan == "Teknik Informatika") echo "selected"; ?>>Teknik Informatika</option>
                        <option value="Kimia" <?php if($jurusan == "Kimia") echo "selected"; ?>>Kimia</option>
                        <option value="Teknik Sipil" <?php if($jurusan == "Teknik Sipil") echo "selected"; ?>>Teknik Sipil</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Foto Profil</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="foto" <?php echo ($id == "") ? "required" : ""; ?>>
                        <p style="font-size: 12px; color: #888; margin-top: 5px;">*Format: JPG/PNG, Maksimal 2MB</p>
                    </div>
                    <?php if ($foto != ""): ?>
                        <div style="margin-top: 10px;">
                            <small style="color: #888;">Foto saat ini:</small><br>
                            <img src="uploads/<?php echo $foto; ?>" class="current-photo">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="btn-group">
                    <button type="submit" name="btnSimpan" class="btn-save">Simpan Data</button>
                    <a href="index.php" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>