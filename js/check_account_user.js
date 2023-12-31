document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('#checkForm').onsubmit = check;

    document.querySelector('#editButton').addEventListener('click', function () {
        document.querySelector('#editSection').style.display = 'block';
    });
});

function check() {
        const newPassword = document.querySelector("#newPassword").value;
        const rePassword = document.querySelector("#rePassword").value;

        //Check pass có ít nhất ký tự hoa /thường/ số
        const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;

        if (newPassword === "" || rePassword === "") {
            alert("Không được để trống");
        }
        else{
            if(newPassword.length >= 8 && rePassword === newPassword && passwordRegex.test(newPassword)){
                alert("Bạn đã đăng ký thành công!")
            }
            else{
                if(newPassword.length < 8){
                    alert("Mật khẩu yêu cầu 8 ký tự trở lên!")
                }
                else if(newPassword != rePassword ){
                    alert("Mật khẩu không trùng nhau!")
                }
            }
        }
    window.location.reload();
}