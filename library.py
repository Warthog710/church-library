from flask import Flask, render_template

from Database import database

lib = Flask(__name__)

# Start the database
db = database(lib)

@lib.route('/')
def index():
    return render_template('index.html')

if __name__ == '__main__':
    lib.run(debug=True)
