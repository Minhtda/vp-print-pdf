<?php
if (!defined('ABSPATH')) exit;

class VP_Print_Render {

    private static function parse_legacy_specs_from_content($html) {
        $result = [
            'floor_structure' => '',
            'floor_area' => '',
            'ceiling_height' => '',
            'elevators' => '',
            'air_conditioner' => '',
            'backup_power' => '',
            'toilet' => '',
            'parking' => '',
            'working_time' => '',
        ];

        if (empty($html)) {
            return $result;
        }

        libxml_use_internal_errors(true);

        $dom = new DOMDocument();
        $loaded = $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

        if (!$loaded) {
            return $result;
        }

        $xpath = new DOMXPath($dom);
        $rows = $xpath->query('//table//tr');

        if (!$rows || $rows->length === 0) {
            return $result;
        }

        foreach ($rows as $row) {
            $cells = $row->getElementsByTagName('td');
            if ($cells->length < 3) {
                continue;
            }

            $label = trim(preg_replace('/\s+/u', ' ', $cells->item(1)->textContent));
            $value = trim(preg_replace('/\s+/u', ' ', $cells->item(2)->textContent));

            switch (mb_strtolower($label, 'UTF-8')) {
                case 'kết cấu':
                    $result['floor_structure'] = $value;
                    break;
                case 'diện tích 1 sàn':
                case 'diện tích sàn':
                    $result['floor_area'] = $value;
                    break;
                case 'độ cao trần':
                    $result['ceiling_height'] = $value;
                    break;
                case 'thang máy':
                    $result['elevators'] = $value;
                    break;
                case 'điều hòa':
                    $result['air_conditioner'] = $value;
                    break;
                case 'điện dự phòng':
                    $result['backup_power'] = $value;
                    break;
                case 'toilet':
                    $result['toilet'] = $value;
                    break;
                case 'đỗ xe':
                    $result['parking'] = $value;
                    break;
                case 'giờ làm việc':
                    $result['working_time'] = $value;
                    break;
            }
        }

        return $result;
    }

    public static function get_product_data($post_id) {
        $post = get_post($post_id);
        if (!$post) return [];

        $acf = function_exists('get_fields') ? get_fields($post_id) : [];
        $fees = $acf['fees'] ?? [];
        $content = $post->post_content;

        $legacy_specs = self::parse_legacy_specs_from_content($content);

        return [
            'title'     => get_the_title($post_id),
            'content'   => apply_filters('the_content', $content),
            'thumbnail' => get_the_post_thumbnail_url($post_id, 'large'),
            'site_logo' => 'https://vanphonghcm.com/wp-content/uploads/2021/10/logo-pnr-3010.png',

            'building_name' => $acf['building_name'] ?? '',
            'address'       => $acf['address'] ?? '',
            'price'         => $acf['price'] ?? '',
            'area'          => $acf['area'] ?? '',
            'rating'        => $acf['rating'] ?? '',
            'status'        => $acf['status'] ?? '',
            'min_rent'      => $acf['minimum_rental_period'] ?? '',
            'utilities'     => $acf['tien_ich'] ?? '',

            'management_fee' => $fees['management_fee'] ?? '',
            'motor_fee'      => $fees['motorbike_fee'] ?? '',
            'car_fee'        => $fees['car_fee'] ?? '',
            'overtime_fee'   => $fees['overtime_fee'] ?? '',
            'electric_fee'   => $fees['electricity_bill'] ?? '',
            'aircon_fee'     => $fees['conditioner_bill'] ?? '',
            'deposit'        => $fees['deposits'] ?? '',
            'payment'        => $fees['payment'] ?? '',

            'floor_structure' => $acf['floor_structure'] ?? $legacy_specs['floor_structure'],
            'floor_area'      => $acf['floor_area'] ?? $legacy_specs['floor_area'],
            'ceiling_height'  => $acf['ceiling_height'] ?? $legacy_specs['ceiling_height'],
            'elevators'       => $acf['elevators'] ?? $legacy_specs['elevators'],
            'backup_power'    => $acf['backup_power'] ?? $legacy_specs['backup_power'],
            'air_conditioner' => $acf['air_conditioner'] ?? $legacy_specs['air_conditioner'],
            'working_time'    => $acf['working_time'] ?? $legacy_specs['working_time'],
            'toilet'          => $acf['toilet'] ?? $legacy_specs['toilet'],
            'parking'         => $acf['parking'] ?? $legacy_specs['parking'],
            'direction'       => $acf['direction'] ?? '',

            'consultant_name'  => $acf['consultant_name'] ?? 'PHẠM MINH NGHIỆP',
            'consultant_phone' => $acf['consultant_phone'] ?? '0763 966 333',
        ];
    }

    public static function render_product_print($post_id, $override = []) {
        $data = array_merge(self::get_product_data($post_id), $override);

        ob_start();
        include VP_PRINT_PDF_PATH . 'templates/single-product-print.php';
        return ob_get_clean();
    }
}