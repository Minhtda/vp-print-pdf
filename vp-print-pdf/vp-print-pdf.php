<?php
/**
 * Plugin Name: VP Print PDF
 * Description: In sản phẩm ra HTML và PDF theo mẫu.
 * Version: 1.0.0
 * Author: Minh
 */

if (!defined('ABSPATH')) exit;

define('VP_PRINT_PDF_PATH', plugin_dir_path(__FILE__));
define('VP_PRINT_PDF_URL', plugin_dir_url(__FILE__));

require_once VP_PRINT_PDF_PATH . 'includes/class-render.php';
require_once VP_PRINT_PDF_PATH . 'includes/class-pdf.php';
require_once VP_PRINT_PDF_PATH . 'includes/class-admin.php';

new VP_Print_Admin();