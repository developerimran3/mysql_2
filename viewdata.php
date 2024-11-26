<?php

if (file_exists(__DIR__ . "/autoload.php")) {
    require_once(__DIR__ . "/autoload.php");
} else {
    echo "autoload.php not found";
}


if (isset($_GET['viewdataId'])) {
    $viewdataId = $_GET['viewdataId'];

    $sql = "SELECT * FROM deves WHERE id=' $viewdataId'";
    $statement = connect()->prepare($sql);
    $statement->execute();
    $viewdata = $statement->fetch(PDO::FETCH_OBJ);


    if (!$viewdata) {
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
    <title><?php echo $viewdata->name; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- All Developer Show -->
    <div class="container  my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a class="btn btn-sm btn-primary" href="index.php">Back</a>
                <br>
                <br>
                <div class="card shadow-sm">

                    <div class="card-body">
                        <span id="viewSignalStudentData"> <?php echo $viewdata->skill; ?> : <?php echo $viewdata->name; ?></span>

                        <table class="table table-bordered table-striped">
                            <tr>
                                <td class="title">Applicant ID</td>
                                <td class="colon">:</td>
                                <td><?php echo $viewdata->id; ?></td>
                                <td rowspan="8" class="image" id="view_data"><img width="300" src="media/deves/<?php echo $viewdata->photo; ?>" alt=""></td>
                            </tr>
                            <tr>
                                <td class="title">Name</td>
                                <td class="colon">:</td>
                                <td><?php echo $viewdata->name; ?></td>
                            </tr>
                            <tr>
                                <td class="title">Email</td>
                                <td class="colon">:</td>
                                <td id="email"> <?php echo $viewdata->email; ?></td>
                            </tr>
                            <tr>
                                <td class="title">Phone</td>
                                <td class="colon">:</td>
                                <td><?php echo $viewdata->phone; ?></td>
                            </tr>
                            <tr>
                                <td class="title">Skill</td>
                                <td class="colon">:</td>
                                <td><?php echo $viewdata->skill; ?></td>
                            </tr>
                            <tr>
                                <td class="title">location</td>
                                <td class="colon">:</td>
                                <td><?php echo $viewdata->location; ?></td>
                            </tr>
                            <tr>
                                <td class="title">Age</td>
                                <td class="colon">:</td>
                                <td><?php echo $viewdata->age; ?></td>
                            </tr>
                            <tr>
                                <td class="title">Gender</td>
                                <td class="colon">:</td>
                                <td><?php echo $viewdata->gender; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>