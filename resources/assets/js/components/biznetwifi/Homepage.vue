<template lang="html">
<div>
  <div class="uk-cover-container coverbannerhomepage">
    <img :src="url + '/images/banner/Banner2.jpg'" alt="banner_hotspot_1" uk-cover>
    <!--<img :src="url + '/images/banner/plazaindonesia/PI_mobile_2.png'" alt="" uk-cover>-->
    <div class="uk-overlay uk-overlay-primary uk-position-cover banner_ovlay_homepage">
      <div class="uk-position-top-left">
        <div class="uk-card uk-card-body uk-card-small banner_ovlay_content">
          <h1>Biznet Wifi</h1>
          <p>Wi-Fi Gratis dari Biznet</p>
          <p>Cara mudah mendapatkan banyak hal baru melalui akses internet terbaik.
            <br />Mulai sekarang untuk segera terkoneksi.
          </p>
          <!--<a class="uk-button uk-button-default banner_btnovlay">Mulai Sekarang</a>-->
        </div>
      </div>
    </div>
  </div>
  <div class="section-banner-biznethome">
    <div class="uk-grid-collapse uk-grid-match" uk-grid>
      <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s uk-visible@s">
        <div class="uk-tile uk-tile-default">
          <img class="uk-width-4-5 uk-box-shadow-large uk-align-center" src="https://www.biznetwifi.com/img/main/Biznet_Home_Web_Banner_620x620px_Aug2018-IND.jpg" alt="" uk-scrollspy="cls: uk-animation-fade; delay: 500">
        </div>
      </div>
      <div class="uk-width-1-1 uk-hidden@s">
        <div class="uk-tile uk-tile-default">
          <img class="uk-width-4-5 uk-box-shadow-large uk-align-center" src="https://www.biznetwifi.com/img/main/Biznet_Home_Web_Banner_620x620px_Aug2018-IND.jpg" alt="" uk-scrollspy="cls: uk-animation-fade; delay: 500">
        </div>
      </div>
      <div class="uk-width-expand">
        <div class="uk-tile uk-tile-default uk-text-center section-banner-context-right uk-visible@s">
          <div class="uk-position-center">
            <div uk-scrollspy="cls: uk-animation-fade; delay: 1000">
              <h1>Biznet Home</h1>
              <p>
                Biznet Home Internet merupakan layanan Internet Ultra Cepat untuk rumah dan apartemen dengan kecepatan koneksi hingga 100 Mbps baik untuk download maupun upload.
              </p>
            </div>
          </div>
        </div>
        <div class="uk-tile uk-tile-default uk-text-center section-banner-context-right uk-hidden@s">
          <div uk-scrollspy="cls: uk-animation-fade; delay: 1000">
            <h1>Biznet Home</h1>
            <p>
              Biznet Home Internet merupakan layanan Internet Ultra Cepat untuk rumah dan apartemen dengan kecepatan koneksi hingga 100 Mbps baik untuk download maupun upload.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-banner-biznetmetronet">
    <div class="uk-grid-collapse uk-grid-match" uk-grid>
      <div class="uk-width-expand uk-visible@s">
        <div class="uk-tile uk-tile-default uk-text-center section-banner-context-right">
          <div class="uk-position-center">
            <div uk-scrollspy="cls: uk-animation-fade; delay: 500">
              <h1>Biznet Metronet</h1>
              <p>
                 Biznet Metronet merupakan layanan Broadband Internet Super Cepat khusus untuk keperluan bisnis UKM. Dengan pilihan layanan dari 50 hingga 750 Mbps dan menggunakan jaringan Biznet Fiber, memastikan bisnis Anda akan selalu berjalan dengan lancar.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s">
        <div class="uk-tile uk-tile-default">
          <img class="uk-width-4-5 uk-box-shadow-large uk-align-center" :src="url + '/images/banner/Biznet_Metronet_Web_Banner_620x620px_Dec2017_IND.jpg'" alt="" uk-scrollspy="cls: uk-animation-fade; delay: 1000">
        </div>
      </div>
      <div class="uk-width-1-1 uk-hidden@s">
        <div class="uk-tile uk-tile-default uk-text-center section-banner-context-right">
          <div uk-scrollspy="cls: uk-animation-fade; delay: 500">
            <h1>Biznet Metronet</h1>
            <p>
               Biznet Metronet merupakan layanan Broadband Internet Super Cepat khusus untuk keperluan bisnis UKM. Dengan pilihan layanan dari 50 hingga 750 Mbps dan menggunakan jaringan Biznet Fiber, memastikan bisnis Anda akan selalu berjalan dengan lancar.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-homepage-flashads">
    <div class="uk-card uk-card-body">
      <div class="uk-grid-medium uk-margin-top uk-margin-bottom uk-flex-center" uk-grid>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
          <img class="uk-width-4-5@xl uk-width-4-5@l uk-width-2-3@m uk-width-3-4@s uk-align-center uk-visible@s" :src="url + '/images/logo/FlashAds-Logo.png'" alt="">
          <img class="uk-width-1-2 uk-align-center uk-hidden@s" :src="url + '/images/logo/FlashAds-Logo.png'" alt="">
        </div>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
          <div class="uk-visible@s">
            <div class="flashads-contactads">Hubungi kami untuk beriklan di Biznet Wifi</div>
            <a href="https://www.flashads.co.id/">www.flashads.co.id</a>
          </div>
          <div class="uk-hidden@s uk-text-center">
            <div class="flashads-contactads">Hubungi kami untuk beriklan di Biznet Wifi</div>
            <a href="https://www.flashads.co.id/">www.flashads.co.id</a>
          </div>
        </div>
      </div>
    </div>
  </div>
   <!--<div class="uk-position-relative uk-visible-toggle" uk-slideshow="animation: push; autoplay: true; max-height: 500">
     <ul class="uk-slideshow-items">
       <li>
          <img :src="url + '/images/banner/Banner1.jpg'" alt="banner_hotspot_1" uk-cover>
          <div class="uk-overlay uk-overlay-primary uk-position-cover banner_ovlay_homepage">
            <div class="uk-position-top-left">
              <div class="banner_ovlay_content">
                <h1>Biznet Wifi</h1>
                <p>Wi-Fi Gratis dari Biznet</p>
                <p>Cara mudah mendapatkan banyak hal baru melalui akses internet terbaik.
                  <br />Mulai sekarang untuk segera terkoneksi.
                </p>
                <a class="uk-button uk-button-default banner_btnovlay">Mulai Sekarang</a>
              </div>
            </div>
          </div>
       </li>
       <li>
          <img :src="url + '/images/banner/Banner2.jpg'" alt="banner_hotspot_2" uk-cover>
          <div class="uk-overlay uk-overlay-primary uk-position-cover banner_ovlay_homepage">
            <div class="uk-position-top-left">
              <div class="banner_ovlay_content">
                <h1>Biznet Wifi</h1>
                <p>Wi-Fi Gratis dari Biznet</p>
                <p>Cara mudah mendapatkan banyak hal baru melalui akses internet terbaik.
                  <br />Mulai sekarang untuk segera terkoneksi.
                </p>
                <a class="uk-button uk-button-default banner_btnovlay">Mulai Sekarang</a>
              </div>
            </div>
          </div>
       </li>
       <li>
          <img :src="url + '/images/banner/Banner3.jpg'" alt="banner_hotspot_3" uk-cover>
          <div class="uk-overlay uk-overlay-primary uk-position-cover banner_ovlay_homepage">
            <div class="uk-position-top-left">
              <div class="banner_ovlay_content">
                <h1>Biznet Wifi</h1>
                <p>Wi-Fi Gratis dari Biznet</p>
                <p>Cara mudah mendapatkan banyak hal baru melalui akses internet terbaik.
                  <br />Mulai sekarang untuk segera terkoneksi.
                </p>
                <a class="uk-button uk-button-default banner_btnovlay">Mulai Sekarang</a>
              </div>
            </div>
          </div>
       </li>
     </ul>
     <div class="uk-light">
       <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
       <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
     </div>
   </div>-->
</div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {}
  },
  methods: {},
  mounted() {}
}
</script>

<style lang="css">
</style>
