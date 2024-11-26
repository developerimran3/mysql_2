<?php

if (file_exists(__DIR__ . "/autoload.php")) {
    require_once(__DIR__ . "/autoload.php");
} else {
    echo "autoload.php not found";
}
//delete user date_add
if (isset($_GET['userDeleteId'])) {
    $userDeleteId = $_GET['userDeleteId'];
    $userDeletePhoto = $_GET['userDeletePhoto'];



    $sql = "DELETE FROM deves WHERE id='$userDeleteId'";
    $statement =  connect()->prepare($sql);
    $statement->execute();

    unlink('media/deves/' . $userDeletePhoto);

    header('location:index.php');
}




//get all deves Location

$sql = "SELECT location FROM deves";
$statement = connect()->prepare($sql);
$statement->execute();
$data = $statement->fetchAll(PDO::FETCH_OBJ);

$locationList = [];

foreach ($data as $item) {
    array_push($locationList, $item->location);
}
$locationList = array_unique($locationList);

$search_location = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_submit'])) {
    $search_location = $_POST['location'];
};




?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Database</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/view.css">
</head>

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
    <div class="container col-11 my-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <a class="btn btn-sm btn-primary" href="./create.php">Create New Deves</a>
                <br>
                <br>
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
                    <select class="location_search" name="location" id="">
                        <option value=""> -Select- </option>
                        <?php foreach ($locationList as $location): ?>
                            <option <?php echo $search_location == $location ? 'selected' : '' ?> value="<?php echo $location; ?>"><?php echo $location; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" name="search_submit">Search</button>
                </form>
                <br>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2>Our Developer</h2>
                        <hr>
                        <table class="table table-striped table-hover mt-2 text-center table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Skill</th>
                                    <th>Location</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <!-- <th>CreatedAt</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($search_location) {
                                    $sql = "SELECT * FROM deves WHERE location= '$search_location'";
                                } else {
                                    $sql = "SELECT * FROM deves ";
                                }


                                $statement = connect()->prepare($sql);
                                $statement->execute();
                                $data = $statement->fetchAll(PDO::FETCH_OBJ);

                                $i = 1;
                                foreach ($data as $item):
                                ?>
                                    <tr>
                                        <td><?php echo $i;
                                            $i++; ?> </td>
                                        <td> <img src="media/deves/<?php echo $item->photo; ?>" alt=""> </td>
                                        <td><?php echo $item->name; ?> </td>
                                        <td><?php echo $item->email; ?> </td>
                                        <td><?php echo $item->phone; ?> </td>
                                        <td><?php echo $item->skill; ?> </td>
                                        <td><?php echo $item->location; ?> </td>
                                        <td><?php echo $item->age; ?> </td>
                                        <td><?php echo $item->gender; ?> </td>
                                        <!-- <td><?php echo timeAgo($item->createdAt); ?></td> -->
                                        <td>
                                            <a class="btn btn-sm btn-success" href="#"> <i class="fa fa-thumbs-up"></i></a>
                                        </td>
                                        <td> <a class="btn btn-sm btn-info" href="viewdata.php?viewdataId=<?php echo $item->id; ?>"><i class="fa fa-eye"></i></a>
                                            <a class="btn btn-sm btn-warning" href="edit.php?editId=<?php echo $item->id; ?>"><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-sm btn-danger" href="index.php?userDeleteId=<?php echo $item->id; ?>&userDeletePhoto=<?php echo $item->photo ?>"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>