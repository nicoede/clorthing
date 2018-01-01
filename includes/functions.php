<?php 
session_start();


function confirm($result){
  global $connection;
  if(!$result){
    die("QUERY FAILED" . mysqli_error($connection));
  }
}

//=======================================================
//=================BRANDS FUNCTIONS======================
//=======================================================


function delete_brand(){
    global $connection;
    if(isset($_GET['delete'])){
      $get_brand_id = $_GET['delete'];
      $query = "DELETE FROM brands WHERE brands_id = {$get_brand_id} ";
      $delete_query = mysqli_query($connection, $query);
      confirm($delete_query);
      echo "<script type='text/javascript'>window.top.location='brands.php';</script>"; exit;
    }
}

//=======================================================

function new_brand(){
  global $connection;
  if(isset($_POST['submit'])){
    $brand_name = $_POST['brand_name'];
    $brand_name = mysqli_real_escape_string($connection, $brand_name);
    
    if(empty($brand_name)){
      return 3;
    }
    
    $new_brand_query = "INSERT INTO brands(brands_brand) VALUES('{$brand_name}')";
    $new_brand_query_result = mysqli_query($connection, $new_brand_query);
    
    if(!confirm($new_brand_query_result)){
      return 1;
    }else{
      return 2;
    }
  }
  
}

//=======================================================

function show_all_brands(){
    global $connection;
    $query = "SELECT * FROM brands ORDER BY brands_brand";
    $select_all_brands = mysqli_query($connection, $query);
    $count2 = mysqli_num_rows($select_all_brands);
    
    if($count2 > 0){
      while($row = mysqli_fetch_assoc($select_all_brands)){
        $brand_id = $row['brands_id'];
        $brand_name = $row['brands_brand'];
        
        echo "<tr>";
        ?>
        
        <td style='width: 30px;'><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $brand_id?>'></td>
        <?php
          echo "<td class='text-center' style='width: 70px;'>{$brand_id}</td>";
          echo "<td class='text-center'>{$brand_name}</td>";
          echo "<td class='text-center'><a href='brands.php?edit={$brand_id}#edit_here'>Edit</a></td>";
          echo "<td class='text-center'><a rel='$brand_id' href='javascript:void(0)' class='delete_brand_link_class' >Delete</a></td>";
        echo "</tr>";
      }
      return 1;
    }else{
      return 2;
    }
}


//=======================================================
//=================CATEGORIES FUNCTIONS==================
//=======================================================

function delete_category(){
    global $connection;
    if(isset($_GET['delete'])){
      $get_cat_id = $_GET['delete'];
      $query = "DELETE FROM categories WHERE categories_id = {$get_cat_id} ";
      $delete_query = mysqli_query($connection, $query);
      confirm($delete_query);
      echo "<script type='text/javascript'>window.top.location='categories.php';</script>"; exit;
    }
}

//=======================================================

function new_category(){
  global $connection;
  if(isset($_POST['submit'])){
    $category_name = $_POST['category_name'];
    $category_parent = $_POST['filter_sex_for_creation'];
    $category_name = mysqli_real_escape_string($connection, $category_name);
    
    if((empty($category_name)) || (empty($category_parent))){
      return 3;
    }
    
    $new_category_query = "INSERT INTO categories(categories_category, categories_parent) VALUES('{$category_name}', {$category_parent})";
    $new_category_query_result = mysqli_query($connection, $new_category_query);
    
    if(!confirm($new_category_query_result)){
      return 1;
    }else{
      return 2;
    }
  }
}

//=======================================================
//=================PRODUCTS FUNCTIONS====================
//=======================================================

function delete_product(){
  global $connection;
  if(isset($_GET['delete'])){
    $get_prod_id = $_GET['delete'];
    $query = "DELETE FROM products WHERE products_id = {$get_prod_id} ";
    $delete_query = mysqli_query($connection, $query);
    confirm($delete_query);
    echo "<script type='text/javascript'>window.top.location='products.php';</script>"; exit;
  }
}

//=======================================================

function new_product(){
  include "../../s3/init.php"; 
  global $connection;
  if(isset($_POST['new_product'])){
    $file = $_FILES['image'];

    $name = $file['name'];
    if($name == ''){
      return 3;
    }else{
      $tmp_name = $file['tmp_name'];
      
      $ext = explode('.', $name);
      $ext = strtolower(end($ext));
      
      $key = md5(uniqid());
      
      $temp_file_name = "{$key}.{$ext}";
      
      $temp_file_path = "../clothing/{$temp_file_name}";
      
      move_uploaded_file($tmp_name, $temp_file_path);
      
      try {
        // Upload data.
        $result = $s3->putObject(array(
           'Bucket'=> $config['s3']['bucket'],
            'Key'   => "clothing/{$name}",
            'Body'  => fopen($temp_file_path, 'rb'),
            'ACL'   => 'public-read'
       ));
      
        // Print the URL to the object.
      } catch (S3Exception $e) {
          echo $e->getMessage() . "\n";
      }
      
      unlink($temp_file_path);
      
      $product_image = $_FILES['image']['name'];
      $product_image_tmp = $_FILES['image']['tmp_name'];
    }
    
    $product_title = $_POST['product_name'];
    $product_featured = $_POST['featured'];
    $product_price = $_POST['price'];
    $product_list_price = $_POST['list_price'];
    $product_category_id = $_POST['category_id'];
    $product_brand = $_POST['brand'];
    $product_description = $_POST['product_description'];
    $product_sizes = $_POST['product_sizes'];
    
    if($product_featured == 1){
      $query = "INSERT INTO products(products_title, products_price, products_list_price, products_brand, products_categories, products_image, products_description, products_featured, products_sizes) ";
      $query .= "VALUES('{$product_title}', {$product_price}, {$product_list_price}, {$product_brand}, {$product_category_id}, '{$product_image}', '{$product_description}', {$product_featured}, '{$product_sizes}') ";
      $query_result = mysqli_query($connection, $query);
    }else{
      $query = "INSERT INTO products(products_title, products_price, products_brand, products_categories, products_image, products_description, products_featured, products_sizes) ";
      $query .= "VALUES('{$product_title}', {$product_price}, {$product_brand}, {$product_category_id}, '{$product_image}', '{$product_description}', {$product_featured}, '{$product_sizes}') ";
      $query_result = mysqli_query($connection, $query);
    }
    if(!confirm($query_result)){
      return 1;
    }else{
      return 2;
    }
    
  }
}

//=======================================================

function show_all_products(){
   global $connection;
   if(isset($_POST['show_all_products_button'])){
    $query = "SELECT * FROM products ORDER BY products_title";
    $select_all_products = mysqli_query($connection, $query);
    $count2 = mysqli_num_rows($select_all_products);
    
    if($count2 > 0){
      while($row = mysqli_fetch_assoc($select_all_products)){
        $product_id = $row['products_id'];
        $product_title = $row['products_title'];
        $product_price = $row['products_price'];
        $product_list_price = $row['products_list_price'];
        $product_brand = $row['products_brand'];
        $product_categories = $row['products_categories'];
        $product_image = $row['products_image'];
        $product_description = $row['products_description'];
        $product_featured = $row['products_featured'];
        $product_sizes = $row['products_sizes'];
        
        echo "<tr>";
          
          ?>
          <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $product_id; ?>'></td>
          <?php
          
          echo "<td>{$product_id}</td>";
          echo "<td>{$product_title}</td>";
          echo "<td>{$product_price}</td>";
          echo "<td>{$product_list_price}</td>";
          
          $query = "SELECT * FROM brands WHERE brands_id = {$product_brand} ";
          $select_brands = mysqli_query($connection, $query);
          
          while($row = mysqli_fetch_assoc($select_brands)){
            $brand_id = $row['brands_id'];
            $brand_title = $row['brands_brand'];
            echo "<td>{$brand_title}</td>";
          }
          
          $query = "SELECT * FROM categories WHERE categories_id = {$product_categories} ";
          $select_categories_id = mysqli_query($connection, $query);
          
          while($row = mysqli_fetch_assoc($select_categories_id)){
            $cat_id = $row['categories_id'];
            $cat_title = $row['categories_category'];
            echo "<td>{$cat_title}</td>";
          }
          echo "<td><img width='100' src='https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/{$product_image}' alt='image'></td>";
          echo "<td>{$product_description}</td>";
          if($product_featured == 1){
              echo "<td>Yes</td>";
          }else{
              echo "<td>No</td>";
          }
          echo "<td>{$product_sizes}</td>";
          echo "<td><a href='products.php?edit={$product_id}'>Edit</a></td>";
          echo "<td><a rel='$product_id' href='javascript:void(0)' class='delete_product_link_class' >Delete</a></td>";
        echo "</tr>";
      }
      return 1;
    }else{
      return 2;
    }
   }
}

//=======================================================

function products_filter(){
  global $connection;
    if(isset($_POST['submit_filter'])){
    $filter_sex = $_POST['filter_sex'];
    $brand = $_POST['brand_filter'];
    if($filter_sex == 1){
      $filter_category = $_POST['filter_category_m'];
    }else if($filter_sex == 2){
      $filter_category = $_POST['filter_category_w'];
    }
    
    if((empty($filter_category)) && (empty($brand)) && (!empty($filter_sex))){
      $filter_query = "SELECT * FROM products JOIN categories WHERE categories_parent = $filter_sex AND products_categories = categories_id ORDER BY products_title";
    }
    if((!empty($filter_category)) && (!empty($filter_sex)) && (empty($brand))){
      $filter_query = "SELECT * FROM products WHERE products_categories = {$filter_category} ORDER BY products_title";
    }
    if((empty($filter_category)) && (empty($filter_sex)) && (!empty($brand))){
      $filter_query = "SELECT * FROM products JOIN brands WHERE products_brand = {$brand} AND products_brand = brands_id ORDER BY products_title";
    }
    if((!empty($filter_category)) && (!empty($filter_sex)) && (!empty($brand))){
      $filter_query = "SELECT * FROM products JOIN categories JOIN brands WHERE products_categories = {$filter_category} AND products_categories = categories_id AND products_brand = {$brand} AND products_brand = brands_id ORDER BY products_title";
    }
    
    $filter_query_result = mysqli_query($connection, $filter_query);
    $count = mysqli_num_rows($filter_query_result);
    if($count > 0){
    confirm($filter_query_result);
    
      while($row = mysqli_fetch_assoc($filter_query_result)){
        $product_id = $row['products_id'];
        $product_title = $row['products_title'];
        $product_price = $row['products_price'];
        $product_list_price = $row['products_list_price'];
        $product_brand = $row['products_brand'];
        $product_categories = $row['products_categories'];
        $product_image = $row['products_image'];
        $product_description = $row['products_description'];
        $product_featured = $row['products_featured'];
        $product_sizes = $row['products_sizes'];
        echo "<tr>";
          
          ?>
          <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $product_id; ?>'></td>
          <?php
          
          echo "<td>{$product_id}</td>";
          echo "<td>{$product_title}</td>";
          echo "<td>{$product_price}</td>";
          echo "<td>{$product_list_price}</td>";
          
          $query = "SELECT * FROM brands WHERE brands_id = {$product_brand} ";
          $select_brands = mysqli_query($connection, $query);
          
          while($row = mysqli_fetch_assoc($select_brands)){
            $brand_id = $row['brands_id'];
            $brand_title = $row['brands_brand'];
            echo "<td>{$brand_title}</td>";
          }
          
          $query = "SELECT * FROM categories WHERE categories_id = {$product_categories} ";
          $select_categories_id = mysqli_query($connection, $query);
          
          while($row = mysqli_fetch_assoc($select_categories_id)){
            $cat_id = $row['categories_id'];
            $cat_title = $row['categories_category'];
            echo "<td>{$cat_title}</td>";
          }
          echo "<td><img width='100' src='https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/{$product_image}' alt='image'></td>";
          echo "<td>{$product_description}</td>";
          if($product_featured == 1){
              echo "<td>Yes</td>";
          }else{
              echo "<td>No</td>";
          }
          echo "<td>{$product_sizes}</td>";
          echo "<td><a href='products.php?edit={$product_id}'>Edit</a></td>";
          echo "<td><a rel='$brands_id' href='javascript:void(0)' class='delete_post_link_class' >Delete</a></td>";
        echo "</tr>";
      }
      return 1;
    }else{
      return 2;
    }
  }
}

//=======================================================
//===================SYSTEM FUNCTIONS====================
//=======================================================

function register_user(){
  global $connection;
  if(isset($_POST['submit'])){
      $username = $_POST['username'];
      if(!empty($username)){
          $user_query = "SELECT username FROM users WHERE username = '{$username}'";
          $user_query_result = mysqli_query($connection, $user_query);
          $count = mysqli_num_rows($user_query_result);
      }
      if($count == 0){
          $email = $_POST['email'];
          $password = $_POST['password'];
          $confirm_password = $_POST['confirm_password'];
          if(strcmp($password, $confirm_password) !== 0){
              $errPassword = 'Passwords do not match!';
          }else{
              if(!empty($username) && !empty($email) && !empty($password)){
                  $username = mysqli_real_escape_string($connection, $username);
                  $email = mysqli_real_escape_string($connection, $email);
                  $password = mysqli_real_escape_string($connection, $password);
                  
                  $query = "SELECT randSalt FROM users";
                  $select_randsalt_query = mysqli_query($connection, $query);
                  confirm($select_randsalt_query);
                  
                  
                  $row = mysqli_fetch_array($select_randsalt_query);
                  $salt = $row['randSalt'];
                  $password = crypt($password, $salt);
                  $user_image = 'profile.png';
                  
                  $query = "INSERT INTO users (username, user_email, user_password, user_role, user_image, user_date)";
                  $query .= "VALUES('{$username}', '{$email}', '{$password}', 'Subscriber', '{$user_image}', now() )";
                  $register_user_query = mysqli_query($connection, $query);
                  confirm($register_user_query);
                  return 1;
              }else{
                 return 2;
              }
          }
      }else{
         return 3;
      }
  }
}

//=======================================================

function show_all_users(){
   global $connection;
    $query = "SELECT * FROM users ORDER BY username";
    $select_all_users = mysqli_query($connection, $query);
    $count2 = mysqli_num_rows($select_all_users);
    
    if($count2 > 0){
      while($row = mysqli_fetch_assoc($select_all_users)){
        $user_id =$row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
        $user_image = $row['user_image'];
        $user_date = $row['user_date'];
        
        echo "<tr>";
          
          ?>
          <?php
          
          echo "<td>{$user_id}</td>";
          echo "<td>{$username}</td>";
          echo "<td>{$user_firstname}</td>";
          echo "<td>{$user_lastname}</td>";
          echo "<td>{$user_email}</td>";
          echo "<td>{$user_role}</td>";
          echo "<td><img height='50' src='https://s3-ap-southeast-1.amazonaws.com/nicoedeimages/clothing/{$user_image}' alt='image'></td>";
          echo "<td>{$user_date}</td>";
          
          if($user_role == 'Admin'){
            echo "<td><a href='users.php?edit={$user_id}'>Turn to Subscriber</a></td>";
          }
          
          if($user_role == 'Subscriber'){
            echo "<td><a href='users.php?edit={$user_id}'>Turn to Admin</a></td>";
          }
        echo "</tr>";
      }
      return 1;
    }else{
      return 2;
    }
   
}

//=======================================================

function update_user($user_id){
  include "../../s3/init.php";
  global $connection;
  if(isset($_POST['update_profile'])){
      $username = $_POST['username'];
      if(!empty($username)){
          $user_query = "SELECT username FROM users WHERE username = '{$username}'";
          $user_query_result = mysqli_query($connection, $user_query);
          $count = mysqli_num_rows($user_query_result);
      }
      
      if($count == 0){
        $file = $_FILES['image'];
  
        $name = $file['name'];
        if($name !== ''){
          $file = $_FILES['image'];
      
          $name = $file['name'];
          $tmp_name = $file['tmp_name'];
          
          $ext = explode('.', $name);
          $ext = strtolower(end($ext));
          
          $key = md5(uniqid());
          
          $temp_file_name = "{$key}.{$ext}";
          
          $temp_file_path = "../clothing/{$temp_file_name}";
          
          move_uploaded_file($tmp_name, $temp_file_path);
          
          try {
            // Upload data.
            $result = $s3->putObject(array(
               'Bucket'=> $config['s3']['bucket'],
                'Key'   => "clothing/{$name}",
                'Body'  => fopen($temp_file_path, 'rb'),
                'ACL'   => 'public-read'
           ));
          
            // Print the URL to the object.
          } catch (S3Exception $e) {
              echo $e->getMessage() . "\n";
          }
          unlink($temp_file_path);
          $user_image = $_FILES['image']['name'];
          $user_image_tmp = $_FILES['image']['tmp_name'];
        }else{
          $user_image = $user_image_1;
        }

      $user_firstname = $_POST['user_firstname'];
      $user_lastname = $_POST['user_lastname'];
      $user_email = $_POST['email'];
      $user_password = $_POST['password'];
      
      if(!empty($username) && !empty($user_email) && !empty($user_password)){
          $query = "SELECT randSalt FROM users";
          $select_randsalt_query = mysqli_query($connection, $query);
          confirm($select_randsalt_query);
          
          $row = mysqli_fetch_array($select_randsalt_query);
          $salt = $row['randSalt'];
          $hashed_password = crypt($user_password, $salt);
          
          $query = "UPDATE users SET username = '{$username}', user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', ";
          $query .= "user_email = '{$user_email}', user_password = '{$hashed_password}', user_image = '{$user_image}' "; 
          $query .= "WHERE user_id = {$user_id} ";
          
          $update_sub_user = mysqli_query($connection, $query);
          
          confirm($update_sub_user);
          
          $_SESSION['username'] = $username;
          $return = 1;
      }else{
          $return = 2;
      }
    }else{
      return 3;
    }
  }
}
//=======================================================

function login(){
  global $connection;
  if(isset($_POST['login'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);
  
  $query = "SELECT * FROM users WHERE username = '{$username}' ";
  $select_user_query = mysqli_query($connection, $query);

  confirm($select_user_query);
  
  while($row = mysqli_fetch_array($select_user_query)){
    $db_user_id = $row['user_id'];
    $db_username = $row['username'];
    $db_user_password = $row['user_password'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname = $row['user_lastname'];
    $db_user_role = $row['user_role'];
    $db_user_image = $row['user_image'];
  }
  
  $password = crypt($password, $db_user_password);
  
  if($username === $db_username && $password !== $db_user_password){
    return 2;
  }
  
  if($username === $db_username && $password === $db_user_password){
    $_SESSION['username'] = $db_username;
    $_SESSION['firstname'] = $db_user_firstname;
    $_SESSION['lastname'] = $db_user_lastname;
    $_SESSION['user_role'] = $db_user_role;
    $_SESSION['user_image'] = $db_user_image;
    if($db_user_role == 'Admin'){
      echo "<script type='text/javascript'>window.top.location='admin/';</script>"; exit;
    }else {
      echo "<script type='text/javascript'>window.top.location='../index.php';</script>"; exit;
    }
   
  }
}
}

?>