<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>WAPH-Admin Login</title>
  <style>
      body {
          font-family: 'Times New Roman', Times, serif;
          background-color: #40e0d0;
          margin: 0;
          padding: 0;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          flex-direction: column;
      }
      .container {
          background: #d8bfd8;
          padding: 20px;
          border-radius: 8px;
          box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
          text-align: center;
      }
      .logo {
          width: 80px; 
          margin: 0 auto 20px;
      }
      h1, h2 {
          color: #333;
      }
      .form-group {
          margin-bottom: 15px;
      }
      label {
          display: block;
          margin-bottom: 5px;
      }
      input[type="text"],
      input[type="password"] {
          width: calc(100% - 22px);
          padding: 10px;
          margin: 5px 0 10px 0;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
      }
      button {
          width: 100%;
          padding: 10px;
          border: none;
          border-radius: 4px;
          font-weight: bold;
          color: black;
          background-color: #ff4500;
          cursor: pointer;
      }
      .btn-secondary {
          background-color: #ffb6c1;
      }
      a {
          color: black;
          text-decoration: none;
          font-weight: bold;
          display: inline-block;
          margin-top: 20px;
      }
  </style>
  <script type="text/javascript">
      function displayTime() {
        document.getElementById('digit-clock').innerHTML = "Current time:" + new Date();
      }
      setInterval(displayTime,500);
  </script>
</head>
<body>
  <div class="container">
      <img src="https://i.pinimg.com/736x/e0/b4/06/e0b40685ef41854b70398562f5dd7724.jpg" alt="Mini Facebook Logo" class="logo">
      <h1>Team 9 Admin Login</h1>

      <div id="digit-clock"></div>  

      <?php
        
        echo "Visited time: " . date("Y-m-d h:i:sa")
      ?>

      <form action="index.php" method="POST" class="login">
        <div class="form-group">
          <br><label for="username">Username:</label>
          <input type="text" id="username" name="username">
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password">
        </div>
        <button class="btn btn-primary" type="submit">Login</button>
      </form>

  </div>
</body>
</html>
