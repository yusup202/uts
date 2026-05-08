<?php
include 'koneksi.php';

// LOGIKA HAPUS
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    // Ambil nama file foto sebelum data dihapus
    $cari = mysqli_query($conn, "SELECT foto FROM mahasiswa WHERE id='$id'");
    $dt = mysqli_fetch_assoc($cari);
    
    // Hapus foto fisiknya jika ada
    if(!empty($dt['foto']) && file_exists("uploads/".$dt['foto'])) {
        unlink("uploads/".$dt['foto']);
    }

    $query = mysqli_query($conn, "DELETE FROM mahasiswa WHERE id='$id'");
    header("Location: index.php");
    exit;
}

// LOGIKA SIMPAN & EDIT
if(isset($_POST['btnSimpan'])) {
    $id      = $_POST['id'];
    $nim     = $_POST['nim'];
    $nama    = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    
    $foto_nama = $_FILES['foto']['name'];
    $tmp_name  = $_FILES['foto']['tmp_name'];
    
    // Inisialisasi nama file foto (kosongkan dulu)
    $nama_baru = "";

    // Proses Upload Foto jika ada file yang dipilih
    if($foto_nama != "") {
        $ekstensi = pathinfo($foto_nama, PATHINFO_EXTENSION);
        // Ganti nama otomatis menggunakan time() agar unik (Poin 4)
        $nama_baru = time() . "_" . uniqid() . "." . $ekstensi; 
        
        // Pastikan folder uploads ada
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }
        
        move_uploaded_file($tmp_name, "uploads/" . $nama_baru);

        // Jika mode EDIT dan upload foto baru, hapus foto lama agar tidak menumpuk
        if($id != "") {
            $cari_lama = mysqli_query($conn, "SELECT foto FROM mahasiswa WHERE id='$id'");
            $dt_lama = mysqli_fetch_assoc($cari_lama);
            if(!empty($dt_lama['foto']) && file_exists("uploads/".$dt_lama['foto'])) {
                unlink("uploads/".$dt_lama['foto']);
            }
        }
    }

    if($id == "") { 
        // Mode TAMBAH BARU
        $sql = "INSERT INTO mahasiswa (nim, nama, jurusan, foto) VALUES ('$nim', '$nama', '$jurusan', '$nama_baru')";
    } else { 
        // Mode EDIT
        if($foto_nama != "") {
            // Update semua data termasuk foto baru
            $sql = "UPDATE mahasiswa SET nim='$nim', nama='$nama', jurusan='$jurusan', foto='$nama_baru' WHERE id='$id'";
        } else {
            // Update data tanpa mengganti foto yang sudah ada
            $sql = "UPDATE mahasiswa SET nim='$nim', nama='$nama', jurusan='$jurusan' WHERE id='$id'";
        }
    }

    $eksekusi = mysqli_query($conn, $sql);
    if($eksekusi) {
        echo "<script>alert('Data Berhasil Disimpan!'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>