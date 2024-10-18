<?php
// Tabel substitusi karakter
$encryptionTable = [
    'A' => 'G',
    'B' => 'I',
    'C' => 'T',
    'D' => 'A',
    'E' => 'B',
    'F' => 'C',
    'G' => 'D',
    'H' => 'E',
    'I' => 'F',
    'J' => 'H',
    'K' => 'J',
    'L' => 'K',
    'M' => 'L',
    'N' => 'M',
    'O' => 'N',
    'P' => 'O',
    'Q' => 'P',
    'R' => 'Q',
    'S' => 'R',
    'T' => 'S',
    'U' => 'U',
    'V' => 'V',
    'W' => 'W',
    'X' => 'X',
    'Y' => 'Y',
    'Z' => 'Z'
];

// Fungsi untuk mengenkripsi teks
function encryptText($text, $table) {
    $encryptedText = "";
    $text = strtoupper($text); // Konversi teks ke huruf besar

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        // Periksa apakah karakter ada dalam tabel substitusi
        if (array_key_exists($char, $table)) {
            $encryptedText .= $table[$char];
        } else {
            // Jika karakter tidak ada dalam tabel substitusi, biarkan karakter asli
            $encryptedText .= $char;
        }
    }

    return $encryptedText;
}

// Fungsi untuk mendekripsi teks
function decryptText($text, $table) {
    $decryptedText = "";

    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        // Cari karakter asli dalam tabel substitusi
        $originalChar = array_search($char, $table);
        if ($originalChar !== false) {
            $decryptedText .= $originalChar;
        } else {
            // Jika karakter tidak ada dalam tabel substitusi, biarkan karakter asli
            $decryptedText .= $char;
        }
    }

    return $decryptedText;
}

// Inisialisasi variabel
$text = "";
$processedText = "";
$operation = "encrypt"; // Default operation is encryption

// Memproses input saat formulir dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $text = $_POST["text"];
    $operation = $_POST["operation"];

    if ($operation == "encrypt") {
        $processedText = encryptText($text, $encryptionTable);
    } elseif ($operation == "decrypt") {
        $processedText = decryptText($text, $encryptionTable);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enkripsi dan Dekripsi Teks</title>
    <!-- Tambahkan link CSS untuk Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Enkripsi dan Dekripsi Teks Menggunakan Caesar Cipher</h1>
        <form method="post" action="">
            <div class="form-group">
                <label for="text">Masukkan Teks:</label>
                <!-- Ganti input dengan textarea untuk menampung banyak teks -->
                <textarea class="form-control" rows="5" id="text" name="text"><?php echo $text; ?></textarea>
            </div>
            <div class="form-group">
                <!-- Tambahkan radio button untuk memilih enkripsi atau dekripsi -->
                <label class="radio-inline"><input type="radio" name="operation" value="encrypt" <?php if ($operation == "encrypt") echo "checked"; ?>>Enkripsi</label>
                <label class="radio-inline"><input type="radio" name="operation" value="decrypt" <?php if ($operation == "decrypt") echo "checked"; ?>>Dekripsi</label>
            </div>
            <button type="submit" class="btn btn-primary">Proses</button>
        </form>

        <?php if (!empty($processedText)) : ?>
            <div class="result">
                <?php if ($operation == "encrypt") : ?>
                    <h2>Hasil Enkripsi:</h2>
                <?php elseif ($operation == "decrypt") : ?>
                    <h2>Hasil Dekripsi:</h2>
                <?php endif; ?>
                <p><?php echo $processedText; ?></p>
            </div>
        <?php endif; ?>

        <a href="Vigner.php"><button class="btn btn-default">Enkripsi Tahap Kedua</button></a>
    </div>

    <!-- Tambahkan script JS untuk Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>