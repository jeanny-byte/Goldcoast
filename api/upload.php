<?php
header('Content-Type: application/json');

$target_dir = "../uploads/gallery/";
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$response = ['success' => false, 'message' => ''];

try {
    if (!isset($_FILES['images'])) {
        throw new Exception('No files uploaded');
    }

    // Create uploads directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $db = new PDO("mysql:host=localhost;dbname=goldcoast", "username", "password");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $uploaded_files = [];
    
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_type = $_FILES['images']['type'][$key];
        if (!in_array($file_type, $allowed_types)) {
            continue;
        }

        // Generate unique filename with timestamp
        $timestamp = time();
        $file_extension = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
        $file_name = uniqid() . '_' . $timestamp . '.' . $file_extension;
        $target_file = $target_dir . $file_name;
        
        // Additional security checks
        $check = getimagesize($tmp_name);
        if ($check === false) {
            throw new Exception('File is not a valid image.');
        }
        
        if ($_FILES['images']['size'][$key] > 10000000) { // 10MB limit
            throw new Exception('File is too large.');
        }
        
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Create thumbnails directory if it doesn't exist
            $thumb_dir = $target_dir . 'thumbnails/';
            if (!file_exists($thumb_dir)) {
                mkdir($thumb_dir, 0755, true);
            }
            
            // Create thumbnail
            $thumb_file = $thumb_dir . $file_name;
            createThumbnail($target_file, $thumb_file, 300); // 300px width
            
            // Store in database
            $stmt = $db->prepare("INSERT INTO gallery (image_url, thumbnail_url, event_date, description, file_size) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                '/uploads/gallery/' . $file_name,
                '/uploads/gallery/thumbnails/' . $file_name,
                $_POST['eventDate'],
                $_POST['description'],
                $_FILES['images']['size'][$key]
            ]);
            
            $uploaded_files[] = $file_name;
        }
    }
    
    $response['success'] = true;
    $response['message'] = 'Files uploaded successfully';
    $response['files'] = $uploaded_files;
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);

// Helper function to create thumbnails
function createThumbnail($source, $destination, $targetWidth) {
    $info = getimagesize($source);
    $width = $info[0];
    $height = $info[1];
    $type = $info[2];
    
    $targetHeight = floor($height * ($targetWidth / $width));
    
    switch ($type) {
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($source);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($source);
            break;
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($source);
            break;
        default:
            return false;
    }
    
    $thumb = imagecreatetruecolor($targetWidth, $targetHeight);
    
    // Preserve transparency for PNG images
    if ($type == IMAGETYPE_PNG) {
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    }
    
    imagecopyresampled($thumb, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
    
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumb, $destination, 80);
            break;
        case IMAGETYPE_PNG:
            imagepng($thumb, $destination, 8);
            break;
        case IMAGETYPE_GIF:
            imagegif($thumb, $destination);
            break;
    }
    
    imagedestroy($image);
    imagedestroy($thumb);
    
    return true;
}