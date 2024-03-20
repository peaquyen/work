PHÂN TÍCH HỆ THỐNG JOB SEARCH WEBSITE

Bài toán là xây dựng một hệ thống web tìm kiếm tuyển dụng việc làm, cho phép người dùng tạo bài viết về thông tin tìm việc, gửi mail ứng tuyển đến nhà tuyển dụng. Hệ thống sẽ có hai tác nhân chính  là người dùng(user) và admin.

1.	Người dùng
Người dùng là tác nhân chính của hệ thống. Người dùng được chia làm hai nhóm:
Nhóm 1: Người dùng có thể là nhà tuyển dụng muốn đăng tải nội dung tìm kiếm nhân viên mới. Người dùng ở nhóm này có thể đăng kí tài khoản, đăng nhập vào hệ thống để thực hiện các chức năng của hệ thống.
Nhóm 2: Người dùng cũng có thể là người ứng tuyển đến nhà tuyển dụng thông qua các bài đăng. Người dùng ở nhóm này có thể apply vào mail công ty sau khi đã đăng nhập.

2.	Admin
Admin là tác nhân chính của hệ thống Quản lí người dùng, tạo, chỉnh sửa, xóa người dùng trên hệ thống.

Yêu cầu và chức năng:
•	Người dùng:
o	Có thể tạo tài khoản và đăng nhập vào hệ thống
o	Có để tạo, đọc, sửa, xóa nội dung
•	Admin:
o	Có thể quản lý người dùng bao gồm tạo, sửa, xóa người dùng
Các use case
•	Tạo tài khoản: Use case này cho phép người dùng tạo một tài khoản trên hệ thống
•	Đăng nhập, đăng xuất: Use case này cho phép người dùng đăng nhập, đăng xuất hệ thống
•	Tạo bài viết: Use case này cho phép người dùng tạo một bài viết mới trên website
•	Đọc bài viết: Use case này cho phép người dùng đọc cái bài viết trên website
•	Quản lí user: Use case này cho phép admin quản lý user.
Các đặc tả chi tiết:

1.	Đặc tả “UC01 – Tạo tài khoản”
Tên use case	Tạo tài khoản
Sự tương tác trong use case	User tạo tài khoản mới
Tác nhân	User 
Điều kiện kích hoạt	Mail user đăng kí chưa có trong hệ thống
Luồng sự kiện chính	+ User tạo tài khoản
+ Các thông tin bao gồm: fullname, email, phone, password.
+ User nhấn nút register
+ Hệ thống kiểm tra các thông tin đã hợp lệ và lưu vào hệ thống.
+ Hệ thống thông báo đã tạo tài khoản thành công
Điều kiện cần để thực hiện thành công	+ Điền đầy đủ các thông tin hợp lệ
+ Nếu mail nằm trong user đã bị xóa -> kích hoạt lại qua mail
+ Nếu mail chưa đăng kí -> kích hoạt thông qua mail
+ Nếu mail nằm trong user còn hoạt động -> không kích hoạt
Luồng sự kiện thay thế	+ Nếu thông tin không hợp lệ thì thông báo lỗi cho người dùng.
Sau khi use case thực hiện thành công 	Tài khoản user mới được lưu thành công vào table users

2.	Đặc tả “UC02 – Đăng nhập, đăng xuất”
Tên use case	Đăng nhập, đăng xuất
Sự tương tác trong use case	Admin/user đăng nhập hoặc đăng xuất
Tác nhân	Admin/user
Điều kiện kích hoạt	Admin/user đã có tài khoản trong hệ thống
Luồng sự kiện chính	Khi đăng nhâp:
+ Nhấn login
Khi đăng xuất:
+ Nhấn logout
Điều kiện cần để thực hiện thành công	Khi đăng nhập:
+ Điền đầy đủ thông tin
+ Đảm bảo mail đã được kích hoạt
Khi đăng xuất:
+ Đã login
Luồng sự kiện thay thế	+ Không hợp lệ thì thông báo lỗi
Sau khi use case thực hiện thành công 	Khi đăng nhâp:
+ lưu tài khoản vào table login
+ mở phiên người dùng
Khi đăng xuất:
+ xóa tài khoản trong table login
+ xóa phiên người dùng

3.	Đặc tả “UC03 – Tạo bài viết”
Tên use case	Tạo bài viết
Sự tương tác trong use case	User tạo bài viết mới
Tác nhân	User 
Điều kiện kích hoạt	User đăng nhập vào hệ thống
Luồng sự kiện chính	+ User truy cập vào trang post-job
+ Nhập các thông tin về “job” và “company”
+ Submit 
+ Hệ thống kiểm tra hợp lệ, lưu bài vào hệ thống
Điều kiện cần để thực hiện thành công	User phải đăng nhập vào hệ thống
Luồng sự kiện thay thế	Thông báo lỗi
Sau khi use case thực hiện thành công 	Bài viết tạo thành công và lưu dữ liệu vào table lisitng và company


4.	Đặc tả “UC04 – Đọc bài viết”
Tên use case	Đọc bài viết
Sự tương tác trong use case	User chỉnh sửa/xóa bài viết
Tác nhân	User
Điều kiện kích hoạt	User đăng nhập vào hệ thống
Luồng sự kiện chính	+ user có thể truy cập vào trang bài viết
+ hiển thị các bài viết có trên hệ thống
Điều kiện cần để thực hiện thành công	Người dùng cần đăng nhập
Luồng sự kiện thay thế	Không có
Sau khi use case thực hiện thành công 	Hiển thị các dánh sách bài viết


5.	Đặc tả “UC05 – Quản Lý Users”
Tên use case	Quản lý users
Sự tương tác trong use case	Admin thêm, sửa, xóa user
Tác nhân	Admin
Điều kiện kích hoạt	Admin đăng nhập
Luồng sự kiện chính	Thực hiện ở xử lý trong trang “manage user”
Điều kiện cần để thực hiện thành công	Admin đăng nhập
Luồng sự kiện thay thế	Thông báo lỗi 
Sau khi use case thực hiện thành công 	Cập nhật lại dữ liệu trong database trong table user


Thành viên - Contributer:
Đinh Yến Linh
Đỗ Thảo Quyên
Trần Thị Hoài Thương
Nguyễn Thu Trang
Tống Bảo Trâm
