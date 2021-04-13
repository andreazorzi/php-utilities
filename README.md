# PHP Utilities
A useful collection of php plugins

## Plugin
-   [File Uploader](#file-uploader)
-   [Url Slug Generator](#url-slug-generator)

<hr>

## File Uploader
Is a plugin that allows you to upload and save files quickly with php.<br>
On windows servers the calculation of the absolute url of the uploaded file may not be correct.

### Example

    include("file-uploader.php");

    $settings = array(
        "accept" => array(".csv", ".xls", ".xlsx"),
        "nameformat" => "{filename}_{t}-{i}.{ext}",
        "iterator" => 0
    );

    // Save a single file
    $singleFile = FileUpload($_FILES["file"], "file/", $settings);

    // Save multiple files
    $multipleFile = multipleFileUpload($_FILES["multiple-file"], "file/", $settings);

## Url Slug Generator
A simple url slug generator

### Example

    include("url-slug-generator.php");

    $urlslug = generateUrlSlug("Page Title: example"); // page-title-example
