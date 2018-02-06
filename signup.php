<?php
	include_once 'header.php';
?>
<style>
    form{
        width: 45%;
        margin: 50px auto;
        text-align: left;
        padding: 20px;
    }
    .input-group{
        margin: 10px 0px 10px 0px;
    }
    .input-group label{
        display: block;
        text-align: left;
        margin: 3px;
    }
    .input-group input{
        height: 30px;
        width: 93%;
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid gray;
    }
</style>
<section class="main-container">
	<div class="main-wrapper">
		<h2>Sign Up</h2>
	<form class="signup-form" action="includes/signup.inc.php" method="POST">
		<div class="input-group">
            <label>First Name</label>
            <input type="text" name="first">
        </div>
        <div class="input-group">
            <label>Last Name</label>
            <input type="text" name="last">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="text" name="email">
        </div>
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="uid" required>
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="pwd" id="password" required>
        </div>
        <div class="input-group">
            <label>Confirm Password</label>
            <input type="password" id="confirm_password" required>
        </div>
		<button type="submit" name="submit">Sign up</button>
	</form>
        <script  src="js/index.js"></script>
	</div>
</section>

<?php
	include_once "footer.php";
?>