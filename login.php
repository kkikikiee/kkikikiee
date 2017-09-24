<?php

if(isset($_POST['log_in'])) {       // submit 타입이 log_in 일때

    $log_id = $_POST['log_id'];

/////////////////////////////////////////////////////////////////////
/// 로그인 DB
    $connect = mysqli_connect('localhost', 'root', 'autoset');

    mysqli_select_db($connect, 'moon');

    $query = "select * from ci_board where user_id='{$log_id}'";

    $result = mysqli_query($connect,$query);

/////////////////////////////////////////////////////////////////////

    if($log_id == '' || mysqli_num_rows($result) == 0){
        echo "다시입력하라";
        echo "<input type='button' value='돌아가기' onclick='window.location.href=\"main.php\"'>";
    }
    else {

        if (mysqli_query($connect, $query)) {
            @session_start();
            $_SESSION['log_id'] = "kkikikiee";
        }
        echo "<script>document.location.href=\"main.php\"</script>";
    }
}
else{           // submit 타입이 log_out 일때
///////////////////////////////////////////////////////////////////////
/// 로그아웃 DB

    session_unset();

    session_destroy();

    echo "<script>document.location.href=\"main.php\"</script>";
}

?>