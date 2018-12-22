
<?php 
require_once '../core/init.php';
include 'includes/header.php';
include 'includes/navigation.php';

$sql = "SELECT * FROM brand ORDER BY brand";
$result = $db->query($sql);
$errors =array();

//edit brand
if(isset($_GET['edit']) && !empty($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $edit_id = sanitize($edit_id);
  $sql2 ="SELECT * FROM brand WHERE id ='$edit_id'";
  $edit_result = $db->query($sql2);
  // var_dump($edit_result);
  $eBrand = mysqli_fetch_assoc($edit_result);
  
}

//delete brand
   if (isset($_GET['delete']) && !empty($_GET['delete'])) {
     $delete_id = (int)$_GET['delete'];
     $delete_id = sanitize($delete_id);
     $sql ="DELETE FROM brand WHERE id= '$delete_id'";
     $db->query($sql);
     //for redirection to the brand page
     header('Location: brand.php');
   }
//if added form is submitted
   if(isset($_POST['add_submit'])){
    $brand = sanitize($_POST['brand']);
     //check if brand is blank
     if($_POST['brand']== ''){
       $errors[] .= 'You Must Enter A Valid Brand!';
     }
     //check if brand exit in database
     $sql = "SELECT * FROM brand WHERE brand ='$brand'";
     if(isset($_GET['edit'])){
       $sql = "SELECT * FROM brand WHERE brand ='$brand' AND id !='$edit_id'";
     }
     $result= $db->query($sql);
     $count= mysqli_num_rows($result);
     if($count > 0){
         $errors[] .= $brand.'  already exist please choose and brand name';
     }

     //display errors
     if(!empty($errors)){
       echo display_errors($errors);
     }else{
       //Add brand to database
       $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
       if(isset($_GET['edit'])){
         $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_brand'";
       }
       $db->query($sql);
       header('Location: brand.php');
     }
   }
?>
<h2 class="text-center">Brand</h2><hr>

<!-- Brand Form-->
<div class="text-center">
   <form class="form-inline" method="post" action="brand.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>">
      <div class="form-group">
      <!-- making the brand name appear when editing -->
         <?php
         $brand_value = '';
         if(isset($_GET['edit'])){
            $brand_value = $eBrand['brand'];
         }else{
           if(isset($_POST['brand'])){
             $brand_value = sanitize($_POST['brand']);
           }
         } ?>
        <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add A '); ?> Brand</label>
        <!-- value=" $_POST['brand'];  the ? is what will hsppen if the condition is true 
         while colon : is if the condition is false will help to keep the text they typed in the box when the get errors -->
        <input type="text" name="brand" id="brand" class="form-control" value="<?= $brand_value; ?>">
        <!-- adding cancel btn -->
        
        <?php if(isset($_GET['edit'])): ?>
            <a href="brand.php" class="btn btn-default">Cancel</a>
         <?php endif; ?>
        <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Brand" class="btn btn-lg btn-success">
      </div>
   </form>
</div><hr>

<table class="table table-bordered table-striped table-auto table-condensed">
   <thead>
     <th></th><th>Brand</th><th></th>
   </thead>
   <tbody>
     <?php while($brand = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <td><a href="brand.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
        <td><?= $brand['brand']; ?></td>
        <td><a href="brand.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
      </tr>
    <?php endwhile; ?>
   </tbody>
</table>

<?php
include 'includes/footer.php';
?>