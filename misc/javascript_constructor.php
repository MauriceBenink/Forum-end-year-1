<script>
    console.log("<?php if(isset($_GET['path'])&&!empty($_GET['path'])){echo $_GET['path'];}?>");
setTimeout(function(){start()},500);
function start(){
    several_click_elements("#forum-container > div.post-container > div.post-info-container","level_down"<?php if(isset($_GET['path'])&&!empty($_GET['path'])&&$_GET['path']){$var  = $_GET['path'];echo ",'$var'";}?>);
    several_click_elements("#forum-container > div.post-container > div > button",'button');
    several_click_elements("#forum-container > div.comment-container > div > button",'button');
    click_element('#level-up-button','level_up'<?php if(isset($_GET['path'])&&!empty($_GET['path'])&&$_GET['path']){$var  = $_GET['path'];echo ",'$var'";}?>);
    click_element('#to-top-button','to_top');

}

function several_click_elements(path_to_element,post_name,path = ""){
    element = $(path_to_element);
    random = false;

    for( i = 0; i< element.length;i++){
        if(post_name == 'button'||random){
            post_name = element[i]['className'];
            random = true;
        }
        make_click(element,post_name,i,path);
    }
}

function make_click(element,post_name,i,path=''){
    if(path!=''){
        path = "%%"+path
    }
    element.eq(i).click(function(){ajax_processer(post_name,element[i]['id']+path)});
}

function click_element(path_to_element,post_name,path=''){
    $(path_to_element).click(function(){ajax_processer(post_name,path)});
}

function ajax_processer(type,value='NA'){
    type_value_var = {};
    if(type == 'remove_button'){
        promptinput = prompt("reason for the ban");
        value = value+","+promptinput;
    }
    type_value_var[type] = value;
    console.log(type_value_var);
    $.ajax({
        type: 'POST',
        url: 'Php/ajax_files/ajax_landing_comunication.php',
        data: type_value_var,
        success: function (x) {
            x = x.split("%%");
            console.log(x);
            if(x[0] == 'true') {
                location.reload();
            }
            $( "#Insert-container" ).html(x[1]);

        }
    });
}

        /*
         * mods +path+id
         * edit
         * status
         * remove
         * layer up     +
         * layer down   +
         * to top       +
        */

</script>