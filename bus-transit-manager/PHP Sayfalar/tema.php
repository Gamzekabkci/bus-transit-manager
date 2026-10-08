<?php 
function head_ustkisim($title) {
    echo '
    <!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style2.css">
  <title>Ulaşım Paneli</title>
</head>
<body>';
}

function navbar() {
    echo'
     <div class="navbar">
    <div class="dropdown">
      <a href="anasayfa.php"><button class="dropdown-btn">🏠 Anasayfa</button></a>
    </div>

    <div class="dropdown">
      <button class="dropdown-btn">🚌 Araçlar ▾</button>
      <div class="dropdown-content">
        <a href="araçekle.php">Araç Ekle</a>
        <a href="araçlistesi.php">Araç Listesi</a>
        <a href="araçlistele.php">Araç Listele</a>
        <a href="araçsil.php">Araç Kaldır</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropdown-btn">👨‍✈️ Şoförler ▾</button>
      <div class="dropdown-content">
        <a href="şoförekle.php">Şoför Ekle</a>
        <a href="şoförlistesi.php">Şoför Listesi</a>
        <a href="şoförlistele.php">Şoför Listele</a>
        <a href="şoförsil.php">Şoför Sil</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropdown-btn">🗺️ Güzergahlar ▾</button>
      <div class="dropdown-content">
        <a href="guzergah-ekle.php">Güzergah Ekle</a>
        <a href="güzergahsil.php">Güzergah Sil</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropdown-btn">📅 Seferler ▾</button>
      <div class="dropdown-content">
        <a href="seferekle.php">Sefer Ekle</a>
        <a href="sefersil.php">Sefer Sil</a>
        <a href="sefertakvimi.php">Sefer Takvimi</a>
      </div>
    </div>

    <div class="dropdown">
      <a href="sefer-yolcu-listesi.php"><button class="dropdown-btn">🧑 Yolcu Bilgileri </button></a>
    </div>

    <div class="dropdown">
      <button class="dropdown-btn">📊 Raporlar ▾</button>
      <div class="dropdown-content">
        <a href="#">Yolcu Raporu</a>
        <a href="#">Gelir Raporu</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropdown-btn">⚙️ Ayarlar ▾</button>
      <div class="dropdown-content">
        <a href="#">Kullanıcı Ayarları</a>
        <a href="#">Sistem Ayarları</a>
      </div>
    </div>

    <div class="dropdown">
      <button class="dropdown-btn" onclick="openLogout()">🔒 Çıkış</button>
    </div>
  </div>
  
  <div id="logout-modal">
    <div class="logout-box">
      <h3>Çıkış yapmak istediğinize emin misiniz?</h3>
      <button onclick="confirmLogout()">Evet, Çıkış Yap</button>
      <button onclick="closeLogout()">İptal</button>
    </div>
  </div>';
}
function yaklaşanseferler() {
  echo '
  <div class="main-content">
    

    <div class="dashboard">
      <h3>Yaklaşan Seferler</h3>
      <table>
        <thead>
          <tr>
            <th>Sefer No</th>
            <th>Plaka</th>
            <th>Şoför</th>
            <th>Güzergah Adı</th>
            <th>Sefer Tarihi</th>
            <th>Kalkış Saati</th>
             <th>Duraklar</th>
          </tr>
        </thead>
         <tbody>
          <tr>
            <td>1</td>
            <td>34ABC123</td>
            <td>Ahmet Yılmaz</td>
            <td>Merkez - Organize Sanayi</td>
            <td>2025-05-24</td>
            <td>08:00</td>
            <td>
              <ol>
                <li>Durak  - Varış: 08:10  -  Kalkış: 08:15</li>
                <li>Durak  - Varış: 08:25  -  Kalkış: 08:30</li>
                <li>Durak  - Varış: 08:45  -  Kalkış: 08:50</li>
              </ol>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div> ';
}
    
function araçekle(){
    echo'
    <div class="content">
    <div id="arac-ekle" class="form-section">
      <h3>Araç Ekle</h3>
      <form method="post" action="/arac-ekle">
        <input type="text" name="plaka" placeholder="Plaka Numarası" required>
        <input type="text" name="marka" placeholder="Marka / Model " required>
        <input type="text" name="modelyılı" placeholder="Model Yılı" required>
        <input type="text" name="araçtürü" placeholder="Araç Türü" required>
        <input type="number" name="kapasite" placeholder="Kapasite" required>
        <a href= "araçlistesi.php"><button type="submit">Araç Ekle</button></a>
      </form>
    </div>';
    
}

function araçlistele() {
    echo'
     <div class="form-section">
    <h3>Araç Listeleme Kriterleri</h3>
    <form method="get" action="araçlistesi.php">
      <label for="marka">Marka:</label>
      <select name="marka" id="marka">
        <option value="">Tüm Markalar</option>
        <option value="Mercedes">Mercedes</option>
        <option value="MAN">MAN</option>
        <option value="Temsa">Temsa</option>
      </select>

      <label for="kapasite">Kapasite:</label>
      <select name="kapasite" id="kapasite">
        <option value="">Tüm Kapasiteler</option>
        <option value="10">10+</option>
        <option value="20">20+</option>
        <option value="30">30+</option>
      </select>
      <label for="aracTuru">Araç Türü:</label>
      <input name="aracTuru" id="araçTürü" placeholder="otobüs, minibüs, servis vb.">
      <label for="modelYili">Model Yılı:</label>
      <input type="number" name="modelYili" id="modelYili" placeholder="örn: 2020">

      <a href="araçlistesi.php"><button type="submit">Araçları Listele</button></a>
      <a href="araçlistesi.php"><button type="submit">Tüm Araçları Listele</button></a>
    </form>
  </div> ';
}

function araçsil() {
    echo'
    <div id="arac-kaldir" class="form-section">
      <h3>Araç Kaldır</h3>
      <form method="post" action="/arac-kaldir">
        <input type="text" name="plaka" placeholder="Plaka Numarası" required>
        <button type="submit">Araç Kaldır</button>
      </form>
    </div>';
}

function araçlistesi() {
  echo'
  <div class="main-content">
    

    <div class="dashboard">
      <h3>🚌 Araçlar</h3>
      <table>
        <thead>
          <tr>
            <th>Plaka Numarası</th>
            <th>Marka / Model</th>
            <th>Model Yılı</th>
            <th>Araç Türü</th>
            <th>Kapasite</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>34 BHK 789</td>
            <td>Mercedes</td>
            <td>2010</td>
            <td>Otobüs</td>
            <td>30</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> ';
}

function seferekle() {
    echo'
    <div class="form-section">
    <h3>Sefer Ekle</h3>
    <form method="get" action="/sefer-ekle">

        <label>Güzergah Adı:</label>
        <input type="text" name="GuzzergahAdi" placeholder="İstanbul-Ankara" required>

        <label for="Şoför">Şoför:</label>
        <select name="şoför" id="şoför id">
          <option value="">Ahmet Yılmaz</option>
          <option value="">Gamze Kabakcı</option>
          <option value="">Mehmet Yıldız</option>
          <option value="">Ayşe Aslan</option>
        </select>

        <label for="Araç">Araç:</label>
        <input type="text" name="plaka" placeholder="Plaka Numarası" required>

        <label for="sefer-tarihi">Tarih:</label>
        <input type="date" id="date" name="date" required>

        <label for="sefer-saati">Kalkış Saati:</label>
        <input type="text" name="saat" placeholder="00:00" required>

        <label for="sefer-saati">Varış Saati:</label>
        <input type="text" name="saat" placeholder="00:00" required>
        
      <button type="submit">Sefer Ekle</button>
    </form>
  </div> ';
}

function sefersil() {
    echo'
     <div class="form-section">
    <h3>Sefer Sil</h3>
    <form method="post" action="/sefer-kaldir">
        <input type="text" name="sefer id" placeholder="Sefer No" required>
        <button type="submit">Sefer Sil</button>
      </form>
    </form>
  </div> ';
}

function sefertakvimi () {
    echo'
     <div class="main-content">
    

    <div class="dashboard">
      <h3>📅 Sefer Takvimi</h3>
      <table>
        <thead>
          <tr>
            <th>Sefer No</th>
            <th>Plaka</th>
            <th>Şoför</th>
            <th>Güzergah Adı</th>
            <th>Sefer Tarihi</th>
            <th>Kalkış Saati</th>
             <th>Duraklar</th>
          </tr>
        </thead>
         <tbody>
          <tr>
            <td>1</td>
            <td>34ABC123</td>
            <td>Ahmet Yılmaz</td>
            <td>Merkez - Organize Sanayi</td>
            <td>2025-05-24</td>
            <td>08:00</td>
            <td>
              <ol>
                <li>Durak  - Varış: 08:10  -  Kalkış: 08:15</li>
                <li>Durak  - Varış: 08:25  -  Kalkış: 08:30</li>
                <li>Durak  - Varış: 08:45  -  Kalkış: 08:50</li>
              </ol>
            </td>
          </tr>

        </tbody>
      </table>
    </div>
  </div> ';
}

function şoförekle() {
    echo'
     <div class="content">
    <div id="şöför-ekle" class="form-section">
      <h3>Şoför Ekle</h3>
      <form method="post" action="/şöför-ekle">
       <input type="text" id="tc" name="tc" placeholder="TC" pattern="[0-9]{11}" maxlength="11" required>
        <input type="text" name="isim" placeholder="İsim" required>
        <input type="text" name="soyisim" placeholder="Soyisim" required>
        <label for="giriş-tarihi">İşe Giriş Tarihi:</label>
        <input type="date" id="date" name="date" required>
        <label for="ehliyet">Ehliyet Tipi:</label>
        <select id="ehliyet" name="ehliyet">
          <option value="">Seçiniz</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
          <option value="F">F</option>
        </select>
        <input type="tel" id="telefon" name="telefon" placeholder="05XXXXXXXXX" pattern="05[0-9]{9}" required>
        <a href="şoförlistesi.php"><button type="submit">Şoför Ekle</button></a>
      </form>
    </div> ';
}

function şoförlistele(){
    echo'
     <div class="form-section">
    <h3>Şoför Listeleme Kriterleri</h3>
    <form method="get" action="/şoför-listesi">
      <input type="text" id="tc" name="TCKimlikNo" placeholder="TC" pattern="[0-9]{11}" maxlength="11" required>
      <input type="text" name="isim" placeholder="İsim" required>
      <input type="text" name="soyisim" placeholder="Soyisim" required>
      <label for="giriş-tarihi">İşe Giriş Tarihi:</label>
      <input type="date" id="date" name="date" required>
      <label for="ehliyet">Ehliyet Tipi:</label>
        <select id="ehliyet" name="ehliyet">
          <option value="">Seçiniz</option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
          <option value="E">E</option>
          <option value="F">F</option>
        </select>
      <input type="tel" id="telefon" name="telefon" placeholder="05XXXXXXXXX" pattern="05[0-9]{9}" required>

      <a href="şoförlistesi.php"><button type="submit">Şoförleri Listele</button></a>
      
    </form>
    <a href="şoförlistesi.php"><button type="submit">Tüm Şoförleri Listele</button></a>
  </div> ';
}

function şoförsil() {
    echo'
     <div id="şoför-sil" class="form-section">
    <h3>Şoför Sil</h3>
    <form method="post" action="/şoför-sil">
    <input type="text" id="tc" name="tc" placeholder="TC" pattern="[0-9]{11}" maxlength="11" required>
    <button type="submit">Şoför Sil</button>
    </form>
  </div> ';
}


function şoförlistesi() {
  echo'
  <div class="main-content">
    

    <div class="dashboard">
      <h3>👨‍✈️ Şoförler</h3>
      <table>
        <thead>
          <tr>
            <th>TC</th>
            <th>İsim</th>
            <th>Soyisim</th>
            <th>İşe Giriş Tarihi</th>
             <th>Ehliyet Tipi</th>
            <th>Telefon No</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>74185296336</td>
            <td>Ahmet</td>
            <td>Yıldız</td>
            <td>07.05.2023</td>
            <td>A</td>
            <td>05465773454</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> ';
}


function güzergahekle() {
    echo'
    <div class="form-section">
    <h2>Güzergah Ekle</h2>
    <form id="guzergahForm">
      <label>Güzergah Adı:</label>
      <input type="text" id="guzergahAdi" required>

      <label>Başlangıç Noktası:</label>
      <input type="text" id="baslangic" required>

      <label>Bitiş Noktası:</label>
      <input type="text" id="bitis" required>

      <label>Mesafe:</label>
      <input type="text" id="MesafeKm" required>

       <label>Tahmini Süre:</label>
      <input type="text" id="Süre" required>

      <label>Duraklar:</label>
      <input type="text" id="durakInput" placeholder="Durak adı yaz ve ekle">
      <button type="button" onclick="durakEkle()">Durak Ekle</button>

      <div class="durak-listesi" id="durakListesi"></div>

      <button type="submit">Kaydet</button>
    </form>
  </div>

  <script>
    const duraklar = [];

    function durakEkle() {
      const durakInput = document.getElementById("durakInput");
      const durakAdi = durakInput.value.trim();
      if (durakAdi !== "") {
        duraklar.push(durakAdi);
        guncelleDurakListesi();
        durakInput.value = "";
      }
    }

    function guncelleDurakListesi() {
      const liste = document.getElementById("durakListesi");
      liste.innerHTML = "";
      duraklar.forEach((durak, index) => {
        const item = document.createElement("div");
        item.className = "durak-item";
        item.innerHTML = `<span>${durak}</span> <button onclick="durakSil(${index})">Sil</button>`;
        liste.appendChild(item);
      });
    }

    function durakSil(index) {
      duraklar.splice(index, 1);
      guncelleDurakListesi();
    }
   </script> ';
}

function güzergahsil() {
    echo'
    <div class="main-content">
    

    <div class="dashboard">
      <table>
        <thead>
          <tr>
            <th>Güzergah ID</th>
            <th>Adı</th>
            <th>Başlangıç</th>
            <th>Bitiş</th>
            <th>İşlem</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>56789</td>
            <td>Ankara-İstanbul</td>
            <td>Ankara</td>
            <td>İstanbul</td>
            <td><a href="#">Sil</a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div> ';
}

function yolculistesi() {
  echo'
   <div class="main-content" style="margin-left: 20px;">
     <h2> Yolcu Bilgileri</h2>

  <label>Sefer ID: </label>
  <input type="" id="seferId" >
  <button onclick="bilgileriGetir()">Göster</button>

  <div class="bos" id="bosKoltuk"></div>

  <table id="yolcuTablo">
    <thead>
      <tr>
        <th>TC</th>
        <th>Ad</th>
        <th>Soyad</th>
        <th>Cinsiyet</th>
        <th>Güzergah</th>
        <th>Koltuk No</th>
        <th>E-posta adresi</th>
        <th>Telefon No</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  </div> 
  <script>
    async function bilgileriGetir() {
      const seferId = document.getElementById("seferId").value;
      if (!seferId) return alert("Lütfen bir Sefer ID girin");

      // 1. Yolcu listesi
      const yolcuRes = await fetch(`/api/sefer/${seferId}/yolcular`);
      const yolcular = await yolcuRes.json();

      const tbody = document.querySelector("#yolcuTablo tbody");
      tbody.innerHTML = "";
      yolcular.forEach(y => {
        const satir = `<tr>
          <td>${y.ad}</td>
          <td>${y.soyad}</td>
          <td>${y.koltukNo}</td>
        </tr>`;
        tbody.innerHTML += satir;
      });

      // 2. Boş koltuk sayısı
      const bosRes = await fetch(`/api/sefer/${seferId}/boskoltuk`);
      const { bosKoltuk } = await bosRes.json();
      document.getElementById("bosKoltuk").textContent = `Boş Koltuk Sayısı: ${bosKoltuk}`;
    }
  </script> ';
}
    ?>