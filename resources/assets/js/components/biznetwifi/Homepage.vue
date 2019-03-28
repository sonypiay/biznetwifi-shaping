<template lang="html">
<div>
  <div class="uk-cover-container coverbannerhomepage">
    <img :src="url + '/images/banner/Banner1.jpg'" alt="banner_hotspot_1" uk-cover>
    <!--<img :src="url + '/images/banner/plazaindonesia/PI_mobile_2.png'" alt="" uk-cover>-->
    <div class="uk-overlay uk-overlay-primary uk-position-cover banner_ovlay_homepage">
      <div class="uk-position-top-left">
        <div class="uk-card uk-card-body uk-card-small banner_ovlay_content">
          <h1>Biznet Wifi</h1>
          <p>{{ homepagelocale.freewifi.frombiznet }}</p>
          <p v-html="homepagelocale.freewifi.textcontent"></p>
          <!--<a class="uk-button uk-button-default banner_btnovlay">Mulai Sekarang</a>-->
        </div>
      </div>
    </div>
  </div>
  <div class="section-banner-biznethome">
    <div class="uk-grid-collapse uk-grid-match" uk-grid>
      <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s uk-visible@s">
        <div class="uk-tile uk-tile-default">
          <a :href="'https://www.biznethome.net/' + $root.getLocale"><img class="uk-width-4-5 uk-box-shadow-large uk-align-center" :src="url + '/images/banner/Biznet_Home_Web_Banner_620x620px_ID.jpg'" alt="" uk-scrollspy="cls: uk-animation-fade"></a>
        </div>
      </div>
      <div class="uk-width-1-1 uk-hidden@s">
        <div class="uk-tile uk-tile-default">
          <a :href="'https://www.biznethome.net/' + $root.getLocale"><img class="uk-width-4-5 uk-box-shadow-large uk-align-center" :src="url + '/images/banner/Biznet_Home_Web_Banner_620x620px_ID.jpg'" alt="" uk-scrollspy="cls: uk-animation-fade"></a>
        </div>
      </div>
      <div class="uk-width-expand">
        <div class="uk-tile uk-tile-default uk-text-center section-banner-context-right uk-visible@s">
          <div class="uk-position-center">
            <div uk-scrollspy="cls: uk-animation-fade">
              <h1>Biznet Home</h1>
              <p>{{ homepagelocale.product.biznet_home }}</p>
            </div>
          </div>
        </div>
        <div class="uk-tile uk-tile-default uk-text-center section-banner-context-right uk-hidden@s">
          <div uk-scrollspy="cls: uk-animation-fade">
            <h1>Biznet Home</h1>
            <p>{{ homepagelocale.product.biznet_home }}</p>
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
            <div uk-scrollspy="cls: uk-animation-fade;">
              <h1>Biznet Metronet</h1>
              <p>{{ homepagelocale.product.biznet_metronet }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="uk-width-1-2@xl uk-width-1-2@l uk-width-1-2@m uk-width-1-2@s">
        <div class="uk-tile uk-tile-default">
          <a :href="'http://www.biznetnetworks.com/' + $root.getLocale + '/business/internet/biznet-metronet/'"><img class="uk-width-4-5 uk-box-shadow-large uk-align-center" :src="url + '/images/banner/Biznet_Metronet_Web_Banner_620x620px_ID.jpg'" alt="" uk-scrollspy="cls: uk-animation-fade"></a>
        </div>
      </div>
      <div class="uk-width-1-1 uk-hidden@s">
        <div class="uk-tile uk-tile-default uk-text-center section-banner-context-right">
          <div uk-scrollspy="cls: uk-animation-fade">
            <h1>Biznet Metronet</h1>
            <p>{{ homepagelocale.product.biznet_metronet }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-homepage-flashads">
    <div class="uk-card uk-card-body">
      <div class="uk-grid-medium uk-margin-top uk-margin-bottom uk-flex-center" uk-grid>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
          <img class="uk-width-4-5@xl uk-width-4-5@l uk-width-2-3@m uk-width-3-4@s uk-align-center uk-visible@s" :src="url + '/images/logo/FlashAds-Logo.png'" alt="" uk-scrollspy="cls: uk-animation-slide-top">
          <img class="uk-width-1-2 uk-align-center uk-hidden@s" :src="url + '/images/logo/FlashAds-Logo.png'" alt="" uk-scrollspy="cls: uk-animation-slide-top">
        </div>
        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-2@s">
          <div class="uk-visible@s" uk-scrollspy="cls: uk-animation-slide-top">
            <div class="flashads-contactads">{{ homepagelocale.flashads }}</div>
            <a href="https://www.flashads.co.id/">www.flashads.co.id</a>
          </div>
          <div class="uk-hidden@s uk-text-center" uk-scrollspy="cls: uk-animation-slide-top">
            <div class="flashads-contactads">{{ homepagelocale.flashads }}</div>
            <a href="https://www.flashads.co.id/">www.flashads.co.id</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  props: ['url', 'homepagelocale'],
  data() {
    return {}
  },
  methods: {},
  mounted() {}
}
</script>

<style lang="css">
</style>
