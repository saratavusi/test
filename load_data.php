<?php
error_reporting(E_ALL ^ E_DEPRECATED);
?>
<?php
if($_POST['page'])
{
    $page = $_POST['page'];
    $cur_page = $page;
    $page -= 1;
    $per_page = 10;
    $previous_btn = true;
    $next_btn = true;
    $first_btn = true;
    $last_btn = true;
    $start = $page * $per_page;
    include_once("inc/conect.php");
    db();
    $query_pag_data = "SELECT * FROM `newsletter_tb`order by news_id DESC limit $start,$per_page";
    $result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());
    $msg = "";
    while ($row = mysql_fetch_array($result_pag_data)) {

        echo"
<div class='newsbody'>
<div class='newsinfo'>
  <a href='$row[link]' > <div class='newstitle'>$row[title]</div></a>
    <div class='morinfo'>$row[description]</div>
</div>
    <div class='newsimg'> <a href='$row[link]' ><img style='margin: 0 auto;' src='img/$row[img]'></a></div>

</div>

";
    }

        $msg = "<div class='data'><ul>" . $msg . "</ul></div>"; // Content for Data
    $query_pag_num = "SELECT COUNT(*) AS count FROM `newsletter_tb`";
    $result_pag_num = mysql_query($query_pag_num);
    $row = mysql_fetch_array($result_pag_num);
    $count = $row['count'];
    $no_of_paginations = ceil($count / $per_page);

    /* ---------------Calculating the starting and endign values for the loop----------------------------------- */
    if ($cur_page >= 7) {
        $start_loop = $cur_page - 3;
        if ($no_of_paginations > $cur_page + 3)
            $end_loop = $cur_page + 3;
        else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
            $start_loop = $no_of_paginations - 6;
            $end_loop = $no_of_paginations;
        } else {
            $end_loop = $no_of_paginations;
        }
    } else {
        $start_loop = 1;
        if ($no_of_paginations > 7)
            $end_loop = 7;
        else
            $end_loop = $no_of_paginations;
    }
    /* ----------------------------------------------------------------------------------------------------------- */
    $msg .= "<div class='pagination'><ul>";

// FOR ENABLING THE FIRST BUTTON
    if ($first_btn && $cur_page > 1) {
        $msg .= "<li p='1' class='active'>صفحه اول</li>";
    } else if ($first_btn) {
        $msg .= "<li p='1' class='inactive'>صفحه اول</li>";
    }

// FOR ENABLING THE PREVIOUS BUTTON
    if ($previous_btn && $cur_page > 1) {
        $pre = $cur_page - 1;
        $msg .= "<li p='$pre' class='active'>قبلی</li>";
    } else if ($previous_btn) {
        $msg .= "<li class='inactive'>قبلی</li>";
    }
    for ($i = $start_loop; $i <= $end_loop; $i++) {

        if ($cur_page == $i)
            $msg .= "<li p='$i' style='color:#fff;background-color:#3384df;' class='active'>{$i}</li>";
        else
            $msg .= "<li p='$i' class='active'>{$i}</li>";
    }

// TO ENABLE THE NEXT BUTTON
    if ($next_btn && $cur_page < $no_of_paginations) {
        $nex = $cur_page + 1;
        $msg .= "<li p='$nex' class='active'>بعدی</li>";
    } else if ($next_btn) {
        $msg .= "<li class='inactive'>بعدی</li>";
    }

// TO ENABLE THE END BUTTON
    if ($last_btn && $cur_page < $no_of_paginations) {
        $msg .= "<li p='$no_of_paginations' class='active'>صفحه آخر </li>";
    } else if ($last_btn) {
        $msg .= "<li p='$no_of_paginations' class='inactive'>صفحه آخر </li>";
    }
    echo $msg;
}

