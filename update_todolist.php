<?php session_start(); ?>
<?php require_once('constant.php'); ?>
<?php require_once('functions.php'); ?>

<?php
//  *** TO DO LIST ***   //

$task =[
    //'name'      =>  task that user will enter,
    //'status'    =>   by default 1 // 1 = incomplete , 2 = done
];
$list = [] ;

//  **  adding the task  **  //
if(isset($_REQUEST['add']))
{
    if(!empty(trim($_REQUEST['task'])))
    {     
        $task['name']   = $_REQUEST['task'];
        $task['status'] = 1 ; // 1= incomplete by default

        if(isset($_COOKIE['todo_list']) && !empty($_COOKIE['todo_list']))
        {
            $list = decode($_COOKIE['todo_list']);
            foreach ($list as $task_array)
            {
                if(in_array($_REQUEST['task'] ,$task_array))//error on repeated task.
                {
                    $_SESSION['repeated_task'] = $_REQUEST['task']. ERROR_REPEATED_TASK ;
                    $encode = encode($list);
                    header('location:user_profile.php');
                }    
            } 
            if(!in_array( $task , $list))
            {
                $list[] = $task ;
                $encode = encode($list);
            }
        }
        else
        {// will render only one time -> set cookie using the variable $encode. 
            $list[] = $task ;
            $encode = encode($list) ;
        }
    }
    else
    {// error on empty task feild.
        $_SESSION['empty_task_error'] = TASK_NAME_ERROR ;
        header('location:user_profile.php');
    }    
}

//  **  editing the task  **  //
elseif(isset($_REQUEST['edit']))
{
   if(isset($_COOKIE['task_to_be_editted']))
    {
        $edit_task = decode($_COOKIE['task_to_be_editted']);
        $edit_task['name'] = $_REQUEST['task']; // user input -> editted value

        if(isset($_COOKIE['todo_list']) && !empty($_COOKIE['todo_list']))
        {
            $list = decode($_COOKIE['todo_list']);
            
            foreach($list as $index => $task)
            {
                if($index == $edit_task['index'])
                {
                    $task['name'] = $edit_task['name'];
                    break;
                }
            }
            $list[$index] = $task;
            $encode = encode($list);
        }

        //unset cookie
        setcookie('task_to_be_editted' , $encode_edit_task , time()-1 , '/');
    }
}

//  **  on click done -> change task status -> display on same line  **  //
elseif(isset($_GET['done_task'])) // $_get['done_task'] value is an int list index
{
    $index = $_GET['done_task']; 
    if(isset($_COOKIE['todo_list']) && !empty($_COOKIE['todo_list']))
    {
        $list = decode($_COOKIE['todo_list']);
        foreach($list as $i => $task)
        {
            if($i == $index)
            {
                $task['status'] = 2;
                break;
            }
        }
        $list[$index] = $task ;

        $encode = encode($list);
    }
}

//  **  on click remove -> unset that index from $list -> display updated list  **  //
elseif(isset($_GET['remove_task'])) // $_get['remove_task'] value is an int list index
{ 
    $index       = $_GET['remove_task'] ;
    if(isset($_COOKIE['todo_list']) && !empty($_COOKIE['todo_list']))
    {
        $list = decode($_COOKIE['todo_list']);
        foreach($list as $i => $task)
        {
            if($i == $index)
            {
                unset($list[$i]);
                break;
            }
        }
        $encode = encode($list); 
    }
}

//  **  setting the cookie for saving actual to do list  **  //
if(isset($encode))
{
    setcookie('todo_list' , $encode , time() + 3600 * 7 , '/');
    header('location: user_profile.php');
}
