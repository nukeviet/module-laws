# Hướng dẫn cập nhật module laws từ 4.1.02, 4.2.01, 4.2.02, 4.3.00, 4.3.01, 4.3.05, 4.5.00, 4.5.02, 4.5.03, 4.5.04 lên 4.6.01

Chú ý:
- Gói cập nhật này dành cho module laws 4.1.02, 4.2.01, 4.2.02, 4.3.00, 4.3.01, 4.3.05, 4.5.00, 4.5.02, 4.5.03, 4.5.04 nếu module của bạn không ở phiên bản này cần tìm các hướng dẫn cập nhật lên tối thiểu 4.1.02 trước.
- Module laws 4.6.01 hoạt động trên NukeViet 4.6.00 trở lên

## Chuẩn bị cập nhật

Backup toàn bộ CSDL dữ liệu và code của site đề phòng rủi ro.

## Thực hiện cập nhật

Đăng nhập quản trị site, di chuyển vào khu vực Công cụ web => Kiểm tra phiên bản, tại đây nếu hệ thống kiểm tra được module laws và có yêu cầu cập nhật hãy tiến hành theo hướng dẫn của hệ thống.

Nếu không cập nhật được theo cách trên hãy thực hiện cập nhật thủ công như sau:

Tải gói cập nhật tại https://github.com/nukeviet/module-laws/releases/download/4.6.01/update-to-4.6.01.zip. Giải nén và upload thư mục install lên ngang hàng với thư mục install trên server. Đăng nhập quản trị site, nhận được thông báo cập nhật và tiến hành cập nhật theo hướng dẫn của hệ thống.

## Sau cập nhật

Truy cập quản trị vào khu vực quản lý module, di chuyển đến phần cấu hình module để thiết lập các chức năng mới nếu cần thiết

## Cập nhật giao diện

### Nếu hiện tại module nhỏ hơn 4.5.08

Mở (nếu có):
- themes/ten-theme/modules/laws/block_search_center.tpl
- themes/ten-theme/modules/laws/block_search_vertical.tpl

Tìm `yearRange: "2000:2025"` thay lại thành `yearRange: "c-30:c+0"`

### Nếu hiện tại module nhỏ hơn 4.5.06

Nếu site của bạn có themes/ten-theme/modules/laws/theme.php thì cập nhật như:
- [Ở đây](https://github.com/nukeviet/module-laws/commit/77e4f8a61e6388788916153a001ac4e6c28d558f#diff-3b0d669827e7dc57bdd701985ef6c822497396417032df0bcf187115f0647cca)

Nếu site của bạn có themes/ten-theme/modules/laws/list.tpl thì cập nhật như:
- [Ở đây](https://github.com/nukeviet/module-laws/commit/30980939a82d086dcd2e7871cb895627ae342b76#diff-3ad4b427c24c2013c63a747ac762e39d154039112667d0b1cee98cae709ad3fe)
- [Và ở đây](https://github.com/nukeviet/module-laws/commit/77e4f8a61e6388788916153a001ac4e6c28d558f#diff-3ad4b427c24c2013c63a747ac762e39d154039112667d0b1cee98cae709ad3fe)
