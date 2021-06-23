from flask_mysqldb import MySQL
import json

class database:
    def __init__(self, lib):
        # Load config file
        with open('./config/config.json') as config:
            config = json.loads(config.read())

        # Configure the database
        lib.config['MYSQL_HOST'] = config['MYSQL_HOST']
        lib.config['MYSQL_USER'] = config['MYSQL_USER']
        lib.config['MYSQL_PASSWORD'] = config['MYSQL_PW']
        lib.config['MYSQL_DB'] = config['MYSQL_DB_NAME']

        # Save database
        self.__db = MySQL(lib)

    # Example query...
    def test(self):
        db_handle = self.__db.connection.cursor()

        db_handle.execute('SELECT * FROM `login`')
        temp = db_handle.fetchall()
        db_handle.close()

        print('test')
        print(type(temp))
        print(temp)

        

