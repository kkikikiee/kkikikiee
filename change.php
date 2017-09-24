<?php

if(isset($_SESSION['log_id'])){
    ///////////////////////////////////////////////////////////////////////////////////////////
///  DB 부분

    $board_id = $_POST['board_id'];

    $connect = mysqli_connect('localhost','root','autoset');

    mysqli_select_db($connect,'moon');

    $query = "select * from ci_board where board_id={$board_id}";

    $query_result = mysqli_query($connect,$query);

    $result = mysqli_fetch_array($query_result);

////////////////////////////////////////////////////////////////////////////////////////////
///  출력 부분

    echo "<div align='center'>";
    echo "<form action='savetext.php' method='post'>";

    echo "글제목 : <input type='text' value='{$result['subject']}' name='title_change'><br><br>";

    echo "<textarea cols='40' rows='20' name='text_change'>{$result['contents']}</textarea><br><br>";

    echo "<input type='submit' value='확인' name='complete'> <input type='button' value='취소' onclick='window.location.href=\"main.php\"'>";
    echo "<input type='hidden' value='$board_id' name='board_id'>";
    echo "</form>";
    echo "</div>";
}
else{
    echo "로그인하세요 ^^";
    echo "<input type='button' value='돌아가기' onclick='window.location.href=\"main.php\"'>";
}


?>