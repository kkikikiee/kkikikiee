<?php

$user_id = 'kkikikiee';    // 아이디
$user_name = '김영문';      // 이름
$date = date('Y-m-d h:i:s'); // 시간

//////////////////////////////////////////////////////////////////////////////////////////
/// DB부분

$connect = mysqli_connect('localhost','root','autoset');

mysqli_select_db($connect,'moon');

if(isset($_POST['board_id']) && isset($_SESSION['log_id'])){

    $board_id = $_POST['board_id'];
    $title_change = $_POST['title_change'];
    $contents_change = $_POST['text_change'];

    $query ="update ci_board set contents = '{$contents_change}',subject='{$title_change}' where board_id={$board_id}";

    echo $query;
}
else if(isset($_POST['coments'])){

    $board_id = $_POST['coments_board_id'];
    $pid_contents = $_POST['coments'];

    $query = "insert into coments (board_id,pid_contents,user_name,user_id) VALUES ('{$board_id}','{$pid_contents}','{$user_name}','{$user_id}')";

}
else{
    $title = $_POST['title'];   // 제목
    $contents = $_POST['text']; // 내용
    $query = "insert into ci_board (user_id,user_name,subject,contents,reg_data) values ('{$user_id}','{$user_name}','{$title}','{$contents}','{$date}')";

}

mysqli_query($connect,$query);

mysqli_close($connect);

///////////////////////////////////////////////////////////////////////////////////////////

$board_id = $_POST['coments_board_id'];

$subject = $_POST['coments_subject'];

echo "<script>document.location.href='contents.php?board_id={$board_id}&subject={$subject}'</script>"; // 저장완료후, main 으로 돌아가기

?>