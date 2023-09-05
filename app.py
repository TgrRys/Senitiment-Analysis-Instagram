# Import necessary libraries
import instaloader
from os.path import expanduser
import pandas as pd
import datetime
from flask import Flask, jsonify, request, render_template
from io import StringIO

# Create an instance of Instaloader
loader = instaloader.Instaloader()

app = Flask(__name__)

# Set the template folder path to your desired location
app = Flask(__name__, template_folder=expanduser("~/Downloads/flask/flask2"))

@app.route('/')
def index():
    # Render the HTML template for the main page
    return render_template('index.html')

@app.route('/get-instagram-profile', methods=['GET'])
def get_instagram_profile():
    try:
        # Get the profile username from the query parameters
        username = request.args.get('username')

        # Retrieve the public profile
        profile = instaloader.Profile.from_username(loader.context, username)

        # Initialize a list to store post data as dictionaries
        profile_data = []

        # Iterate over the profile's posts
        for post in profile.get_posts():
            post_data = {
                "date": post.date_local.strftime('%Y-%m-%d'),
                "caption": post.caption,
                "likes": post.likes,
                "comments": post.comments,
                "engagement": int(post.comments) + int(post.likes),
                "link": f"https://www.instagram.com/p/{post.shortcode}/"  # Add the post link
            }
            profile_data.append(post_data)

        # Return the profile data as JSON
        return jsonify(profile_data), 200

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
