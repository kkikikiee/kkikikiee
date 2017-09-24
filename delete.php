<?php

if(isset($_SESSION['log_id'])){

    $connect = mysqli_connect('localhost','root','autoset');

    mysqli_select_db($connect,'moon');

    if($_POST['delete_coments']){

        $query = "delete from coments where pid_id={$_POST['delete_coments']}";
    }
    else {

        $board_id = $_POST['board_id'];

        $query = "delete from ci_board where board_id={$board_id}";

    }

    mysqli_query($connect, $query);

    mysqli_close($connect);

    echo "<script>document.location.href='main.php'</script>";

}
else{
    echo "로그인하세요 ^^";
    echo "<input type='button' value='돌아가기' onclick='window.location.href=\"main.php\"'>";
}


?>