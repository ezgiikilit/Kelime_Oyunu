<?php require_once "db.php"; ?>
<?php
/*print_r($_POST); */
   
    if($_POST) { 
    $soru = $_POST['soru'];
    $kelime = $_POST['kelime'];
    $kelime_sayi = $_POST['kelime_sayi'];
    $ekle= "insert into sorular ( soru, kelime, kelime_sayi )  VALUES ('".$soru."','".$kelime."','".$kelime_sayi."')";

    if ($db->query($ekle) === TRUE) 
    {
      header("Location: http://localhost/soruyazimi.php/");
    } 
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">   
    <link href="https://unpkg.com/tailwindcss@1.2.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet"> 
    <title>Soru Ekle</title>
    <style>
    html, body {
        margin-top:5%;
        height: 100%;
        font-family: 'Noto Sans JP', sans-serif;
        font-size: 17px;
    }
    label {
       font-size: 17px;
    }
    @media (max-width:992px) {
        #button-div{
            width: 100%;
            flex-direction: column;
        }
        #button-div button{
            width: 100%;
        }
        #button-div button:last-child{
            margin-top: 10px;
        }
        .input-div{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        button{
            width: 100% !important;
        }
    }    
    </style>
    </head>
    <body class="bg-gray-900 h-100">
<p class="text-left text-white text-4xl mb-6 ml-6 mr-6">Oyun esnasında sorulmasını istediğiniz soruları aşağıdaki boşlukları eksiksiz doldurarak gerçekleştirebilirsiniz!</p>
<div class="row w-100 h-100 mt-50 justify-content-center align-items-center">
  <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <div class="mb-6">
      <label class="block text-gray-700 font-bold mb-2 text-4xl">
        Kelime
      </label>
      <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="kelime" name="kelime" type="text" placeholder="Sorulmasını istediğiniz kelimeyi girin.." onclick="bas();">
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 font-bold mb-2 text-4xl">
        Harf Sayısı
      </label>
      <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="kelime_sayi" name="kelime_sayi" type="text" placeholder="Kelimeye ait harf sayısı girin..">
    </div>
    <div class="mb-6">
      <label class="block text-gray-700 font-bold mb-2 text-4xl">
        Kelime Açıklaması
      </label>
      <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="soru" name="soru" type="text" placeholder="Sorulmasını istediğiniz kelimeye ait açıklama girin..">
    </div>
    <div class="flex items-center justify-between">
    <button type="submit" class="focus:outline-none text-white text-md py-3 px-6 rounded-md bg-red-500 hover:bg-red-600 hover:shadow-lg">Kaydet</button><br>
    <button type="button" class="focus:outline-none text-white text-md py-3 px-6 rounded-md bg-red-500 hover:bg-red-600 hover:shadow-lg"><a href="index.php">Oyun Oyna</a></button>
    </div>
  </form> 
  
  <script>
function bas()
{
    window.alert("En az 4 harfli ve en fazla 10 harfli bir kelime girmeniz gerekmektedir.");
}
</script>

</body>
</html>