<?php
	include_once('inc/user.inc.php');
    include_once('layout/header.php');

    if (isset($_GET['success']) && $_GET['success']!='') {
 ?>
<div class="alert alert-success" role="alert">
    <?php echo $_GET['success']; ?>
</div>
<?php   
        }

        ?>


<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Users
    <a class="btn btn-primary float-right" href="add_edit_user.php?action=add">Add New</a>
</h1>

<div class="row">
    <div class="col-12">

        <!-- User list -->
        <table class="table table-bordered bg-white">
            <thead>
                <tr>
                    <th scope="col" class="text-center" style="width: 50px;">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col" class="text-center">Age</th>
                    <th scope="col">Create Date</th>
                    <th scope="col" class="text-center" style="width: 50px;">Status</th>
                    <th scope="col" class="text-center" style="width: 50px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($users = mysqli_fetch_assoc($data)) {   
                ?>
                <tr>
                    <th scope="row" class="text-center"><?php echo $users['id'] ?></th>

                    <td><?php echo $users['first_name'] ?></td>

                    <td><?php echo $users['last_name'] ?></td>

                    <td>
                        <a href="mailto:<?php echo $users['email'] ?>"><?php echo $users['email'] ?></a>
                    </td>
                    <td>
                        <a href="tel:<?php echo $users['phone_number'] ?>"><?php echo $users['phone_number'] ?></a>
                    </td>
                    <td class="text-center"><?php echo $users['age'] ?></td>
                    <td><?php echo $users['create_date'] ?></td>
                    <td class="text-center">
                        <a
                            href="<?php echo get_site_url('user.php?action=status&user_id='.$users['id'].'&user_status='.$users['status'] ) ?>">
                            <i
                                class="fa<?php echo (isset($users['status']) && $users['status']=='1') ? 's' : 'r' ?> fa-check-circle"></i></a>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo get_site_url('add_edit_user.php?action=edit&user_id='.$users['id']) ?>"><i
                                class="fa fa-edit"></i></a>
                        <a onclick="return confirm('Are you sure you want to delete this user?');"
                            href="<?php echo get_site_url('user.php?action=delete&user_id='.$users['id']) ?>">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>

                <?php } 
               
               if ($data->num_rows==0) {
               ?>

                <tr class="table-info">
                    <td colspan="9">Users not found! Please create new user by <a
                            href="<?php site_url('add_edit_user.php') ?>">this</a> link.</td>
                </tr>
                <?php }  ?>
            </tbody>
        </table>
        <!-- EOF User list -->
        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                 if($current_page == 1) {
                    $disable = 'disabled';
                } else {
                    $disable = 'active';     
                } 
                ?>
                <li class="page-item <?php echo $disable ?>">
                    <a class="page-link" href="<?php echo $prev_page_url ?>" aria-label="Previous">

                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <?php 
                 for($i=1;$i<=$total_page;$i++) {
                         $class='';
                     if($current_page==$i){
                        $class='active';
                     }
                 ?>
                <li class="page-item <?php echo $class?>">
                    <a class="page-link" href="<?php echo get_site_url('user.php?page='.$i); ?>">
                        <?php echo $i; ?></a>
                    </a>
                </li>
                <?php } ?>
                <?php
                if($current_page >= $total_page) {
                $disable_next = 'disable';
                } else {
                $disable_next = 'active';
                }
                ?>
                <li class="page-item <?php echo $disable_next ?>">

                    <a class="page-link" href="<?php echo $next_page_url ?>" aria-label="Next">

                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- EOF Pagination -->


    </div>
</div>

<?php
	include_once('layout/footer.php');
?>