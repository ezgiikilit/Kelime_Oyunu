var app = new Vue({
  el: "#app",
  data() {
    return {
      // BURASI VUE DA DEĞİŞKENLERİN TANIMLADIĞI KISIM
      name: "", 
      surname: "", 
      gameType: "LOBBY", // OYUNUN HANGİ EVREDE OLDUĞU KISMI. LOBBY = İSİM SOYİSİM ALMA, GAME = OYUN BAŞLADIĞI AN, GAMEOVER: OYUN BİTİŞ EKRANI
      displayMinutes: 0, 
      displaySeconds: 0, 
      interval: null, 
      wrongAnswerCount: 0,
      correctAnswerCount: 0, 
      data: [], 
      currentQuestion: 0, 
      currentKelime: [], 
      point: 0,
      gameTimeMin: 3, 
      gameTimeSec: 59,
      replyTime: 20, 
      replyTimeInterval: null,
      wordScore: 100, 
      isRandomHarf: false, 
      finishedDate: null,
    };
  },
  watch: {
    // SORUNUN DEĞİŞTİĞİNİ ALGILAMA
    currentQuestion(val) {
      this.currentKelime = this.data[val].kelime.split("");
    },
  },
  methods: {
    startGame() {
      // OYUN BAŞLANGIÇ FONKSİYONU
      if (this.name !== "" && this.surname !== "") {
        this.gameType = "GAME";
        this.startTimer();
      } else {
        alert("İsim soyisim giriniz");
      }
    },
    startTimer() {
      // OYUN SÜRESİNİN GERİ SAYIM FONKSİYONU
      this.interval = setInterval(() => {
        if (this.gameTimeSec > 0) {
          this.gameTimeSec--;
          if (this.gameTimeSec == 0) {
            this.gameTimeSec = 59;
            if (this.gameTimeMin > 0) {
              this.gameTimeMin--;
              if (this.gameTimeMin == 0) {
                // OYUN SÜRESİ BİTTİYSE TARİHİ ALIR VE OYUN SONU EKRANINA YÖNLENDİRİR
                clearInterval(this.interval);
                this.gameTimeSec = 0;
                this.gameTimeMin = 0;
                this.wrongAnswerCount +=
                  this.data.length - this.currentQuestion;
                this.gameType = "GAMEOVER";
                this.finishedDate = moment().format("d MMMM YYYY H:m:ss");
              }
            }
          }
        }
        this.displayMinutes =
          this.gameTimeMin < 10 ? "0" + this.gameTimeMin : this.gameTimeMin;
        this.displaySeconds =
          this.gameTimeSec < 10 ? "0" + this.gameTimeSec : this.gameTimeSec;
      }, 1000);
    },
    focusInput() {
      // CEVAP YAZMAYA TIKLANDIYSA SÜREYİ DURDURUR
      if (this.gameType == "GAME") {
        clearInterval(this.interval);
        this.replyTimeInterval = setInterval(() => {
          this.replyTime--;
          if (this.replyTime == 0) {
            this.tahmin();
          }
        }, 1000);
      }
    },
    notFocus() {
      // CEVAP YAZDIYSA YA DA İNPUTTAN ÇIKTIYSA
      if (this.gameType == "GAME") {
        this.startTimer();
      }
      clearInterval(this.replyTimeInterval);
    },
    changeInput(event) {
      // İNPUTA HER KARAKTER GİRDİĞİNDE ÇALIŞAN FONKSİYON
      let kelime = "";
      var inp = document.querySelectorAll("input");
      inp.forEach((item) => {
        kelime += item.value;
      });
      console.log(inp);
      if (event.target.value.length > 1) return;
      if (event.target.value.length == 1) {
        if (event.target.nextSibling) {
          event.target.nextSibling.focus();
        }

        this.isRandomHarf = true;
      }
      if (event.keyCode === 8 || event.keyCode === 46) {
        if (event.target.previousSibling) {
          event.target.previousSibling.focus();
          event.target.value = "";
          event.target.previousSibling.value = "";
        }
      }
    },
    tahmin() {
      // TAHMİN BUTONUNA BASTIĞINDA ÇALIŞAN FONKSİYON
      var input = document.querySelectorAll("input");
      this.isRandomHarf = false;
      if (this.currentQuestion <= this.data.length - 1) {
        this.replyTime = 20;
        let kelime = "";
        let dogruKelime = this.data[this.currentQuestion].kelime;
        input.forEach((item) => {
          kelime += item.value;
        });
        if (kelime && kelime.length === dogruKelime.length) {
          if (dogruKelime.toLocaleLowerCase() == kelime.toLocaleLowerCase()) {
            this.point += this.currentKelime.length * this.wordScore;
            this.correctAnswerCount++;
            console.log("DOĞRU", this.point);
          } else {
            this.wrongAnswerCount++;
            this.point += 0;
          }
        } else {
          this.wrongAnswerCount++;
        }
      } else {
        this.gameType = "GAMEOVER";
        this.finishedDate = moment().format("d MMMM YYYY H:m:ss");
        clearInterval(this.interval);
        clearInterval(this.replyTimeInterval);
      }
      input.forEach((item2) => {
        item2.value = "";
      });
      input.forEach((item2) => {
        item2.classList.add("kelime_input");
      });
      this.currentQuestion++;
      if (this.currentQuestion > this.data.length - 1) {
        this.finishedDate = moment().format("d MMMM YYYY H:m:ss");
        this.gameType = "GAMEOVER";
      }
    },
    async randomHarf() {
      // RANDOM HARF İSTEDİĞİNDE ÇALIŞAN FONKSİYON
      let random = Math.floor(Math.random() * this.currentKelime.length);
      let input = document.querySelectorAll(".kelime_input")[random];
      if (input && input.value == "") {
        input.value = this.currentKelime[random];
        input.classList.remove("kelime_input");
      }
      this.currentKelime.splice(random, 1);
    },
    async fetchData() {
      // SORULARI ÇEKEN FONKSİYON
      await fetch("sorular.php")
        .then((res) => {
          return res.json();
        })
        .then((res) => {
          this.data = res;
        });
    },
    resetGame() {
      // OYUNU RESETLEYEN FONKSİOYN
      this.gameType = "LOBBY";
      this.name = "";
      this.surname = "";
      this.finishedDate = null;
      this.wrongAnswerCount = 0;
      this.correctAnswerCount = 0;
      this.isLoading = false;
      this.currentQuestion = 0;
      this.point = 0;
      this.gameTimeMin = 3;
      this.gameTimeSec = 59;
      this.replyTime = 20;
      this.isRandomHarf = false;
      this.currentKelime = this.data[0].kelime.split("");
      clearInterval(this.interval);
      clearInterval(this.replyTimeInterval);
    },
  },
  async mounted() {
    // SAYFA AÇILMADAN ÇALIŞACAK KODLAR
    await this.fetchData(); // SAYFA AÇILMADAN SORULARI GETİREN FONKSİYON
    this.currentKelime = this.data[0].kelime.split(""); // İLK SORUNUN CEVABININ HARFLERİ
    console.log(this.currentKelime);
  },
  destroyed() {
    // SAYFA DEĞİŞTİĞİNDE ÇALIŞAN FONKSİYON
    clearInterval(this.interval); // SÜREYİ DURDUR
  },
});
