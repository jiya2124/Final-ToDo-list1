<?php session_start(); ?>
<?php require_once('data.php'); ?>
<?php require_once('functions.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="src/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

    <title>Document</title>
</head>
<body>
<?php
// **  on click edit -> Hold the value in form input feild through cookie   **  //   
if(isset($_COOKIE['task_to_be_editted']))
{
    $edit_task = decode($_COOKIE['task_to_be_editted']);
    $encode_edit_task = encode($edit_task);
}

?>
<div class="container">
<!-- Display form -->
    <div class="profile">
        <div class="header">
        <h3>WELCOME  <?php echo $_SESSION['name'] . '!';  ?></h3>
        <a href='logout.php'>LOG OUT</a>
        </div>

        <div class="list">
        <form method="post" action="update_todolist.php">
        
        <input type="text" name="task" placeholder="To do ..." 
        value="<?php echo (isset($edit_task) ? $edit_task['name'] : null );?>" required>

        <input type="submit" 
        name="<?php echo (isset($edit_task) ? 'edit' : 'add' );?>" 
        value="<?php echo (isset($edit_task) ? 'EDIT' : 'ADD' );?>" ><br>

        <span><?php echo (isset($_SESSION['empty_task_error']) ? $_SESSION['empty_task_error'] : '' ); ?></span>
        <span><?php echo (isset($_SESSION['repeated_task']) ? $_SESSION['repeated_task'] : '' ); ?></span>        
    
<?php 
// unset errors 
    unset($_SESSION['empty_task_error']);
    unset($_SESSION['repeated_task']);
?>

<?php
// ** Display To Do List  **  //
if(isset($_COOKIE['todo_list']) && !empty($_COOKIE['todo_list']))
{
    $list = decode($_COOKIE['todo_list']);
    listDown($list , 'name');
    $encode = encode($list);
}

//  **  on click edit -> edit the task -> display updated task on same line  **  //
    if(isset($_GET['edit_task']))
    {
        $index = $_GET['edit_task'];
        if(isset($_COOKIE['todo_list']) && !empty($_COOKIE['todo_list']))
        {
            $list = decode($_COOKIE['todo_list']);
            
            //setting new cookie for holding the value of task to be editted
            $edit_task = $list[$index]; //task array with key (name and status)
            $edit_task['index'] = $index ;
            //encode then set cookie
            $encode_edit_task = encode($edit_task);
            setcookie('task_to_be_editted' , $encode_edit_task , time()+3600*24 , '/');
            
            $encode = encode($list);
            header('location:user_profile.php');
        }
    }


?>
		</div>
    </div>
</div>
</body>
</html>
