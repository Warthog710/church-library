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

    def search_by_title(self, title):
        query = f'SELECT r.id, r.title, r.publisher, r.resource_id, a.first_name, a.last_name FROM resource AS r JOIN authorship AS au ON au.resource_id = r.id JOIN author AS a ON au.author_id = a.id WHERE r.title LIKE \'%{title}%\';'
        db_handle = self.__db.connection.cursor()
        db_handle.execute(query)
        temp = db_handle.fetchall()
        db_handle.close()
        return temp
