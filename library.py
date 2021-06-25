from os import error
from flask import Flask, render_template, request

from Database import database

lib = Flask(__name__)

# Start the database
db = database(lib)

@lib.route('/')
def index():
    return render_template('index.html')

@lib.route('/search', methods=['POST', 'GET'])
def search():
    # If we received a post request, search the database for that
    if request.method == 'POST':
        search_term = request.form['search_query']
        search_by = request.form['search_by']

        try:
            if 'title' in search_by:
                results = db.search_by_title(search_term)
            elif 'author' in search_by:
                pass
            elif 'publisher' in search_by:
                pass
            elif 'isbn' in search_by:
                pass
            else:
                pass

            return render_template('search.html/', search_results=results)
        except Exception as e:
            return f'An unknown error occurred while performing your query {e}'

    # Else, return the blank page
    else:
        return render_template('search.html/', search_results=None)

if __name__ == '__main__':
    lib.run(debug=True)
