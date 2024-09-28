<?php
/*
Plugin Name: SFTP Integration
Plugin URI: https://github.com/adriancamaj/sftp-wordpress-plugin
Description: Automates secure file uploads and downloads via SFTP.
Version: 1.0
Author: sharkware.io llc
Author URI: https://sharkware.io
License: GPL3
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use phpseclib3\Net\SFTP;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Shortcode to display the upload form
add_shortcode('sftp_upload_form', 'sftp_upload_form_handler');

function sftp_upload_form_handler()
{
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        echo 'You must be logged in to upload files.';
        return;
    }

    // Check user capabilities
    if (!current_user_can('upload_files')) {
        echo 'You do not have permission to upload files.';
        return;
    }

    // Handle file upload
    if (isset($_POST['submit'])) {
        // Nonce verification for security
        if (!wp_verify_nonce($_POST['sftp_upload_nonce'], 'sftp_upload')) {
            echo 'Nonce verification failed.';
            return;
        }

        $sftp = new SFTP($_ENV['SFTP_HOST']);
        if (!$sftp->login($_ENV['SFTP_USER'], $_ENV['SFTP_PASS'])) {
            echo 'SFTP Login Failed';
            return;
        }

        $uploadedfile = $_FILES['upload_file'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $remote_file = $_ENV['SFTP_REMOTE_PATH'] . basename($movefile['file']);
            $local_file = $movefile['file'];

            if ($sftp->put($remote_file, $local_file, SFTP::SOURCE_LOCAL_FILE)) {
                echo 'File uploaded successfully.';
                // Delete the local file after upload
                unlink($local_file);
            } else {
                echo 'Failed to upload file to SFTP server.';
            }
        } else {
            echo 'Error uploading file: ' . $movefile['error'];
        }
    }

    // Display the upload form
    ?>
    <form enctype="multipart/form-data" method="POST">
        <?php wp_nonce_field('sftp_upload', 'sftp_upload_nonce'); ?>
        <input type="file" name="upload_file" required />
        <input type="submit" name="submit" value="Upload" />
    </form>
    <?php
}
