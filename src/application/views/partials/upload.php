<?php
$filename = $_FILES['file']['name'];

/* Location */
$location = "/assets/images/upload/".$filename;
$uploadOk = 1;

if($uploadOk == 0){
    echo 0;
}else{
    /* Upload file */
    if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){
?>      <li><span class="delete_image">X</span><img class="image_preview" src="<?=$location?>" alt="new food image"></li>
<?php }else{
        echo 0;
    }
} 

?>