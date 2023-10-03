<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Profile Posts Data</title>
    <!-- Tambahkan Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styling utama */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #333;
            /* Ubah warna judul */
        }

        /* Gaya input dan tombol */
        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-group {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }

        #username {
            flex-grow: 1;
        }

        #fetch-button {
            margin-left: 10px;
        }

        /* Gaya tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            margin-top: 20px;
            text-align: center;
        }

        /* Gaya tautan */
        .post-link {
            color: #007bff;
            text-decoration: none;
        }

        .post-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Instagram Profile Posts Data</h1>
    <div class="container">
        <form class="form-group">
            <div class="input-group">
                <label for="username" class="col-sm-3 col-form-label">Enter Instagram Username:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="col-sm-3">
                    <button type="button" class="btn btn-success" id="fetch-button">Fetch Data</button>
                </div>
            </div>
        </form>

        <!-- Display the fetched data here -->
        <div id="profile-data">
            <!-- Table to display the fetched data -->
            <table class="table table-bordered" id="post-table">
                <thead>
                    <tr>
                        <th>Post Date</th>
                        <th>Caption</th>
                        <th>Link</th>
                        <th>Likes</th>
                        <th>Comments</th>
                        <th>Followers</th>
                        <th>Engagement</th>
                        <th>Sentiment</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Posts will be added here dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tambahkan Bootstrap JavaScript dan jQuery (diperlukan oleh Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Function to make an AJAX request and update the table
        function fetchProfileData() {
            const username = document.getElementById('username').value;
            const url = `http://127.0.0.1:5000/get-instagram-profile?username=${username}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Create a table row for each post
                    const tableBody = document.querySelector('#post-table tbody');
                    tableBody.innerHTML = '';

                    data.forEach(post => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${post.date}</td>
                            <td>${post.caption}</td>
                            <td><a class="post-link">${post.link}</a></td>
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

        // Function to generate and trigger the CSV download
        function downloadCSV(data) {
            const csv = 'Post Date,Caption,Likes,Comments,Engagement\n' + data.map(post => (
                `${post.date},"${post.caption}",${post.likes},${post.comments},${post.engagement}`
            )).join('\n');

            const blob = new Blob([csv], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'profile_data.csv';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        }

        // Add click event listener to the "Fetch Data" button
        document.getElementById('fetch-button').addEventListener('click', fetchProfileData);

        // Add click event listener to the "Download CSV" button
        document.getElementById('download-button').addEventListener('click', () => {
            fetch(`http://127.0.0.1:5000/get-instagram-profile?username=${document.getElementById('username').value}`)
                .then(response => response.json())
                .then(data => downloadCSV(data))
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });
    </script>
</body>

</html>
