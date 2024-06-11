<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .notification-counter {
            position: relative;
            display: inline-block;
        }
        .notification-counter .count {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            display: none; /* Initially hidden */
        }
        .notification-content {
            display: none; /* Initially hidden */
            background-color: white;
            color: black;
            border: 1px solid #ddd;
            padding: 10px;
            position: absolute;
            right: 0;
            top: 30px;
            width: 300px;
            z-index: 1000;
            max-height: 400px; /* Optional: Limit height */
            overflow-y: auto; /* Optional: Enable scrolling if content is too large */
        }
    </style>
</head>
<body>

<table width="100%" style="background-color: #0066ff;color: white;">
    <tr>
        <td width="85%">
            <h2>Welcome to Facebook</h2>
        </td>
        <td width="15%" class="notification-counter">
            <i class="fa fa-bell" aria-hidden="true" id="noti_icon"></i>
            <span class="count" id="noti_number"></span>
        </td>
    </tr>
</table>
<div class="notification-content" id="noti_content"></div>

<script type="text/javascript">
function loadDoc() {
    setInterval(function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                var countElement = document.getElementById("noti_number");
                var contentElement = document.getElementById("noti_content");

                if (response.count > 0) {
                    countElement.innerHTML = response.count;
                    countElement.style.display = 'inline-block';
                    contentElement.innerHTML = response.notifications;
                } else {
                    countElement.style.display = 'none';
                    contentElement.innerHTML = '<p>No new notifications</p>';
                }
            }
        };
        xhttp.open("GET", "data.php", true);
        xhttp.send();
    }, 1000);
}

document.addEventListener('DOMContentLoaded', (event) => {
    loadDoc();

    let clickCount = 0;

    document.getElementById("noti_icon").onclick = function() {
        clickCount++;
        var contentElement = document.getElementById("noti_content");

        if (clickCount === 1) {
            contentElement.style.display = "block";
        } else if (clickCount === 2) {
            contentElement.style.display = "none";
            clickCount = 0; // Reset click count

            // Send AJAX request to mark notifications as seen
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST", "mark_notifications_seen.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send();

            // Hide the notification count after marking as seen
            var countElement = document.querySelector(".count");
            countElement.style.display = 'none';
        }
    };
});
</script>
</body>
</html>
