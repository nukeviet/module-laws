# Hướng dẫn cập nhật module laws từ 4.0.29, 4.1.00, 4.1.01 lên 4.1.02

Chú ý: 
- Gói cập nhật này dành cho module laws 4.0.29, 4.1.00, 4.1.01, nếu module của bạn không ở phiên bản này cần tìm các hướng dẫn cập nhật lên tối thiểu 4.0.29 trước.
- Module laws 4.1.02 hoạt động trên NukeViet 4.1 Beta 2 (4.1.01), NukeViet 4.1 Official (4.1.02)

## Chuẩn bị cập nhật

Backup toàn bộ CSDL dữ liệu và code của site đề phòng rủi ro.

## Thực hiện cập nhật

Đăng nhập quản trị site, di chuyển vào khu vực Công cụ web => Kiểm tra phiên bản, tại đây nếu hệ thống kiểm tra được module laws và có yêu cầu cập nhật hãy tiến hành theo hướng dẫn của hệ thống.

Nếu không cập nhật được theo cách trên hãy thực hiện cập nhật thủ công như sau:

Tải gói cập nhật tại https://github.com/nukeviet/module-laws/releases/download/4.1.02/update-to-4.1.02.zip. Giải nén và upload thư mục install lên ngang hàng với thư mục install trên server. Đăng nhập quản trị site, nhận được thông báo cập nhật và tiến hành cập nhật theo hướng dẫn của hệ thống.

## Sau cập nhật

Truy cập quản trị vào khu vực quản lý module, di chuyển đến phần cấu hình module để thiết lập các chức năng mới nếu cần thiết

## Cập nhật các giao diện không phải giao diện mặc định

Nếu site của bạn có tồn tại `themes/ten-theme/modules/laws` cần đối chiếu code với giao diện default để sửa các file sau:

- themes/ten-theme/modules/laws/block_search_center.tpl
- themes/ten-theme/modules/laws/block_search_vertical.tpl
- themes/ten-theme/modules/laws/theme.php (nếu có)
