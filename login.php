<?php
session_start();
// include_once 'session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'dbconfig.php';
    $error_message = "";
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? $_POST['remember'] : 0;
    if($remember==1){
        setcookie('email', $email,time() + 86400,"/" );
        setcookie('password', $password,time() + 86400,"/" );
        // $error_message="welcome back user! ";
        // header("Location: dashboard.php");
        // exit();
    }
   


    $sql = "SELECT * FROM phonebook WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    try {
      
        $stmt->execute();

      
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $user['password'])) {
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_phone'] = $user['phone'];

                header("Location: dashboard.php");
                exit();
            } else {

                $error_message = "Invalid password!";
            }
        } else {
           
            $error_message = "No account found with that email.";
        }
    } catch (PDOException $e) {
       
        $error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login Page</title>
</head>
<body>
    

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img class="mx-auto h-10 w-auto" src="https://leleventures.com/assets/img/logo.png" alt="Your Company">
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="login.php" method="POST">
            <div>
                <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                <div class="mt-2">
                    <input id="email" name="email" type="email" value="<?php if(isset($_COOKIE['email'])) echo $_COOKIE['email']; else echo ''; ?>" autocomplete="email" required class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    <div class="text-sm">
                        <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                    </div>
                </div>
                <div class="mt-2">
                    <input id="password" name="password" type="password" value="<?php if(isset($_COOKIE['password'])) echo $_COOKIE['password']; else echo ''; ?>" autocomplete="current-password" required class="block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                </div>
            </div>
            <label class="block text-sm/6 font-medium text-gray-900">
            <input type="checkbox" name="remember" value="1" >
            Keep me logged in
            
            </label>
            <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
            </div>
        </form>

        <?php if (isset($error_message) && $error_message != ""): ?>
            <div class="mt-4 text-center text-red-500">
                <strong><?php echo $error_message; ?></strong>
            </div>
        <?php endif; ?>

        <p class="mt-10 text-center text-sm/6 text-gray-500">
            Not a member?
            <a href="register.php" class="font-semibold text-indigo-600 hover:text-indigo-500">Register here</a>
        </p>
    </div>
</div>

</body>
</html>
