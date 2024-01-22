<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="container">
        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/o6wtDPVkKqI?si=UPrXWvpJ8ARR15SQ"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
        </div>
        <div class="comment-section">
            <form action="" method="POST">
                <div>
                    *Name: <input type="text" name="naam" value="">
                </div>
                <div>
                    *E-mail: <input type="text" name="email" value="">
                </div>
                <div>
                    Comment: <input type="text" name="commentaar" value="">
                </div>
                <input type="submit" value="Submit">
            </form>

            <?php

            function test_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            include 'connectie.php';

            $naam = $email = $commentaar = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $naam = test_input($_POST["naam"]);
                $email = test_input($_POST["email"]);
                $commentaar = test_input($_POST["commentaar"]);

                if (empty($naam) || empty($email)) {
                    echo "Naam en email zijn verplicht";
                } elseif (empty($commentaar)) {
                    echo "U heeft geen commentaar opgegeven";
                } else {
                    $sql = "INSERT INTO comments (firstname, email, comment)  
                           VALUES ('$naam', '$email', '$commentaar')";

                    if ($conn->query($sql) === TRUE) {
                        echo "Comment posted";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }

            $sql_fetch_comments = "SELECT * FROM comments";
            $result = $conn->query($sql_fetch_comments);


            if ($result->num_rows > 0) {
                echo "<h2>Comments:</h2>";
                while ($row = $result->fetch_assoc()) {
                    echo "<p><strong>Name:</strong> " . $row["firstname"] . "</p>";
                    echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
                    echo "<p><strong>Comment:</strong> " . $row["comment"] . "</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p>No comments yet.</p>";
            }


            $conn->close();
            ?>