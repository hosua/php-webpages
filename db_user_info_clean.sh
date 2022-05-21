username="$1"
password="$2"
dir="$3"

# You should enter your mysql username and password as the args
# This script will recursively remove all mysql username and password information from each file.
# Use this before uploading to Github.

if [[ -z $dir ]]; then
	dir=".";
fi

clean_db_user_info(){
	fn_dir="$1";
	cd "$fn_dir";
	if [[ -z $username ]] | [[ -z $password ]]; then
		echo Usage: username password
		echo Removes all database username and password info from all files for pushing to Github.
	else
		user_regex="db_username = \"$username\"";
		password_regex="db_password = \"$password\"";
		for f in *; do
			if [[ -d $f ]]; then
				echo Checking directory $f;
				clean_db_user_info "$f"
			else
				user_res=$(cat $f | grep "$user_regex");
				password_res=$(cat $f | grep "$password_regex");

				# Use .bak if you want to make a backup just incase
				if [[ ! -z $user_res ]]; then
					echo "Cleaned username from $f"
					# sed -i.bak "s/$user_regex/db_username = \"\"/" $f;
					sed -i "s/$user_regex/db_username = \"\"/" $f;
				fi
				if [[ ! -z $password_res ]]; then
					echo "Cleaned password from $f"
					# sed -i.bak "s/$password_regex/db_password = \"\"/" $f;
					sed -i "s/$password_regex/db_password = \"\"/" $f;
				fi
			fi
		done;
	fi
	cd ".."
}

clean_db_user_info $dir
