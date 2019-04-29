<template>
<div>
  <!-- desktop -->
  <section class="uk-cover-container uk-visible@s banner-hmpg-customer">
    <div class="uk-overlay uk-position-cover uk-light banner-hmpg-overlay">
      <div class="uk-container">
        <div class="uk-position-center">
          <div class="uk-text-center banner-icon-customer">
            <span class="fas fa-user-circle"></span>
          </div>
          <div class="uk-text-center welcome-customer-name">Hi, {{ datauser.displayname }}</div>
          <div class="uk-text-center uk-margin desktop-customer-id">{{ connectlocale.biznetwifi.connected }}</div>
        </div>
      </div>
    </div>
  </section>

  <section class="uk-visible@s container">
    <div class="uk-card uk-card-default uk-card-body container-box">
      <div class="container-devices">
        <div class="uk-margin-bottom container-heading">{{ custdash.mydevice }}</div>
        <div v-if="errors">
          <div class="uk-alert-error" uk-alert>
            {{ errors }}
            <a class="uk-alert-close" uk-close></a>
          </div>
        </div>
        <div v-if="devices.total === 0">
          <div class="uk-alert-warning" uk-alert>
            {{ custdash.nodevice }}
          </div>
        </div>
        <div class="uk-grid-medium uk-flex-center" uk-grid>
          <div v-for="device in devices.results" class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-2@m uk-width-1-2@s card-devices">
            <div class="uk-tile uk-tile-default card-device-box">
              <div class="card-icon-device">
                <span v-if="device.device_agent === 'ANDROID'"><i class="fab fa-android"></i></span>
                <span v-else-if="device.device_agent === 'iOS'"><i class="fab fa-apple"></i></span>
                <span v-else><i class="fas fa-laptop"></i></span>
              </div>
              <div class="card-identity-mac">{{ device.device_agent }}</div>
              <div class="card-device-info">
                <div class="device-info-lead">Mac Address</div>
                <div class="uk-text-uppercase device-last-login">{{ device.mac_address }}</div>
              </div>
              <button @click="deleteDevice(device.account_id, device.mac_address)" class="uk-width-1-1 uk-button uk-button-default btn-delete-device">{{ custdash.btndelete }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- desktop -->

  <!-- mobile -->
  <section class="uk-card uk-card-body uk-hidden@s box-content-customer">
    <div class="uk-tile uk-tile-default box-customer-profile">
      <div class="uk-grid-small" uk-grid>
        <div class="uk-width-1-1">
          <div class="uk-text-center box-icon-customer">
            <!--<span class="fas fa-user-circle"></span>-->
            <span class="icon ion-ios-contact"></span>
          </div>
        </div>
        <div class="uk-width-1-1">
          <div class="uk-text-center box-customer-name">Hello, <br> {{ datauser.displayname }}</div>
        </div>
        <div class="uk-width-1-1">
          <div class="uk-text-center">
            <a href="https://www.biznethome.net/id/" class="uk-button uk-button-default box-button-browse">{{ custdash.browse }}</a>
          </div>
          <div class="uk-text-center connected-mobile">{{ connectlocale.biznetwifi.connected }}</div>
        </div>
      </div>
    </div>
  </section>

  <div class="uk-card uk-card-body uk-card-small container-listdevice uk-hidden@s">
    <div class="heading-listdevice">{{ custdash.mydevice }}</div>
    <div v-if="errors">
      <div class="uk-alert-warning" uk-alert>
        {{ errors }}
        <a class="uk-alert-close" uk-close></a>
      </div>
    </div>
    <div class="uk-grid-medium" uk-grid>
      <div v-for="device in devices.results" class="uk-width-1-1">
        <div class="uk-card uk-card-default uk-card-body card-listdevice">
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
          <div class="uk-card uk-card-body">
            <div class="uk-margin">
              <div class="card-labeldevice">{{ device.device_agent }}</div>
              <!--<div class="card-sublabel">{{ device.device_agent }}</div>-->
            </div>
            <div class="uk-margin">
              <div class="card-labeldevice">Mac Address</div>
              <div class="uk-text-uppercase card-sublabel">{{ device.mac_address }}</div>
            </div>
            <div class="uk-margin">
              <button @click="deleteDevice(device.account_id, device.mac_address)" class="uk-width-1-1 uk-button uk-button-default btn-delete-device">{{ custdash.btndelete }}</button>
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
  props: ['url', 'datauser', 'connectlocale', 'custdash'],
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
