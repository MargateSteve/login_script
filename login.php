<?php 
require_once 'core/init.php';

// login

if (Input::exists()) {


    if (Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'field_name' => 'Username',
                'required' => true,
                'min' => 2
            ),
            'password' => array('required' => true)
        ));

        if($validation->passed()) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login) {
                Redirect::to('index.php');
            } else {
                echo 'Login Failed';
            }
        } else {
            foreach($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}

?>
<form action="" method="post">
    
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" autocomplete="false" />
    </div><!-- /.field --> 

     

     <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" autocomplete="false"/>
    </div><!-- /.field -->   

    <div class="field">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember" autocomplete="false"/>
            Remember Me
        </label>
    </div><!-- /.field --> 

      <input type="hidden" name="token" value ="<?php echo Token::generate(); ?>"/>
    <input type="submit" value="Log in" />
</form>