from flask import Flask, render_template, request, jsonify
import mysql.connector

app = Flask(__name__)

# MySQL Database Configuration
db_config = {
    'host': 'localhost',
    'user': 'root',  # Replace with your MySQL username
    'password': '',  # Replace with your MySQL password
    'database': 'farmer_detials'  # Corrected database name
}

# Function to fetch diseases and time from the database
def fetch_diseases(district, village):
    try:
        # Connect to the MySQL database
        connection = mysql.connector.connect(**db_config)
        cursor = connection.cursor(dictionary=True)

        # Query to fetch diseases and time based on district and village
        query = """
            SELECT disease, time 
            FROM location 
            WHERE district = %s AND village = %s
        """
        cursor.execute(query, (district.lower(), village.lower()))
        result = cursor.fetchall()

        # Close the database connection
        cursor.close()
        connection.close()

        return result
    except Exception as e:
        print(f"Error fetching data: {e}")
        return []

# Route to serve the HTML frontend
@app.route('/')
def index():
    return render_template('index.html')

# Route to handle AJAX requests
@app.route('/check_diseases', methods=['POST'])
def check_diseases():
    data = request.json
    district = data.get('district')
    village = data.get('village')

    if not district or not village:
        return jsonify({'error': 'District and village are required!'}), 400

    # Fetch data from the MySQL database
    diseases = fetch_diseases(district, village)
    return jsonify({'diseases': diseases})

if __name__ == '__main__':
    app.run(debug=True)