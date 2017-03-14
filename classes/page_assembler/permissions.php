<?php
class permissions extends page_assembler {


    public function __construct()
    {
    }

    public function check_vieuw($user,$data){
        if(isset($data['user_level_req_vieuw'])){
            if($user[0]['level'] <=$data['user_level_req_vieuw']){
                return true;
            }else{
                return false;
            }
        }
        else{
            return true;
        }
    }

    public function check_edit($user,$data){
        if(isset($data['user_id'])){
            if($user[0]['id'] == $data['user_id']){
                return  "owner";
            }
        }
        if(isset($data['user_level_req_edit'])) {
            if ($user[0]['level'] <= $data['user_level_req_edit']) {
                return true;
            }
        }elseif ($user[0]['level'] <=2){
            return true;
        }
        $path = $this->getPath();
        $type = $this->getType();
        $class = explode(",",$user[0]['class']);
        if($path != '') {
            $path = explode("%", $path);
            //path should be [0] = maintopic.id [1] = subtopic.id [2] = posts.id [3] = comments.id
        }
        foreach($class as $x=>$v) {
            switch ($type) {
                case 3:
                    if ($v == "3.". $path[3]) {
                        return true;
                    }
                case 2:
                    if ($v == "2.". $path[2]) {
                        return true;
                    }
                case 1:
                    if ($v == "1.". $path[1]) {
                        return true;
                    }
                case 0:
                    if ($v == "0.". $path[0]) {
                        return true;
                    }
            }
        }
        return false;
    }
}
?>