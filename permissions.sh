#!/bin/sh
DIRS="assets content kirby site thumbs"
FILES="index.php"

for dir in $DIRS;do
 sudo chown -R rob.rob "$dir"
 find "$dir" -type d -print0 | xargs -0r sudo chmod 775
 find "$dir" -type f -print0 | xargs -0r sudo chmod 664
 find "$dir" -type f \( -name *.pl -o -name *.cgi \) -print0 | xargs -0r sudo chmod 775
done

for file in $FILES;do
 sudo chown rob.rob "$file"
 sudo chmod 664 "$file"
done

exit 0;
