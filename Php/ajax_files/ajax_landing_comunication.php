<?php

if(!isset($_SESSION)){
    session_start();
}

if(isset($_POST["level_down"])&&!empty($_POST["level_down"])){
    $level = explode("%%",$_POST['level_down']);
    if($level[1]!=''){
        $holder = explode("/",$level[1]);
        $holder[] = $level[0];
    }else{
        $holder = [$level[0]];
    }
    $holder = implode("/",$holder);
    echo "false%%<script>window.location.replace('landing.php?path=$holder');</script>";
}


if(isset($_POST["level_up"])&&!empty($_POST["level_up"])){
    $holder = explode("/",$_POST['level_up']);
    unset($holder[count($holder)-1]);
    $holder = implode("/",$holder);
    echo "false%%<script>window.location.replace('landing.php?path=$holder');</script>";
}

if((isset($_POST["to_top"]))){
    echo "false%%<script>window.location.replace('landing.php');</script>";
}

if(isset($_POST['edit_button'])&&!empty($_POST['edit_button'])){
    $niceEdit = '<div unselectable="on" style="width: 157px;"><div class=" nicEdit-panelContain" unselectable="on" style="overflow: hidden; width: 100%; border: 1px solid rgb(204, 204, 204); background-color: rgb(239, 239, 239);"><div class=" nicEdit-panel" unselectable="on" style="margin: 0px 2px 2px; zoom: 1; overflow: hidden;"><div style="float: left; margin-top: 2px; display: none;"><div class=" nicEdit-buttonContain    " style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -432px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -54px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -126px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -342px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -162px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -72px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -234px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -144px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -180px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -324px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin: 2px 1px 0px;"><div class=" nicEdit-selectContain" unselectable="on" style="width: 90px; height: 20px; cursor: pointer; overflow: hidden; opacity: 0.6;"><div unselectable="on" style="overflow: hidden; zoom: 1; border: 1px solid rgb(204, 204, 204); padding-left: 3px; background-color: rgb(255, 255, 255);"><div class=" nicEdit-selectControl" unselectable="on" style="overflow: hidden; float: right; height: 18px; width: 16px; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -450px 0px;"></div><div class=" nicEdit-selectTxt" unselectable="on" style="overflow: hidden; float: left; width: 66px; height: 14px; margin-top: 1px; font-family: sans-serif; text-align: center; font-size: 12px;">Font&nbsp;Size...</div></div></div></div><div unselectable="on" style="float: left; margin: 2px 1px 0px;"><div class=" nicEdit-selectContain" unselectable="on" style="width: 90px; height: 20px; cursor: pointer; overflow: hidden; opacity: 0.6;"><div unselectable="on" style="overflow: hidden; zoom: 1; border: 1px solid rgb(204, 204, 204); padding-left: 3px; background-color: rgb(255, 255, 255);"><div class=" nicEdit-selectControl" unselectable="on" style="overflow: hidden; float: right; height: 18px; width: 16px; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -450px 0px;"></div><div class=" nicEdit-selectTxt" unselectable="on" style="overflow: hidden; float: left; width: 66px; height: 14px; margin-top: 1px; font-family: sans-serif; text-align: center; font-size: 12px;">Font&nbsp;Family...</div></div></div></div><div unselectable="on" style="float: left; margin: 2px 1px 0px;"><div class=" nicEdit-selectContain" unselectable="on" style="width: 90px; height: 20px; cursor: pointer; overflow: hidden; opacity: 0.6;"><div unselectable="on" style="overflow: hidden; zoom: 1; border: 1px solid rgb(204, 204, 204); padding-left: 3px; background-color: rgb(255, 255, 255);"><div class=" nicEdit-selectControl" unselectable="on" style="overflow: hidden; float: right; height: 18px; width: 16px; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -450px 0px;"></div><div class=" nicEdit-selectTxt" unselectable="on" style="overflow: hidden; float: left; width: 66px; height: 14px; margin-top: 1px; font-family: sans-serif; text-align: center; font-size: 12px;">Font&nbsp;Format...</div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -108px 0px;"></div></div></div></div><div unselectable="on" style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " unselectable="on" style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" unselectable="on" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -198px 0px;"></div></div></div></div><div style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -360px 0px;"></div></div></div></div><div style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -468px 0px;"></div></div></div></div><div style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined nicEdit-button-hover" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -378px 0px;"></div></div></div></div><div style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -396px 0px;"></div></div></div></div><div style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -36px 0px;"></div></div></div></div><div style="float: left; margin-top: 2px;"><div class=" nicEdit-buttonContain    " style="width: 20px; height: 20px; opacity: 0.6;"><div class=" nicEdit-button-undefined" style="background-color: rgb(239, 239, 239); border: 1px solid rgb(239, 239, 239);"><div class=" nicEdit-button" unselectable="on" style="width: 18px; height: 18px; overflow: hidden; zoom: 1; cursor: pointer; background-image: url(&quot;http://js.nicedit.com/nicEditIcons-latest.gif&quot;); background-position: -18px 0px;"></div></div></div></div></div></div></div>';
    $niceEdit .= '<div style="width: 157px; border-width: 0px 1px 1px; border-top-style: initial; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: initial; border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; overflow-y: auto; overflow-x: hidden;"><div class=" nicEdit-main " contenteditable="true" style="width: 149px; margin: 4px; min-height: 32px; overflow: hidden;">';
    $rest = '<input class = "geustsee" type="checkbox" name="cansee"> geusts can see this comment<br><button id = "edit_comment">edit</button>';
    $title = '<input class = "title" name = "title" type = "text" placeholder="comment title">';
    if(count(explode('/',$_SESSION['path'])) == 3){
       $type = "comment";
        echo "false%%<script>
title = '$title';
element = $(document).find('div#{$_POST['edit_button']} > .comment-content-container > .comment-content');
elementTitle = $(element).find('.comment-title').html();
title = $(title).val(elementTitle);
console.log(title);
elementComment = $(element).find('.comment-comment').html();
$(document).find('#Insert-container').html('$niceEdit'+elementComment+'</div></div>'+'$rest').children().eq(0).before(title);


        $(document).find('#edit_comment').click(function(){comment_click()});
        
            
            
        function comment_click(){
            element =  $(document).find('#edit_comment').parent().find('div > .nicEdit-main').html();
            element2 =  $(document).find('#edit_comment').parent().find('.title').val();
            element3 =  $(document).find('#edit_comment').parent().find('.geustsee').prop('checked');
            
            console.log(element);           
            elementsend = element +'**'+ element2 +'**'+element3+'**'+{$_POST['edit_button']};
            
                                    
            try{if(((element2.match(/[\<\>\{\}\[\]]/)).length>0)){
                alert('the following symbols arent allowed []{}<>');
            }}
            catch(err){
                    if(element.replace(/<br>|&amp;|&lt;|&gt;|&nbsp;/g,'1').length >=25){
                        ajax_processer('edit_comment',elementsend);
                    }else{
                        alert('comment text is too short!');
                    }
                }
            }

</script>";
    }else{
       $type = "post";
    }
//    echo 'false'."%%<script>
//    element = $('#{$_POST['edit_button']}.post-info-container');
//    elementName = $(element).find('.post-name');
//    elementDesc = $(element).find('.post-description');
//    alert(elementName.html());
//
//    </script>";

    //make content and title of post typable
}


if(isset($_POST['edit_comment'])&&!empty($_POST['edit_comment'])){
    $_SESSION['edit_comment'] = $_POST['edit_comment'];
    echo "true";
}



if(isset($_POST['remove_button'])&&!empty($_POST['remove_button'])){
    $url =  "//{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    echo "false%%";
    $check = explode(",",$_POST['remove_button']);
    if(isset($check[1])&&!empty($check[1])&&$check[1]!="null") {
        $_SESSION['delete'] = $_POST['remove_button'];
    }
    // update of post to banned in database + given reason + id of person who banned him
}

if(isset($_POST['status_button'])&&!empty($_POST['status_button'])){
    //for future order .
    // update status in the database to something else
}

if(isset($_POST['mod_button'])&&!empty($_POST['mod_button'])){
    echo 'false'."%%<script>alert('mods')</script>";
    //add/remove mods from a post by updating the affected user his class info
}

if(isset($_POST['new_comment'])&&!empty($_POST['new_comment'])) {
    $element = explode('%%', $_POST['new_comment']);
    include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/classes/database/database.php";
    include_once "{$_SERVER['DOCUMENT_ROOT']}/forum/Php/global_functions.php";
    if(database::getConn() == ''){
        new database();
    }
    $user = database::get_user($_SESSION['id']);
    if($user[0]['level'] != 8) {
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
                    database::add_comment($element[1], $element[0], $user, $path[2], $vieuw);
                }
            }
        }
    }

    echo 'true' . "%%";
}



?>
