<?php

/*  Plugin Name: Related Category Plugin



  Plugin URI: http://webbrainstechnologies.com



  Description: This plugin for add Related Categories



  Version: 0.1 (the current version of the plugin)



	Author: Vinod Khatik



	Author URI: http://webbrainstechnologies.com



	License: GPL2  - most WordPress plugins are released under GPL2 license terms



*/ 

ob_start();

function related_category()

{

	 add_options_page("related_category", "related_category", 1, "related_category", "related_category");

global $wpdb;



?>
<h1>Category</h1>

<script>

/*function validation() {

	var i, chks = document.getElementsByName('chk[]');

	for (i = 0; i < chks.length; i++){

		alert(chks.length);

		if (chks[i].checked){

			return true;

		}else{

			alert('No item selected');

			return false;

		}

	}

}*/

</script>

<form name="addcate" method="post" style="float: left; width: 95%;">
<?php
//$q = "SELECT * FROM wp_sabai_taxonomy_term";

$q = "SELECT * FROM `wp_sabai_taxonomy_term` inner join wp_sabai_entity_bundle on wp_sabai_taxonomy_term.term_entity_bundle_name = wp_sabai_entity_bundle.bundle_name";

$result = $wpdb->get_results($q, OBJECT);

//print_r($result);

$q1 = "SELECT * FROM `wp_sabai_entity_bundle` where bundle_entitytype_name = 'taxonomy'";

$result1 = $wpdb->get_results($q1, OBJECT);

//print_r($result1);
?>
<div style="float: left; width: 50%;">
	<b>Select Category</b><br />
    <select id="main_cat" name="main_cat">
        <option value="">--Select--</option>
        <?php
        foreach($result1 as $res1) {
            ?>
            <option value="<?php echo $res1->bundle_name; ?>"><?php echo $res1->bundle_addon; ?></option>
            <?php
        }
        ?>
    </select>
    <!--<select name="cat" id="cat" required>
        <option value="">--Select--</option>
    </select>-->
    <input type="text" name="cat_demo" id="cat" placeholder="Search" size="27" />
    <input type="hidden" name="cat" value="" />
</div>
<div style="float: left; width: 50%; display: none;" id="sch-div">
	<br />
    Search Caegories: 
	<input type="text" name="sch" id="sch" placeholder="Search" size="27" />
</div>
<div style="width: 350px; float: left; margin-left: 50%;">
	<ul id="log">
    	
    </ul>
</div>


<!--<select name="cat" id="cat" required>
	<option value="">--Select--</option>
	foreach($result as $res) {

		$expl = explode("/", $res->bundle_path);

		//print_r($expl);

		$pth = $expl[1];

		?>

		<option value="<?php //echo $res->term_id; ?>"><?php //echo $res->term_title . " - " . $pth; ?></option>

		
	}

	?>
</select>-->
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style>
.ui-autocomplete-loading {
	background: white url("ui-anim_basic_16x16.gif") right center no-repeat;
}
#log {
    float: left;
	width: 100%;
}
#log li, #result_updt li {
    background-color: #428bca;
    border: 1px solid;
    color: #fff;
    float: left;
    padding: 5px;
    width: 100%;
	cursor: move;
}
#log .text {
	float: left;
}
.ui-icon-circle-close {
	color: #fff;
    cursor: pointer;
    float: right;
}
</style>
<script>

$( document ).ready(function(){

	function log( message, id ) {
		//alert(id);
		//$( "<div>" ).text( message ).prependTo( "#log" );
		$( "<li id='"+id+"' class='close'><span class='text tt'>" + message + "</span><span onclick='delete_rec("+id+");' class='ui-icon ui-icon-circle-close'>&nbsp;</span><input type='hidden' name='chk[]' value='"+id+"'></li>" ).prependTo( "#log" );
		//$("<li><span>" + message + "</span></li>").appendTo("#log");
		$( "#log" ).scrollTop( 0 );
	}
	
	$("#main_cat").change(function(){
		
		//$("#sch-div").hide();

		$id = $( this ).val();
		//alert($id);
		$( "#cat" ).autocomplete({
			source: "/getmaincat.php?id=" + $id,
			minLength: 2,
			select: function( event, ui ) {
				
				$("[name='cat']").val( ui.item.id );
				
				$("#sch-div").show();

				$.ajax({
		
					url: "/getrelatedcat.php?id=" + ui.item.id,
		
				}).done(function( html ){
		
					//alert(html);
		
					$("#log").html( html );
		
				});
				
				/*log( ui.item ?
					'Selected: ' + ui.item.value :
					"Nothing selected, input was " + this.value, ui.item.id );*/
			}
		});
		
		$( "#log" ).sortable();
		
		
		/*$.ajax({

			url: "/getmaincat.php?id=" + $id,

		}).done(function( html ){

			//alert(html);

			$("#cat").html( html );
			
			
			
		});*/
		
		$( "#sch" ).autocomplete({
			source: "/search.php?id=" + $id,
			minLength: 2,
			select: function( event, ui ) {
				log( ui.item ?
					'Selected: ' + ui.item.value :
					"Nothing selected, input was " + this.value, ui.item.id );
			}
		});
	});
	
	/*$("#cat").change(function(){

		$id = $( this ).val();
		
		//alert($id);
		
		if($id != "") {
			
			$("#sch-div").show();

			$.ajax({
	
				url: "/getrelatedcat.php?id=" + $id,
	
			}).done(function( html ){
	
				//alert(html);
	
				$("#log").html( html );
	
			});
		}
		else {
			$("#sch-div").hide();
		}

	});*/

});

function delete_rec(id) {
	//alert(id);
	
	$( "#log #" + id ).remove();
	
	
	
}

</script>
<div style="width: 100%; float: left;">

	<ul id="result_updt" style="width: 50%;">
	<?php

	/*foreach($result as $res) {

		$expl = explode("/", $res->bundle_path);

		//print_r($expl);

		$pth = $expl[1];

		?>

		<li style="float: left; width: 20%; margin-left: 5%;">

			<input type="checkbox" name="chk[]" value="<?php echo $res->term_id; ?>"><?php echo $res->term_title . " - " . $pth; ?>

		</li>

		<?php

	}*/
	?>
	</ul>

</div>

<br>
<!--<div class="close">
bvcvbncvnvcvnvcvnc
</div>-->
<div style="width: 100%; text-align: center; float: left;">

	<input type="submit" name="submit" value="Submit" class="buttonnew searchnew"/>

</div>



</form>
<?php

if(isset($_POST['submit'])) {
	


	$cat_id = $_POST['cat'];

	$chk = serialize($_POST['chk']);

	

// 	print_r($_POST['chk']);

	

	//if(isset($_POST['chk'])) {

	

		$q = "SELECT * FROM `wp_related_categories` where category_id = '$cat_id'";

		$result = $wpdb->get_results($q, OBJECT);

		

	//	print_r($result);exit;

$username = "onebusyd_wprest";
$password = "09m9va13PS";
$hostname = "localhost"; 
$dbnew = "onebusyd_limeden";
//connection to the database
$dbhandle = mysqli_connect($hostname, $username, $password,$dbnew) 
  or die("Unable to connect to MySQL");

//$selected = mysqli_select_db($dbhandle,"onebusyd_limeden") 
 // or die("Could not select examples");


		if(empty($result)) {

			$q = "INSERT into wp_related_categories (category_id, related_categories) values ('$cat_id', '$chk')";

			mysqli_query($dbhandle,$q) or die(mysqli_error());

			

			echo "<div style='float: left;'>Related categories inserted successfully..</div>";

		}

		else {

			$q = "Update wp_related_categories set related_categories = '$chk' where category_id = '$cat_id'";

			mysqli_query($dbhandle,$q) or die(mysqli_error());

			

			echo "<div style='float: left;'>Related categories Updated successfully..</div>";


		}

	/*}

	else {

		die ("<div style='float: left;'>Please Select any one category!!</div>");

	}*/

	

}

/*if(isset($_POST['incat'])){

	$col1 = $_POST['incat'];

	$query = "INSERT INTO api_categories(cat_name)VALUES('".$col1."')";

$s=mysql_query($query);

	}

if(isset($_POST['api'])){

	//echo $_POST['cateid'];

$m = file_get_contents($_POST['api']);



$ap = json_decode($m);

echo '<pre>';

//print_r($ap);

echo '</pre>';



print get_template_directory_uri();





$count = count($ap->headlines);

print $count . "<br>";



for ($row = 0; $row <= $count; $row++)

{

$postname = $ap->headlines[$row]->title;

$api_id = $ap->headlines[$row]->id;

print $api_id . "<br>";

echo $postname . "<br>";

$desc = $ap->headlines[$row]->description;



//print_r($ap->headlines[$row]->images) . "<br>";

if(!empty($ap->headlines[$row]->images)) {

	$img = $ap->headlines[$row]->images[0]->url;

}

else {

	$img = get_template_directory_uri() . "/images/No-Image-Available-Icon-150x150.gif";

}



$ty = mysql_query("Select * from wp_posts where api_id = '$api_id'") or die(mysql_error());

$result = mysql_fetch_array($ty);

//print_r($result);



if(empty($result)) {



	//exit;

	$sql = mysql_query("INSERT INTO `wp_posts` (`post_author`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_name`,`guid`,`post_type`, `api_id`, `api_category`) VALUES 

	(1,now(),'".mysql_real_escape_string($desc)."','".mysql_real_escape_string($postname)."','".mysql_real_escape_string($desc)."','publish','open','open','".mysql_real_escape_string($postname)."','$img','post', '$api_id', '".$_POST['cateid']."')") or die(mysql_error());

	//echo "INSERT INTO `wp_posts` (`post_author`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_name`,`guid`,`post_type`) VALUES 

	//(1,now(),'".mysql_real_escape_string($desc)."','".mysql_real_escape_string($postname)."','".mysql_real_escape_string($desc)."','publish','open','open','".mysql_real_escape_string($postname)."','$img','post')";

}

}

//print_r($jkl);

//echo $ap->headlines[0]->title;

//echo $ap->headlines[0]->description;

//echo $ap->headlines[0]->images[0]->url;

echo '</pre>';

}*/

 ?>

<?php } ?>

<?php function csv_menu () {



 			add_menu_page("related_category","related_category","manage_options","related_category", related_category);

}

add_action("admin_menu","csv_menu");

//add_shortcode('wp_course_schedule', 'wp_display_schedule');

?>