<?php
class database{

    private static $conn;
    private static $servername = "localhost";
    private static $password;
    private static $username;
    private static $databasename= "forum";

    public function __construct()
    {
        $databasename = database::$databasename;
        $server = database::$servername;
        try {
            database::$conn = new PDO("mysql:host=$server;dbname=$databasename");
            // set the PDO error mode to exception
            database::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            echo "Connection with database failed, please contact a admin and include the following message : " . $e->getMessage();
        }

    }

    public static function getConn()
    {
        return self::$conn;
    }

    public static function standard($query){
        $conn = database::getConn();
        $send_to_database = $conn->prepare("$query");
        $send_to_database->execute();
        $result = $send_to_database->fetchAll();
        return $result;
    }

    public static function no_return($query){
        $conn = database::getConn();
        $send_to_database = $conn->prepare("$query");
        $send_to_database->execute();
    }

    public static function get_main_topics(){
        $return = database::standard("SELECT * FROM main_topics");
        return $return;
    }

    public static function get_sub_topics($upperlevelid){
        $return = database::standard("SELECT * FROM sub_topics WHERE upper_level_id = $upperlevelid");
        return $return;
    }

    public static function get_topics($upperlevelid){
        $return = database::standard("SELECT * FROM posts WHERE upper_level_id = $upperlevelid");
        return $return;
    }

    public static function get_comments($upperlevelid){
        $return = database::standard("SELECT * FROM comments WHERE upper_level_id = $upperlevelid");
        print_r($upperlevelid);
        return $return;
    }

    public static function get_geust(){
        $return = database::standard("SELECT * FROM users WHERE id = 12");
        return $return;
    }

    public static function get_user($id){
        $return = database::standard("SELECT * FROM users WHERE id = $id");
        return $return;
    }

    public static function get_author($author){
        $return = database::standard("SELECT * FROM users WHERE id = $author");
        return $return[0];
    }

    public static function get_post($upperid){
        $return = database::standard("SELECT * FROM posts WHERE id = $upperid");
        return $return[0];
    }

    public static function ban_post($where,$post_id,$user,$reason){
        $return = database::no_return("UPDATE $where SET `banned_by_user_id` = '$user,$reason' WHERE $where.`id` = $post_id;");
    }


    public static function add_comment($title,$content,$user,$path,$vieuw){
        $score = 0;
        $status = 0;
        $datum = date("Y-m-d");;
        $user_id = $user[0]["id"];

        database::no_return("INSERT INTO `comments` (`name`, `content`, `score`, `status`, `date`, `user_id`, `upper_level_id`, `user_level_req_vieuw`, `user_level_req_edit`) VALUES ('$title', '$content', '$score', '$status', '$datum', '$user_id', '$path', '$vieuw', '4')");
    }

    public static function new_post($user,$title,$desc,$content,$vieuw,$upper){
        $datum = date("Y-m-d");

        database::no_return("INSERT INTO `posts` (`name`, `description`, `user_id`, `content`, `status`, `rating`, `upper_level_id`, `date`, `user_level_req_vieuw`, `user_level_req_edit`) VALUES ('$title', '$desc', '{$user[0]['id']}', '$content', '0', '0', '$upper', '$datum', '$vieuw', '5')");



    }

    public static function new_sub_topic($user,$title,$desc,$vieuw,$upper){

        database::no_return("INSERT INTO `sub_topics` (`name`, `description`, `status`, `user_level_req_vieuw`, `user_level_req_edit`, `user_id`, `upper_level_id`) VALUES ('$title', '$desc', '0', '$vieuw', '2', '{$user[0]['id']}', '$upper')");
    }

    public static function new_main_topic($title,$desc,$vieuw){

        database::no_return("INSERT INTO `main_topics` (`name`, `description`, `status`, `user_level_req_vieuw`, `user_level_req_edit`) VALUES ('$title', '$desc', '$vieuw', '8', '2');");
    }

    public static function edit_comment($title,$content,$path,$vieuw,$id){
        $score = 0;
        $status = 0;
        $datum = date("Y-m-d");
        print_r("heyy");
        database::no_return("UPDATE `comments` SET `name` = '$title',`date` = '$datum', `content` = '$content',`user_level_req_vieuw` = '$vieuw', `upper_level_id` = '$path' WHERE `comments`.`id` = '$id';");
    }

    public static function get_comment($id){
        $return = database::standard("SELECT * FROM comments WHERE id = $id");
        return  $return;
    }

    public static function update_sub_topic($title,$desc,$vieuw,$id){
        database::no_return("UPDATE `sub_topics` SET `name` = '$title', `description` = '$desc', `user_level_req_vieuw` = '$vieuw', WHERE `sub_topics`.`id` = $id;");
    }

    public static function update_main_topic($title,$desc,$vieuw,$id){
        database::no_return("UPDATE `main_topics` SET `name` = '$title', `description` = '$desc', `user_level_req_vieuw` = '$vieuw' WHERE `main_topics`.`id` = $id;");
    }

    public static function update_post($title,$desc,$content,$vieuw,$id){
        $datum = date("Y-m-d");

        database::no_return("UPDATE `posts` SET `name` = '$title', `description` = '$desc', `content` = '$content', `date` = '$datum', `user_level_req_vieuw` = '$vieuw' WHERE `posts`.`id` = $id;");
    }



}
?>