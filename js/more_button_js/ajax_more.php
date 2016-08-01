<?php
if(isset($_POST["id"]) && !empty($_POST["id"])){

//include database configuration file
include('db_config.php');

//get rows query
$query = mysqli_query($con, "SELECT * FROM tutorials WHERE id < ".$_POST['id']." ORDER BY id DESC LIMIT 2");

//number of rows
$rowCount = mysqli_num_rows($query);

if($rowCount > 0){ 
    while($row = mysqli_fetch_assoc($query)){ 
        $tutorial_id = $row["id"];
?>
        <div class="list_item"><a href="javascript:void(0);"><h2><?php echo $row["title"]; ?></h2></a></div>
<?php } ?>
    </div>
    <div class="show_more_main" id="show_more_main<?php echo $tutorial_id; ?>">
        <span id="<?php echo $tutorial_id; ?>" class="show_more" title="Load more posts">Show more</span>
        <span class="loding" style="display: none;"><span class="loding_txt">Loading…</span></span>
    </div>
<?php 
    } 
}
?>