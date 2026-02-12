<?php
$images = glob("uploads/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
$captions = file_exists("captions.json")
    ? json_decode(file_get_contents("captions.json"), true)
    : [];

if (isset($_GET["delete"])) {
    $file = $_GET["delete"];
    if (file_exists($file)) {
        unlink($file);
        unset($captions[$file]);
        file_put_contents("captions.json", json_encode($captions));
        header("Location: manage.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<body>

<h2>Manage Images</h2>

<table border="1" cellpadding="10">
<tr>
    <th>Image</th>
    <th>Caption</th>
    <th>Action</th>
</tr>

<?php foreach ($images as $img): ?>
<tr>
    <td><img src="<?= $img ?>" width="120"></td>
    <td><?= $captions[$img] ?? "No caption" ?></td>
    <td>
        <a href="?delete=<?= urlencode($img) ?>" 
           onclick="return confirm('Delete this image?')">
           🗑 Delete
        </a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<p><a href="index.php">⬅ Back to Slider</a></p>

</body>
</html>
