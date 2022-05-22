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
                 'status': 'success',
                 'ip': hostname,
                 'time_logged': now}

    add_to_database(test_data)


def add_to_database(msg_dict: dict):
    dbase = "Logs"
    db = mysql.connector.connect(
            host=hostname,
            user=usr,
            password=passwd,
            database=dbase
            )
    cursor = db.cursor()

    u_name = msg_dict['user']
    table_name = 'Login'

    try: 
        cursor.execute("CREATE TABLE " + table_name + " ("
                       "user VARCHAR(255) NOT NULL,"
                       "status VARCHAR(10), "  # Either failed or success
                       "ip VARBINARY(16), "
                       "time_logged DATETIME)")

        # For handling Chinese characters
        cursor.execute("ALTER TABLE " + table_name + """
                        CONVERT TO CHARACTER SET utf8mb4
                        COLLATE utf8mb4_unicode_ci;
                        """)

    except mysql.connector.errors.ProgrammingError:
        print("table", u_name, "already exists")

    sql = "INSERT INTO " + table_name + " (user, status, ip, time_logged)" + \
            """
            VALUES (%s, %s, %s, %s)
            """

    print(tuple(msg_dict.values()))
    cursor.execute(sql, tuple(msg_dict.values()))
    db.commit()
    db.close()


if __name__ == "__main__":
    test()
