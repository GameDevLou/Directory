sed 's,?>,[/insert_php],g' directory.php > directory-temp.php
sed 's,<?php,[insert_php],g' directory-temp.php > directory-wp.php
rm directory-temp.php