<?php
function encryptText($text, $key) {
    $encryptedText = '';
    $keyLength = strlen($key);
    
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $shift = 0; // Set default shift untuk karakter non-alphabet
        
        if (ctype_alpha($char)) {
            $shift = ord(strtolower($key[$i % $keyLength])) - ord('a');
            $isUpperCase = ctype_upper($char);
            $char = strtolower($char);
            $position = ord($char) - ord('a');
            $newPosition = ($position + $shift) % 26;
            $newChar = chr($newPosition + ord('a'));
            
            if ($isUpperCase) {
                $newChar = strtoupper($newChar);
            }
        } else {
            $newChar = $char; // Karakter non-alphabet tidak diubah
        }
        
        $encryptedText .= $newChar;
    }
    
    return $encryptedText;
}

function decryptText($text, $key) {
    $decryptedText = '';
    $keyLength = strlen($key);
    
    for ($i = 0; $i < strlen($text); $i++) {
        $char = $text[$i];
        $shift = 0; // Set default shift untuk karakter non-alphabet
        
        if (ctype_alpha($char)) {
            $shift = ord(strtolower($key[$i % $keyLength])) - ord('a');
            $isUpperCase = ctype_upper($char);
            $char = strtolower($char);
            $position = ord($char) - ord('a');
            $newPosition = ($position - $shift + 26) % 26; // Perbaikan di sini
            $newChar = chr($newPosition + ord('a'));
            
            if ($isUpperCase) {
                $newChar = strtoupper($newChar);
            }
        } else {
            $newChar = $char; // Karakter non-alphabet tidak diubah
        }
        
        $decryptedText .= $newChar;
    }
    
    return $decryptedText;
}

$text = ''; // Masukkan teks yang ingin dienkripsi/didekripsi di sini
$key = 'GITA'; // Kunci enkripsi

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["text"])) {
    $text = $_POST["text"];
    if (isset($_POST["operation"]) && $_POST["operation"] == "encrypt") {
        $encryptedText = encryptText($text, $key);
    } elseif (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") {
        $decryptedText = decryptText($text, $key);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enkripsi dan Dekripsi Teks</title>
    <!-- Tautan gaya Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 50px;">
        <h1>Enkripsi dan Dekripsi Teks Menggunakan Vigenere Cipher</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin-top: 20px;">
            <div class="form-group">
                <label for="text">Masukkan teks:</label>
                <input type="text" class="form-control" name="text" id="text" value="<?php echo $text; ?>">
            </div>
            <div class="form-group">
                <label class="radio-inline">
                    <input type="radio" name="operation" value="encrypt" <?php if (!isset($_POST["operation"]) || (isset($_POST["operation"]) && $_POST["operation"] == "encrypt")) echo "checked"; ?>> Enkripsi
                </label>
                <label class="radio-inline">
                    <input type="radio" name="operation" value="decrypt" <?php if (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") echo "checked"; ?>> Dekripsi
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Proses</button>
        </form>

        <?php if (!empty($encryptedText) || !empty($decryptedText)): ?>
            <div class="result" style="margin-top: 20px;">
                <?php if (isset($_POST["operation"]) && $_POST["operation"] == "encrypt"): ?>
                    <h2>Hasil Enkripsi</h2>
                <?php elseif (isset($_POST["operation"]) && $_POST["operation"] == "decrypt"): ?>
                    <h2>Hasil Dekripsi</h2>
                <?php endif; ?>
                <p>Input: <?php echo $text; ?></p>
                <p>Output: <?php echo (isset($_POST["operation"]) && $_POST["operation"] == "decrypt") ? $decryptedText : $encryptedText; ?></p>
            </div>
        <?php endif; ?>

        <a href="Caesar.php" style="margin-top: 20px;"><button class="btn btn-default">Enkripsi Tahap Pertama</button></a>
    </div>

    <!-- Tautan script Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
