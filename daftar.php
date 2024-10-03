<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Halaman Sign Up</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
    />
    <link rel="stylesheet" href="css/daftar.css" />
  </head>
  <body>
    <div class="container">
      <form method="POST" action="daftar_action.php">
        <div class="nama">
          <input
            type="text"
            name="first_name"
            placeholder="First Name"
            required
          />
          <input
            type="text"
            name="last_name"
            placeholder="Last Name"
            required
          />
        </div>
        <div class="other">
          <input type="email" name="email" placeholder="Email" required />
          <input type="text" name="username" placeholder="Username" required />
          <input type="text" name="phone" placeholder="Phone Number" required />
          <input
            type="text"
            name="address"
            placeholder="Address"
            required
          /><input
            type="password"
            name="password"
            placeholder="Password"
            required
          />
          <input
            type="password"
            name="confirm-password"
            placeholder="Confirm Password"
            required
          />
        </div>

        <input type="reset" name="batal" value="RESET" />
        <input type="submit" name="daftar" value="DAFTAR" />
        <p>Sudah punya akun? <a href="login.php">Login sekarang</a></p>
      </form>
    </div>
  </body>
</html>
