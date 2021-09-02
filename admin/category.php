<?php
    include "header.php";
    
    if($_SESSION['role'] == '0')
    {
        header("Location: {$host}admin/post.php");
    }

?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                        <?php
                            
                            include "config.php";
                            $limit = 3;

                            if(isset($_GET['page']))
                                $page = $_GET['page'];
                            else
                                $page = 1;

                            $offset = ($page-1)*$limit;
                            $sql = "SELECT * FROM category ORDER BY post DESC LIMIT {$offset},{$limit}";
                            $result = mysqli_query($conn,$sql) or die('couldnt run query');

                            if(mysqli_num_rows($result) > 0)
                            {
                                $serial = $offset + 1;
                                while($rows = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td class='id'><?php echo $serial++;?></td>
                            <td><?php echo $rows['category_name'];?></td>
                            <td><?php echo $rows['post'];?></td>
                            <td class='edit'><a href='update-category.php'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                        <?php }}?>
                    </tbody>
                </table>
                <ul class='pagination admin-pagination'>
                    <?php 
                        $sql1 = "SELECT * FROM category";
                        $result1 = mysqli_query($conn,$sql1) or die("couldnt run query");
                        $total_records = mysqli_num_rows($result1);
                        if($total_records > 0){            
                        $total_pages = ceil($total_records/$limit);
                        if($page > 1)
                        {
                            echo "<li><a href='category.php?page=".($page-1)."'>PREV</a></li>";
                        }
                        for($i = 1; $i <= $total_pages; $i++){
                            if($i == $page)
                                $active = "active";
                            else
                                $active = "";
                            echo "<li class='".$active."'><a href='category.php?page=".$i."'>".$i."</a></li>";
                        }
                        if($total_pages > $page)
                        {
                            echo "<li><a href='category.php?page=".($page+1)."'>NEXT</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
