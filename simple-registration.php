<!DOCTYPE HTML>
<html>
<head>
    <style>
        .error {
            color: #FF0000;
        }
        table{
            border-collapse: collapse;
            width: 100%;
        }
        td, th{
            border: solid 1px #ccc;
        }
        form{
            width: 450px;
        }
    </style>
</head>
<body>
<?php
    function loadRegister($filename) {
        $datajson = file_get_contents($filename);
        $arr_data = json_decode($datajson,true);
        return $arr_data;
    }
    function saveRegister($filename , $name, $email, $phone) {
        try{
            $contact = array(
              "name" => $name,
              "email" => $email,
                "phone" => $phone
            );
            $arr_data = loadRegister($filename);
            array_push($arr_data,$contact);
            $jsondata = json_encode($arr_data);
            file_put_contents($filename,$jsondata);
            echo "OK!";

        } catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    $error = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        if (empty($name)) {
            $nameErr = " Tên đăng nhập không được để trống";
            $error = true;
        }
        if (empty($email)) {
            $emailErr = "Email không được để trống!";
            $error = true;
        } else{
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $emailErr = "Định dạng email sai (xxx@xxx.xxx.xxx)!";
                $error = true;
            }
        }
        if (empty($phone)){
            $phoneErr= "Số điện thoại không được để trống!";
            $error = true;
        }
        if ($error == false) {
            saveRegister('users.json', $name, $email, $phone);
        }
    }

?>
<h2>Registration Form</h2>
<form method="post">
    <fieldset>
        <legend>Details</legend>
        Name: <input type="text" name="name" value="<?php  echo $name?>">
        <span class="error">* <?php echo $nameErr?></span>
        <br><br>
        E-mail: <input type="text" name="email" value="<?php  echo $email?>">
        <span class="error">* <?php  echo $emailErr?></span>
        <br><br>
        Phone: <input type="text" name="phone" value="<?php  echo $phone?>">
        <span class="error">*<?php  echo $phoneErr?></span>
        <br><br>
        <input type="submit" name="submit" value="Register">
        <p><span class="error">* required field.</span></p>
    </fieldset>
</form>

<h2>Registration list</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
    </tr>
    <tr>
        <td>xxx</td>
        <td>xxx</td>
        <td>xx</td>
    </tr>
    <tr>
        <td>vvvv</td>
        <td>vvv@vvv.vvv.ccc</td>
        <td>vvv</td>
    </tr>
    <tr>
        <td>cccccc</td>
        <td>ccc@ccc.ccc.cc</td>
        <td>ccccc</td>
    </tr>
</table>
</body>
</html>