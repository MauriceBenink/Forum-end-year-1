<?php
include "classes/page_assembler/permissions.php";
class page_assembler extends assembler {

    private $_permissions;


    function __construct()
    {
        $this->_permissions = new permissions();
    }

    public function check_edit($user,$data){
        return $this->_permissions->check_edit($user,$data);
    }

    public function assemble_menu($user,$path=0){
        $path_array = explode('%',$path);
        $posting_allowed = '';
        if($user['level']<=count($path_array)*2+2){
            $posting_allowed = "<div id = 'post_to_site'><button><img src = img/post.jpg></button></div>";
        }
        $return = "
<div id ='header-options'>
    <div id = 'search'>
        search the forum
    </div>
    <div id = 'nieuw-topics'>
        show recently added topics
    </div>
    $posting_allowed;
</div>
";
        return $return;
    }

    public function toolbar_construction($user,$data,$post=''){
        if($post == '') {
            if (isset($post) && !empty($post)) {
                $post = "2.";
            }
            $return = '';
            switch ($this->_permissions->check_edit($user, $data)) {
                case true:
                    $return .= "<button id = " . $post . $data['id'] . " class = 'edit_button'><img src = 'img/edit.jpg'></button>";
                    $return .= "<button id = " . $post . $data['id'] . " class = 'remove_button'><img src = 'img/remove.jpg'></button>";
                    $return .= "<button id = " . $post . $data['id'] . " class = 'status_button'><img src = 'img/status.jpg'></button>";
                    $return .= "<button id = " . $post . $data['id'] . " class = 'mod_button'><img src = 'img/mod.jpg'></button>";
                    break;
                case "owner":
                    $return .= "<button id = " . $post . $data['id'] . " class = 'edit_button'><img src = 'img/edit.jpg'></button>";
                    $return .= "<button id = " . $post . $data['id'] . " class = 'remove_button'><img src = 'img/remove.jpg'></button>";
                    break;
            }
            return $return;
        }
    }



    public function comment_construction($user,$data,$post='')
    {
        if(isset($post)&&!empty($post)){
            $postnr = "2.";
        }else{
            $postnr = '';
        }

        $author = database::get_author($data['user_id']);

        $return = "<div id = ".$postnr.$data['id']." class = 'comment-" . $post . "container'>";
        $return .= "<div class = 'comment-" . $post . "toolbar'>";
        $return .= $this->toolbar_construction($user, $data,$post) . "</div>";
        $return .= "<div class = comment-" . $post . "content-container>";
        $return .= "<div class = user-info>";
        $return .= "<div class = user-png><img src = img/" . $author['png'] . "></div>";
        $return .= "<div class = user-display-name>" . $author['display_name'] . "</div>";
        $return .= "<div class = user-rank>" . $author["popularity_rank"] . "</div>";
        $return .= "<div class = user-info-blank></div></div>";
        $return .= "<div class = 'comment-" . $post . "content'>";
        $return .= "<div class = 'comment-" . $post . "title'>" . $data['name'] . "</div>";
        $return .= "<div class = 'comment-" . $post . "comment'>" . $data['content'] . "</div>";
        if((!isset($post)||empty($post))&&isset($author['comment_footer'])){
            $return .= "<div class = comment-footer>".$author["comment_footer"]."</div>";
        }
        $return .="</div></div></div>";
        return $return;

    }

    public function comment_box_constructor($user,$data){
        if(is_array($data)){
            $can_comment = database::get_post("{$data[0]['upper_level_id']}");
        }else{
            $can_comment = database::get_post("{$data}");
        }

        if($can_comment['user_level_req_vieuw']>=$user[0]['level']) {
            if($user[0]['level'] != 9) {
                $return = "
<div id = 'comment-box'>
    <input class = 'title' name = 'title' type = 'text' placeholder='comment title'>
    <textarea></textarea>
    <input class = 'geustsee' type='checkbox' name=cansee> geusts can't see this comment
    <br>
    <button id = 'send_comment'>Send</button>
    <script>
        $(document).find('#send_comment').click(function(){comment_click()});
        
        window.onerror = function(){
            return true;
        };
            
            
        function comment_click(){
            element =  $(document).find('#send_comment').parent().find('div > .nicEdit-main').html();
            element2 =  $(document).find('#send_comment').parent().find('.title').val();
            element3 =  $(document).find('#send_comment').parent().find('.geustsee').prop('checked');
            
            console.log(element);           
            elementsend = element +'%%'+ element2 +'%%'+element3;
            
                                    
            try{if(((element2.match(/[\<\>\{\}\[\]\;]/)).length>0)){
                alert('the following symbols arent allowed []{}<>');
            }}
            catch(err){
                    if(element.replace(/<br>|&amp;|&lt;|&gt;|&nbsp;/g,'1').length >=25){
                        ajax_processer('new_comment',elementsend);
                    }else{
                        alert('comment text is too short!');
                    }
                }
            }
           window.onerror = '';
    </script>
</div>";
            }else{
                $return = "<div id = 'login-popup'>Please login to comment</div>";
            }
        }else{

        }
        return $return;
    }

    public function post_construction($user,$data){
        $return = "<div class = post-container>";
        $return .= "<div class = post-toolbar'>";
        $return .= $this->toolbar_construction($user,$data)."</div>";
        $return .="<div id =". $data['id']." class = 'post-info-container'>";
        $return .="<div class = 'post-name'>".$data['name']."</div>";
        $return .="<div class = 'post-author'>";
        if(isset($data['user_id'])&&!empty($data['user_id'])){
            $return .= database::get_author($data['user_id'])['display_name'];
        }
        $return .="</div>";
        $return .="<div class = 'post-description'>".$data['description']."</div>";
        $return .="</div></div>";
        return  $return;
    }

    public function place_post_constructor($user,$type,$path){
        $permission = $type*3+2;
        switch($type){
            case 0:
                $type = "main-post";
                break;
            case 1:
                $type = "sub-topic";
                break;
            case 2:
                $type = "posts";
                break;
        }
        if($user[0]['level']<$permission) {
            $make_post = "<div id = 'make-new-post'><button>New $type</button></div>";
            $return = "
<script>
            $(document).find('#forum-container').after(\"$make_post\");
            $(document).find('#make-new-post > button').click(function(){post_click()});
            
            function post_click(){
                $(document).find('#make-new-post').html('' +
                    '<input placeholder = \"post title\">' +
                    '<br>' +
                    '<input placeholder = \"post description\">' +
                    '<br>' +";
                    if(count($path) == 2){
                        $return .="'<textarea placeholder = \"post content\" ></textarea>' +
                    '<br>' +"
                        ;}
                    $return .="
                    '<input class = \'geustsee\' type = \'checkbox\'>geusts cant see '+
                    '<br>' +
                    '<button id = \'new-post\'>make new post</button>'
                    );
                     $(document).find('#new-post').click(function(){post_send()});
            }
            
            function post_send(){
                element = $(document).find('#make-new-post');
                elementtitle = $(element).children().eq(0).val();
                elementdesc = $(element).children().eq(2).val();";
                if(count($path) == 2){
                    $return .=
                        "elementcont = $(element).children().eq(4).val();"
                    ;}else{
                        $return .="elementcont = 'ajkbdjasbjkbdakjbsdkjabdjksbsaajkbdkjabdkjbsakbkjasbdjkbaksjdbjkasbdkjbasjkdbajskbdjasbjkdbakjsdbjkasbdkjabsjdkbasjkbdkajbsdkj';";
                }
                $return .="
                elementcheck = $(element).children().eq(6).prop('checked');
                console.log(elementtitle+'%%'+elementdesc+'%%'+elementcont+'%%'+elementcheck);
                console.log(elementtitle.length + '||'+elementdesc.length+'||'+elementcont.length);
                try{if((((elementtitle+''+elementdesc+''+elementcont).match(/[\<\>\{\}\[\]\;]/)).length>0)){
                    alert('the following symbols arent allowed []{}<>;');
                }}
                catch(err){
                    if(elementtitle.length >= 10&&elementtitle.length <50 && elementdesc.length >= 10 && elementdesc.length < 100 && elementcont.length >= 50 && elementcont.length < 2000){
                        elementsend = elementtitle+'%%'+elementdesc+'%%'+elementcont+'%%'+elementcheck;
                    ajax_processer('new_post',elementsend);
                    }else{
                        alert('too long or too short');
                    }
                    
                }
            }
</script>";
            return $return;
        }
    }

    public function javascript_constructor(){
        include("misc/javascript_constructor.php");
    }


}
?>