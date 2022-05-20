import datetime
import sys
import mysql.connector

hostname = '127.0.0.1'

# This script is used to create the first table

try:
    usr = sys.argv[1]
    passwd = sys.argv[2]
except IndexError:
    print("Usage: username password\n \
           Use mysql username and password")
    exit(1)


def init_db():
    dbase = "Accounts"
    db = mysql.connector.connect(
            host=hostname,
            user=usr,
            password=passwd,
            database=dbase
            )
    cursor = db.cursor()

    table_name = 'Users'

    try: 
        cursor.execute("CREATE TABLE " + table_name + " ("
                       "id VARBINARY(36) PRIMARY KEY NOT NULL, "
                       "username VARCHAR(255) NOT NULL, "
                       "password VARCHAR(60) NOT NULL, "
                       "ip_registered VARBINARY(16), "
                       "time_registered DATETIME)")

        # For handling Chinese characters
        cursor.execute("ALTER TABLE " + table_name + """
                        CONVERT TO CHARACTER SET utf8mb4
                        COLLATE utf8mb4_unicode_ci;
                        """)

    except mysql.connector.errors.ProgrammingError:
        print("table", u_name, "already exists")

    sql = "INSERT INTO " + table_name + " (id, username, password, ip_registered, time_registered)" + \
            """
            VALUES (UUID(), %s, %s, %s, %s)
            ON DUPLICATE KEY
                UPDATE username=username;
            """
    print("Created database '" + dbase + "'");
    db.commit()
    db.close()



if __name__ == "__main__":
    init_db()
