
<html>

<head>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>

<table border="1" align="center">

    <tr align="center">
        <td width="100px">글번호</td>
        <td width="200px">제목</td>
        <td width="100px">날짜</td>
        <td width="100px">글쓴이</td>
        <td width="100px">닉네임</td>
    </tr>

    <?php

    /////////////////////////////////////////////////////////////////////////////////////////
    /// 로그인 부분
    if(isset($_SESSION['log_id'])){

     echo "{$_SESSION['log_id']}님 환영합니다! ";
     echo "<form action='login.php' method='post'>";
     echo "<input type='submit' value='Logout' name='log_out'>";
     echo "</form>";
    }
    else {
        echo "<form action='login.php' method='post'>";
        echo "ID : <input type='text' id='idid' name='log_id'><input type='submit' value='Login' name='log_in'><br>";
        echo "PW : <input type='text' name='log_pw'>";
        echo "</form>";
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    /// DB 부분

    $connect = mysqli_connect('localhost','root','autoset');

    mysqli_select_db($connect,'moon');

    if( isset($_POST['search_value']) ){                //  검색 했을때

        switch($_POST['search_type']){       // 셀렉트에 따른 쿼리선택
            case 1: // 제목
                $query = "select * from ci_board where subject like '{$_POST['search_value']}'";
                break;
            case 2: // 내용
                $query = "select * from ci_board where contents like '{$_POST['search_value']}'";
                break;
            case 3: // 글쓴이
                $query = "select * from ci_board where user_name like '{$_POST['search_value']}'";
                break;
            case 4: // 제목+내용+글쓴이
                $query = "select * from ci_board where contents like '{$_POST['search_value']}' or subject like '{$_POST['search_value']}' or user_name like '{$_POST['search_value']}'";
        }

        if(isset($_POST['page_num'])){  // 페이지선택

            $page_num = $_POST['page_num']*5-5;
            $query_all_select = $query;
            $query_limit_select = "{$query} limit {$page_num},5";
        }
        else{                            // 페이지선택 X
            $query_all_select = $query;
            $query_limit_select = "{$query} limit 5";
        }
    }
    else{                                                 // 검색 안했을때
        $query_all_select = "select * from ci_board";

        if(isset($_POST['page_num'])){

            $page_num = $_POST['page_num']*5-5;
            $query_limit_select = "select * from ci_board where board_id limit {$page_num},5"; // ~ 부터 5개만 선택
        }
        else {

            $query_limit_select = "select * from ci_board where board_id limit 5"; // 5개만 선택
        }
    }

    $query_num_limit = mysqli_query($connect,$query_limit_select); // 5개만 선택

    $query_num_all = mysqli_query($connect,$query_all_select);  // 전체선택

    $num_rows_limit = mysqli_num_rows($query_num_limit);  // 5개만 선택

    $num_rows_all = mysqli_num_rows($query_num_all);    // 전체선택

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// 검색 부분

    echo "<div align='center'>";
    echo "<form action='main.php' method='post'>";
    echo "<select name='search_type'> ";
    echo "<option value='1'>제목</option> ";
    echo "<option value='2'>내용</option> ";
    echo "<option value='3'>글쓴이</option> ";
    echo "<option value='4'>제목+내용+글쓴이</option> ";
    echo "<input type='text' name='search_value'> ";
    echo "<input type='submit' value='검색'><br>";
    echo "</form>";
    echo "</div>";

    /////////////////////////////////////////////////////////////////////////////////////////
    /// 페이지 출력부분

    for($i=0; $i<$num_rows_limit; $i++){

        $result = mysqli_fetch_array($query_num_limit);

        echo "<tr align='center'>";
        echo "<td>{$result['board_id']}</td>";
        echo "<td><a href='contents.php?board_id={$result['board_id']}&subject={$result['subject']}'>{$result['subject']}</a></td>";
        echo "<td>{$result['reg_data']}</td>";
        echo "<td>{$result['user_name']}</td>";
        echo "<td>{$result['user_id']}</td>";
        echo "</tr>";
    }

    echo "<div align='center'>";

    ///////////////////////////////////////////////////////////////////////////////////////

        echo "<form action='main.php' method='post'>";

        if(isset($_POST['search_type'])){
            echo "<input type='hidden' value='{$_POST['search_value']}' name='search_value' '> ";
            echo "<input type='hidden' value='{$_POST['search_type']}' name='search_type' '> ";
        }
        for ($i = 0; $i < $num_rows_all / 5; $i++) {

            $i++;   //  1부터 시작

            echo "<input type='submit' value='$i' name='page_num'>";

            if ($num_rows_all % 5 != 0) {
                $i++;
                echo "<input type='submit' value='$i' name='page_num'>";
            }
        }
        echo "</form>";

    /////////////////////////////////////////////////////////////////////////////////////////

    echo "</div><br>";

    mysqli_close($connect);
    ?>

</table>

<?php
    echo "<br><div align='center'>";
    echo "<form action='newtext.php' method='post'>";
    echo "<input type='submit' value='글쓰기'></form>";
    echo "</div>";
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
</body>

</html>
