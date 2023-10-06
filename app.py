# Import necessary libraries
import instaloader
from os.path import expanduser
import pandas as pd
import datetime
from flask import Flask, jsonify, request, render_template, send_file
from io import StringIO, BytesIO
from textblob import TextBlob
from wordcloud import WordCloud
import matplotlib
matplotlib.use('Agg')  # Use the 'Agg' backend for non-interactive use
import matplotlib.pyplot as plt
import networkx as nx
from networkx.drawing.nx_pydot import graphviz_layout
import nxpd

# Create an instance of Instaloader
loader = instaloader.Instaloader()

app = Flask(__name__)

# Set the template folder path to your desired location
app.template_folder = expanduser("D:/xampp/htdocs/Senitiment-Analysis-Instagram/")

@app.route('/')
def index():
    # Render the HTML template for the main page
    return render_template('index.php')

@app.route('/get-instagram-profile', methods=['GET'])
def get_instagram_profile():
    try:
        # Get the profile username and limit from the query parameters
        username = request.args.get('username')
        limit = int(request.args.get('limit')) if 'limit' in request.args else None

        # Retrieve the public profile
        profile = instaloader.Profile.from_username(loader.context, username)

        # Get the follower count for the profile
        follower_count = profile.followers

        # Initialize a list to store post data as dictionaries
        profile_data = []

        # Initialize a list to store all captions for word cloud generation
        all_captions = []

        # Iterate over the profile's posts
        for post in profile.get_posts():
            # Initialize post_data dictionary for each post
            post_data = {
                "date": post.date_local.strftime('%Y-%m-%d'),
                "caption": post.caption,
                "likes": post.likes,
                "comments": post.comments,
                "engagement": int(post.comments) + int(post.likes),
                "followers": follower_count,
                "link": f'https://www.instagram.com/p/{post.shortcode}/',
                "shortcode": f'https://www.instagram.com/p/{post.shortcode}/',
                "sentimen": "Netral"  # Inisialisasi sentimen ke "Netral"
            }

            # Append the caption to the list for word cloud
            caption = post.caption
            if caption:
                all_captions.append(caption)

            # Analisis sentimen dengan TextBlob
            if caption:
                analysis = TextBlob(caption)
                sentiment = analysis.sentiment
                # Dapatkan nilai sentimen (range dari -1 hingga 1)
                sentiment_value = sentiment.polarity
                # Beri label sentimen berdasarkan nilai sentimen
                if sentiment_value > 0:
                    post_data["sentimen"] = "Positif"
                elif sentiment_value < 0:
                    post_data["sentimen"] = "Negatif"
                else:
                    post_data["sentimen"] = "Netral"

            # Tambahkan data postingan ke dalam profile_data jika belum mencapai limit
            if limit is None or len(profile_data) < limit:
                profile_data.append(post_data)
            else:
                break  # Hentikan iterasi jika sudah mencapai limit

        # Generate and save the word cloud to a file
        if all_captions:
            wordcloud = WordCloud(width=800, height=400).generate(' '.join(all_captions))
            fig, ax = plt.subplots(figsize=(10, 5))
            ax.imshow(wordcloud, interpolation='bilinear')
            ax.axis("off")
            plt.savefig('wordcloud.png', format='png', bbox_inches='tight')
            plt.close()

        # Create a response with CORS headers
        response = jsonify(profile_data)
        response.headers.add('Access-Control-Allow-Origin', '*')

        return response, 200

    except Exception as e:
        return jsonify({"error": str(e)}), 500

@app.route('/get-word-cloud', methods=['GET'])
def get_word_cloud():
    try:
        # Read the word cloud image from the file
        with open('wordcloud.png', 'rb') as f:
            image = BytesIO(f.read())

        return send_file(image, mimetype='image/png')

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
