<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../admin/assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">


    <?php include("nav.php"); ?>


    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tables</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Tables</li>
                </ol>
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-table me-1"></i>
                                Food Data
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Food</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                require_once("../includes/connection.php");

                                // $userID = $_SESSION["userID"];

                                $sqlQuery = "SELECT * FROM food_tbl INNER JOIN category_tbl ON food_tbl.foodCategory = category_tbl.category_id";
                                $statement = $conn->prepare($sqlQuery);
                                $statement->execute();
                                $result = $statement->fetchAll();


                                $sqlQueryCategory = "SELECT * FROM category_tbl";
                                $statement2 = $conn->prepare($sqlQueryCategory);
                                $statement2->execute();
                                $result2 = $statement2->fetchAll();

                                if ($result == true) {


                                    foreach ($result as $data) {
                                        $foodId = $data["id"];
                                        $foodName = $data["foodName"];
                                        $categoryName = $data["categoryName"];
                                        $categoryId = $data["category_id"];
                                        $foodPrice = $data["foodPrice"];
                                        $imageUrl = $data["image_url"];
                                        // $status = $data['status'];
                                ?>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>
                                                <img src="../includes/images/<?php echo $imageUrl; ?>" alt="Food Image" width="50" height="50">
                                            </td>
                                            <td><?php echo $foodName; ?></td>
                                            <td><?php echo $categoryName; ?></td>
                                            <td><?php echo $foodPrice; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $foodId ?>">Edit</button>
                                                <a href="./includes/deleteUser.php?foodId=<?php echo $foodId; ?>" type="button" class="btn btn-outline-danger btn-sm"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editModal<?php echo $foodId ?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addModalLabel">Edit Food Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="../includes/Food.php" method="post">

                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Food Name</label>
                                                                <input type="text" class="form-control" id="name" name="foodName" value="<?php echo $foodName ?>">
                                                                <input type="text" class="form-control" id="name" name="foodId" value="<?php echo $foodId ?>">
                                                            </div>
                                                            <div class="mb-3">

                                                                <div class="form-group">
                                                                    <label for="">Food Category</label>
                                                                    <select class="form-control" name="foodCategory" id="foodCategory">
                                                                        <option value="<?php echo $categoryId ?>"> <?php echo $categoryName ?></option>
                                                                        <hr>
                                                                        <?php
                                                                        if ($result2 == true) {
                                                                            foreach ($result2 as $data2) {
                                                                        ?>
                                                                                <option value="<?php echo $data2["category_id"] ?>"><?php echo $data2["categoryName"] ?></option>

                                                                        <?php }
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Food Price</label>
                                                                <input type="number" class="form-control" id="foodPrice" name="foodPrice" value="<?php echo $foodPrice ?>">
                                                            </div>
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" name="editFood">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">&copy; 2021-2023</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Food Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../includes/Food.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="images" class="form-label">Food Image</label>
                            <input type="file" class="form-control" id="images" name="images">
                        </div>
                        <div class="mb-3">
                            <label for="foodName" class="form-label">Food Name</label>
                            <input type="text" class="form-control" id="foodName" name="foodName">
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="foodCategory">Food Category</label>
                                <select class="form-control" name="foodCategory" id="foodCategory">
                                    <?php
                                    if ($result2 == true) {
                                        foreach ($result2 as $data2) {
                                    ?>
                                            <option value="<?php echo $data2["category_id"] ?>"><?php echo $data2["categoryName"] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="foodPrice" class="form-label">Food Price</label>
                            <input type="number" class="form-control" id="foodPrice" name="foodPrice">
                        </div>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="addFood">Save</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="editName">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="editEmail">
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../admin/assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../admin/assets/js/datatables-simple-demo.js"></script>
</body>

</html>