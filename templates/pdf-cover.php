<?php
// templates/pdf-cover.php
if (!defined('ABSPATH')) exit;
?>
<div class="sheet" style="background-color: #325a77; background-image: url('https://vanphonghcm.com/wp-content/uploads/2021/10/bitexco-bg.png'); background-size: cover; background-position: center; position: relative; color: #fff; padding: 0; display: flex; flex-direction: column;">
    
    <!-- Dải trắng trang trí bên trái (Mô phỏng thiết kế) -->
    <div style="position: absolute; top: 0; left: 20px; width: 15px; height: 100%; background-color: #fff; transform: skewX(-3deg);"></div>

    <div style="padding: 50px 60px 50px 80px; flex-grow: 1;">
        <!-- Header Logo & Công ty -->
        <table style="width: 100%; margin-bottom: 60px;">
            <tr>
                <td style="width: 100px;">
                    <img src="https://vanphonghcm.com/wp-content/uploads/2021/10/logo-pnr-3010.png" style="width: 80px; filter: brightness(0) invert(1);"> <!-- Filter làm logo chuyển sang màu trắng -->
                </td>
                <td>
                    <h2 style="margin: 0; font-size: 24px; font-weight: bold; padding-bottom: 5px;">Công Ty TNHH Thương Mại Dịch Vụ PN Real</h2>
                    <p style="margin: 0; font-size: 14px;">134/1 Cách Mạng Tháng 8, Phường Nhiêu Lộc, TP. HCM</p>
                </td>
            </tr>
        </table>

        <!-- Đường kẻ ngang -->
        <div style="width: 100%; height: 5px; background: #fff; margin-bottom: 80px;"></div>

        <!-- Tiêu đề chính -->
        <h1 style="font-size: 42px; font-weight: bold; line-height: 1.3; margin-bottom: 40px; text-transform: uppercase;">
            BÁO GIÁ CHO THUÊ<br>VĂN PHÒNG TẠI TP.HCM
        </h1>

        <!-- Slogan -->
        <p style="font-size: 20px; margin-bottom: 20px;">Giải pháp văn phòng phù hợp - Uy tín - Tư vấn miễn phí</p>
        <p style="font-size: 20px; margin-bottom: 80px;">2000+ Tòa nhà văn phòng cho thuê</p>
    </div>

    <!-- Footer Liên hệ -->
    <div style="padding: 0 60px 60px 80px;">
        <p style="font-size: 16px; margin: 5px 0;">🌐 Website: Vanphonghcm.com</p>
        <p style="font-size: 16px; margin: 5px 0;">☎ Hotline/zalo: 0763 966 333</p>
    </div>
</div>