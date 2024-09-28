# SFTP-Wordpress-Plugin
Automates secure file uploads and downloads via SFTP.

This plugin allows you to securely upload files from your WordPress site to a remote server using SFTP (Secure File Transfer Protocol). It's designed to be easy to install, configure, and use—even if you're new to WordPress or SFTP.

---
## Table of Contents
- [Features](#features)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Security Best Practices](#security-best-practices)
- [Troubleshooting](#troubleshooting)
- [Frequently Asked Questions](#frequently-asked-questions)
- [Support](#support)
- [Contributing](#contributing)
- [License](#license)

---
## Features
- **Secure File Uploads**: Upload files securely to a remote server via SFTP.
- **User-Friendly Interface**: Simple upload form that integrates seamlessly with your WordPress site.
- **Access Control**: Restrict file uploads to logged-in users with specific roles or permissions.
- **Customizable**: Easily modify settings to suit your needs.

---

## Prerequisites
Before you begin, ensure you have the following:

- **WordPress**: Version 5.0 or higher.
- **PHP**: Version 7.4 or higher.
- **Composer**: For managing PHP dependencies.
- **SFTP Server Credentials**: Hostname, username, password (or SSH key), and remote path.
- **phpseclib Library**: A PHP library for secure communications (installed via Composer).

---
## Installation
Follow these simple steps to install the SFTP Integration Plugin.

### Step 1: Download the Plugin
You can download the plugin from the GitHub repository.

- Click the green **Code** button and select **Download ZIP**.
- Alternatively, clone the repository using Git:

  ```
  git clone https://github.com/adriancamaj/SFTP-Wordpress-Plugin.git
  ```

### Step 2:Install Dependencies with Composer
Since the plugin uses external libraries, you'll need to install them using Composer.

- Navigate to the plugin directory:

  ```
  cd sftp-integration
  ```
- Run the following command to install dependencies:

  ```
  composer install
  ```

> [!NOTE]  
> If you don't have Composer installed on your server, you may need to install it or run this command locally and upload the directory to your server.

### Step 3: Upload the Plugin to WordPress
- Log in to your WordPress admin dashboard.
- Navigate to **Plugins** > **Add** New.
- Click on **Upload Plugin**.
- Choose the downloaded ZIP file (`SFTP-Wordpress-Plugin.zip`) and click **Install Now**.
  
### Step 4: Activate the Plugin
- After installation, click **Activate Plugin**.
- The plugin is now active on your WordPress site.

---
## Configuration
Configure the plugin to connect to your SFTP server.

### Step 1: Create a .env File
In the plugin directory (SFTP-Wordpress-Plugin), create a file named .env and add your SFTP credentials:
```
SFTP_HOST=your_sftp_host
SFTP_USER=your_username
SFTP_PASS=your_password
SFTP_REMOTE_PATH=/remote/path/
```
- **Replace** the placeholder values with your actual SFTP server details.
> [!WARNING]  
> Do not include quotes around the values.

### Step 2: Secure the `.env` File
To prevent sensitive information from being exposed:

- Add `.env` to your `.gitignore` file if you're using version control.
> [!IMPORTANT] 
> Ensure proper file permissions are set so that unauthorized users cannot access the file.

---
## Usage
Start using the plugin to upload files securely.

### Step 1: Add the Upload Form to a Page or Post
- Create or edit a page or post where you want the upload form to appear.
- Add the shortcode `[sftp_upload_form]` to the content area.
  ```
  [sftp_upload_form]
  ```
- Publish or update the page or post.

### Step 2: Upload Files
- Visit the page or post where you added the upload form.
- You should see a file upload field and an **Upload** button.
- Choose a file from your computer and click **Upload**.
- Upon successful upload, a confirmation message will appear.

---
## Security Best Practices
Keep your site and data secure by following these guidelines.

### Use SSH Keys Instead of Passwords
- Configure your SFTP server to use SSH key authentication.
- Update the plugin to use your SSH private key for authentication.
  ```
  use phpseclib3\Crypt\PublicKeyLoader;
  
  $key = PublicKeyLoader::loadPrivateKey('path/to/private/key');
  if (!$sftp->login($_ENV['SFTP_USER'], $key)) {
      echo 'SFTP Login Failed';
      return;
  }
  ```
- Update your `.env` file:
  ```
  SFTP_PRIVATE_KEY_PATH=/path/to/private/key
  ```
### Restrict User Access
- Ensure that only trusted users have access to the upload form.
- The plugin checks if a user is logged in and has the capability `upload_files`.

### Limit File Types
- Modify the allowed file types to prevent uploading potentially harmful files.
- Adjust the `$upload_overrides array` in the plugin code:
  ```
  $upload_overrides = array(
      'test_form' => false,
      'mimes' => array(
          'jpg|jpeg|jpe' => 'image/jpeg',
          'png' => 'image/png',
          'pdf' => 'application/pdf',
      ),
  );
  ```

### Keep Software Updated
- Regularly update WordPress, plugins, and dependencies to the latest versions.

---
## Troubleshooting
Having issues? Here's how to resolve common problems.

### SFTP Login Failed
- **Cause**: Incorrect SFTP credentials or server is unreachable.
- **Solution**: Verify your SFTP host, username, password (or SSH key), and network connectivity.

### File Upload Errors
- **Cause**: File exceeds maximum upload size or disallowed file type.
- **Solution**: Increase the upload size limit in `php.ini` and ensure the file type is allowed.

### Composer Dependencies Not Found
- **Cause**: directory is missing.
- **Solution**: Run `composer install` in the plugin directory.

### Permission Denied Errors
- **Cause**: Insufficient permissions on the SFTP server.
- **Solution**: Ensure the SFTP user has write permissions to the remote directory.

---

## Frequently Asked Questions

### Can I customize the upload form?
Yes! You can modify the HTML form in the `SFTP-Wordpress-Plugin.php` file to suit your needs.

### Is it safe to store SFTP credentials in the plugin code?
For better security, it's recommended to use environment variables as shown in the configuration steps.

### Does the plugin support SSH key authentication?
Yes, you can configure the plugin to use SSH keys instead of passwords.

---

## Support

Need assistance? We're here to help!

- GitHub Issues: [Submit an issue](https://github.com/adriancamaj/SFTP-Wordpress-Plugin/issues) on GitHub.
- Email: Contact us at [sharkware.io](sharkware.io)
- Documentation: Refer to this guide

---

## Contributing
We welcome contributions from the community!

- **Fork the Repository**: Click the **Fork** button on GitHub.
- **Create a Branch**: `git checkout -b feature/YourFeature`
- **Commit Your Changes**: `git commit -m 'Add Your Feature'`
- **Push to the Branch**: `git push origin feature/YourFeature`
- **Open a Pull Request**: Submit your pull request on GitHub.

---

## License
This plugin is licensed under the GPL-3.0 License.

---

### Thank you for choosing the SFTP Integration Plugin!

If you find this plugin helpful, please consider giving it a ⭐ on [GitHub](https://github.com/adriancamaj/SFT-Wordpress-Plugin). Your support is appreciated!
