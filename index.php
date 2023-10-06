<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Profile Post Data</title>
    <!-- Include Bootstrap CSS from CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Instagram Profile Posts Data</h1>
        <form class="d-flex flex-column align-items-center mt-4">
            <div class="form-group w-100">
                <label for="username">Enter Instagram Username:</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-dark" id="fetch-button">Fetch Data</button>
                    </div>
                </div>
            </div>
            <!-- Add an input for limiting the number of posts -->
            <div class="form-group w-100">
                <label for="limit">Limit the number of posts:</label>
                <input type="number" class="form-control" id="limit" name="limit">
            </div>
        </form>

        <!-- Display the fetched data here -->
        <div id="profile-data" class="mt-5">
            <!-- Table to display the fetched data -->
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Post Date</th>
                        <th>Caption</th>
                        <th>Link</th>
                        <th>Likes</th>
                        <th>Comments</th>
                        <th>Followers</th>
                        <th>Average</th>
                        <th>Sentimen</th>
                    </tr>
                </thead>
                <!-- Give an id to tbody -->
                <tbody id="post-table-body">
                    <!-- Posts will be added here dynamically -->
                </tbody>
            </table>
        </div>

        <!-- Display the word cloud container -->
        <div id="word-cloud" class="mt-5">
            <h2 class="text-center">Word Cloud</h2>
            <div id="word-cloud-canvas" class="d-flex justify-content-center"></div>
        </div>
        
    </div>

    <script>
        // Function to make an AJAX request and update the table
        function fetchProfileData() {
            const username = document.getElementById('username').value;
            const limit = document.getElementById('limit').value; // Get the limit input
            const url = `/get-instagram-profile?username=${username}&limit=${limit}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Create a table row for each post
                    const tableBody = document.querySelector('#post-table-body'); // Select the tbody with id
                    tableBody.innerHTML = '';

                    data.forEach(post => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${post.date}</td>
                            <td>${post.caption}</td>
                            <td><a href="${post.link}" target="_blank">Link Postingan</a></td>
                            <td>${post.likes}</td>
                            <td>${post.comments}</td>
                            <td>${post.followers}</td>
                            <td>${post.engagement}</td>
                            <td>${post.sentimen}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Function to display the word cloud
        function displayWordCloud() {
            const wordCloudCanvas = document.getElementById('word-cloud-canvas');
            const wordCloudImage = new Image();

            // Generate a timestamp to append to the image URL
            const timestamp = Date.now();

            // Fetch the word cloud image from the server with the timestamp
            fetch(`/get-word-cloud?timestamp=${timestamp}`)
                .then(response => response.blob())
                .then(blob => {
                    const url = URL.createObjectURL(blob);
                    wordCloudImage.src = url;
                    wordCloudCanvas.innerHTML = ''; // Clear previous image
                    wordCloudCanvas.appendChild(wordCloudImage);
                })
                .catch(error => {
                    console.error('Error fetching word cloud:', error);
                });
        }

        // Add click event listener to the "Fetch Data" button
        document.getElementById('fetch-button').addEventListener('click', () => {
            fetchProfileData();
            displayWordCloud(); // Display the word cloud when fetching data
        });
    </script>

    <!-- Include Bootstrap JS and jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
