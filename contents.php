<?php
//////////////////////////////////////////////////////////////////////////////////////////
///  DB저장 부분

$board_id = $_GET['board_id'];

$subject = $_GET['subject'];

$connect = mysqli_connect('localhost','root','autoset');

mysqli_select_db($connect,'moon');

$query = "select * from ci_board where board_id={$board_id}";

$query_result = mysqli_query($connect,$query);

$result = mysqli_fetch_array($query_result);

///////////////////////////////////////////////////////////////////////////////////////////
///  내용 출력 부분

echo "<div align='center'>";
echo "글제목 : <input type='text' value='{$result['subject']}' readonly><br><br>";

echo "<textarea cols='40' rows='20' readonly>{$result['contents']}</textarea><br><br>";

echo "<form method='post'>";
echo "<input formaction='change.php' type='submit' value='수정'> <input formaction='delete.php' type='submit' value='삭제'>";
echo "<input type='hidden' value='{$board_id}' name='board_id'>";
echo "</form>";


////////////////////////////////////////////////////////////////////////////////////////////
///  댓글 작성 부분

echo "<form action='savetext.php' method='post'>";
echo "<input type='text' name='coments'> <input type='submit' value='댓글작성'>";
echo "<input type='hidden' value='$board_id' name='coments_board_id'>";
echo "<input type='hidden' value='$subject' name='coments_subject'>";
echo "</form>";

////////////////////////////////////////////////////////////////////////////////////////////
///  댓글 출력 DB

$query_coments = "select * from coments where board_id={$board_id}";

$query_coments_result = mysqli_query($connect,$query_coments);      // 댓글 검색 결과

$query_coments_rows = mysqli_num_rows($query_coments_result);       // 결과 길이 측정

//////////////////////////////////////////////////////////////////////////////////////////////
///  댓글 출력 부분

$num = 0;

for($i=0; $i<$query_coments_rows; $i++){

    $query_coments_final = mysqli_fetch_array($query_coments_result);

    echo "<table border='1'>";
    echo "<tr align='center'>";
    echo "<td width='200px'>{$query_coments_final['pid_contents']}</td>";
    echo "<td width='100px'>{$query_coments_final['user_name']}</td>";
    echo "<td width='100px'>{$query_coments_final['user_id']}</td>";
    echo "<td width='50px'><form action='delete.php' method='post'><input type='submit' value='삭제'>
            <input type='hidden' value='{$query_coments_final['pid_id']}' name='delete_coments'></form></td>";
    echo "</tr>";
    echo "</table>";
}

echo "</div>";

/////////////////////////////////////////////////////////////////////////////////////////////
mysqli_close($connect);

?>

