<?php require_once "db.php"; ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kelime Oyunu</title>
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <style>
    html,body{
        height: 100%;
        font-family: 'Noto Sans JP', sans-serif;
    }
    button[disabled]{
        opacity: .2;
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
      
       <div id="app" class="h-100">
        <h1 class="text-white text-center text-4xl py-16">KELİME OYUNU</h1>
       <div class="mx-auto h-auto w-10/12 bg-gray-700 p-8 justify-center items-center rounded">
        <div v-if="gameType == 'LOBBY'" class="w-full">
            <div class="flex flex-col">
                <label class="text-white">Adınız</label>
                <input class="mt-2 lg:w-1/4 md:w-1/4 sm:w-full py-2 bg-transparent border-b border-pink-600 focus:outline-none text-white placeholder-gray-400" type="text" placeholder="Adınız" required v-model="name">
            </div>
            <div class="flex flex-col mt-4">
                <label class="text-white">Soyadınız</label>
                <input class="mt-2 lg:w-1/4 md:w-1/4 sm:w-full py-2 bg-transparent border-b border-pink-600 focus:outline-none text-white placeholder-gray-400" type="text" placeholder="Soyadınız" required v-model="surname">
            </div>
            <div class="lg:w-1/4 md:w-1/4 sm:w-full ">
                <button class="mt-12 py-2 w-full text-center bg-pink-600 text-white rounded hover:bg-pink-700" @click="startGame()"> Başla!</button>
            </div>
            <div class="lg:w-1/4 md:w-1/4 sm:w-full ">
                <button class="mt-12 py-2 w-full text-center bg-pink-600 text-white rounded hover:bg-pink-700"><a href="soruyazimi.php">Soru Ekle!</a></button>
            </div>
        </div>
        <div v-if="gameType == 'GAME'" class="w-100 flex flex-col justify-center items-center">
          
                <div >
                    <h4 class="mb-2 text-white text-xl"> Oyun Süresi </h4>
                    <div class="flex space-x-4">
                        <div class="bg-pink-700 py-2 px-4 rounded text-center text-xl text-white">{{ displayMinutes}}</div>
                        <div class="bg-pink-700 py-2 px-4 rounded text-center text-xl text-white">{{ displaySeconds}}</div>
                    </div>
                </div>
                <div class="my-4">
                    <h4 class="text-white text-xl mb-2">Cevap verme süreniz:</h4>
                    <div class="bg-pink-700 py-2 px-4 rounded text-center text-xl text-white">{{ replyTime}}</div>
                </div>
                <div class="text-white my-4">{{ data[currentQuestion].soru}}</div>
                <div class="mt-6 space-x-4  input-div">
                    <input @blur="notFocus()" @focus="focusInput($event)"  @keyup="changeInput($event)" class="kelime_input bg-transparent rounded border border-pink-700 p-2 w-10  text-center text-white focus:outline-none" v-for="v in parseInt(data[currentQuestion].kelime_sayi)" maxlength="1" name="tahmin[]" type="text">
                </div>          
                <div id="button-div" class="mt-12 w-full flex justify-center lg:space-x-4 md:space-x-4">
                    <button ref="tahmin_btn" class="py-2 w-1/4 text-center bg-pink-600 text-white rounded hover:bg-pink-700 focus:outline-none"  @click="tahmin()" >Tahmin</button>
                    <button class=" py-2 w-1/4 text-center bg-pink-600 text-white rounded hover:bg-pink-700 focus:outline-none" @click="randomHarf()" :disabled="isRandomHarf">Random Harf</button>
                </div>
        </div>
            <div v-if="gameType == 'GAMEOVER'" class="flex flex-col items-center justify-center">
                <h1 class="text-4xl text-white mb-4">Oyun Bitti !</h1>
                <h4 class="text-white mb-4">{{name}}  {{surname}}</h4>
                <p class="text-white"><strong>Puanınız: </strong> {{ point }}</p>
                <p class="text-white"><strong>Doğru Sayınız: </strong> {{ correctAnswerCount }}</p>
                <p class="text-white "><strong>Yanlış Sayınız: </strong> {{ wrongAnswerCount }}</p>
                <div class="text-white text-lg">{{ finishedDate }} </div>
                <button @click="resetGame()" class="py-2 w-1/4 text-center bg-pink-600 text-white rounded hover:bg-pink-700 focus:outline-none mt-8">Tekrar Oyna</button>
            </div>
        </div>
       </div>
       <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/tr.min.js" integrity="sha512-4h/paApp7jGj1wjt7xHsUYfnRGH38LE2DzQWIsflmkTFJdiGBakOBjucqVyjkcrnOsqJ6ow41sJnLVAuXAnpdw==" crossorigin="anonymous"></script>
       <script src="vue.js"> </script>
    </body>
</html>