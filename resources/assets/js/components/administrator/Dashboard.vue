<template>
  <div>
    <div class="uk-margin-top">
      <div class="dashboard-container">
        <div class="subheading-dashboard">Dashboard</div>
        <div class="heading-dashboard">Overview</div>
        <div class="uk-grid-small uk-margin-top" uk-grid>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-4@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <a class="card-overview-device-icon card-overview-device-apple"><span class="fab fa-apple"></span></a>
              <div class="card-overview-value">{{ summarydevice.device.ios }}</div>
              <div class="card-overview-subvalue">iOS</div>
            </div>
          </div>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-4@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <a class="card-overview-device-icon card-overview-device-android"><span class="fab fa-android"></span></a>
              <div class="card-overview-value">{{ summarydevice.device.android }}</div>
              <div class="card-overview-subvalue">Android</div>
            </div>
          </div>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-4@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <a class="card-overview-device-icon"><span class="fas fa-laptop"></span></a>
              <div class="card-overview-value">{{ summarydevice.device.pc }}</div>
              <div class="card-overview-subvalue">PC / Laptop</div>
            </div>
          </div>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-4@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <a class="card-overview-device-icon card-overview-device-unknown"><span class="fas fa-question-circle"></span></a>
              <div class="card-overview-value">{{ summarydevice.device.unknown }}</div>
              <div class="card-overview-subvalue">Unknown Device</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['url'],
  data() {
    return {
      summarydevice: {
        total: 0,
        device: {
          ios: 0,
          android: 0,
          pc: 0,
          tv: 0,
          unknown: 0
        }
      }
    }
  },
  methods: {
    getSummaryDevice()
    {
      axios({
        method: 'get',
        url: this.url + 'admin/summary_device'
      }).then( res => {
        let result = res.data;
        this.summarydevice = {
          total: result.results.total,
          device: {
            ios: result.results.device.ios,
            android: result.results.device.android,
            pc: result.results.device.pc,
            tv: result.results.device.tv,
            unknown: result.results.device.unknown
          }
        };
        console.log(this.summarydevice);
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  mounted() {
    this.getSummaryDevice();
  }
}
</script>
