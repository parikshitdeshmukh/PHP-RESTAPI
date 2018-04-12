<?php

// Connect to database
	include("../connection.php");
	$db = new dbObj();
	$connection =  $db->getConnstring();

	$request_method=$_SERVER["REQUEST_METHOD"];


switch($request_method)
	{
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				get_studentsById($id);
			}
			else
			{
				get_students();
			}
			break;

		case 'POST':
			// Insert Product
			insert_student();
			break;

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

	function get_students()
	{
		global $connection;
		$query="SELECT name, grades, year FROM students";
		$response=array();
		$result=mysqli_query($connection, $query);
		while($row=mysqli_fetch_array($result))
		{
			// echo $row;
			$response[]=$row;
		}
		//console.log($response)
		header('Content-Type: application/json');
		echo json_encode($response);
	}


	function get_studentsById($id=0)
	{
		global $connection;
		$query="SELECT  name, grades, year FROM students";
		if($id != 0)
		{
			$query.=" WHERE id=".$id." LIMIT 1";
		}
		$response=array();
		$result=mysqli_query($connection, $query);
		while($row=mysqli_fetch_array($result))
		{
			$response[]=$row;
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}


	function insert_student()
	{
		global $connection;

		$data = json_decode(file_get_contents('php://input'), true);
		$name=$data["name"];
		$grades=$data["grades"];
		$year=$data["year"];
		echo $query="INSERT INTO students SET name='".$name."', grades='".$grades."', year='".$year."'";
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Student Added Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Student Addition Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

?>