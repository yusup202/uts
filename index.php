<?php 
// Memanggil koneksi
include 'koneksi.php'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS - Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header-area">
            <h1>Data Mahasiswa</h1>
            <p>Kelola data dan informasi akademik mahasiswa</p>
        </div>

        <div class="action-bar">
            <input type="text" class="search-box" placeholder="Cari nama atau NIM...">
            <a href="form.php" class="btn-add">
                <span>+</span> Tambah Data
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>NO</th>
                    <th>FOTO</th>
                    <th>NIM</th>
                    <th>NAMA LENGKAP</th>
                    <th>JURUSAN</th>
                    <th style="text-align: center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY id DESC");
                $no = 1;
                
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)) {
                        $foto_path = !empty($row['foto']) ? "uploads/".$row['foto'] : "https://via.placeholder.com/150";
                        
                        echo "<tr>
                            <td>".$no++."</td>
                            <td>
                                <img src='".$foto_path."' class='student-photo' alt='Foto Profil'>
                            </td>
                            <td><b>".$row['nim']."</b></td>
                            <td>".$row['nama']."</td>
                            <td>
                                <span style='background: #eef2ff; color: #5d5fef; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;'>
                                    ".$row['jurusan']."
                                </span>
                            </td>
                            <td class='action-links' style='text-align: center;'>
                                <a href='form.php?id=".$row['id']."' class='edit-icon' title='Ubah Data'>✏️</a>
                                <a href='proses.php?hapus=".$row['id']."' class='delete-icon' title='Hapus Data' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>🗑️</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' align='center' style='padding: 40px; color: #999;'>Belum ada data mahasiswa.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>