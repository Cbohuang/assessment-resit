<form action="upload.php" method="post" enctype="multipart/form-data">
    Choose your files：
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Start to Upload" name="submit">
</form>
<?php
if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // 檢查檔案大小、類型等
    // ...

    // 嘗試上傳檔案
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "File ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). "Success";
        
        // 檔案上傳成功後，連接資料庫
        $servername = "localhost";
        $username = "root";
        $password = "qwerty";
        $dbname = "File";

        // 使用 mysqli 或 PDO 建立連接
        $conn = new mysqli($servername, $username, $password, $dbname);

        // 檢查連接
        if ($conn->connect_error) {
            die("Fail connection: " . $conn->connect_error);
        }

        // 使用預備語句防止 SQL 注入
        $stmt = $conn->prepare("INSERT INTO Files (name, path) VALUES (?, ?)");
        $stmt->bind_param("ss", $fileName, $filePath);

        $filePath = $target_file;
        $fileName = basename($_FILES["fileToUpload"]["name"]);

        if ($stmt->execute()) {
            echo "New document uploaded  success";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();

    } else {
        echo "Unknown Error";
    }
}
?>
