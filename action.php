<?php

//action.php

$connect = new PDO("mysql:host=localhost;dbname=busine22_vuejs", "busine22_vueuser", "8lEjmGyK80FN");
$conn = mysqli_connect("localhost", "busine22_vueuser", "8lEjmGyK80FN", "busine22_vuejs");
$received_data = json_decode(file_get_contents("php://input"));
$data = array();

/* Show all Data */
	if($received_data->action == 'fetchall')
	{
	 $query = "SELECT * FROM `tbl_sample` ORDER BY id DESC";
	 $statement = $connect->prepare($query);
	 $statement->execute();
	 while($row = $statement->fetch(PDO::FETCH_ASSOC))
	 {
	  $data[] = $row;
	 }
	 echo json_encode($data);
	}

/*Insert Data Function*/	
	if($received_data->action == 'insert')
	{
		 $data = array(
		  ':first_name' => $received_data->firstName,
		  ':last_name' => $received_data->lastName,
		  ':phone_number' => $received_data->phoneNumber,
		   ':password' => $received_data->password,
		   ':userrole' => $received_data->userRole,
		  ':email_id' => $received_data->emailId
		 );
		 $query = "INSERT INTO `tbl_sample` (first_name, last_name,phone_number,email_id,password,userrole) VALUES (:first_name, :last_name, :phone_number, :email_id,:password,:userrole)";
		 $statement = $connect->prepare($query);
		 $statement->execute($data);
		 $output = array(
		  'message' => 'Registration Done Successfully'
		 );
		 echo json_encode($output);
	}

/*Fetch Data Function*/	
	if($received_data->action == 'fetchSingle')
	{
		 $query = "SELECT * FROM tbl_sample WHERE id = '".$received_data->id."'";
		 $statement = $connect->prepare($query);
		 $statement->execute();
		 $result = $statement->fetchAll();
		 foreach($result as $row)
		 {
		  $data['id'] = $row['id'];
		  $data['first_name'] = $row['first_name'];
		  $data['last_name'] = $row['last_name'];
		   $data['phone_number'] = $row['phone_number'];
		  $data['email_id'] = $row['email_id'];
		 }
		 echo json_encode($data);
	}


/*login Function*/	
	if($received_data->action == 'login')
	{
		/*$data = array(
		  ':email_id' => $received_data->EmilLogin,
		  ':password' => $received_data->PassLogin
		 );
		*/
		$query = "SELECT  userrole, COUNT(`id`) as countid FROM `tbl_sample` WHERE `email_id` = '".$received_data->EmilLogin."'";
		$statement = $connect->prepare($query);
		 $statement->execute();
		 $result = $statement->fetchAll();
		 foreach($result as $row)
		 {
		  $data['id'] = $row['countid'];
		  $data['userrole'] = $row['userrole'];
		 }
		 echo json_encode($data);
		
		
		 //echo json_encode($output);
		
	}
		
	
/*Update Function*/	
	if($received_data->action == 'update')
	{
		 $data = array(
		  ':first_name' => $received_data->firstName,
		  ':last_name' => $received_data->lastName,
		  ':id'   => $received_data->hiddenId
		 );

		 $query = "UPDATE tbl_sample 
		 SET first_name = :first_name, 
		 last_name = :last_name 
		 WHERE id = :id";

		 $statement = $connect->prepare($query);
		 $statement->execute($data);
		 $output = array(
		  'message' => 'Data Updated'
		 );
		 echo json_encode($output);
	}
	
/*Delete Function*/
	if($received_data->action == 'delete')
	{
		 $query = "DELETE FROM tbl_sample WHERE id = '".$received_data->id."'";
		 $statement = $connect->prepare($query);
		 $statement->execute();
		 $output = array(
		  'message' => 'Data Deleted'
		 );

		 echo json_encode($output);
	}

?>