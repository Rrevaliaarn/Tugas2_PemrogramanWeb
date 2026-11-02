<?php
// Aktifkan pelaporan error untuk mencegah layar putih (White Screen)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function hitungNilaiAkhir($tugas, $uts, $uas) {
    return ($tugas * 0.30) + ($uts * 0.30) + ($uas * 0.40);
}

function tentukanGrade($nilai) {
    if ($nilai >= 85) {
        return "A";
    } elseif ($nilai >= 75) {
        return "B";
    } elseif ($nilai >= 65) {
        return "C";
    } elseif ($nilai >= 50) {
        return "D";
    } else {
        return "E";
    }
}

function tentukanStatus($nilai) {
    return ($nilai >= 65) ? "Lulus" : "Tidak Lulus";
}

$hasil = false;
$error = "";
$nama = "";
$nim = "";
$tugas = "";
$uts = "";
$uas = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $tugas = $_POST["tugas"] ?? "";
    $uts = $_POST["uts"] ?? "";
    $uas = $_POST["uas"] ?? "";

    if ($nama == "" || $nim == "") {
        $error = "Nama dan NIM wajib diisi!";
    } elseif (!is_numeric($tugas) || !is_numeric($uts) || !is_numeric($uas)
        || $tugas < 0 || $tugas > 100
        || $uts < 0 || $uts > 100
        || $uas < 0 || $uas > 100) {
        $error = "Nilai harus berupa angka antara 0 sampai 100!";
    } else {
        $nilaiAkhir = hitungNilaiAkhir($tugas, $uts, $uas);
        $grade = tentukanGrade($nilaiAkhir);
        $status = tentukanStatus($nilaiAkhir);
        $hasil = true;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penghitung Nilai Mahasiswa</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 30px 15px;
            color: #263445;
        }

        .container {
            max-width: 550px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            color: #244c78;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 7px;
            border: 1px solid #ccd4df;
            border-radius: 7px;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            border: none;
            background: #244c78;
            color: white;
            font-size: 16px;
            border-radius: 7px;
            cursor: pointer;
        }

        button:hover {
            background: #183653;
        }

        .result {
            margin-top: 25px;
            padding: 20px;
            background: #edf5ff;
            border-radius: 10px;
        }

        .result h3 {
            color: #244c78;
            margin-top: 0;
        }

        .error {
            background: #ffe8e8;
            color: #b42318;
            padding: 12px;
            border-radius: 7px;
            margin-top: 15px;
        }

        .footer {
            text-align: center;
            color: #888;
            margin-top: 25px;
            font-size: 12px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Penghitung Nilai Mahasiswa</h2>
    <p class="subtitle">Program Perhitungan Nilai Akhir Mahasiswa</p>

    <form method="POST">

        <label>Nama Mahasiswa</label>
        <input type="text" name="nama" placeholder="Masukkan nama"
        value="<?= htmlspecialchars($nama) ?>" required>

        <label>NIM</label>
        <input type="text" name="nim" placeholder="Masukkan NIM"
        value="<?= htmlspecialchars($nim) ?>" required>

        <label>Nilai Tugas</label>
        <input type="number" name="tugas" min="0" max="100"
        step="any" placeholder="0 - 100"
        value="<?= htmlspecialchars($tugas) ?>" required>

        <label>Nilai UTS</label>
        <input type="number" name="uts" min="0" max="100"
        step="any" placeholder="0 - 100"
        value="<?= htmlspecialchars($uts) ?>" required>

        <label>Nilai UAS</label>
        <input type="number" name="uas" min="0" max="100"
        step="any" placeholder="0 - 100"
        value="<?= htmlspecialchars($uas) ?>" required>

        <button type="submit">Hitung Nilai</button>

    </form>

    <?php if ($error != ""): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($hasil): ?>
        <div class="result">
            <h3>Hasil Perhitungan</h3>

            <p>Nama: <?= htmlspecialchars($nama) ?></p>
            <p>NIM: <?= htmlspecialchars($nim) ?></p>
            <p>Nilai Tugas: <?= $tugas ?></p>
            <p>Nilai UTS: <?= $uts ?></p>
            <p>Nilai UAS: <?= $uas ?></p>

            <hr>

            <p>Nilai Akhir:
                <b><?= number_format($nilaiAkhir, 2) ?></b>
            </p>

            <p>Grade: <b><?= $grade ?></b></p>
            <p>Status: <b><?= $status ?></b></p>
        </div>
    <?php endif; ?>

    <div class="footer">
        Tugas 2 Pemrograman Berbasis Web
    </div>

</div>

</body>
</html>