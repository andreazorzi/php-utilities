# PHP Utilities
A useful collection of php plugins

## Plugin
-   [File Uploader](#file-uploader)

<hr>

## File Uploader
Is a plugin that allows you to upload and save files quickly with php

### Example

    include("file-uploader.php");

    $settings = array(
        "accept" => array(".csv", ".xls", ".xlsx"),
        "nameformat" => "{filename}_{t}-{i}.{ext}",
        "iterator" => 0
    );

    // Save a single file
    singleFileUpload($_FILES["file"], "file/", $settings);

    // Save multiple files
    multipleFileUpload($_FILES["multiple-file"], "file/", $settings);


## Slug Generator
A simple url slug generator

### Example

    include("url-slug-generator.php");

    $urlslug = generateUrlSlug("Page Title: example"); // page-title-example
