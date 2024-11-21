<?php

if (file_exists(__DIR__ . "/autoload.php")) {
    require_once(__DIR__ . "/autoload.php");
} else {
    echo "autoload.php not found";
} ?>


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

    //uplode deves photos
    $deves_photo = null;
    if (isset($_FILES['photo']['name'])) {
        $deves_photo = move(
            [
                "tmp_name" => $_FILES['photo']['tmp_name'],
                "name" => $_FILES['photo']['name'],
            ],
            "media/deves/"
        );
    }
    //form valadation
    if (empty($name) || empty($email) || empty($phone) || empty($skill) || empty($location) || empty($age) || empty($gender)) {
        $msg = createAlert('All Fields Are Requerd');
    } else {
        $sql = "INSERT INTO deves (name, email, phone, skill, location, age, gender, photo ) VALUES (:name, :email, :phone, :skill, :location, :age, :gender, :photo)";
        $statement = connect()->prepare($sql);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':skill', $skill);
        $statement->bindParam(':location', $location);
        $statement->bindParam(':age', $age);
        $statement->bindParam(':gender', $gender);
        $statement->bindParam(':photo', $deves_photo);
        $statement->execute();

        header('location:index.php');
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="my-3">
                                <label for="">Name</label>
                                <input class="form-control" name="name" type="text">
                            </div>
                            <div class="my-3">
                                <label for="">Email</label>
                                <input class="form-control" name="email" type="text">
                            </div>
                            <div class="my-3">
                                <label for="">Phone</label>
                                <input class="form-control" name="phone" type="text">
                            </div>
                            <div class="my-3">
                                <label for="">Skill</label>
                                <select class="form-control" name="skill" type="text">
                                    <option value="">--Select Skill--</option>
                                    <option value="Wordpress Developer">Wordpress Developer</option>
                                    <option value="Laravel Developer">Laravel Developer</option>
                                    <option value="React js Developer">React Js Developer</option>
                                    <option value="View js Developer">View Js Developer</option>
                                </select>
                            </div>

                            <div class="my-3">
                                <label for="">Location</label>
                                <select class="form-control" name="location" type="text">
                                    <option value="">--Select Location--</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Barishal">Barishal</option>
                                    <option value="Rajshahi">Rajshahi</option>
                                    <option value="Chittagong">Chittagong</option>
                                    <option value="Cummila">Cummila</option>
                                    <option value="Jassor">Jassor</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Sylet">Sylet</option>
                                </select>
                            </div>

                            <div class="my-3">
                                <label for="">Age</label>
                                <input class="form-control" name="age" type="text">
                            </div>

                            <div class="my-3">
                                <label>Gender</label>
                                <br />
                                <label>
                                    <input type="radio" name="gender" value="Male"> Male
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="Female"> Female
                                </label>
                            </div>
                            <div class="my-3">
                                <label for="">Photo</label>
                                <input type="file" class="form-control" name="photo">
                            </div>
                            <div class="my-3">
                                <input type="submit" name="submit" value="create" class="btn btn-primary">
                                <input type="reset" name="reset" value="reset" class="btn btn-info">
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