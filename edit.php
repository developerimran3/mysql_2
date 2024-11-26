<?php

if (file_exists(__DIR__ . "/autoload.php")) {
    require_once(__DIR__ . "/autoload.php");
} else {
    echo "autoload.php not found";
}

if (isset($_GET['editId'])) {
    $editId = $_GET['editId'];

    $sql = "SELECT * FROM deves WHERE id=' $editId'";
    $statement = connect()->prepare($sql);
    $statement->execute();
    $signalData = $statement->fetch(PDO::FETCH_OBJ);


    if (!$signalData) {
        header('location:index.php');
    }
} else {
    header("location:index.php");
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Database</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<?php

/**
 * Create Deves Data
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    //get form Data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $skill = $_POST['skill'];
    $location = $_POST['location'];
    $age = $_POST['age'];
    $gender = $_POST['gender'] ?? '';

    $updateId = $editId;

    //uplode deves photos
    $deves_photo = $signalData->photo;
    if (!empty($_FILES['photo']['name'])) {
        $deves_photo = move(
            [
                "tmp_name" => $_FILES['photo']['tmp_name'],
                "name" => $_FILES['photo']['name'],
            ],
            "media/deves/"
        );

        unlink('media/deves/' . $signalData->photo);
    }
    //form valadation
    if (empty($name) || empty($email) || empty($phone) || empty($skill) || empty($location) || empty($age) || empty($gender)) {
        $msg = createAlert('All Fields Are Requerd');
    } else {
        $sql = "UPDATE deves SET name=:name, email=:email, phone=:phone, skill=:skill, location=:location, age=:age, gender=:gender, photo=:photo WHERE id='$updateId' ";
        $statement = connect()->prepare($sql);
        $statement->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':skill' => $skill,
            ':location' => $location,
            ':age' => $age,
            ':gender' => $gender,
            ':photo' => $deves_photo,
        ]);

        header('location:index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $signalData->name; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- All Developer Show -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <a class="btn btn-sm btn-primary" href="./index.php">Back</a>
                <br>
                <br>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2>Create A new Developer</h2>
                        <div class="msg">
                            <?php echo $msg ?? '' ?>
                        </div>

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>?editId=<?php echo $editId ?>" method="POST" enctype="multipart/form-data">
                            <div class="my-3">
                                <label for="">Name</label>
                                <input type="text" name="name" value="<?php echo $signalData->name; ?>" class="form-control">
                            </div>
                            <div class="my-3">
                                <label for="">Email</label>
                                <input type="text" name="email" value="<?php echo $signalData->email; ?>" class="form-control">
                            </div>
                            <div class="my-3">
                                <label for="">Phone</label>
                                <input type="text" name="phone" value="<?php echo $signalData->phone; ?>" class="form-control">
                            </div>
                            <div class="my-3">
                                <label for="">Skill</label>
                                <select type="text" name="skill" value="<?php echo $signalData->skill; ?>" class="form-control">
                                    <option <?php echo $signalData->skill == 'Wordpress Developer' ? 'selected' : ""; ?> value="Wordpress Developer">Wordpress Developer</option>
                                    <option <?php echo $signalData->skill == 'Laravel Developer' ? 'selected' : ""; ?> value="Laravel Developer">Laravel Developer</option>
                                    <option <?php echo $signalData->skill == 'React js Developer' ? 'selected' : ""; ?> value="React js Developer">React Js Developer</option>
                                    <option <?php echo $signalData->skill == 'View js Developer' ? 'selected' : ""; ?> value="View js Developer">View Js Developer</option>
                                </select>
                            </div>

                            <div class="my-3">
                                <label for="">Location</label>
                                <select type="text" name="location" class="form-control">
                                    <option <?php echo $signalData->location == 'Dhaka' ? 'selected' : ""; ?> value="Dhaka">Dhaka</option>
                                    <option <?php echo $signalData->location == 'Barishal' ? 'selected' : ""; ?> value="Barishal">Barishal</option>
                                    <option <?php echo $signalData->location == 'Rajshahi' ? 'selected' : ""; ?> value="Rajshahi">Rajshahi</option>
                                    <option <?php echo $signalData->location == 'Chittagong' ? 'selected' : ""; ?> value="Chittagong">Chittagong</option>
                                    <option <?php echo $signalData->location == 'Cummila' ? 'selected' : ""; ?> value="Cummila">Cummila</option>
                                    <option <?php echo $signalData->location == 'Jassor' ? 'selected' : ""; ?> value="Jassor">Jassor</option>
                                    <option <?php echo $signalData->location == 'Rangpur' ? 'selected' : ""; ?> value="Rangpur">Rangpur</option>
                                    <option <?php echo $signalData->location == 'Sylet' ? 'selected' : ""; ?> value="Sylet">Sylet</option>
                                </select>
                            </div>

                            <div class="my-3">
                                <label for="">Age</label>
                                <input name="age" type="number" value="<?php echo $signalData->age; ?>" class="form-control">
                            </div>

                            <div class="my-3">
                                <label>Gender</label>
                                <br />
                                <label>
                                    <input type="radio" name="gender" <?php echo $signalData->gender == 'Male' ? 'checked' : ""; ?> value="Male"> Male
                                </label>
                                <label>
                                    <input type="radio" name="gender" <?php echo $signalData->gender == 'Female' ? 'checked' : ""; ?> value="Female"> Female
                                </label>
                            </div>
                            <div class="my-3">
                                <img id="signal_user_photo" src="media/deves/<?php echo $signalData->photo; ?>" alt="">
                                <label for="">Photo</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                            <div class="my-3">
                                <input type="submit" name="submit" value="Update Deves" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>