username="$1"
password="$2"
dir="$3"

# You should enter your mysql username and password as the args
# This script will recursively add all mysql username and password information to each file.
# Use this so that the all scripts will have the necessary account information in it.

if [[ -z $dir ]]; then
	dir=".";
fi

set_db_user_info(){
	fn_dir="$1";
	cd "$fn_dir";
	if [[ -z $username ]] | [[ -z $password ]]; then
		echo Usage: username password
		echo Recursively sets all database username and password info to the db variables in the directory.
	else
		user_regex="db_username = \"\"";
		password_regex="db_password = \"\"";
		for f in *; do
			if [[ -d $f ]]; then
				echo Checking directory $f;
				set_db_user_info "$f"
			else
				user_res=$(cat $f | grep "$user_regex");
				password_res=$(cat $f | grep "$password_regex");

				# Use .bak if you want to make a backup just incase
				if [[ ! -z $user_res ]]; then
					echo "Appended username to $f"
					# sed -i.bak "s/$user_regex/db_username = \"\"/" $f;
					sed -i "s/$user_regex/db_username = \"$username\"/" $f;
				fi
				if [[ ! -z $password_res ]]; then
					echo "Appended password to $f"
					# sed -i.bak "s/$password_regex/db_password = \"\"/" $f;
					sed -i "s/$password_regex/db_password = \"$password\"/" $f;
				fi
			fi
		done;
	fi
	cd ".."
}

set_db_user_info $dir
