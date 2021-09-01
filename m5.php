<html>
    <head>
        <meta charset="UTF-8">
        <title>mission_5</title>
    </head>
    <body>
        
        <?php
        
        $numedit="";
        $nameedit="";
        $stredit="";
        $passedit="";
        $error="";
        $time=date("Y/m/d/ H:i:s");
        
        //データベースへの接続
        $dsn="データベース名";
        $user="ユーザー名";
        $password="パスワード";
        $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));//エラー発生時の警告文
        
        //テーブルの作成
        $sql="CREATE TABLE IF NOT EXISTS tbmission5"."("."id INT AUTO_INCREMENT PRIMARY KEY,"."name char(32),"."comment TEXT,"."password char(32),"."time TEXT".");";
        $stmt=$pdo->query($sql);
        
        if(isset($_POST['sendsub'])){//送信ボタンが押されていたら
            if(isset($_POST['numedit'])&&$id=$_POST["numedit"]){//idがあったら
                if(isset($_POST['strpass'])&&$passA=$_POST["strpass"]){//passがあったら
                    $sql='SELECT*FROM tbmission5';
                    $stmt=$pdo->query($sql);
                    $results=$stmt->fetchAll();
                    foreach($results as $row){
                        if($row['id']===$id){//tbmission5を参照してidが合っていたら
                            $name=$_POST["name"];
                            $str=$_POST["str"];
                            $sql='UPDATE tbmission5 SET name=:name,comment=:comment,password=:password,time=:time WHERE id=:id';
                            $stmt=$pdo->prepare($sql);
                            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                            $stmt->bindParam(':name',$name,PDO::PARAM_STR);
                            $stmt->bindParam(':comment',$str,PDO::PARAM_STR);
                            $stmt->bindParam(':password',$passA,PDO::PARAM_STR);
                            $stmt->bindParam(':time',$time,PDO::PARAM_STR);
                            $stmt->execute();
                        }
                    }
                }else{
                    $error="-- パスワードを設定してください --";
                }
            }elseif(isset($_POST['name'])&&$name=$_POST["name"]){
                if(isset($_POST['str'])&&$str=$_POST["str"]){//名前とコメントがあったら
                    if(isset($_POST['strpass'])&&$passB=$_POST["strpass"]){//passが設定されていたら
                        $sql=$pdo->prepare("INSERT INTO tbmission5 (name,comment,password,time) VALUES (:name,:comment,:password,:time)");
                        $sql->bindParam(':name',$name,PDO::PARAM_STR);
                        $sql->bindParam(':comment',$str,PDO::PARAM_STR);
                        $sql->bindParam(':password',$passB,PDO::PARAM_STR);
                        $sql->bindParam(':time',$time,PDO::PARAM_STR);
                        $sql->execute();
                    }else{
                        $error="-- パスワードを設定してください --";
                    }
                }else{
                    $error="-- コメントを入力してください --";
                }
            }else{
                $error="-- 名前を入力してください --";
            }
        }elseif(isset($_POST['delsub'])){//削除ボタンが押されたら
            if(isset($_POST['delnum'])&&$id=$_POST["delnum"]){//削除機能
                if(isset($_POST['delpass'])&&$passC=$_POST["delpass"]){
                    $sql='SELECT*FROM tbmission5';
                    $stmt=$pdo->query($sql);
                    $results=$stmt->fetchAll();
                    foreach($results as $row){
                        if($row['id']===$id&&$row['password']===$passC){//tbmission5を参照してidとパスワードが合っていたら
                            $sql='delete from tbmission5 where id=:id';
                            $stmt=$pdo->prepare($sql);
                            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                            $stmt->execute();
                        }
                    }
                }else{
                    $error="-- パスワードを入力してください --";
                }
            }else{
                $error="-- IDを入力してください --";
            }
        }elseif(isset($_POST['edisub'])){//編集ボタンが押されたら
            if(isset($_POST['edinum'])&&$id=$_POST["edinum"]){//編集機能
                if(isset($_POST['edipass'])&&$passD=$_POST["edipass"]){
                    $sql='SELECT*FROM tbmission5';
                    $stmt=$pdo->query($sql);
                    $results=$stmt->fetchAll();
                    foreach($results as $row){
                        if($row['id']===$id&&$row['password']===$passD){
                            $numedit=$row[0];
                            $nameedit=$row[1];
                            $stredit=$row[2];
                            $passedit=$row[3];
                        }
                    }
                }else{
                    $error="-- パスワードを入力してください --";
                }
            }else{
                $error="-- IDを入力してください --";
            }
        }
        
        ?>
        
        
        <br>
        <h3>　好きな動物を教えてください！</h3>
        <br>
        投稿欄
        <form action="#" method="post">
            <input type="hidden" name="numedit" value=<?php echo$numedit; ?>>
            <input type="text" name="name" placeholder="名前" value=<?php echo$nameedit; ?>>
            <input type="text" name="str" placeholder="コメント" value=<?php echo$stredit; ?>><br>
            <input tupe="password" name="strpass" placeholder="パスワード" value=<?php echo$passedit; ?>>
            <input type="submit" name="sendsub" value="送信"><br><br>
        </form>
        削除依頼
        <form action="#" method="post">
            <input type="number" name="delnum"><br>
            <input tupe="password" name="delpass" placeholder="パスワード">
            <input type="submit" name="delsub" value="削除"><br><br>
        </form>
        編集依頼
        <form action="#" method="post">
            <input type="number" name="edinum"><br>
            <input tupe="password" name="edipass" placeholder="パスワード">
            <input type="submit" name="edisub" value="編集">
        </form>
        <br>
        
        <?php
        echo$error."<br><br>";
        echo"<hr>";
        $sql='SELECT*FROM tbmission5';
        $stmt=$pdo->query($sql);
        $results=$stmt->fetchAll();
        foreach($results as $row){//$rowの中にはテーブルのカラム名が入る
            echo$row['id'].' ';
            echo$row['name'].' ';
            echo$row['comment'].' ';
            echo$row['time'].'<br>';
        }
        echo"<hr>";
        
        ?>
        
    </body>
</html>