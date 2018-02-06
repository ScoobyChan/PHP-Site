<?php
	include_once 'header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Welcome</h2>
		<?php
			if (isset($_SESSION['u_id'])) {
				echo "<h2>" . $_SESSION['u_uid'] . " has logged in!</h2>";
			}
		?>

	</div>
</section>

<?php
	include_once "footer.php";
?>
