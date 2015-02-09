<?php

$docId = "1W3S_j9vi58Y5BMTPLdWptTQwScMWv5KrkU-r9R2_dvU";
//$url = "https://spreadsheets.google.com/feeds/list/" . $docId . "/od6/public/values?alt=json";
$url = "http://spreadsheets.google.com/feeds/list/" . $docId . "/od6/public/values?alt=json&amp;callback=displayContent";

$json = file_get_contents($url);
//echo $json;
$data = json_decode($json, TRUE);
//$people = $data->feed->entry;


//debugSrc($people);

$people = $data['feed']['entry'];





function displayPeople($people){
	$peopleHTML = "";
	foreach ($people as $person) {
		if($person['gsx$showonsite']['$t'] == "TRUE"){
			//echo $person['gsx$firstname']['$t'];
			//echo $person['gsx$lastname']['$t'];
	


		$peopleHTML .= "<div class='person'>"; 
$peopleHTML .= "<div class='photoHolder'>";
// 			//$peopleHTML .= addPhoto(person);
// 			//$peopleHTML .= addBadges(person, badgeData);
$peopleHTML .= "</div>";
$peopleHTML .= "<div class='personContent'>";
$peopleHTML .= addName($person);
// 			//$peopleHTML .= addField(person, "Studio", "studio");
// 			//$peopleHTML .= addField(person, "Bio", "bio");
// 			//$peopleHTML .= addField(person, "Projects", "projects");
// 			//$peopleHTML .= addField(person, "Skills", "skills");
// 			//$peopleHTML .= addField(person, "Seeking", "seeking");
// 			//$peopleHTML .= addWebsite(person);
$peopleHTML .= "<div class='social'>";
// 			//$peopleHTML .= addEmail(person);
// 			//$peopleHTML .= addTwitter(person);
// 			//$peopleHTML .= addGithub(person);
// 			//$peopleHTML .= addTumblr(person);
// 			//$peopleHTML .= addGooglePlus(person);
// 			//$peopleHTML .= addSteam(person);
$peopleHTML .= "</div>";
			$peopleHTML .= "</div>";
			$peopleHTML .= "</div>";

// 	}
				}
	}

	return $peopleHTML;
 }

function countPeople($people){
	$count = 0;
	foreach ($people as $person) {
		if($person['gsx$showonsite']['$t'] == "TRUE"){
			$count ++;
		}
	}
	return $count;
}

function addName($person){
	$name = "<h3>";
	$firstname = $person['gsx$firstname']['$t'];
	$lastname = $person['gsx$lastname']['$t'];
	$nicknames = $person['gsx$nicknames']['$t'];
	if(!empty($firstname)) {
		$name .= $firstname . " ";
	}
	if(!empty($nicknames)) {
		$name .= "'" . $nicknames . "' ";
	}
	if(!empty($lastname)) {
		$name .= $lastname;
	}
	return $name . "</h3>";
}


?>
<style>
	* {-webkit-box-sizing: border-box;
	  -moz-box-sizing: border-box;
	  box-sizing: border-box; }
	.person {
	  margin: 15px 0;
	  padding: 15px;
	  background: #f2f2f2;
	  border-radius: 8px;
	  min-height: 170px;
	}

	.person:after {
	  clear: both;
	  display: table;
	  content: "";
	}

	.person h3 {
	  margin: 0;
	}

	.personContent {
	  display: inline-block;
	  float: left;
	}
	@media (min-width: 1025px) {
	  .personContent {
	    width: 65%;
	  }
	}
	@media (min-width: 731px) and (max-width: 1024px) {
	  .personContent {
	    width: 65%;
	  }
	}
	@media (min-width: 320px) and (max-width: 730px) {
	  .personContent {
	    width: 100%;
	  }
	}

	.photoHolder {
	  text-align: center;
	  display: inline-block;
	  float: right;
	}
	@media (min-width: 1025px) {
	  .photoHolder {
	    width: 35%;
	    padding: 0 10px 10px 10px;
	  }
	}
	@media (min-width: 731px) and (max-width: 1024px) {
	  .photoHolder {
	    width: 35%;
	  }
	}
	@media (min-width: 320px) and (max-width: 730px) {
	  .photoHolder {
	    width: 100%;
	  }
	}

	.directoryPhoto {
	  width: 100%;
	  height: auto;
	  max-width: 200px;
	  box-shadow: none !important;
	}

	.badge {
	  width: 45px;
	  display: inline-block;
	  margin: 2px 5px;
	  border-radius: 0 !important;
	  box-shadow: none !important;
	}

	.social{

	}

	.social a{
		color: #000;
		font-size: 35px;
		margin: 5px 10px;
	}

	.social a:visited{
		color: #000;
	}

	.social a:hover{
		color: #ffce38;
	}

	.studios{
		text-align: center;
	}

	.studios:after{
	    clear: both;
	    display: table;
	    content:"";
	    }
		
	.studio img{
		width: 100%;
		mheight: 100%;
		border-radius: 0 !important;
	  	box-shadow: none !important;
	}

	.studio{
		vertical-align: top;
		text-align: center;
		width: 109px;
		height: 109px;
		background: #f2f2f2;
	    border-radius: 20px;
	    display: inline-block;
		margin: 17px;
		/*cursor: pointer;*/
		overflow: hidden;
		box-shadow: 0 3px 4px 2px rgba(0,0,0,.2);
	}

	.studio:hover{
		/*background: #ffce38;*/
	}
</style>

<h3> 
	<span class="devCount"><?php echo countPeople($people); ?></span> 
	Independant Game Developers!
</h3>

<div class="directoryPage">
	<h3>Members:</h3>
	<?php echo displayPeople($people); ?>
</div>

