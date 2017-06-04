<?php
function add_post(){
    global $conn;
    include ('views/add_note.html');
    if (isset($_POST['comment'])) {
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        mysqli_query($conn, "insert into pratsep_eksam(notes)
                               values('$comment')")
        or die("MySQL error:" . $conn->error);
        header('Location: main.php');
        exit();
    }
}
function delete_post(){
    global $conn;
    if (isset($_POST['delete'])) {
        $sql = "DELETE FROM pratsep_eksam WHERE id='" . mysqli_real_escape_string($conn, $_POST['delete']) . "'";
        mysqli_query($conn, $sql);
        header('Location: main.php');
        exit();
    }
}
function edit_post(){
    global $conn;
    if (isset($_POST['edit'])) {
        $confirm = "SELECT * FROM pratsep_eksam WHERE id = '" . mysqli_real_escape_string($conn, $_POST['edit']) . "'";
        $result = mysqli_query($conn, $confirm);
        $check = mysqli_fetch_assoc($result);

    }
    if(isset($_POST['confirm'])){
        $edited_note = mysqli_real_escape_string($conn, $_POST['confirm']);
        $sql = "UPDATE pratsep_eksam SET notes = '".$edited_note."' WHERE id=" . mysqli_real_escape_string($conn, $_POST['edit_id']);
        mysqli_query($conn, $sql);
        header('Location: main.php');
        exit();
    }
    include('views/edit_note.html');
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function configDB(){
    global $conn;
    $servername = "localhost";
    $username = "test";
    $password = "t3st3r123";
    $dbname = "test";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Ei saanud ühendada: ".$conn->connect_error);
    }
}
function showPosts(){
    global $conn;
    $posts = array();
    $sql = "SELECT * FROM pratsep_eksam order by id DESC ";
    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));;
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }
    include('views/eksam.html');
}