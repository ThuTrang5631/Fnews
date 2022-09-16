// Script Scroll Top ----------------------------------------------------------->

$(document).scroll(function () { 
    // Khi màn hình qua 300 scroll thì mới bắt đầu cho button lăn lên hiện ra
    // Button sáng dần, khi lăn thêm được 800 thì opacty = 1 (max opacty)
    var opacty = ($(document).scrollTop()-300) / 800.0;
    // 0.0 <= opacty >= 1.0
    if (opacty < 0)  opacty = 0;
    if (opacty > 1)  opacty = 1;
    // Khi qua 300 thì cho "display" = "block" (hiện ra) vì "display" mặc định là "none"
    if($(document).scrollTop() > 300) 
        $("#scrollToTopButton").css("display", "block");    
    else
        $("#scrollToTopButton").css("display", "none");
    $("#scrollToTopButton").css("background-color", "rgba(23, 162, 184,"+opacty+")");
});

$('#scrollToTopButton').click(function() { 
    // Cho cả trang html lăn ngược lên điểm 0 (điểm đầu), "speed":"slow"
    $("html,body").animate({scrollTop: 0}, "slow");
});

// Script Login ----------------------------------------------------------------->

function startLogin() {
    // Cho thẻ div "login-container" (form đăng nhập) hiện ra, mặc định là "none"
    $("#login-container").css("display", "block");
    // Hiển thị form ở dạng đăng nhập
    LoadSignIn();
    
}
// Điều hướng form: Nằm bênh dưới button submit góc phải
    // Nếu đang ở trạng thái "đăng nhập", nó sẽ dẫn ta đến "đăng ký"
    // Nếu đang ở trạng thái "đăng ký", nó sẽ dẫn ta đến "đăng nhập"
    // Nếu đang ở trạng thái "quên mật khẩu", nó sẽ dẫn ta đến "quay lại đăng nhập"
$('#register').click(function(e) {
    e.preventDefault();
    if ($('#register').text() == "Đăng ký") {
        // Hiển thị form đăng ký
        LoadSignUp();
    } else {
        // Hiển thị form đăng nhập
        LoadSignIn();
    }
});

$('#forgot').click(function(e) {
    e.preventDefault();
    // Hiển thị form 
    LoadForgot();
})

function LoadSignUp() {
    // Điều hướng : dẫn ta đến "đăng nhập"
    $('#register').text("Đăng nhập");
    // Tiêu đề :
    $('#title-form').text("Đăng ký");
    // Nội dung hướng dẫn
    $("#text-form").text("Tạo tài khoản FNews để đăng nhập và hưởng những quyền lợi của người dùng.");
    // Mật khẩu 
    $("#group-Password").css("display", "flex");
    // Nhập lại mật khẩu
    $("#group-RePassword").css("display", "flex");
    // Submit
    $("#exampleSubmit").text("Đăng ký");
}
function LoadSignIn() {
    $('#register').text("Đăng ký");
    $('#title-form').text("Đăng nhập");
    $("#text-form").text("Đăng nhập với email");
    $('#group-Password').css("display","flex");
    $('#group-RePassword').css("display","none");
    $("#exampleSubmit").text("Đăng nhập");
}
function LoadForgot() {
    $('#register').text("Quay lại đăng nhập");
    $('#title-form').text("Quên mật khẩu");
    $("#text-form").text("Nhập địa chỉ email của bạn, chúng tôi sẽ gửi một gmail xác nhận tới địa chỉ email.");
    $('#group-Password').css("display","none");
    $('#group-RePassword').css("display","none");
    $("#exampleSubmit").text("Đặt lại mật khẩu");
}

// 
function show_hide(object) {
    if (object == 'password') {
        if ($("#exampleInputPassword").attr("type") =="password"){
            $("#exampleInputPassword").attr("type","text");
            $('#icon-password').css("color","#17a2b8");
        }
            
        else {
            $("#exampleInputPassword").attr("type","password");
            $('#icon-password').css("color","black");
        }
            
    }
    else {
        if ($("#exampleInputRePassword").attr("type") =="password") {
            $("#exampleInputRePassword").attr("type","text");
            $('#icon-repassword').css("color","#17a2b8");
        }
        else {
            $("#exampleInputRePassword").attr("type","password");
            $('#icon-repassword').css("color","black");
        }
            
    }
}

// Xử lý tác vụ khi click ra ngoài thì ta sẽ thoát khỏi form login
    // div "login" bao bọc ở ngoài div "form-container"
    // Vùng click là vùng không nằm trong "login" và không trùng "form-container"
var check = 0;
$('#form-container').click(function(e) {
    e.preventDefault();
    // Cho "check" : 1 để biết có click vào vùng ở trong hay k
    check = 1;
})
$('#login').click(function(e) {
    e.preventDefault();
    if (check == 0) {
        // Nếu không click vào vùng ở trong thì tắt "login-container" đi
        $("#login-container").css("display", "none");
    } else {
        check = 0;
    }
})

function LoadDate() {
    var date = new Date();
    var toDay = ['Sunday','Monday', 'Tuesday','Wednesday','Thurday','Friday','Saturday'];
    var toMonth = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
    var toDate = toDay[date.getDay()]+', '+toMonth[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear();
    $('#title-date').text(toDate);
}

LoadDate()

// $("#ChinhTri-btn").click(function (e) {
//     e.preventDefault();
//     $('#de-muc').css("display", "block");
//     $('#ChinhTri-btn').css("background-color", "#17a2b8");
//     $('#top-news').css("display", "none");
//     $('#home-btn').css("background-color", "#343a40");
//     $('#top-search').css("display", "none");
//     $('#NoiDung_BaoVuongDinhHue').css("display", "none");
    
// });

// $("#home-btn").click(function (e) {
//     e.preventDefault();
//     $('#de-muc').css("display", "none");
//     $('#ChinhTri-btn').css("background-color", "#343a40");
//     $('#top-news').css("display", "block");
//     $('#home-btn').css("background-color", "#17a2b8");
//     $('#top-search').css("display", "none");
//     $('#NoiDung_BaoVuongDinhHue').css("display", "none");
// });

// $("#search-btn").click(function (e) {
//     e.preventDefault();
//     $('#de-muc').css("display", "none");
//     $('#top-news').css("display", "none");
//     $('#top-search').css("display", "block");
//     $('#NoiDung_BaoVuongDinhHue').css("display", "none");
// });
// // click bài báo Vương Đình Huệ
// $('#baiviet').click(function(e){
//     e.preventDefault();
//     $('#top-news').css("display", "none");
//     $('#top-search').css("display","none");
//     $('#home-btn').css("background-color","#343a40");
//     $('#NoiDung_BaoVuongDinhHue').css("display", "block");
//     $('#de-muc').css("display", "none");
// })