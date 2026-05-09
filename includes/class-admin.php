<?php
if (!defined('ABSPATH')) exit;

class VP_Print_Admin {

    public function __construct() {
        // Móc nối cho trang chỉnh sửa 1 sản phẩm (Giao diện cũ)
        add_action('add_meta_boxes', [$this, 'add_metabox']);
        add_action('admin_post_vp_print_html', [$this, 'print_html']);
        add_action('admin_post_vp_export_pdf', [$this, 'export_pdf']);

        // GIAI ĐOẠN 1: Móc nối cho Hành động hàng loạt (Bulk Action)
        add_filter('bulk_actions-edit-product', [$this, 'register_pdf_bulk_action']);
        add_filter('handle_bulk_actions-edit-product', [$this, 'handle_pdf_bulk_action'], 10, 3);

        // GIAI ĐOẠN 2 & 3: Móc nối cho trang Form trung gian và Xử lý xuất Báo giá
        add_action('admin_menu', [$this, 'register_pdf_preview_page']);
        add_action('admin_post_vp_submit_multi_pdf', [$this, 'submit_multi_pdf']);
    }

    // ==========================================
    // CÁC HÀM XỬ LÝ HÀNH ĐỘNG HÀNG LOẠT (BULK)
    // ==========================================

    public function register_pdf_bulk_action($bulk_actions) {
        $bulk_actions['vp_generate_quote'] = 'Tạo báo giá PDF (Nhiều tòa nhà)';
        return $bulk_actions;
    }

    public function handle_pdf_bulk_action($redirect_to, $doaction, $post_ids) {
        if ($doaction !== 'vp_generate_quote') {
            return $redirect_to;
        }
        $ids_string = implode(',', $post_ids);
        $redirect_to = admin_url('admin.php?page=vp-pdf-preview&building_ids=' . $ids_string);
        return $redirect_to;
    }

    // ==========================================
    // CÁC HÀM XỬ LÝ TRANG FORM CHỈNH SỬA (GIAI ĐOẠN 2)
    // ==========================================

    public function register_pdf_preview_page() {
        add_submenu_page(
            null, 
            'Chỉnh sửa báo giá PDF', 
            'Báo giá PDF',
            'edit_products', 
            'vp-pdf-preview', 
            [$this, 'render_pdf_preview_page']
        );
    }

    public function render_pdf_preview_page() {
        if (!current_user_can('edit_products')) {
            wp_die('Bạn không có quyền truy cập trang này.');
        }

        $ids_string = isset($_GET['building_ids']) ? sanitize_text_field($_GET['building_ids']) : '';
        if (empty($ids_string)) {
            echo '<div class="wrap"><h2>Lỗi: Không có sản phẩm nào được chọn!</h2></div>';
            return;
        }

        $post_ids = explode(',', $ids_string);

        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">Chỉnh sửa thông số Báo Giá</h1>
            <p>Dữ liệu bạn sửa ở đây chỉ hiển thị trên file in ra, <b>KHÔNG</b> làm thay đổi dữ liệu gốc trên website.</p>

            <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" target="_blank">
                <input type="hidden" name="action" value="vp_submit_multi_pdf">
                <?php wp_nonce_field('vp_multi_pdf_action', 'vp_multi_pdf_nonce'); ?>

                <div class="postbox" style="padding: 15px; margin-top: 20px;">
                    <h3>Thông tin khách hàng & Tư vấn viên</h3>
                    <table class="form-table">
                        <tr>
                            <th scope="row"><label>Tên khách hàng / Công ty:</label></th>
                            <td><input type="text" name="customer_info[name]" class="regular-text" placeholder="VD: Công ty TNHH ABC" required></td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Tên NV Hỗ Trợ (PN Real):</label></th>
                            <td><input type="text" name="customer_info[consultant_name]" class="regular-text" value="PHẠM MINH NGHIỆP"></td>
                        </tr>
                        <tr>
                            <th scope="row"><label>SĐT NV Hỗ Trợ:</label></th>
                            <td><input type="text" name="customer_info[consultant_phone]" class="regular-text" value="0763 966 333"></td>
                        </tr>
                    </table>
                </div>

                <h3>Danh sách các tòa nhà đã chọn</h3>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th style="width: 25%">Tên tòa nhà</th>
                            <th style="width: 15%">Diện tích thuê (m2)</th>
                            <th style="width: 15%">Giá thuê ($/m2)</th>
                            <th style="width: 15%">Phí quản lý ($/m2)</th>
                            <th style="width: 20%">Khoảng cách đến Bitexco</th>
                            <th style="width: 10%">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($post_ids as $post_id) {
                            $post_id = absint($post_id);
                            $data = VP_Print_Render::get_product_data($post_id);
                            if (!$data) continue;
                            ?>
                            <tr>
                                <td>
                                    <strong><?php echo esc_html($data['building_name'] ?: $data['title']); ?></strong>
                                    
                                    <?php
                                    // Danh sách các key ĐÃ CÓ ô nhập liệu ở các cột bên cạnh
                                    $editable_keys = ['area', 'price', 'management_fee'];

                                    // Lặp qua toàn bộ dữ liệu gốc của tòa nhà để tự động tạo thẻ ẩn mang theo
                                    foreach ($data as $key => $val) {
                                        if (!in_array($key, $editable_keys) && (is_string($val) || is_numeric($val))) {
                                            echo '<input type="hidden" name="buildings[' . $post_id . '][' . esc_attr($key) . ']" value="' . esc_attr($val) . '">';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <input type="text" name="buildings[<?php echo $post_id; ?>][area]" value="<?php echo esc_attr($data['area']); ?>" style="width:100%;">
                                </td>
                                <td>
                                    <input type="text" name="buildings[<?php echo $post_id; ?>][price]" value="<?php echo esc_attr($data['price']); ?>" style="width:100%;">
                                </td>
                                <td>
                                    <input type="text" name="buildings[<?php echo $post_id; ?>][management_fee]" value="<?php echo esc_attr($data['management_fee']); ?>" style="width:100%;">
                                </td>
                                <td>
                                    <input type="text" name="buildings[<?php echo $post_id; ?>][distance]" placeholder="VD: 900m" style="width:100%;">
                                </td>
                                <td>
                                    <button type="button" class="button remove-row" onclick="this.closest('tr').remove();">Xóa</button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <p class="submit">
                    <button type="submit" class="button button-primary button-large">Tạo & Xem Báo Giá HTML</button>
                </p>
            </form>
        </div>
        <?php
    }

    // ==========================================
    // HÀM XỬ LÝ XUẤT BÁO GIÁ ĐA SẢN PHẨM (GIAI ĐOẠN 3)
    // ==========================================

    public function submit_multi_pdf() {
        check_admin_referer('vp_multi_pdf_action', 'vp_multi_pdf_nonce');

        $buildings = isset($_POST['buildings']) ? wp_unslash($_POST['buildings']) : [];
        $customer_info = isset($_POST['customer_info']) ? wp_unslash($_POST['customer_info']) : [];

        if (empty($buildings)) {
            wp_die('Không có dữ liệu tòa nhà.');
        }

        // Cập nhật CSS để in ra HTML mượt mà, định dạng trang chuẩn
        echo '<!DOCTYPE html><html lang="vi"><head><meta charset="UTF-8"><title>Báo Giá - PN Real</title>';
        echo '<style> 
                body { font-family: DejaVu Sans, sans-serif; background: #ececec; margin:0; padding: 20px 0;} 
                .sheet { width: 1120px; min-height: 1584px; margin: 0 auto 30px auto; background: #fff; box-sizing: border-box; box-shadow: 0 4px 10px rgba(0,0,0,0.1); overflow: hidden;} 
                @media print { 
                    body { background: #fff; padding: 0;} 
                    .sheet { margin: 0; box-shadow: none; min-height: 100vh; page-break-after: always; } 
                } 
              </style>';
        echo '</head><body>';

        // 0. Nạp Trang Bìa (Cover)
        $cover_path = plugin_dir_path(dirname(__FILE__)) . 'templates/pdf-cover.php';
        if (file_exists($cover_path)) include $cover_path;

        // 1. Nạp Trang Tóm Tắt (Summary)
        $template_path = plugin_dir_path(dirname(__FILE__)) . 'templates/pdf-summary.php';
        if (file_exists($template_path)) {
            include $template_path;
        } else {
            echo '<div style="text-align:center; padding: 20px;">Không tìm thấy file mẫu pdf-summary.php. Vui lòng tạo file này trong thư mục templates/.</div>';
        }

        // 2. Nạp Các Trang Chi Tiết Tòa Nhà
        foreach ($buildings as $post_id => $override_data) {
            
            // Ghi đè thông tin NV Tư Vấn cho từng tòa nhà bằng thông tin nhập từ Form
            $override_data['consultant_name'] = $customer_info['consultant_name'] ?? '';
            $override_data['consultant_phone'] = $customer_info['consultant_phone'] ?? '';

            // Gọi hàm render từ class-render.php để xuất layout chi tiết
            $html_detail = VP_Print_Render::render_product_print($post_id, $override_data);
            
            // Lọc bỏ các thẻ html, body, head thừa trong file single-product-print để không bị lỗi cấu trúc trang tổng
            $html_detail = preg_replace('/<!DOCTYPE.*?>/i', '', $html_detail);
            $html_detail = preg_replace('/<\/?(html|head|body|meta|title)[^>]*>/i', '', $html_detail);
            
            echo $html_detail;
        }

        echo '</body></html>';
        exit;
    }

    // ==========================================
    // CÁC HÀM XỬ LÝ 1 SẢN PHẨM ĐƠN LẺ (GIỮ NGUYÊN)
    // ==========================================

    public function add_metabox() {
        add_meta_box(
            'vp_print_pdf_box',
            'In tài liệu PDF',
            [$this, 'render_metabox'],
            'product',
            'side',
            'high'
        );
    }

    public function render_metabox($post) {
        $html_url = wp_nonce_url(
            admin_url('admin-post.php?action=vp_print_html&post_id=' . $post->ID),
            'vp_print_action_' . $post->ID
        );

        $pdf_url = wp_nonce_url(
            admin_url('admin-post.php?action=vp_export_pdf&post_id=' . $post->ID),
            'vp_print_action_' . $post->ID
        );

        echo '<p><a class="button button-primary" target="_blank" href="' . esc_url($html_url) . '">Xem bản in HTML</a></p>';
        echo '<p><a class="button" target="_blank" href="' . esc_url($pdf_url) . '">Xuất PDF</a></p>';
    }

    public function print_html() {
        $post_id = absint($_GET['post_id'] ?? 0);
        check_admin_referer('vp_print_action_' . $post_id);

        if (!$post_id) wp_die('Thiếu post_id');

        echo VP_Print_Render::render_product_print($post_id);
        exit;
    }

    public function export_pdf() {
        $post_id = absint($_GET['post_id'] ?? 0);
        check_admin_referer('vp_print_action_' . $post_id);

        if (!$post_id) wp_die('Thiếu post_id');

        VP_Print_PDF::stream_product_pdf($post_id);
        exit;
    }
}