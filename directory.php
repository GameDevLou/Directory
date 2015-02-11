<?php
$gameDevLouPeople = "1W3S_j9vi58Y5BMTPLdWptTQwScMWv5KrkU-r9R2_dvU";
$gameDevLouJams = "1yAFycceiw7hi3uIGfPof49V7jGJ0MzTlh0C-2YtS80Q";

$people = googleSheetData( $gameDevLouPeople );
$jams = googleSheetData( $gameDevLouJams );

function googleSheetData( $docId ) {
	$url = "http://spreadsheets.google.com/feeds/list/" . $docId . "/od6/public/values?alt=json&amp;callback=displayContent";
	try {
		$json = file_get_contents( $url );
	} catch ( Exception $e ) {
		echo " I AM ERROR <br>";
		echo $e;
		return;
	}
	$data = json_decode( $json, TRUE );
	return $data['feed']['entry'];
}

$peopleModel = createModel( $people );
$jamsModel = createModel( $jams );

function createModel( $table ) {
	$model = array();
	foreach ( $table as $row ) {
		$newItem = new stdClass;
		foreach ( $row as $key => $value ) {
			if ( strpos( $key, 'gsx$' ) !== FALSE ) {
				$fieldName = str_replace( 'gsx$', '', $key );
				$content = htmlspecialchars( str_replace( "'", "", $value['$t'] ) );
				$newItem->$fieldName = $content;
			}
		}
		array_push( $model, $newItem );
	}
	return $model;
}

function displayPeople( $people, $jams ) {
	$peopleHTML = "";
	foreach ( $people as $person ) {
		if ( $person->showonsite == "TRUE" ) {
			$peopleHTML .= "<div class='person'>"
				. "<div class='photoHolder'>"
				. addPhoto( $person )
				. addBadges( $person, $jams )
				. "</div>"
				. "<div class='personContent'>"
				. addAnchor( $person )
				. addName( $person )
				. addStudio( $person )
				. addField( $person, "Bio", "bio" )
				. addField( $person, "Projects", "projects" )
				. addField( $person, "Skills", "skills" )
				. addField( $person, "Seeking", "seeking" )
				. addWebsite( $person )
				. "<div class='social'>"
				. addEmail( $person )
				. addTwitter( $person )
				. addTumblr( $person )
				. addGithub( $person )
				. addGooglePlus( $person )
				. addSteam( $person )
				. "</div>"
				. "</div>"
				. "</div>";
		}
	}
	return $peopleHTML;
}

function countPeople( $people ) {
	$count = 0;
	foreach ( $people as $person ) {
		if ( $person->showonsite == "TRUE" ) {
			$count ++;
		}
	}
	return $count;
}

function addAnchor( $person ) {
	$name = "<a name='";
	if ( !empty( $person->firstname ) ) {
		$name .= strtolower( $person->firstname );
	}
	if ( !empty( $person->lastname ) ) {
		$name .= strtolower(  $person->lastname );
	}
	return $name . "'></a>";
}

function addName( $person ) {
	$name = "<h3>";
	if ( !empty( $person->firstname ) ) {
		$name .= $person->firstname . " ";
	}
	if ( !empty( $person->nicknames ) ) {
		$name .= "'" . $person->nicknames . "' ";
	}
	if ( !empty( $person->lastname ) ) {
		$name .= $person->lastname;
	}
	return $name . "</h3>";
}

function addPhoto( $person ) {
	$photoURL = $person->photourl;
	if ( empty( $photoURL ) ) {
		return "<img class='directoryPhoto' src='http://gamedevlou.org/wp-content/uploads/2015/02/nophoto.png'></img>";
	}
	$name = "";
	if ( !empty( $person->firstname ) ) {
		$name .= $person->firstname . " ";
	}
	if ( !empty( $person->lastname ) ) {
		$name .= $person->lastname;
	}
	$location = "";
	if ( !empty( $person->location ) ) {
		$location .= $person->location;
	}
	return "<img class='directoryPhoto' src='" . $photoURL . "' alt='". $name ." - independant game developer - " . $location . "'></img>";
}

function addField( $person, $name, $field ) {
	$field = $person->$field;
	if ( empty( $field ) ) {
		return "";
	}
	return "<p><strong>" . $name . ": </strong>" . $field . "</a></p>";
}

function addStudio( $person ) {
	$studio = $person->studio;
	$studiolink = $person->studiolink;
	if ( empty( $studio ) ) {
		return "";
	}
	if ( empty( $studiolink ) ) {
		return "<p><strong>Studio: </strong>" . $studio . "</p>";
	}
	return "<p><strong>Studio: </strong><a href='" . $studiolink . "'>" . $studio ."</a></p>";
}

function addEmail( $person ) {
	if ( empty( $person->email ) ) {
		return "";
	}
	return "<a href='mailto:" . $person->email . "'><i class='fa fa-envelope'></i></a>";
}

function addWebsite( $person ) {
	if ( empty( $person->website ) ) {
		return "";
	}
	return "<p><strong>Website: </strong><a href='" . $person->website . "'>" . $person->website ."</a></p>";
}

function addTwitter( $person ) {
	if ( empty( $person->twitter ) ) {
		return "";
	}
	return "<a href='https://twitter.com/" . $person->twitter . "'><i class='fa fa-twitter'></i></a>";
}

function addTumblr( $person ) {
	if ( empty( $person->tumblr ) ) {
		return "";
	}
	return "<a href='http://" . $person->tumblr . ".tumblr.com/'><i class='fa fa-tumblr'></i></a>";
}

function addGithub( $person ) {
	if ( empty( $person->github ) ) {
		return "";
	}
	return "<a href='http://github.com/" . $person->github . "'><i class='fa fa-github'></i></a>";
}

function addGooglePlus( $person ) {
	if ( empty( $person->googleplus ) ) {
		return "";
	}
	return "<a href='http://googleplus.com/" . $person->googleplus . "'><i class='fa fa-googleplus'></i></a>";
}

function addSteam( $person ) {
	if ( empty( $person->steam ) ) {
		return "";
	}
	return "<a href='http://steamcommunity.com/id/" . $person->steam . "'><i class='fa fa-steam'></i></a>";
}

function addBadges( $person, $jams ) {
	$badges = "<div class='badges'>";

	foreach ( $jams as $jam ) {
		$jamName = str_replace('#', '', strtolower($jam->hashtag));

		if( !empty ( $person->$jamName ) ){

			$jamGame = $person->$jamName;
			$jamLink = $jamName . "link";
			$gameLink = $person->$jamLink;

			$description = $jamGame . " - " . $jam->name . " - " . $jam->month . " - " . $jam->year . " - " . $jam->theme;

			$badgeHTML = "<img class='badge' src='" . $jam->image . "'  alt='" . $description . "' title='" . $description . "'/>";
			if ( !empty( $gameLink ) ) {
				$badges .= "<a href='".  $gameLink  . "' target='_blank'>";
				$badges .= $badgeHTML;
				$badges .= "</a>";
			}else {
				$badges .= $badgeHTML;
			}
		}
	}
	return $badges .= "</div>";
}

function displayContactPeople( $people ) {
	$contactPeople = "";
	foreach ( $people as $person ) {
		if ( $person->showonsite == "TRUE"
			&& $person->cancontact == "TRUE"
			&& !empty( $person->email ) ) {
			$contactPeople .= "<a href='mailto:" . $person->email . "' target='_blank'>" . $person->firstname . "</a>, ";
		}
	}
	return $contactPeople;
}

?>

<h3><?php echo countPeople( $peopleModel ); ?> Independant Game Developers!</h3>

<h1>New, or have questions?</h1>
<p>Contact <?php echo displayContactPeople( $peopleModel ); ?> and we can help you out!</p>

<div class="directoryPage">
	<h3>Members:</h3>
	<?php echo displayPeople( $peopleModel, $jamsModel ); ?>
</div>


<style>
	* {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}

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
