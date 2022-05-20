import datetime
import sys
import mysql.connector

hostname = '127.0.0.1'

# This script is used to create the first table

try:
    usr = sys.argv[1]
    passwd = sys.argv[2]
except IndexError:
    print("Usage: username password")
    exit(1)


def test():
    now = datetime.datetime.today().strftime('%Y-%m-%d %H:%M:%S')

    test_data = {'user': 'Hoswoo',
                 'message': 'Hello world!',
                 'ip': hostname,
                 'time_posted': now}

    add_to_database(test_data)


def add_to_database(msg_dict: dict):
    dbase = "Forum"
    db = mysql.connector.connect(
            host=hostname,
            user=usr,
            password=passwd,
            database=dbase
            )
    cursor = db.cursor()

    u_name = msg_dict['user']
    table_name = 'Main'

    try: 
        cursor.execute("CREATE TABLE " + table_name + " ("
                       "id VARBINARY(36) PRIMARY KEY NOT NULL, "
                       "user VARCHAR(255) NOT NULL, "
                       "message VARCHAR(1024), "
                       "ip VARBINARY(16), "
                       "time_posted DATETIME)")

        # For handling Chinese characters
        cursor.execute("ALTER TABLE " + table_name + """
                        CONVERT TO CHARACTER SET utf8mb4
                        COLLATE utf8mb4_unicode_ci;
                        """)

    except mysql.connector.errors.ProgrammingError:
        print("table", u_name, "already exists")

    sql = "INSERT INTO " + table_name + " (id, user, message, ip, time_posted)" + \
            """
            VALUES (UUID(), %s, %s, %s, %s)
            ON DUPLICATE KEY
                UPDATE message=message, time_posted=time_posted, ip=ip;
            """

    print(tuple(msg_dict.values()))
    cursor.execute(sql, tuple(msg_dict.values()))
    db.commit()
    db.close()


if __name__ == "__main__":
    test()
