<?php include_once('include/include.php');?>
<!DOCTYPE html>
<html>
    <head>
        <title>Books</title>
        <meta CHARSET="UTF-8"/>
		<link rel="stylesheet" href="main.css"/>
    </head>
    <body>
		<table class="table">
			<thead>
				<tr>
					<th>
						Book
					</th>
					<th>
						Compatibility
					</th>
					<th>
						Book Date
					</th>
					<th>
						Female AVG age
					</th>
					<th>
						Male AVG age
					</th>
				</tr>
			</thead>
			<tbody>
		<?php
			$book = 'ZieLoNa MiLa';
			$sql = "SELECT b.id, b.name, b.book_date, r.book_id, r.age, r.sex 
				FROM books b
				INNER JOIN reviews r ON r.book_id = b.id
				WHERE b.name = '$book'
				AND r.age>=30";
			$result = mysqli_query($conn,$sql);
			$fAge = array();
			$mAge = array();
				
			function sexAvg($age){
				if(count($age)==0){
					echo '0';
				}else{
					$avg=round((array_sum($age)/count($age)),2);
					echo $avg;
				}
			}
			
			while($row = mysqli_fetch_array($result)){
				$name = $row['name'];
				$date = $row['book_date'];
				$name = strtolower($name);
				$book = strtolower($book);
				$sim = similar_text($name, $book, $perc);
				$comp = round($perc, 2);
				if(($row['sex'])=='f'){
					$fAge[] = $row['age'];
				}
				if(($row['sex'])=='m'){
					$mAge[] = $row['age'];
				}
				$name = $row['name'];
				
			}
				echo '<tr>';
					echo '<td>';
						echo $name;
					echo '</td>';
					echo '<td>';
						echo $comp.'%';
					echo '</td>';
					echo '<td>';
						echo $date;
					echo '</td>';
					echo '<td>';
						sexAvg($fAge);
					echo '</td>';
					echo '<td>';
						sexAvg($mAge);
					echo '</td>';
				echo '</tr>';
			echo '</tbody>';
		echo '</table>';
		?>
		<table class="table">
			<thead>
				<tr>
					<th>
						Book
					</th>
					<th>
						Compatibility
					</th>
					<th>
						Book Date
					</th>
					<th>
						Female AVG age
					</th>
					<th>
						Male AVG age
					</th>
				</tr>
			</thead>
			<tbody>
		<?php 
			
			$book = 'ZiElonA Droga';
			$sql = "SELECT DISTINCT b.id, b.name, b.book_date, r.book_id, r.age, r.sex 
			FROM books b
			INNER JOIN reviews r ON r.book_id = b.id
			WHERE r.age<30
			GROUP BY b.name";
			$result = mysqli_query($conn,$sql);
			$fAge = array();
			$mAge = array();
			while($row = mysqli_fetch_array($result)){
				if($book!==$row['name']){
				$name = $row['name'];
				$date = $row['book_date'];
				$name = strtolower($name);
				$book = strtolower($book);
				$sim = similar_text($name, $book, $perc);
				$comp = round($perc, 2);
				if(($row['sex'])=='f'){
					$fAge[] = $row['age'];
				};
				if(($row['sex'])=='m'){
					$mAge[] = $row['age'];
				};
				$name = $row['name'];
				
				echo '<tr>';
					echo '<td>';
						echo $name;
					echo '</td>';
					echo '<td>';
						echo $comp.'%';
					echo '</td>';
					echo '<td>';
						echo $date;
					echo '</td>';
					echo '<td>';
						sexAvg($fAge);
					echo '</td>';
					echo '<td>';
						sexAvg($mAge);
					echo '</td>';
				echo '</tr>';
				}
			};
			echo '</tbody>';
		echo '</table>';
		?>
	</body>
</html>
