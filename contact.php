<?php
// ==========================
//  Database connection
// ==========================
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "wildlife"; // change if your DB name is different

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<h3 style='color:red;'>❌ Connection failed: " . $conn->connect_error . "</h3>");
}

// ==========================
//  Handle Form Submission
// ==========================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $msg   = $_POST['msg'] ?? '';

    if (!empty($name) && !empty($email) && !empty($msg)) {

        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $msg);

        if ($stmt->execute()) {
            header("Location: contact.php?success=1");
            exit();
        } else {
            header("Location: contact.php?error=1");
            exit();
        }

        $stmt->close();
    } else {
        header("Location: contact.php?empty=1");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="si">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sri Lankan Wildlife - ශ්‍රී ලංකා වන ජීවී | Contact</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Simple inline styles for message boxes */
    .alert {
      padding: 15px;
      margin: 20px auto;
      width: 80%;
      border-radius: 8px;
      text-align: center;
      font-weight: bold;
    }
    .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .warning { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
  </style>
</head>
<body>

  <!-- Navigation -->
  <nav>
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
      <div class="logo">🐘 Sri Lankan Wildlife</div>
      <ul id="nav-menu">
        <li><a href="index.html">Home</a></li>
        <li><a href="animals.html">Animals</a></li>
        <li><a href="parks.html">Parks</a></li>
        <li><a href="birds.html">Birds</a></li>
        <li><a href="gallery.html">Gallery</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
      </ul>
    </div>
  </nav>

  <!-- Contact Header -->
  <section class="hero contact-hero">
    <h1>Contact Us</h1>
    <p>Have a question or feedback? Send us a message below 👇</p>
  </section>

  <!-- ✅ Success / Error Messages -->
  <?php if (isset($_GET['success'])): ?>
    <div class="alert success">✅ Message sent successfully!</div>
  <?php elseif (isset($_GET['error'])): ?>
    <div class="alert error">❌ There was a problem sending your message. Please try again.</div>
  <?php elseif (isset($_GET['empty'])): ?>
    <div class="alert warning">⚠️ Please fill all fields before submitting.</div>
  <?php endif; ?>

  <!-- Contact Form Section -->
  <section class="contact-section container">
    <form action="contact.php" method="POST" class="contact-form">
      <div class="form-group">
        <label for="name">Name *</label>
        <input type="text" id="name" name="name" required placeholder="Enter your name">
      </div>

      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required placeholder="your@gmail.com">
      </div>

      <div class="form-group">
        <label for="msg">Message *</label>
        <textarea id="msg" name="msg" rows="6" required placeholder="Write your message here..."></textarea>
      </div>

      <button type="submit" class="btn">Send Message ✉️</button>
    </form>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Sri Lankan Wildlife. All rights reserved.</p>
    <p>🌿 Protecting and preserving Sri Lanka's natural heritage 🌿</p>
    <p style="margin-top: 1rem;">Made with ❤️ for Wildlife Conservation</p>
  </footer>

</body>
</html>
