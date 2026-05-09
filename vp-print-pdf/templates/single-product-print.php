<?php
$spec_icons = [
    'floor_structure' => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-building-100.png',
    'floor_area'      => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-square-100.png',
    'ceiling_height'  => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-reduce-height-100.png',
    'elevators'       => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-elevator-100-2.png',
    'air_conditioner' => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-fan-90.png',
    'backup_power'    => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-lightning-bolt-100.png',
    'toilet'          => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-toilet-100-1.png',
    'parking'         => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-scooter-100.png',
    'working_time'    => 'https://vanphonghcm.com/wp-content/uploads/2021/11/icons8-time-100.png',
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo esc_html($data['building_name'] ?: $data['title']); ?></title>
    <style>
        @page {
            margin: 12mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            background: #ececec;
            color: #214f86;
            font-size: 14px;
            line-height: 1.35;
        }

        .sheet {
            width: 1120px;
            margin: 18px auto;
            background: #fff;
            padding: 0;
            box-sizing: border-box;
        }

        .topbar {
            background: #214f86;
            color: #fff;
            font-weight: 700;
            font-size: 22px;
            line-height: 1.2;
            padding: 10px 14px;
        }

        .address {
            color: #214f86;
            font-size: 13px;
            line-height: 1.35;
            padding: 4px 14px 0;
        }

        .layout {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 2px;
        }

        .left {
            width: 39%;
            vertical-align: top;
            padding: 0 0 0 14px;
            box-sizing: border-box;
        }

        .right {
            width: 61%;
            vertical-align: top;
            padding: 0 14px 0 0;
            box-sizing: border-box;
        }

        .rating-row {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 2px;
        }

        .rating-row td {
            padding: 7px 0;
            border-top: 1px solid #d7d7d7;
            border-bottom: 1px solid #d7d7d7;
            font-size: 17px;
            color: #214f86;
        }

        .rating-row .label {
            width: 50%;
            font-weight: 700;
        }

        .section-title {
            margin: 12px 0 6px;
            color: #214f86;
            font-size: 19px;
            font-weight: 700;
        }

        .cost-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 14px;
        }

        .cost-table tr {
            border-bottom: 1px solid #d7d7d7;
        }

        .cost-table td {
            padding: 8px 0;
            vertical-align: top;
            font-size: 16px;
            color: #214f86;
        }

        .cost-table td.label {
            width: 50%;
        }

        .cost-table td.value {
            width: 50%;
            font-weight: 400;
        }

        .cost-table tr.total-row td {
            font-weight: 700;
            font-size: 17px;
        }

        .vat-note td {
            border-bottom: 0;
            padding-top: 0;
            font-size: 12px;
            color: #607da3;
            font-style: italic;
        }

        .image-wrap {
            position: relative;
            width: 100%;
        }

        .main-image {
            width: 100%;
            height: 470px;
            object-fit: cover;
            object-position: center;
            display: block;
            border: 1px solid #d7d7d7;
            box-sizing: border-box;
        }

        .site-logo {
            position: absolute;
            top: 18px;
            left: 18px;
            width: 78px;
            height: auto;
            z-index: 2;
        }

        .spec-title {
            text-align: center;
            color: #214f86;
            font-size: 19px;
            font-weight: 700;
            margin: 8px 0 6px;
        }

        .spec-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            border-top: 1px solid #d7d7d7;
        }

        .spec-table td {
            width: 50%;
            vertical-align: top;
            padding: 10px 8px 10px 10px;
            color: #214f86;
            font-size: 14px;
        }

        .spec-row {
            display: table;
            width: 100%;
        }

        .spec-icon,
        .spec-text {
            display: table-cell;
            vertical-align: middle;
        }

        .spec-icon {
            width: 42px;
        }

        .spec-icon img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            display: block;
        }

        .spec-text {
            padding-left: 6px;
        }

        .spec-label {
            font-weight: 700;
        }

        .footer {
            margin: 8px 14px 0;
            border-top: 2px solid #214f86;
            border-bottom: 2px solid #214f86;
            padding: 9px 8px;
            font-size: 14px;
            color: #214f86;
            font-weight: 700;
        }

        .extra-content {
            margin: 10px 14px 14px;
            padding: 0;
            font-size: 13px;
            color: #4a4a4a;
        }

        .extra-content p:first-child {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="sheet">
        <div class="topbar">
            <?php echo esc_html($data['building_name'] ?: $data['title']); ?>
        </div>

        <div class="address">
            Địa chỉ: <?php echo esc_html($data['address']); ?>
        </div>

        <table class="layout">
            <tr>
                <td class="left">
                    <table class="rating-row">
                        <tr>
                            <td class="label">★ Xếp hạng:</td>
                            <td><?php echo esc_html($data['rating']); ?></td>
                        </tr>
                    </table>

                    <div class="section-title">☛ Chi phí thuê</div>

                    <table class="cost-table">
                        <tr>
                            <td class="label">Giá thuê:</td>
                            <td class="value"><?php echo esc_html($data['price']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Phí quản lý:</td>
                            <td class="value"><?php echo esc_html($data['management_fee']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Tổng giá:</td>
                            <td class="value">
                                <?php
                                $total_price = trim(
                                    (string) ($data['price'] ?? '') .
                                    (
                                        !empty($data['price']) && !empty($data['management_fee'])
                                        ? ' + '
                                        : ''
                                    ) .
                                    (string) ($data['management_fee'] ?? '')
                                );
                                echo esc_html($total_price);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Diện tích thuê:</td>
                            <td class="value"><?php echo esc_html($data['area']); ?></td>
                        </tr>
                        <td class="label">Tổng giá thuê:</td>
							<td class="value">&nbsp;</td>
                        <tr class="vat-note">
                            <td></td>
                            <td>(Chưa bao gồm VAT)</td>
                        </tr>
                    </table>

                    <div class="section-title">☛ Chi phí khác</div>

                    <table class="cost-table">
                        <tr>
                            <td class="label">Phí xe máy:</td>
                            <td class="value"><?php echo esc_html($data['motor_fee']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Phí ô tô:</td>
                            <td class="value"><?php echo esc_html($data['car_fee']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Phí ngoài giờ:</td>
                            <td class="value"><?php echo esc_html($data['overtime_fee']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Tiền điện:</td>
                            <td class="value"><?php echo esc_html($data['electric_fee']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Tiền điện lạnh:</td>
                            <td class="value"><?php echo esc_html($data['aircon_fee']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Tiền đặt cọc:</td>
                            <td class="value"><?php echo esc_html($data['deposit']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Thanh toán:</td>
                            <td class="value"><?php echo esc_html($data['payment']); ?></td>
                        </tr>
                        <tr>
                            <td class="label">Thuê tối thiểu:</td>
                            <td class="value"><?php echo esc_html($data['min_rent']); ?></td>
                        </tr>
                    </table>
                </td>

                <td class="right">
                    <div class="image-wrap">
                        <?php if (!empty($data['thumbnail'])): ?>
                            <img
                                class="main-image"
                                src="<?php echo esc_url($data['thumbnail']); ?>"
                                alt="<?php echo esc_attr($data['building_name'] ?: $data['title']); ?>"
                            >
                        <?php endif; ?>

                        <?php if (!empty($data['site_logo'])): ?>
                            <img
                                class="site-logo"
                                src="<?php echo esc_url($data['site_logo']); ?>"
                                alt="PN Real"
                            >
                        <?php endif; ?>
                    </div>

                    <div class="spec-title">Thông số tòa nhà</div>

                    <table class="spec-table">
                        <tr>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['floor_structure']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Kết cấu:</span>
                                        <?php echo esc_html($data['floor_structure'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['ceiling_height']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Độ cao trần:</span>
                                        <?php echo esc_html($data['ceiling_height'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['floor_area']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Diện tích sàn:</span>
                                        <?php echo esc_html($data['floor_area'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['floor_structure']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Hướng tòa nhà:</span>
                                        <?php echo esc_html($data['direction'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['elevators']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Thang máy:</span>
                                        <?php echo esc_html($data['elevators'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['backup_power']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Điện dự phòng:</span>
                                        <?php echo esc_html($data['backup_power'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['air_conditioner']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Điều hòa:</span>
                                        <?php echo esc_html($data['air_conditioner'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['working_time']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Giờ hoạt động:</span>
                                        <?php echo esc_html($data['working_time'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['toilet']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Toilet:</span>
                                        <?php echo esc_html($data['toilet'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="spec-row">
                                    <div class="spec-icon">
                                        <img src="<?php echo esc_url($spec_icons['parking']); ?>" alt="">
                                    </div>
                                    <div class="spec-text">
                                        <span class="spec-label">Đỗ xe:</span>
                                        <?php echo esc_html($data['parking'] ?? ''); ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            PN REAL - NV HỖ TRỢ: <?php echo esc_html($data['consultant_name'] ?? 'PHẠM MINH NGHIỆP'); ?> - <?php echo esc_html($data['consultant_phone'] ?? '0763 966 333'); ?>
        </div>
    </div>
</body>
</html>