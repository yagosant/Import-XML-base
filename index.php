<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
   // require 'simplexml.class.php';
    require 'database.php';
     //if(isset($_POST['buttonImport'])) copy($_FILES['xmlFile']['tmp_name'],'data/'.$_FILES['xmlFile']['name']);
     if(isset($_POST['buttonImport'])) {
        copy($_FILES['xmlFile']['tmp_name'],'data/'.$_FILES['xmlFile']['name']);
        $products = simplexml_load_file('data/'.$_FILES['xmlFile']['name']);
        //print_r($products->user);
        foreach($products as $product){
            //$stmt = $conn->prepare('insert into user (email, nome) values(:email,:nome)');
            $query = $conn->prepare('insert into user (id_user, email, nome) values(:id_user,:email,:nome)');
            $query->bindValue(':id_user', $product->id_user); 
            $query->bindValue(':email', $product->email); 
            $query->bindValue(':nome', $product->nome); 
            $query->execute(); 

            //echo '<br>ID: '.$product->id_user;
        }

     }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        Arquivo XML <input type="file" name="xmlFile" id="">
        <br>
        <input type="submit" value="Import" name="buttonImport">
    </form>
    <br>
    <h3>Lista de Usuarios</h3>
    <table cellpadding ="2" cellspacing="2" border="1">
        <tr>
            <th>id_user</th>
            <th>Email</th>
            <th>Nome Usuario</th>
        </tr>
        <?php 
        $query = $conn->prepare('select * from user');
        $query->execute();
        while($user = $query->fetch(PDO::FETCH_OBJ)) {?>
            <tr>
                <td><?php echo $user->id_user?></td>
                <td><?php echo $user->email?></td>
                <td><?php echo $user->nome?></td>
            </tr>

            <?php }?>
    </table>
</body>
</html>