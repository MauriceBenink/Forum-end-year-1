<?php
include "classes/page_assembler/page-assembler.php";
class assembler{

    private $_user;
    private $_data;
    private $_page_assembler;
    private $_type;
    private $_path;


    public function __construct($user,$path=''){
        $this->_data = $this->path_to_data($path);
        $this->_user = $user;
        $this->_page_assembler = new page_assembler;
        print_r( $this->getType());
    }

    public function assamble_page()
    {
        if(empty($this->_data)||!isset($this->_data)){
            if (count($this->_path) >= 3) {
                $post = database::get_post($this->_path[2]);
                $return = $this->_page_assembler->comment_construction($this->_user, $post, "post-");
                echo $return;
                echo "<div class = 'empty page'>no comments here yet, be the first one to comment something :D</div>";
            }else{
                echo "<div class = 'empty page'>no posts here yet, be the first one to post something :D</div>";
            }

        }else {
            if (count($this->_path) >= 3) {
                $post = database::get_post($this->_data[0]['upper_level_id']);
                if ((!isset($post['banned_by_user_id']) || empty($post['banned_by_user_id'])) && $this->_user[0]['level'] <= $post['user_level_req_vieuw']) {
                    $return = $this->_page_assembler->comment_construction($this->_user, $post, "post-");
                } else {
                    return;
                }
            } else {
                //  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                // $return = $this->_page_assembler->assemble_menu($this->_user,$this->_path);
            }
            if(isset($return)&&!empty($return)) {
                echo $return;
            }
            foreach ($this->_data as $x => $y) {
                $return = '';
                if ((!isset($this->_data[$x]['banned_by_user_id']) || empty($this->_data[$x]['banned_by_user_id'])) && $this->_user[0]['level'] <= $this->_data[$x]['user_level_req_vieuw']) {
                    if (count($this->_path) >= 3) {
                        $return[$x] = $this->_page_assembler->comment_construction($this->_user, $this->_data[$x]);
                    } else {
                        $return[$x] = $this->_page_assembler->post_construction($this->_user, $this->_data[$x]);
                    }

                    //!TEMP!!!!!!!!!!!!!!!!!!!
                    echo $return[$x];
                    // $return[0] == content
                    // $return [1] == position
                }
            }
        }
        if (count($this->_path) >= 3) {
            $return = $this->_page_assembler->comment_box_constructor($this->_user, $this->_path[2]);
            echo $return;
        } elseif(isset($this->_path)&&!empty($this->_path)) {
            $return = $this->_page_assembler->place_post_constructor($this->_user, $this->_type);
            echo $return;
        }
        $this->_page_assembler->javascript_constructor();
    }

    private function path_to_data($path){
        $this->_type = 0;
        if(is_array($path)){
            $holder = $path;
        }elseif ($path ==='') {
            $this->_path = 0;
            return database::get_main_topics();
        }else{
                $holder = explode("/",$path);
        };
        $this->_path = $holder;
        $counter = count($holder);
        switch($counter){
            case 1: // 1 = main class selected, display all subclasses within
                $this->_type = 1;
                return database::get_sub_topics($holder[0]);
                break;
            case 2:
                $this->_type = 2;
                return database::get_topics($holder[1]);
                break;
            case 3:
                $this->_type = 3;
                return database::get_comments($holder[2]);
                break;
            // case 4: get_comments + navigate to comment;
            default :
                return database::get_comments($holder[2]);
                break;
        }
    }

    public function edit($data)
    {
        $element = explode('**', $data);
        include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/classes/database/database.php";
        include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/Php/global_functions.php";
        if ($this->_page_assembler->check_edit($this->_user, $this->_data)||$this->_page_assembler->check_edit($this->_user, $this->_data)=='owner') {

            $path = $_SESSION['path'];
            $path = explode("/", $path);
            if ($element[2] == true) {
                $vieuw = 8;
            } else {
                $vieuw = 9;
            }
            if (!preg_match('/[\(\)\[\]\}\{\<\>]/', $element[1]) && strlen($element[1]) > 10) {
                if (!preg_match('/<script>/', $element[0]) && strlen($element[0]) > 25) {
                    if (blacklist($element[0] . '' . $element[1])) {

                        database::edit_comment($element[1], $element[0], $path[2], $vieuw, $element[3]);
                        header("Refresh:0;");
                    }
                }
            }
        }
    }

    public function delete($data){
        $data = explode(",",$data);
        $post_id = $data[0];
        $user = $this->_user;
        $user_id = $user[0]['id'];
        $reason = $data[1];
        $permission = false;
        $type;
        if(isset($data['user_level_req_edit'])) {
            if ($user[0]['level'] <= $data['user_level_req_edit']) {
                $permission =  true;
            }
        }elseif ($user[0]['level'] <=2){
            $permission = true;
        }
        if($permission){
            echo "<br>";
            switch($this->getType()) {
                case 0:
                    $permission = false;
                    break;
                case 1:
                    $type = "sub_topics";
                    break;
                case 2:
                    $type = "posts";
                    break;
                case 3:
                    $type = "comments";
                    break;
            }
            echo $type."".$post_id."".$user_id."".$reason;
            if($permission) {
                database::ban_post($type, $post_id, $user_id, $reason);
            }
        }
        header("Location: landing.php");

    }

    public function getType()
    {
        return $this->_type;
    }

    public function getPath()
    {
        return $this->_path;
    }
}
?>