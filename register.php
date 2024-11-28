<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'dbconfig.php';
    $error_message='';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $hashpassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `phonebook`(name, email, phone, password ) values('$name', '$email', '$phone', '$hashpassword')";

    $stmt = $conn->prepare($sql);    

    try {
        
        $result = $stmt->execute();
    
        if ($result) {
          
            $error_message = "User Registration Successfull";  
            header("Location: login.php");
          }
    } catch (PDOException $e) {
       
        if ($e->getCode() == 23000) {
            
         
            $error_message = "This Email or Phone is already in use"; 
        } else {
              
         
            header("Location: register.php?message=Error: " . $e->getMessage());
        }
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
   
    <title>Register Here</title>
</head>
<body>


    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
          <img class="mx-auto h-10 w-auto" src="https://leleventures.com/assets/img/logo.png" alt="Your Company">
          <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Register new account</h2>
        </div>
      
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
          <form class="space-y-6" action="register.php"  method="POST">

         

            <div>
                <label for="name" class="block text-sm/6 font-medium text-gray-900">Full Name</label>
                <div class="mt-2">
                  <input id="name" name="name" type="name" autocomplete="name" required class="block w-full rounded-md border-0 px-3 py-1.5 text-s-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                </div>
              </div>

            <div>
              <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
              <div class="mt-2">
                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
              </div>
            </div>
            <div>
                <label for="phone" class="block text-sm/6 font-medium text-gray-900">Phone Number</label>
                <div class="mt-2">
                  <input id="phone" name="phone" type="phone" autocomplete="phone" required class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                </div>
              </div>
            <div>
              <div class="flex items-center justify-between">
                <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                <div class="text-sm">
                  
                </div>
              </div>
              <div class="mt-2">
                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
              </div>
            </div>
            <div>
                <div class="flex items-center justify-between">
                  <label for="password" class="block text-sm/6 font-medium text-gray-900">Confirm Password</label>
                  <div class="text-sm">
                    
                  </div>
                </div>
                <div class="mt-2">
                  <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                </div>
              </div>
            <div>
              <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Register New Account</button>
            </div>
          </form>
          <?php if (isset($error_message) && $error_message != ""): ?>
            <div class="mt-4 text-center text-red-500">
                <strong><?php echo $error_message; ?></strong>
            
            </div>
        <?php endif; ?>
          <p class="mt-10 text-center text-sm/6 text-gray-500">
            Already got an account?
            <a href="login.php" class="font-semibold text-indigo-600 hover:text-indigo-500">Login Here</a>
          </p>
        </div>
      </div>
</body>
</html>