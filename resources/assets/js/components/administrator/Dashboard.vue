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
        <div class="uk-grid-small uk-grid-match" uk-grid>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-1@s">
            <div class="uk-card uk-card-body uk-card-small uk-card-default card-overview-device">
              <canvas id="chartBarSummaryClientAsVisitors" width="400" height="400">Unable to load chart</canvas>
              <!--<div v-for="visitors in summaryClientAsVisitors.results">
                <div class="uk-margin">
                  <div class="uk-text-left card-overview-subvalue">{{ visitors.client_os }}</div>
                  <div :style="{ width: (visitors.total_device / 100) * 10 + '%', 'background-color': 'red', height: '10px', padding: '8px' }"></div>
                </div>
              </div>-->
            </div>
          </div>
          <div class="uk-width-expand">
            <div class="uk-card uk-card-body uk-card-small uk-card-default card-overview-device">
              <div class="uk-width-1-1 uk-text-left uk-inline">
                <button class="uk-button uk-button-default form-overview-button" type="button">
                  {{ forms.filterdate.text }} <span uk-icon="chevron-down"></span>
                </button>
                <div class="form-overview-dropdown" uk-dropdown="mode: click">
                  <ul class="uk-nav uk-dropdown-nav">
                    <li>
                      <a v-if="forms.filterdate.value == 'today'" class="form-overview-dropdown-active" @click="onFilteringDate('Today', 'today')">Today</a>
                      <a v-else @click="onFilteringDate('Today', 'today')">Today</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == '7days'" class="form-overview-dropdown-active" @click="onFilteringDate('Last 7 days', '7days')">Last 7 days</a>
                      <a v-else @click="onFilteringDate('Last 7 days ', '7days')">Last 7 days</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == '28days'" class="form-overview-dropdown-active" @click="onFilteringDate('Last 28 days', '28days')">Last 28 days</a>
                      <a v-else @click="onFilteringDate('Last 28 days', '28days')">Last 28 days</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == '30days'" class="form-overview-dropdown-active" @click="onFilteringDate('Last 30 days', '30days')">Last 30 days</a>
                      <a v-else @click="onFilteringDate('Last 30 days', '30days')">Last 30 days</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == 'this_month'" class="form-overview-dropdown-active" @click="onFilteringDate('This Month', 'this_month')">This Month</a>
                      <a v-else @click="onFilteringDate('This Month', 'this_month')">This Month</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == 'last_month'" class="form-overview-dropdown-active" @click="onFilteringDate('Last Month', 'last_month')">Last Month</a>
                      <a v-else @click="onFilteringDate('Last Month', 'last_month')">Last Month</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == '3month'" class="form-overview-dropdown-active" @click="onFilteringDate('Last 3 Months Ago', '3month')">Last 3 Months Ago</a>
                      <a v-else @click="onFilteringDate('Last 3 Month Ago', '3month')">Last 3 Months Ago</a>
                    </li>
                  </ul>
                </div>
              </div>
              <canvas id="chartLineSummaryClientAsVisitor" width="300" height="100"></canvas>
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
      forms: {
        filterdate: {
          value: 'today',
          text: 'Today'
        }
      }
    }
  },
  methods: {
    onFilteringDate( str, val )
    {
      this.forms.filterdate.text = str;
      this.forms.filterdate.value = val;

      this.getSummaryDeviceClientAsVisitorByDate();
    },
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
    getSummaryDeviceClientAsVisitor()
    {
      axios({
        method: 'get',
        url: this.url + 'admin/clients/summary/visitors'
      }).then( res => {
        let result = res.data;
        this.summaryClientAsVisitors = {
          total: result.results.total_device,
          results: result.results.data_device
        };
        let chartSummaryClientAsVisitors = { label: [], data: [] };
        for( var os = 0; os < this.summaryClientAsVisitors.results.length; os++ ) {
          chartSummaryClientAsVisitors.label[os] = this.summaryClientAsVisitors.results[os].client_os;
          chartSummaryClientAsVisitors.data[os] = this.summaryClientAsVisitors.results[os].total_device;
        }

        var ctx = document.getElementById('chartBarSummaryClientAsVisitors').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: chartSummaryClientAsVisitors.label,
                datasets: [{
                    label: '# of Devices',
                    data: chartSummaryClientAsVisitors.data,
                    backgroundColor: [
                      'rgba(255, 99, 132, 0.5)',
                      'rgba(54, 162, 235, 0.5)',
                      'rgba(255, 206, 86, 0.5)',
                      'rgba(75, 192, 192, 0.5)',
                      'rgba(153, 102, 255, 0.5)',
                      'rgba(255, 159, 64, 0.5)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
              legend: {
                display: true
              },
              responsive: true,
              aspectRatio: 2
            }
        });
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getSummaryDeviceClientAsVisitorByDate()
    {
      axios({
        method: 'get',
        url: this.url + 'admin/clients/summary/visitors_by_date?filterdate=' + this.forms.filterdate.value
      }).then( res => {
        let result = res.data;
        var ctx = document.getElementById('chartLineSummaryClientAsVisitor').getContext('2d');
        if( this.forms.filterdate.value !== 'today' )
        {
          var labelDate = [];
          var ios = [], android = [], windows = [], linux = [], macos = [], other = [];
          for( var label = 0; label < result.records.length; label++ )
          {
            labelDate[label] = result.records[label].date;
            ios[label] = result.records[label].os.ios.total;
            android[label] = result.records[label].os.android.total;
            windows[label] = result.records[label].os.windows.total;
            linux[label] = result.records[label].os.linux.total;
            macos[label] = result.records[label].os.macos.total;
            other[label] = result.records[label].os.other.total;
          }
          var chart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: labelDate,
              datasets: [
                {
                  label: 'Android',
                  data: android,
                  backgroundColor: 'rgba(255, 99, 132, 0.2)',
                  borderColor: 'rgba(255, 99, 132, 1)',
                  borderWidth: 1,
                  fill: true,
                  lineTension: 0.4
                },
                {
                  label: 'iOS',
                  data: ios,
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1,
                  fill: true,
                  lineTension: 0.4
                },
                {
                  label: 'Windows',
                  data: windows,
                  backgroundColor: 'rgba(255, 206, 86, 0.2)',
                  borderColor: 'rgba(255, 206, 86, 0.2)',
                  borderWidth: 1,
                  fill: true,
                  lineTension: 0.4
                },
                {
                  label: 'Linux',
                  data: linux,
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
                  borderColor: 'rgba(75, 192, 192, 1)',
                  borderWidth: 1,
                  fill: true,
                  lineTension: 0.4
                },
                {
                  label: 'Mac OS',
                  data: macos,
                  backgroundColor: 'rgba(153, 102, 255, 0.2)',
                  borderColor: 'rgba(153, 102, 255, 1)',
                  borderWidth: 1,
                  fill: true,
                  lineTension: 0.4
                },
                {
                  label: 'Other',
                  data: other,
                  backgroundColor: 'rgba(255, 159, 64, 0.2)',
                  borderColor: 'rgba(255, 159, 64, 1)',
                  borderWidth: 1,
                  fill: true,
                  lineTension: 0.4
                },
              ]
            },
            options: {
      				responsive: true,
      				title: {
      					display: true,
      					text: 'of Clients OS'
      				}
      			}
          });
        }
        else
        {
          var barChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: [
                    result.os.ios.label,
                    result.os.android.label,
                    result.os.windows.label,
                    result.os.linux.label,
                    result.os.macos.label,
                    result.os.other.label
                  ],
                  datasets: [{
                      label: '# of Devices OS',
                      data: [
                        result.os.ios.total,
                        result.os.android.total,
                        result.os.windows.total,
                        result.os.linux.total,
                        result.os.macos.total,
                        result.os.other.total
                      ],
                      backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                legend: {
                  display: true
                },
                responsive: true,
                aspectRatio: 2
              }
          });
        }
      }).catch( err => {
        console.log( err );
      });
    }
  },
  mounted() {
    this.getSummaryClientAsSubscriber();
    this.getSummaryDeviceClientAsVisitor();
    this.getSummaryDeviceClientAsVisitorByDate();
  }
}
</script>
