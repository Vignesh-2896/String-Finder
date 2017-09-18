<head>
	<meta http-equiv="refresh" content="10;url=index.html">
</head>
<?php
$str=0;
	if(isset($_POST["str"]))
		$str=$_POST["str"];
	else
		{
			header("Location:index.html");
			exit();
		}	
	$count=0;
	$user_input=explode(" ",$str);									// User Input which is a string is converted into a string
	$num_of_user_inputs=1;
	
	$files=glob("*.txt");
	if(sizeof($files)==0)
		echo "	Oops ! No Text file is present in this folder.";
	else
	{	
	foreach($user_input as $substring)                              // Running the search one substring at a time
	{
		echo "<strong>".$num_of_user_inputs.".".$substring."</strong><br>"; 
		echo "<table>
			<tr>
				<th> Partial Substring </th>
				<th> Frequency </th>
				<th> File Name </th>
			</tr>";		
		foreach($files  as $filename)                            // Iterating through all files with text file extension
		{	
				$file_to_search=file_get_contents($filename);  			       	// Gettting the contents of the file, and set all characters to lower character set.		
				$file_to_search=strtolower($file_to_search);
				$file_to_search=str_replace("."," ",$file_to_search);
				$file_to_search=preg_replace('/[^A-Za-z0-9\-]/', ' ',$file_to_search);
				$lines=explode(" ",$file_to_search);						// Iterating through each line in the file.
				$z=0;														// Number of Partial Substrings found
				$count=0;
				$flag=0;
				foreach($lines as $word)							// Starting the comparison process word by word in each line
				{	$word=trim($word);
					if(preg_match("/".$substring."/",$word))
						{
							if($z==0)								// First Partial Substring found
							{
								$string_found[$z]=$word;			// Storing Partial Substring in array
								$string_found_count[$z]=1;
								$z++;
							}
							else							
							{
								for($x=0;$x<$z;$x++)				
								{
									if($string_found[$x]==$word)		// Checking if the Partial substring was already found
										{
											$string_found_count[$x]++;
											break;
										}
									else
										$flag=1;		
								}
									if($flag==1)						// New Partial Substring found, but not the first
										{
										 $string_found[$z]=$word;
										 $string_found_count[$z]=1;
										 $z++;
										 $flag=0;
										}
							}
						}
				}
				for($x=0;$x<$z;$x++)	
				{
					echo "<tr><td>".$string_found[$x]."</td><td>".$string_found_count[$x]."</td><td>".$filename."</td></tr>";
				}
				$z=0;
		}
		}
		echo "</table>";		
		$num_of_user_inputs++;
		echo "<br>";
	}
?>