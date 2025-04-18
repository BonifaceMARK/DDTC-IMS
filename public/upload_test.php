<?php
if (isset($_FILES['file'])) {
    var_dump($_FILES['file']);
} else {
    echo "No file uploaded.";
}
