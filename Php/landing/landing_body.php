<?php
include "classes/page_assembler/assembler.php";
include "classes/database/database.php";
include "php/global_functions.php";
include "php/ajax_files/ajax_landing_comunication.php";
new database();
?>
<nav>to be nav</nav>
<?php

if(isset($_GET['path'])&&!empty($_GET['path'])){
    $_SESSION['path'] = $_GET['path'];
}

if(isset($_SESSION['id'])&&!empty($_SESSION['id'])) {
    print_r($_SESSION);
    $user = database::get_user($_SESSION['id']);
    $display = $user[0]['display_name'];
    $status = explode(",", $user[0]['status']);
    if($status[0] == 0)
    {   header("Location: verification.php?");
        die();
    }else if($status[0] == 2) {
    }
    ?>
    <form method="post">
        <input name="logout" type="Submit" value="logout" >
    </form>
    <?php
}else {
    $user = database::get_geust();
    $display = " guest";
    ?>
    <form action="index.php">
        <input name="login" type="Submit" value="login">
    </form>
    <?php
}
if(isset($_GET['path'])&&!empty($_GET['path'])){
    echo "<div id = level-up-button><button>back up</button></div>";
    echo "<div id = to-top-button><button>to main-topics</button></div>";
    $test = new assembler($user,$_GET['path']);
}else{
    $test = new assembler($user);
}

if(isset($_SESSION['delete'])&&!empty($_SESSION['delete'])&&isset($_SESSION['id'])){
    $test -> delete($_SESSION['delete']);
    echo "Deleted";
    unset($_SESSION['delete']);
}

if(isset($_SESSION['new_post'])&&!empty($_SESSION['new_post'])){
    $test ->new_post($_SESSION['new_post']);
    unset($_SESSION['new_post']);
}

if(isset($_SESSION['edit_post'])&&!empty($_SESSION['edit_post'])){
    $test->edit_post($_SESSION['edit_post']);
    unset($_SESSION['edit_post']);
}

if(isset($_SESSION['edit_comment'])&&!empty($_SESSION['edit_comment'])){
    $test ->edit_comment($_SESSION['edit_comment']);
    unset($_SESSION['edit_comment']);
}

echo "<br>welcome $display ";
if (isset($_POST['logout'])) {
    unset($_SESSION['id']);
    header("Location: landing.php?");
}
debug_r($test);
echo "<div id = forum-container>";
$test->assamble_page();
echo "</div>";
echo "<div id = Insert-container></div>";

//onclick of link, refresh page and load related information
?>
<div id="javascript-dump"></div>
