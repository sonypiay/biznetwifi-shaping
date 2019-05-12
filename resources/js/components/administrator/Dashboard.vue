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
        <div class="uk-margin-top uk-grid-small" uk-grid>
          <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-1@s">
            <div class="uk-card uk-card-body uk-card-default card-overview-device">
              <canvas id="chartPieSummaryClientAsVisitors" width="400" height="400">Unable to load chart</canvas>
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
                      <a v-if="forms.filterdate.value == '7days'" class="form-overview-dropdown-active" @click="onFilteringDeviceByOSByDate('Last 7 days', '7days')">Last 7 days</a>
                      <a v-else @click="onFilteringDeviceByOSByDate('Last 7 days ', '7days')">Last 7 days</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == '14days'" class="form-overview-dropdown-active" @click="onFilteringDeviceByOSByDate('Last 14 days', '14days')">Last 14 days</a>
                      <a v-else @click="onFilteringDeviceByOSByDate('Last 14 days ', '14days')">Last 14 days</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == '28days'" class="form-overview-dropdown-active" @click="onFilteringDeviceByOSByDate('Last 28 days', '28days')">Last 28 days</a>
                      <a v-else @click="onFilteringDeviceByOSByDate('Last 28 days', '28days')">Last 28 days</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == '30days'" class="form-overview-dropdown-active" @click="onFilteringDeviceByOSByDate('Last 30 days', '30days')">Last 30 days</a>
                      <a v-else @click="onFilteringDeviceByOSByDate('Last 30 days', '30days')">Last 30 days</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == 'this_month'" class="form-overview-dropdown-active" @click="onFilteringDeviceByOSByDate('This Month', 'this_month')">This Month</a>
                      <a v-else @click="onFilteringDeviceByOSByDate('This Month', 'this_month')">This Month</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == 'last_month'" class="form-overview-dropdown-active" @click="onFilteringDeviceByOSByDate('Last Month', 'last_month')">Last Month</a>
                      <a v-else @click="onFilteringDeviceByOSByDate('Last Month', 'last_month')">Last Month</a>
                    </li>
                    <li>
                      <a v-if="forms.filterdate.value == '3month'" class="form-overview-dropdown-active" @click="onFilteringDeviceByOSByDate('Last 3 Months Ago', '3month')">Last 3 Months Ago</a>
                      <a v-else @click="onFilteringDeviceByOSByDate('Last 3 Month Ago', '3month')">Last 3 Months Ago</a>
                    </li>
                  </ul>
                </div>
              </div>
              <canvas id="chartAllDeviceVisitor" width="500" height="180"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="uk-margin dashboard-container">
        <div class="subheading-dashboard">Traffic Access Point</div>
        <div class="heading-dashboard">Ruckus Wireless</div>
        <div class="uk-margin-top uk-card uk-card-body uk-card-small uk-card-default card-overview-dashboard">
          <div class="uk-margin uk-card content-data">
            <div class="uk-width-1-1 uk-inline">
              <button class="uk-button uk-button-default form-content-button" type="button">
                {{ trafficAp.ruckus.filterdate.text }} <span uk-icon="chevron-down"></span>
              </button>
              <div class="uk-width-2-3" id="filterDateRuckus" uk-dropdown="mode: click; pos: right-center">
                <div class="uk-dropdown-grid uk-grid-small" uk-grid>
                  <div class="uk-width-expand">
                    <v-date-picker :formats="trafficAp.ruckus.datepicker.formats" mode="range" :is-inline="true" v-model="trafficAp.ruckus.datepicker.filterdate" :theme-styles="trafficAp.ruckus.datepicker.themeStyles" show-caps is-double-paned></v-date-picker>
                  </div>
                  <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-3@s">
                    <button class="uk-width-1-1 uk-button uk-button-default button-datepicker" @click="getListApTrafficRuckus()">Apply</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="trafficAp.ruckus.total === 0" class="uk-alert-warning" uk-alert>
            There is no data to display.
          </div>
          <div v-else class="uk-overflow-auto">
            <table class="uk-table uk-table-small uk-table-striped uk-table-divider uk-table-hover table-overview-dashboard">
              <thead>
                <tr>
                  <th>AP Name</th>
                  <th>Upload</th>
                  <th>Download</th>
                  <th>Total Traffic</th>
                  <th>Sessions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="traffic in trafficAp.ruckus.results">
                  <td>{{ traffic.ap_name }}</td>
                  <td>
                    <progress class="uk-progress" :value="$root.toPercentage( traffic.upload, traffic.total_traffic )" max="100"></progress>
                    {{ $root.formatNumeral( traffic.upload, '0.00 b' ) }}
                  </td>
                  <td>
                    <progress class="uk-progress" :value="$root.toPercentage( traffic.download, traffic.total_traffic )" max="100"></progress>
                    {{ $root.formatNumeral( traffic.download, '0.00 b' ) }}
                  </td>
                  <td>
                    <progress class="uk-progress" :value="$root.toPercentage( traffic.total_traffic, traffic.total_traffic )" max="100"></progress>
                    {{ $root.formatNumeral( traffic.total_traffic, '0.00 b' ) }}
                  </td>
                  <td>{{ traffic.total_session }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <ul class="uk-pagination" uk-margin>
            <li>
              <a v-if="trafficAp.ruckus.pagination.prev_page !== 1" @click="getListApTrafficRuckus( trafficAp.ruckus.pagination.path + '/' + trafficAp.ruckus.pagination.prev_page )"><span uk-pagination-previous></span></a>
              <a v-else><span uk-pagination-previous></span></a>
            </li>
            <li class="uk-disabled"><span>Page {{ trafficAp.ruckus.pagination.current_page }} of {{ trafficAp.ruckus.pagination.last_page }}</span></li>
            <li>
              <a v-if="trafficAp.ruckus.pagination.next_page !== 1" @click="getListApTrafficRuckus( trafficAp.ruckus.pagination.path + '/' + trafficAp.ruckus.pagination.next_page )"><span uk-pagination-next></span></a>
              <a v-else><span uk-pagination-next></span></a>
            </li>
          </ul>
        </div>
      </div>

      <div class="uk-margin dashboard-container">
        <div class="subheading-dashboard">Traffic Access Point</div>
        <div class="heading-dashboard">Mikrotik</div>
        <div class="uk-margin-top uk-card uk-card-body uk-card-small uk-card-default card-overview-dashboard">
          <div class="uk-margin uk-card content-data">
            <div class="uk-width-1-1 uk-inline">
              <button class="uk-button uk-button-default form-content-button" type="button">
                {{ trafficAp.mikrotik.filterdate.text }} <span uk-icon="chevron-down"></span>
              </button>
              <div class="uk-width-2-3" id="filterDateMikrotik" uk-dropdown="mode: click; pos: right-center">
                <div class="uk-dropdown-grid uk-grid-small" uk-grid>
                  <div class="uk-width-expand">
                    <v-date-picker :formats="trafficAp.mikrotik.datepicker.formats" mode="range" :is-inline="true" v-model="trafficAp.mikrotik.datepicker.filterdate" :theme-styles="trafficAp.mikrotik.datepicker.themeStyles" show-caps is-double-paned></v-date-picker>
                  </div>
                  <div class="uk-width-1-4@xl uk-width-1-4@l uk-width-1-4@m uk-width-1-3@s">
                    <button class="uk-width-1-1 uk-button uk-button-default button-datepicker" @click="getListApTrafficMikrotik()">Apply</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-if="trafficAp.mikrotik.total === 0" class="uk-alert-warning" uk-alert>
            There is no data to display.
          </div>
          <div v-else class="uk-overflow-auto">
            <table class="uk-table uk-table-small uk-table-striped uk-table-divider uk-table-hover table-overview-dashboard">
              <thead>
                <tr>
                  <th>AP Name</th>
                  <th>Upload</th>
                  <th>Download</th>
                  <th>Total Traffic</th>
                  <th>Sessions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="traffic in trafficAp.mikrotik.results">
                  <td>{{ traffic.ap_name }}</td>
                  <td>
                    <progress class="uk-progress" :value="$root.toPercentage( traffic.upload, traffic.total_traffic )" max="100"></progress>
                    {{ $root.formatNumeral( traffic.upload, '0.00 b' ) }}
                  </td>
                  <td>
                    <progress class="uk-progress" :value="$root.toPercentage( traffic.download, traffic.total_traffic )" max="100"></progress>
                    {{ $root.formatNumeral( traffic.download, '0.00 b' ) }}
                  </td>
                  <td>
                    <progress class="uk-progress" :value="$root.toPercentage( traffic.total_traffic, traffic.total_traffic )" max="100"></progress>
                    {{ $root.formatNumeral( traffic.total_traffic, '0.00 b' ) }}
                  </td>
                  <td>{{ traffic.total_session }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <ul class="uk-pagination" uk-margin>
            <li>
              <a v-if="trafficAp.mikrotik.pagination.prev_page !== 1" @click="getListApTrafficRuckus( trafficAp.mikrotik.pagination.path + '/' + trafficAp.mikrotik.pagination.prev_page )"><span uk-pagination-previous></span></a>
              <a v-else><span uk-pagination-previous></span></a>
            </li>
            <li class="uk-disabled"><span>Page {{ trafficAp.mikrotik.pagination.current_page }} of {{ trafficAp.mikrotik.pagination.last_page }}</span></li>
            <li>
              <a v-if="trafficAp.mikrotik.pagination.next_page !== 1" @click="getListApTrafficRuckus( trafficAp.mikrotik.pagination.path + '/' + trafficAp.mikrotik.pagination.next_page )"><span uk-pagination-next></span></a>
              <a v-else><span uk-pagination-next></span></a>
            </li>
          </ul>
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
      trafficAp: {
        ruckus: {
          filterdate: {
            value: 'today',
            text: this.$root.formatDate( new Date(), 'MMM DD, YYYY' ),
            start: new Date(),
            end: new Date()
          },
          datepicker: {
            filterdate: {
              start: new Date(),
              end: new Date()
            },
            props: {},
            attributes: {},
            themeStyles: {},
            formats: {
              title: 'MMMM YYYY',
              weekdays: 'W',
              navMonths: 'MMM',
              input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
              dayPopover: 'L', // Only for `v-date-picker`
              data: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'] // For attribute dates
            }
          },
          total: 0,
          results: [],
          pagination: {
            first_page: 1,
            last_page: 1,
            next_page: 1,
            prev_page: 1,
            current_page: 1,
            path: this.url + 'admin/bandwidth/ap/ruckus'
          }
        },
        mikrotik: {
          filterdate: {
            value: 'today',
            text: this.$root.formatDate( new Date(), 'MMM DD, YYYY' ),
            start: new Date(),
            end: new Date()
          },
          datepicker: {
            filterdate: {
              start: new Date(),
              end: new Date()
            },
            props: {},
            attributes: {},
            themeStyles: {},
            formats: {
              title: 'MMMM YYYY',
              weekdays: 'W',
              navMonths: 'MMM',
              input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
              dayPopover: 'L', // Only for `v-date-picker`
              data: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'] // For attribute dates
            }
          },
          total: 0,
          results: [],
          pagination: {
            first_page: 1,
            last_page: 1,
            next_page: 1,
            prev_page: 1,
            current_page: 1,
            path: this.url + 'admin/bandwidth/ap/mikrotik'
          }
        }
      },
      forms: {
        filterdate: {
          value: '7days',
          text: 'Last 7 Days'
        },
        filterdevice: {
          value: 'all',
          text: 'All'
        }
      },

    }
  },
  methods: {
    onFilteringDeviceByOSByDate( str, val )
    {
      this.forms.filterdate.text = str;
      this.forms.filterdate.value = val;
      this.getSummaryDeviceClientAsVisitorByDate();
    },
    onFilteringPieDeviceByOSByDate( str, val )
    {
      this.forms.filterdate_pie.text = str;
      this.forms.filterdate_pie.value = val;
      this.getSummaryDeviceClientAsVisitor();
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
        url: this.url + 'admin/clients/summary/current_visitors'
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

        var ctx = document.getElementById('chartPieSummaryClientAsVisitors').getContext('2d');
        if( window.pieSummaryClientAsVisitors !== undefined ) window.pieSummaryClientAsVisitors.destroy();

        window.pieSummaryClientAsVisitors = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartSummaryClientAsVisitors.label,
                datasets: [{
                    label: '# of Devices',
                    data: chartSummaryClientAsVisitors.data,
                    backgroundColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
              title: {
                display: true,
                text: 'All Devices'
              },
              legend: {
                display: true
              },
              responsive: true,
              maintainAspectRatio: true,
              animation: {
                animateRotate: true,
                animateScale: true
              },
              circumference: 2 * Math.PI
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
        url: this.url + 'admin/clients/summary/visitors_by_date?filterdate=' + this.forms.filterdate.value + '&filterdevice=' + this.forms.filterdevice.value
      }).then( res => {
        let result = res.data;
        var ctx = document.getElementById('chartAllDeviceVisitor').getContext('2d');
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

        if( window.bar !== undefined )
          window.bar.destroy();

        var context = {
          type: 'line',
          data: {
            labels: labelDate,
            datasets: [
              {
                label: 'Android',
                data: android,
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                lineTension: 0.4,
                fill: false,
                pointHitRadius: 1,
                pointBackgroundColor: 'rgba(255, 99, 132, 1 )',
                pointBorderColor: 'rgba(255, 99, 132, 1 )',
                pointBorderWidth: 1
              },
              {
                label: 'iOS',
                data: ios,
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: false,
                lineTension: 0.4,
                pointHitRadius: 1,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: 'rgba(54, 162, 235, 1)',
                pointBorderWidth: 1
              },
              {
                label: 'Windows',
                data: windows,
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 2,
                fill: false,
                lineTension: 0.4,
                pointHitRadius: 1,
                pointBackgroundColor: 'rgba(255, 206, 86, 1)',
                pointBorderColor: 'rgba(255, 206, 86, 1)',
                pointBorderWidth: 1
              },
              {
                label: 'Linux',
                data: linux,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false,
                lineTension: 0.4,
                pointHitRadius: 1,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointBorderColor: 'rgba(75, 192, 192, 1)',
                pointBorderWidth: 1
              },
              {
                label: 'Mac OS',
                data: macos,
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 2,
                fill: false,
                lineTension: 0.4,
                pointHitRadius: 1,
                pointBackgroundColor: 'rgba(153, 102, 255, 0.1)',
                pointBorderColor: 'rgba(153, 102, 255, 1)',
                pointBorderWidth: 1
              },
              {
                label: 'Other',
                data: other,
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2,
                fill: false,
                lineTension: 0.4,
                pointHitRadius: 1,
                pointBackgroundColor: 'rgba(255, 159, 64, 0.1)',
                pointBorderColor: 'rgba(255, 159, 64, 1)',
                pointBorderWidth: 1
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
              display: true,
              text: '# Operating Systems'
            },
            tooltips: {
              mode: 'index',
              intersect: false
            },
            hover: {
              mode: 'nearest',
              intersect: true
            },
            legend: {
              display: true
            },
            scales: {
              xAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: this.forms.filterdate.text
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  userCallback: function(label, index, labels) {
                    if (Math.floor(label) === label) {
                      return label;
                    }
                  },
                }
              }],
            }
          }
        };
        window.bar = new Chart(ctx, context);
      }).catch( err => {
        console.log( err );
      });
    },
    getListApTrafficRuckus( url )
    {
      if( url === undefined ) url = this.trafficAp.ruckus.pagination.path;
      UIkit.dropdown('#filterDateRuckus').hide();
      var startdate = this.$root.formatDate( this.trafficAp.ruckus.datepicker.filterdate.start, 'YYYY-MM-DD' );
      var enddate = this.$root.formatDate( this.trafficAp.ruckus.datepicker.filterdate.end, 'YYYY-MM-DD' );
      if( startdate === this.$root.formatDate( new Date(), 'YYYY-MM-DD' ) )
      {
        this.trafficAp.ruckus.filterdate.text = this.$root.formatDate( new Date(), 'MMM DD, YYYY' );
      }
      else
      {
        this.trafficAp.ruckus.filterdate.text = this.$root.formatDate( this.trafficAp.ruckus.datepicker.filterdate.start, 'MMM DD, YYYY' ) + ' - ' + this.$root.formatDate( this.trafficAp.ruckus.datepicker.filterdate.end, 'MMM DD, YYYY' );
      }

      axios({
        method: 'get',
        url: url + '?startdate=' + startdate + '&enddate=' + enddate
      }).then( res => {
        let result = res.data;
        this.trafficAp.ruckus.total = result.total_records;
        this.trafficAp.ruckus.results = result.results.data;

        if( result.results.next_page_url !== null )
        {
          this.trafficAp.ruckus.pagination.next_page =  + this.$root.getParameterURL( result.results.next_page_url ).get('page');
        }

        if( result.results.prev_page_url !== null )
        {
          this.trafficAp.ruckus.pagination.prev_page = this.$root.getParameterURL( result.results.prev_page_url ).get('page');
        }
        this.trafficAp.ruckus.pagination.current_page = result.results.current_page;
        this.trafficAp.ruckus.pagination.last_page = result.results.last_page;
      }).catch( err => {
        console.log( err.response.statusText );
      });

    },
    getListApTrafficMikrotik( url )
    {
      if( url === undefined ) url = this.trafficAp.mikrotik.pagination.path;
      UIkit.dropdown('#filterDateMikrotik').hide();
      var startdate = this.$root.formatDate( this.trafficAp.mikrotik.datepicker.filterdate.start, 'YYYY-MM-DD' );
      var enddate = this.$root.formatDate( this.trafficAp.mikrotik.datepicker.filterdate.end, 'YYYY-MM-DD' );
      if( startdate === this.$root.formatDate( new Date(), 'YYYY-MM-DD' ) )
      {
        this.trafficAp.mikrotik.filterdate.text = this.$root.formatDate( new Date(), 'MMM DD, YYYY' );
      }
      else
      {
        this.trafficAp.mikrotik.filterdate.text = this.$root.formatDate( this.trafficAp.mikrotik.datepicker.filterdate.start, 'MMM DD, YYYY' ) + ' - ' + this.$root.formatDate( this.trafficAp.mikrotik.datepicker.filterdate.end, 'MMM DD, YYYY' );
      }

      axios({
        method: 'get',
        url: url + '?startdate=' + startdate + '&enddate=' + enddate
      }).then( res => {
        let result = res.data;
        this.trafficAp.mikrotik.total = result.total_records;
        this.trafficAp.mikrotik.results = result.results.data;

        if( result.results.next_page_url !== null )
        {
          this.trafficAp.mikrotik.pagination.next_page =  + this.$root.getParameterURL( result.results.next_page_url ).get('page');
        }

        if( result.results.prev_page_url !== null )
        {
          this.trafficAp.mikrotik.pagination.prev_page = this.$root.getParameterURL( result.results.prev_page_url ).get('page');
        }
        this.trafficAp.mikrotik.pagination.current_page = result.results.current_page;
        this.trafficAp.mikrotik.pagination.last_page = result.results.last_page;
      }).catch( err => {
        console.log( err.response.statusText );
      });
    }
  },
  mounted() {
    this.getSummaryClientAsSubscriber();
    this.getSummaryDeviceClientAsVisitor();
    this.getSummaryDeviceClientAsVisitorByDate();
    this.getListApTrafficRuckus();
    this.getListApTrafficMikrotik();
  }
}
</script>
