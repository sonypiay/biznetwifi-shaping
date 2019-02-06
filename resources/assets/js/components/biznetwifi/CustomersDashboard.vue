<template lang="html">
<div>
  <!-- desktop -->
  <section class="uk-cover-container uk-visible@s banner-hmpg-customer">
    <img :src="url + '/images/banner/banner3.jpg'" alt="banner 3" uk-cover>
    <div class="uk-overlay uk-position-cover uk-light banner-hmpg-overlay">
      <div class="uk-container">
        <div class="uk-position-center">
          <div class="uk-text-center banner-icon-customer">
            <span class="fas fa-user-circle"></span>
          </div>
          <div class="uk-text-center welcome-customer-name">Hi, {{ datauser.displayname }}</div>
          <div v-show="datauser.customer_id">
            <div class="uk-text-center desktop-customer-id">12266000</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="uk-visible@s container">
    <div class="uk-card uk-card-default uk-card-body container-box">
      <div class="container-devices">
        <div class="uk-margin-bottom container-heading">Perangkat Saya</div>
        <div v-if="errors">
          <div class="uk-alert-error" uk-alert>
            {{ errors }}
            <a class="uk-alert-close" uk-close></a>
          </div>
        </div>
        <div v-if="devices.total === 0">
          <div class="uk-alert-warning" uk-alert>
            Tidak ada perangkat yang terdaftar
          </div>
        </div>
        <div class="uk-grid-medium uk-flex-center" uk-grid>
          <div v-for="device in devices.results" class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-2@m uk-width-1-2@s card-devices">
            <div v-if="device.device_agent === 'ANDROID'" class="uk-tile uk-tile-default uk-box-shadow-medium card-device-box card-android">
              <div class="card-icon-device">
                <span class="android"><i class="fab fa-android"></i></span>
              </div>
              <div class="card-identity-mac">{{ device.mac_address }}</div>
              <div class="card-device-info">
                <div class="device-info-lead">Perangkat terdaftar</div>
                <div class="device-last-login">
                  {{ dateConverted(device.logindate) }}
                </div>
              </div>
              <button @click="deleteDevice(device.account_id, device.mac_address)" class="uk-width-1-1 uk-button uk-button-default btn-delete-device delete-android">Hapus</button>
            </div>
            <div v-else-if="device.device_agent === 'iOS'" class="uk-tile uk-tile-default uk-box-shadow-medium card-device-box card-ios">
              <div class="card-icon-device">
                <span class="ios"><i class="fab fa-apple"></i></span>
              </div>
              <div class="card-identity-mac">{{ device.mac_address }}</div>
              <div class="card-device-info">
                <div class="device-info-lead">Perangkat terdaftar</div>
                <div class="device-last-login">
                  {{ dateConverted(device.logindate) }}
                </div>
              </div>
              <button @click="deleteDevice(device.account_id, device.mac_address)" class="uk-width-1-1 uk-button uk-button-default btn-delete-device delete-ios">Hapus</button>
            </div>
            <div v-else class="uk-tile uk-tile-default uk-box-shadow-medium card-device-box card-laptop">
              <div class="card-icon-device">
                <span class="laptop"><i class="fas fa-laptop"></i></span>
              </div>
              <div class="card-identity-mac">{{ device.mac_address }}</div>
              <div class="card-device-info">
                <div class="device-info-lead">Perangkat terdaftar</div>
                <div class="device-last-login">
                  {{ dateConverted(device.logindate) }}
                </div>
              </div>
              <button @click="deleteDevice(device.account_id, device.mac_address)" class="uk-width-1-1 uk-button uk-button-default btn-delete-device delete-laptop">Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- desktop -->

  <!-- mobile -->
  <section class="uk-card uk-card-default uk-card-body uk-hidden@s banner-hmpg-customer">
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-1-1">
        <div class="uk-text-center banner-icon-customer">
          <span class="fas fa-user-circle"></span>
        </div>
      </div>
      <div class="uk-width-1-1-">
        <div class="uk-text-center welcome-customer-name">Hi, {{ datauser.displayname }}</div>
        <div v-show="datauser.customer_id">
          <div class="uk-text-center mobile-customer-id">12266000</div>
        </div>
      </div>
    </div>
  </section>

  <div class="uk-card uk-card-body uk-card-small container-listdevice uk-hidden@s">
    <div class="heading-listdevice">Perangkat Saya</div>
    <div v-if="errors">
      <div class="uk-alert-warning" uk-alert>
        {{ errors }}
        <a class="uk-alert-close" uk-close></a>
      </div>
    </div>
    <div class="uk-grid-medium" uk-grid>
      <div v-for="device in devices.results" class="uk-width-1-1">
        <div class="uk-card uk-card-default uk-box-shadow-large card-listdevice">
          <div class="uk-tile uk-tile-default tile-icon-device">
            <div v-if="device.device_agent === 'iOS'">
              <div class="uk-text-center icon-device ios"><i class="fab fa-apple"></i></div>
            </div>
            <div v-else-if="device.device_agent === 'ANDROID'">
              <div class="uk-text-center icon-device android"><i class="fab fa-android"></i></div>
            </div>
            <div v-else>
              <div class="uk-text-center icon-device laptop"><i class="fas fa-laptop"></i></div>
            </div>
          </div>
          <div class="uk-card uk-card-body uk-card-small">
            <!--<div class="uk-margin">
              <div class="card-labeldevice">Perangkat</div>
              <div class="card-sublabel">{{ device.device_agent }}</div>
            </div>-->
            <div class="uk-margin">
              <div class="card-labeldevice">Perangkat terdaftar</div>
              <div class="card-sublabel">{{ dateConverted(device.logindate) }}</div>
            </div>
            <div class="uk-margin">
              <button @click="deleteDevice(device.account_id, device.mac_address)" class="uk-width-1-1 uk-button uk-button-default btn-delete-device">Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- mobile -->

</div>
</template>

<script>
export default {
  props: ['url', 'datauser'],
  data() {
    return {
      devices: {
        total: 0,
        results: []
      },
      errors: ''
    }
  },
  methods: {
    deviceList()
    {
      axios({
        method: 'get',
        url: this.url + '/biznetwifi/devicesubscriber/' + this.datauser.username
      }).then( res => {
        let result = res.data;
        this.devices = {
          total: result.total,
          results: result.data
        };
      }).catch( err => {
        this.errors = err.response.statusText;
      });
    },
    deleteDevice(user, mac)
    {
      swal({
        title: 'Konfirmasi',
        text: 'Apakah anda ingin menghapus device ini?',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: true,
          confirm: { value: true, text: 'Hapus' }
        }
      }).then( value => {
        if( value ) {
          axios({
            method: 'delete',
            url: this.url + '/biznetwifi/deletedevice/' + user + '/' + mac
          }).then( res => {
            swal({
              title: 'Berhasil',
              text: res.data.statusText,
              icon: 'success',
              timer: 5000
            });
            this.deviceList();
          }).catch( err => {
            this.errors = err.response.statusText;
          });
        }
      });
    },
    dateConverted: function(date) {
      return moment(date).locale('id').format('LL');
    }
  },
  mounted() {
    this.deviceList();
  }
}
</script>
