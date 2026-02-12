<?php
$captions = file_exists("captions.json")
    ? json_decode(file_get_contents("captions.json"), true)
    : [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "uploads/";
    $fileName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $targetDir . $fileName;

    $allowed = ["jpg","jpeg","png","gif"];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $captions[$targetFile] = $_POST["caption"];
            file_put_contents("captions.json", json_encode($captions));
            $message = "✅ Uploaded with caption!";
        } else {
            $message = "❌ Upload failed.";
        }
    } else {
        $message = "❌ Only JPG, PNG, GIF allowed.";
    }
}
?>

<!DOCTYPE html>
<html>
<body>

<h2>Upload Image</h2>

<?php if(isset($message)) echo "<p>$message</p>"; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="image" required><br><br>
    <input type="text" name="caption" placeholder="Enter image title/caption" required><br><br>
    <button type="submit">Upload</button>
</form>

<p><a href="index.php">⬅ Back to Slider</a></p>

</body>
</html>
