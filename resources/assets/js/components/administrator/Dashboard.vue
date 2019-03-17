<template>
  <div>
    <div class="uk-margin-top">
      <div class="uk-margin dashboard-container">
        <div class="subheading-dashboard">Summary Clients</div>
        <div class="heading-dashboard">As Subscribers</div>
        <div class="uk-grid-small uk-margin-top" uk-grid>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-4@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <a class="card-overview-device-icon card-overview-device-apple"><span class="fab fa-apple"></span></a>
              <div class="card-overview-value">{{ summaryClientAsSubscribers.device.ios }}</div>
              <div class="card-overview-subvalue">iOS</div>
            </div>
          </div>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-4@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <a class="card-overview-device-icon card-overview-device-android"><span class="fab fa-android"></span></a>
              <div class="card-overview-value">{{ summaryClientAsSubscribers.device.android }}</div>
              <div class="card-overview-subvalue">Android</div>
            </div>
          </div>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-4@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <a class="card-overview-device-icon"><span class="fas fa-laptop"></span></a>
              <div class="card-overview-value">{{ summaryClientAsSubscribers.device.pc }}</div>
              <div class="card-overview-subvalue">PC / Laptop</div>
            </div>
          </div>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-4@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <a class="card-overview-device-icon card-overview-device-unknown"><span class="fas fa-question-circle"></span></a>
              <div class="card-overview-value">{{ summaryClientAsSubscribers.device.unknown }}</div>
              <div class="card-overview-subvalue">Unknown Device</div>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-margin dashboard-container">
        <div class="subheading-dashboard">Summary Clients</div>
        <div class="heading-dashboard">As Visitor</div>
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-4@m uk-width-1-1@s">
            <div class="uk-card uk-card-body uk-card-small uk-card-default card-overview-device">
              <div v-for="visitors in summaryClientAsVisitors.results">
                <div class="uk-margin">
                  <div class="uk-text-left card-overview-subvalue">{{ visitors.client_os }}</div>
                  <div :style="{ width: (visitors.total_device / 100) * 10 + '%', 'background-color': 'red', height: '10px', padding: '8px' }"></div>
                </div>
              </div>
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
      summaryClientAsSubscribers: {
        total: 0,
        device: {
          ios: 0,
          android: 0,
          pc: 0,
          tv: 0,
          unknown: 0
        }
      },
      summaryClientAsVisitors: {
        total: [],
        results: {}
      },
    }
  },
  methods: {
    getSummaryClientAsSubscriber()
    {
      axios({
        method: 'get',
        url: this.url + 'admin/clients/summary/subscribers'
      }).then( res => {
        let result = res.data;
        this.summaryClientAsSubscribers = {
          total: result.results.total,
          device: {
            ios: result.results.device.ios,
            android: result.results.device.android,
            pc: result.results.device.pc,
            tv: result.results.device.tv,
            unknown: result.results.device.unknown
          }
        };
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getSummaryClientAsVisitor()
    {
      axios({
        method: 'get',
        url: this.url + 'admin/clients/summary/visitors'
      }).then( res => {
        let result = res.data;
        this.summaryClientAsVisitors = {
          total: result.results.total,
          results: result.results.data
        };
        console.log( this.summaryClientAsVisitors );
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  mounted() {
    this.getSummaryClientAsSubscriber();
    this.getSummaryClientAsVisitor();
  }
}
</script>
