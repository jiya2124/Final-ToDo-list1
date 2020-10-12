<?php
// encode
    function encode( $decoded_array )
    {
        $encode = serialize($decoded_array) ;
        $encode = base64_encode($encode) ;

            return $encode ;
    }

// decode
    function decode($cookie_array)
    {
        $decode = base64_decode($cookie_array) ;
        $normal_array = unserialize($decode) ;
    
            return $normal_array;
    }


// listing the tasks
    function listDown(array $parent_array , string $child_array_key1 )
    {?>
		<table>
        <tbody>
        <?php 
            foreach($parent_array as $k => $child_array)
            {?>
                <tr class="task">
				<td><div 
					style="<?php echo $child_array['status'] == 2 ?
								//'text-decoration:line-through;' : ''
								'background-color:#99e600;color:#ffffff;': '' 
							?> " >

					<?php echo $child_array[$child_array_key1]; ?>
					</div>
				</td>
				
				<td><a href="update_todolist.php?done_task=<?php echo $k; ?>"> <i class="fa fa-check-circle"></i> </a></td>
				<td><a href="?edit_task=<?php echo $k; ?>"><i class="fa fa-edit"></i></a></td>
                <td><a href="update_todolist.php?remove_task=<?php echo $k; ?>"> <i class="fa fa-times-circle"></i> </a></td>
                
                </tr><?php
            }
        ?>
        </tbody>
		</table>
        <?php
    }