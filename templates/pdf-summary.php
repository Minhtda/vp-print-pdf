<?php
// templates/pdf-summary.php
if (!defined('ABSPATH')) exit;
?>
<div class="sheet" style="padding: 40px 40px 20px 40px; display: flex; flex-direction: column; justify-content: space-between;">
    <div>
        <h2 style="color: #214f86; font-size: 22px; font-weight: bold; margin-bottom: 20px; text-transform: uppercase;">
            DANH SÁCH TÒA NHÀ PHÙ HỢP VỚI NHU CẦU THUÊ
        </h2>

        <table style="width: 100%; border-collapse: collapse; font-size: 13px; color: #214f86;">
            <thead>
                <tr style="border-top: 2px solid #214f86; border-bottom: 2px solid #214f86; font-weight: bold;">
                    <td style="padding: 10px 5px; text-align: center;">Stt</td>
                    <td style="padding: 10px 5px;">Tên tòa nhà</td>
                    <td style="padding: 10px 5px; text-align: center;">Diện tích</td>
                    <td style="padding: 10px 5px; text-align: center;">Tầng</td>
                    <td style="padding: 10px 5px; text-align: center;">Giá thuê<br>/m2</td>
                    <td style="padding: 10px 5px; text-align: center;">Phí quản lý<br>/m2</td>
                    <td style="padding: 10px 5px; text-align: center;">Tổng giá<br>(chưa VAT)</td>
                    <td style="padding: 10px 5px; text-align: center;">Khoảng cách<br>đến Bitexco</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $stt = 1;
                foreach ($buildings as $post_id => $b_data) {
                    // Logic tự động tính Tổng Giá: (Giá + PQL) * Diện tích
                    $price_val = floatval(preg_replace('/[^0-9.]/', '', $b_data['price'] ?? 0));
                    $fee_val = floatval(preg_replace('/[^0-9.]/', '', $b_data['management_fee'] ?? 0));
                    $area_val = floatval(preg_replace('/[^0-9.]/', '', $b_data['area'] ?? 0));
                    
                    $total_price = ($price_val + $fee_val) * $area_val;
                    $total_str = $total_price > 0 ? number_format($total_price, 0, ',', '.') . ' usd /tháng' : 'Đang cập nhật';

                    echo '<tr style="border-bottom: 1px solid #d4e0ee;">';
                    echo '<td style="padding: 12px 5px; text-align: center; vertical-align: top;">' . $stt++ . '</td>';
                    echo '<td style="padding: 12px 5px; vertical-align: top;">
                            <strong style="font-size: 14px;">' . esc_html($b_data['title']) . '</strong><br>
                            <span style="font-size: 11px; color: #555;">' . esc_html($b_data['address']) . '</span>
                          </td>';
                    echo '<td style="padding: 12px 5px; text-align: center; vertical-align: top;">' . esc_html($b_data['area']) . '</td>';
                    echo '<td style="padding: 12px 5px; text-align: center; vertical-align: top;">' . esc_html($b_data['floor_structure'] ?? 'N/A') . '</td>';
                    echo '<td style="padding: 12px 5px; text-align: center; vertical-align: top;">' . esc_html($b_data['price']) . '</td>';
                    echo '<td style="padding: 12px 5px; text-align: center; vertical-align: top;">' . esc_html($b_data['management_fee']) . '</td>';
                    echo '<td style="padding: 12px 5px; text-align: center; vertical-align: top;">' . $total_str . '</td>';
                    echo '<td style="padding: 12px 5px; text-align: center; vertical-align: top; font-weight: bold;">' . esc_html($b_data['distance'] ?? '') . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Footer trang danh sách -->
    <div style="border-top: 2px solid #214f86; padding-top: 10px; margin-top: 20px; font-weight: bold; color: #214f86; display: flex; align-items: center;">
        <img src="https://vanphonghcm.com/wp-content/uploads/2021/10/logo-pnr-3010.png" style="height: 30px; margin-right: 15px;">
        PN REAL - NV HỖ TRỢ: <?php echo esc_html(strtoupper($customer_info['consultant_name'] ?? '')); ?> - <?php echo esc_html($customer_info['consultant_phone'] ?? ''); ?>
    </div>
</div>