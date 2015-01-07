<?php

require_once "vendor/autoload.php";

use Respect\Validation\Validator as v;
use Core\Validator;

$number = 123;
$validation = v::numeric()->validate($number); //true

?>
<form method="POST">
	<table>
		<tr>
			<td>
				<label>Name</label>
			</td>
			<td>
				<input type="text" name="name" />	
			</td>
		</tr>
		<tr>
			<td>
				<label>Email</label>
			</td>
			<td>
				<input type="text" name="email" />	
			</td>
		</tr>
		<tr>
			<td>
				<label>Password</label>
			</td>
			<td>
				<input type="password" name="password" />	
			</td>
		</tr>
		<tr>
			<td>
				<label>Password Confirmation</label>
			</td>
			<td>
				<input type="password" name="password_confirmation" />	
			</td>
		</tr>
		<tr>
			<td>
				<label>Site</label>
			</td>
			<td>
				<input type="text" name="site" />	
			</td>	
		</tr>
		<tr>
			<td>
				<label>Sex</label>
			</td>
			<td>
				<label>Male</label>
				<input type="radio" name="sex" value="M" />			
				<label>Female</label>
				<input type="radio" name="sex" value="F" />	
			</td>
		</tr>
		<tr>
			<td>
				<label>Age</label>
			</td>
			<td>
				<input type="text" name="age" />	
			</td>
		</tr>
		<tr>
			<td>
				<label>Date of birth</label>
			</td>
			<td>
				<input type="text" name="birthdate" />	
			</td>	
		</tr>		
	</table>
	<input type="submit" value="Submit" />	
</form>