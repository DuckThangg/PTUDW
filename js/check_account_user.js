document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#checkForm').onsubmit = check;

    // Khi nhấn click id editButton thì hiện ra phần chỉnh sửa thông tin
    document.querySelector('#editButton').addEventListener('click', function () {
        document.querySelector('#editSection').style.display = 'block';
    });
});

function check() {
    const name = document.querySelector("#newName").value;
    const date = document.querySelector("#newDate").value;
    const phone = document.querySelector("#newPhone").value;
    //Kiểm tra xem user có nhập đầy đủ thông tin
    if (name === "" || date === "" || phone === "") {
        alert("Bạn đã nhập thiếu thông tin. Vui lòng kiểm tra lại.");
    } else {
        if (phone.length >= 10) {
            alert("Bạn đã đăng ký thành công!");
        } else {
            alert("Số điện thoại không hợp lệ");
        }
        
        return phone.length >= 10;
    }
    // Tải lại trang
    window.location.reload();
}