<?php
$docId = "1W3S_j9vi58Y5BMTPLdWptTQwScMWv5KrkU-r9R2_dvU";
$url = "http://spreadsheets.google.com/feeds/list/" . $docId . "/od6/public/values?alt=json&amp;callback=displayContent";
$json = file_get_contents( $url );
$data = json_decode( $json, TRUE );
$people = $data['feed']['entry'];

function displayPeople( $people, $badgeData ) {
	$peopleHTML = "";
	foreach ( $people as $person ) {
		if ( $person['gsx$showonsite']['$t'] == "TRUE" ) {
		$peopleHTML .= "<div class='person'>"
						. "<div class='photoHolder'>"
							. addPhoto( $person )
							. addBadges( $person, $badgeData )
						. "</div>"
						. "<div class='personContent'>"
						. addName( $person )
						. addField( $person, "Studio", "studio" )
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
		if ( $person['gsx$showonsite']['$t'] == "TRUE" ) {
			$count ++;
		}
	}
	return $count;
}

function addName( $person ) {
	$name = "<h3>";
	if ( !empty( $person['gsx$firstname']['$t'] ) ) {
		$name .= $person['gsx$firstname']['$t'] . " ";
	}
	if ( !empty( $person['gsx$nicknames']['$t'] ) ) {
		$name .= "'" . $person['gsx$nicknames']['$t'] . "' ";
	}
	if ( !empty( $person['gsx$lastname']['$t'] ) ) {
		$name .= $person['gsx$lastname']['$t'];
	}
	return $name . "</h3>";
}

function addPhoto( $person ) {
	$photoURL = $person['gsx$photourl']['$t'];
	if ( empty( $photoURL ) ) {
		return "<img class='directoryPhoto' src='http://gamedevlou.org/wp-content/uploads/2015/02/nophoto.png'></img>";
	}
	$name = "";
	if ( !empty( $person['gsx$firstname']['$t'] ) ) {
		$name .= $person['gsx$firstname']['$t'] . " ";
	}
	if ( !empty( $person['gsx$lastname']['$t'] ) ) {
		$name .= $person['gsx$lastname']['$t'];
	}
	$location = "";
	if ( !empty( $person['gsx$location']['$t'] ) ) {
		$location .= $person['gsx$location']['$t'];
	}
	return "<img class='directoryPhoto' src='" . htmlspecialchars($photoURL) . "' alt='". htmlspecialchars($name) ." - independant game developer - " . htmlspecialchars($location) . "'></img>";
}

function addField( $person, $name, $field ) {
	$field = $person['gsx$' . $field]['$t'];
	if ( empty( $field ) ) {
		return "";
	}
	return "<p><strong>" . htmlspecialchars($name) . ": </strong>" . htmlspecialchars($field) . "</a></p>";
}

function addEmail( $person ) {
	$email = $person['gsx$email']['$t'];
	if ( empty( $email ) ) {
		return "";
	}
	return "<a href='mailto:" . htmlspecialchars($email) . "'><i class='fa fa-envelope'></i></a>";
}

function addWebsite( $person ) {
	$website = $person['gsx$website']['$t'];
	if ( empty( $website ) ) {
		return "";
	}
	return "<p><strong>Website: </strong><a href='" . htmlspecialchars($website) . "'>" . htmlspecialchars($website) ."</a></p>";
}

function addTwitter( $person ) {
	$twitterId = $person['gsx$twitter']['$t'];
	if ( empty( $twitterId ) ) {
		return "";
	}
	return "<a href='https://twitter.com/" . htmlspecialchars($twitterId) . "'><i class='fa fa-twitter'></i></a>";
}

function addTumblr( $person ) {
	$tumblrId = $person['gsx$tumblr']['$t'];
	if ( empty( $tumblrId ) ) {
		return "";
	}
	return "<a href='http://" . htmlspecialchars($tumblrId) . ".tumblr.com/'><i class='fa fa-tumblr'></i></a>";
}

function addGithub( $person ) {
	$githubId = $person['gsx$github']['$t'];
	if ( empty( $githubId ) ) {
		return "";
	}
	return "<a href='http://github.com/" . htmlspecialchars($githubId) . "'><i class='fa fa-github'></i></a>";
}

function addGooglePlus( $person ) {
	$googleplusId = $person['gsx$googleplus']['$t'];
	if ( empty( $googleplusId ) ) {
		return "";
	}
	return "<a href='http://googleplus.com/" . htmlspecialchars($googleplusId) . "'><i class='fa fa-googleplus'></i></a>";
}

function addSteam( $person ) {
	$steamId = $person['gsx$steam']['$t'];
	if ( empty( $steamId ) ) {
		return "";
	}
	return "<a href='http://steamcommunity.com/id/" . htmlspecialchars($steamId) . "'><i class='fa fa-steam'></i></a>";
}

$badgeData = (object) array(
	'ggj14' => (object) array(
		'name' => 'ggj14',
		'link' => 'ggj14link',
		'description' => ' - Global Game Jam - 2014 - We dont see things as they are, we see them as we are.',
		'image' => 'http://gamedevlou.org/wp-content/uploads/2015/02/badge-ggj14.png'
	),
	'ld29' => (object) array(
		'name' => 'ld29',
		'link' => 'ld29link',
		'description' => ' - Ludum Dare 29 - April 2014	- Beneath the surface',
		'image' => 'http://gamedevlou.org/wp-content/uploads/2015/02/badge-ld29.png'
	),
	'ld30' => (object) array(
		'name' => 'ld30',
		'link' => 'ld30link',
		'description' => ' - Ludum Dare 30 - August 2014 - Connected Worlds',
		'image' => 'http://gamedevlou.org/wp-content/uploads/2015/02/badge-ld30.png'
	),
	'ld31' => (object) array(
		'name' => 'ld31',
		'link' => 'ld31link',
		'description' => ' - Ludum Dare 31 - December 2014 - Entire Game on One Screen!',
		'image' => 'http://gamedevlou.org/wp-content/uploads/2015/02/badge-ld31.png'
	),
	'ggj15' => (object) array(
		'name' => 'ggj15',
		'link' => 'ggj15link',
		'description' => ' - Global Game Jam - 2015 - What do we do now?',
		'image' => 'http://gamedevlou.org/wp-content/uploads/2015/02/badge-ggj15.png'
	)
);

function addBadges( $person, $data ) {
	$badges = "<div class='badges'>";

	foreach ( $data as $badge ) {
		$gameName = $person['gsx$' . $badge->name]['$t'];
		$gameName = str_replace("'", "&rsquo;", $gameName);
		$gameLink = $person['gsx$' . $badge->link]['$t'];
		if ( !empty( $person['gsx$' . $badge->name]['$t'] ) ) {
			$badgeHTML = "<img class='badge' src='" . $badge->image . "' alt='" . htmlspecialchars($gameName) . $badge->description . "' title='" . $gameName . $badge->description . "'/>";
			if ( !empty( $gameLink ) ) {
				$badges .= "<a href='". htmlspecialchars($gameLink) . "' target='_blank'>";
				$badges .= $badgeHTML;
				$badges .= "</a>";
			}else {
				$badges .= $badgeHTML;
			}
		}
	};

	return $badges .= "</div>";
}

function displayContactPeople( $people ) {
	$contactPeople = "";
	foreach ( $people as $person ) {
		if ( $person['gsx$showonsite']['$t'] == "TRUE"
			&& $person['gsx$cancontact']['$t'] == "TRUE"
			&& !empty( $person['gsx$email']['$t'] ) ) {
			$contactPeople .= "<a href='mailto:".$person['gsx$email']['$t']."' target='_blank'>".$person['gsx$firstname']['$t']."</a>, ";
		}
	}
	return $contactPeople;
}

?>

<h3><?php echo countPeople( $people ); ?> Independant Game Developers!</h3>

<h1>New, or have questions?</h1>
<p>Contact <?php echo displayContactPeople( $people ) ?> and we can help you out!</p>

<div class="directoryPage">
	<h3>Members:</h3>
	<?php echo displayPeople( $people, $badgeData ); ?>
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