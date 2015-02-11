# Directory

Reads data from a google doc (public url) and formats it into a member directory.

###How it works:
The Magic: 
```php
"http://spreadsheets.google.com/feeds/list/" . $docId . "/od6/public/values?alt=json&amp;callback=displayContent"
```
The URL above will ask google docs for a JSON feed of any *public* spreadsheet.
The returned JSON has a few interesting quirks which I have worked out in my 'googleSheetData' & 'createModel' functions.

The JSON returned will have the content of your spreadsheet's rows will look like this:
```json
"entry": [
            {
                "id": {
                    "$t": "https://spreadsheets.google.com/feeds/list/1yAFycceiw7hi3uIGfPof49V7jGJ0MzTlh0C-2YtS80Q/od6/public/values/cokwr"
                },
                "updated": {
                    "$t": "2015-02-11T16:42:24.572Z"
                },
                "category": [
                    {
                        "scheme": "http://schemas.google.com/spreadsheets/2006",
                        "term": "http://schemas.google.com/spreadsheets/2006#list"
                    }
                ],
                "title": {
                    "type": "text",
                    "$t": "Global Game Jam 2014"
                },
                "content": {
                    "type": "text",
                    "$t": "hashtag: #GGJ14, month: Janurary, year: 2014, theme: We don't see things as they are, we see them as we are., image: http://gamedevlou.org/wp-content/uploads/2015/02/badge-ggj14.png, location: LVL1"
                },
                "link": [
                    {
                        "rel": "self",
                        "type": "application/atom+xml",
                        "href": "https://spreadsheets.google.com/feeds/list/1yAFycceiw7hi3uIGfPof49V7jGJ0MzTlh0C-2YtS80Q/od6/public/values/cokwr"
                    }
                ],
                "gsx$name": {
                    "$t": "Global Game Jam 2014"
                },
                "gsx$hashtag": {
                    "$t": "#GGJ14"
                },
                "gsx$month": {
                    "$t": "Janurary"
                },
                "gsx$year": {
                    "$t": "2014"
                },
                "gsx$theme": {
                    "$t": "We don't see things as they are, we see them as we are."
                },
                "gsx$image": {
                    "$t": "http://gamedevlou.org/wp-content/uploads/2015/02/badge-ggj14.png"
                },
                "gsx$location": {
                    "$t": "LVL1"
                }
            },
```
Really all I wanted was to access the data in each row using the column name (first row)
so in the JSON example above my columns are "gsx$name", "gsx$hashtag", "gsx$month", ,"gsx$year", "gsx$theme", "gsx$image", and "gsx$location"

All of the relevant data is nested inside "feed" then inside "entry"
so I built a function that gets the json from the URL and returns a PHP object of just the "entry" data nested inside.

Here are the googleSheetData and CreateModel functions:
```php
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
```
Then I use the "createModel" function to reformat the data into eisier to use structure like this:
```php
Array
(
    [0] => stdClass Object
        (
            [name] => Global Game Jam 2014
            [hashtag] => #GGJ14
            [month] => Janurary
            [year] => 2014
            [theme] => We dont see things as they are, we see them as we are.
            [image] => http://gamedevlou.org/wp-content/uploads/2015/02/badge-ggj14.png
            [location] => LVL1
        )

    ...

)
```
Check out the functions in Directory.php they should be easy to translate into other languages!


###Deployment to wordpress:
Make sure the 'Insert PHP' plugin is installed in wordpress
From your terminal run build script in the project directory:
```sh
sh build.sh
```
this will replace the "<?php" and "?>" tags with "[insert_php]" and "[/insert_php]" tags required by Insert PHP plugin
ritten in Markdown! To get a feel for Markdown's syntax, type some text into the left window and watch the results in the right.

From here you can copy the contents of directory-wp.php and paste it into a regular wordpress page, the Insert PHP plugin will run the code on the server before the page loads.
