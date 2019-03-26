<template>
  <div>
    <div class="uk-modal-full" id="modal" uk-modal>
      <div class="uk-modal-dialog">
        <!--<a class="uk-modal-close-full uk-close" uk-close></a>-->
        <div class="uk-modal-body modal-body-analytic uk-height-viewport">
          <div class="uk-container">
            <div class="modal-heading-analytic">Analytic Data - <span class="uk-text-uppercase">{{ bandwidth.mac_address }}</span></div>
            <div class="uk-margin">
              <button class="uk-margin-small-left uk-button uk-button-default uk-button-small modal-button-analytic" @click="getBandwidthUsageClient(bandwidth.mac_address)"><i class="fas fa-sync-alt"></i></button>
              <button class="uk-button uk-button-default uk-button-small uk-modal-close modal-button-analytic"><i class="fas fa-times"></i></button>
            </div>
            <div class="uk-margin uk-grid-medium uk-flex-center" uk-grid>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
                <div class="uk-card uk-card-default uk-card-body modal-card-analytic">
                  <div class="uk-card-title modal-card-analytic-title">Total Bandwidth Usage</div>
                  <canvas id="canvas_total_bandwidth_usage"></canvas>
                </div>
              </div>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
                <div class="uk-card uk-card-default uk-card-body modal-card-analytic">
                  <div class="uk-card-title modal-card-analytic-title">Current Bandwidth Usage</div>
                  <canvas id="canvas_current_bandwidth_usage"></canvas>
                </div>
              </div>
              <div class="uk-width-1-1">
                <div class="uk-card uk-card-default uk-card-body">
                  <div class="uk-width-1-1 uk-text-left uk-inline">
                    <button class="uk-button uk-button-default modal-button-form-analytic" type="button">
                      {{ bandwidth.filterdate.text }} <span uk-icon="chevron-down"></span>
                    </button>
                    <div class="modal-dropdown-analytic-form" uk-dropdown="mode: click">
                      <ul class="uk-nav uk-dropdown-nav">
                        <li>
                          <a v-if="bandwidth.filterdate.value == '7days'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last 7 days', '7days')">Last 7 days</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last 7 days ', '7days')">Last 7 days</a>
                        </li>
                        <li>
                          <a v-if="bandwidth.filterdate.value == '14days'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last 14 days', '14days')">Last 14 days</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last 14 days ', '14days')">Last 14 days</a>
                        </li>
                        <li>
                          <a v-if="bandwidth.filterdate.value == '28days'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last 28 days', '28days')">Last 28 days</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last 28 days', '28days')">Last 28 days</a>
                        </li>
                        <li>
                          <a v-if="bandwidth.filterdate.value == '30days'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last 30 days', '30days')">Last 30 days</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last 30 days', '30days')">Last 30 days</a>
                        </li>
                        <li>
                          <a v-if="bandwidth.filterdate.value == 'this_month'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('This Month', 'this_month')">This Month</a>
                          <a v-else @click="onFilteringBandwidthPerDay('This Month', 'this_month')">This Month</a>
                        </li>
                        <li>
                          <a v-if="bandwidth.filterdate.value == 'last_month'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last Month', 'last_month')">Last Month</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last Month', 'last_month')">Last Month</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <canvas id="canvas_bandwidth_usage_perday" width="200" height="70"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="uk-margin-top">
      <h3 class="content-heading">Client as Visitor</h3>
      <div class="uk-card uk-card-body uk-card-default content-data">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.selectedrows" @change="getClientAsVisitors( pagination.path + '?page=1' )">
              <option value="10">10 rows</option>
              <option value="20">20 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
              <option value="200">200 rows</option>
              <option value="500">500 rows</option>
            </select>
          </div>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.filterap" @change="getClientAsVisitors( pagination.path + '?page=1' )">
              <option value="all">All Access Point</option>
              <option value="ruckus">Ruckus Wireless</option>
              <option value="mkt">Mikrotik</option>
            </select>
          </div>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.filterdevice" @change="getClientAsVisitors( pagination.path + '?page=1' )">
              <option value="all">All Devices</option>
              <option value="Windows">Windows</option>
              <option value="Linux">Linux</option>
              <option value="Android">Android</option>
              <option value="iOS">iOS</option>
              <option value="Mac OS">Mac OS</option>
            </select>
          </div>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <div class="uk-width-1-1 uk-inline">
              <button class="uk-width-1-1 uk-button uk-button-default form-content-button" type="button">
                {{ forms.filterdate.text }} <span uk-icon="chevron-down"></span>
              </button>
              <div class="form-content-dropdown" uk-dropdown="mode: click">
                <ul class="uk-nav uk-dropdown-nav">
                  <li>
                    <a v-if="forms.filterdate.value == 'today'" class="form-content-dropdown-active" @click="onFilteringDate('Today', 'today')">Today</a>
                    <a v-else @click="onFilteringDate('Today', 'today')">Today</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == '7days'" class="form-content-dropdown-active" @click="onFilteringDate('Last 7 days', '7days')">Last 7 days</a>
                    <a v-else @click="onFilteringDate('Last 7 days ', '7days')">Last 7 days</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == '28days'" class="form-content-dropdown-active" @click="onFilteringDate('Last 28 days', '28days')">Last 28 days</a>
                    <a v-else @click="onFilteringDate('Last 28 days', '28days')">Last 28 days</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == '30days'" class="form-content-dropdown-active" @click="onFilteringDate('Last 30 days', '30days')">Last 30 days</a>
                    <a v-else @click="onFilteringDate('Last 30 days', '30days')">Last 30 days</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == 'this_month'" class="form-content-dropdown-active" @click="onFilteringDate('This Month', 'this_month')">This Month</a>
                    <a v-else @click="onFilteringDate('This Month', 'this_month')">This Month</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == 'last_month'" class="form-content-dropdown-active" @click="onFilteringDate('Last Month', 'last_month')">Last Month</a>
                    <a v-else @click="onFilteringDate('Last Month', 'last_month')">Last Month</a>
                  </li>
                  <li>
                    <a v-if="forms.filterdate.value == 'custom'" class="form-content-dropdown-active" @click="onFilteringDate('Custom Date', 'custom')">Custom Date</a>
                    <a v-else @click="onFilteringDate('Custom Date', 'custom')">Custom Date</a>
                  </li>
                </ul>
              </div>
            </div>
            <!--<v-date-picker :formats="datepicker.formats" mode="range" v-model="forms.datepicker" :select-attribute="datepicker.attributes" :input-props="datepicker.props" :theme-styles="datepicker.themeStyles" show-caps></v-date-picker>-->
          </div>
          <div class="uk-width-expand">
            <div class="uk-width-1-1 uk-inline">
              <a @click="getClientAsVisitors( pagination.path + '?page=1' )" class="uk-form-icon" uk-icon="search"></a>
              <input @keyup.enter="getClientAsVisitors( pagination.path + '?page=1' )" type="search" placeholder="Search keywords..." class="uk-width-1-1 uk-input form-content-input" v-model="forms.keywords">
            </div>
          </div>
        </div>

        <div v-if="clientasvisitor.isLoading === true" class="uk-text-center uk-margin-top">
          <span uk-spinner></span> Loading data...
        </div>
        <div v-else-if="clientasvisitor.total === 0" class="uk-margin-top">
          <div class="uk-alert-warning" uk-alert>No record(s).</div>
        </div>
        <div v-else class="uk-margin-top uk-overflow-auto">
          <div class="uk-margin">
            <span class="uk-label">Clients: {{ clientasvisitor.total }}</span>
          </div>
          <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-hover table-data-content">
            <thead>
              <tr>
                <th class="uk-width-small">Action</th>
                <th>Mac Address</th>
                <th>Operating System</th>
                <th>Access Point</th>
                <th>Last Connected</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="clients in clientasvisitor.results">
                <td>
                  <a @click="getBandwidthUsageClient(clients.client_mac)" class="uk-button uk-button-default uk-button-small table-btn-action" uk-tooltip="title: View"><span class="fas fa-chart-bar"></span></a>
                </td>
                <td>{{ clients.client_mac }}</td>
                <td>{{ clients.client_os }}</td>
                <td>
                  <span v-if="clients.ap == 'mkt'">Mikrotik</span>
                  <span v-else>Ruckus Wireless</span>
                </td>
                <td>{{ formatDate(clients.updated_at, 'MMM DD, YYYY HH:mm ') }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <ul class="uk-pagination content-data-pagination">
          <li>
            <a v-if="pagination.prev_url" @click="getClientAsVisitors( pagination.prev_url )">
              <span uk-pagination-previous></span>
            </a>
            <a v-else>
              <span uk-pagination-previous></span>
            </a>
          </li>
          <li><a>Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
          <li>
            <a v-if="pagination.next_url" @click="getClientAsVisitors( pagination.next_url )">
              <span uk-pagination-next></span>
            </a>
            <a v-else>
              <span uk-pagination-next></span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import VCalendar from 'v-calendar';
import 'v-calendar/lib/v-calendar.min.css';

export default {
  props: ['url'],
  components: { VCalendar },
  data() {
    return {
      forms: {
        datepicker: {
          start: '',
          end: ''
        },
        filterdate: {
          text: 'Today',
          value: 'today'
        },
        selectedrows: 10,
        filterdevice: 'all',
        filterap: 'all',
        keywords: ''
      },
      pagination: {
        current_page: 1,
        last_page: 1,
        prev_url: '',
        next_url: '',
        path: this.url + 'admin/clients/client_visitor'
      },
      clientasvisitor: {
        total: 0,
        results: [],
        isLoading: false
      },
      bandwidth: {
        mac_address: '',
        filterdate: {
          text: 'Last 7 Days Ago',
          value: '7days'
        },
        total_usage: {
          download: 0,
          upload: 0
        },
        current_usage: {
          download: 0,
          upload: 0
        },
        results: []
      },
      datepicker: {
        props: {
          class: "uk-width-1-1 uk-input form-content-input",
          placeholder: "Enter date",
          readonly: true
        },
        attributes: {
          highlight: {
            backgroundColor: '#da068c',     // Red background
            borderColor: '#da068c',
            borderWidth: '2px',
            borderStyle: 'solid',
          }
        },
        themeStyles: {
          wrapper: {
            background: '#ffffff',
            color: '#ffffff',
            border: '0',
            borderRadius: '5px',
            boxShadow: '0 4px 8px 0 rgba(0, 0, 0, 0.14), 0 6px 20px 0 rgba(0, 0, 0, 0.13)'
          }
        },
        formats: {
          title: 'MMMM YYYY',
          weekdays: 'W',
          navMonths: 'MMM',
          input: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'], // Only for `v-date-picker`
          dayPopover: 'L', // Only for `v-date-picker`
          data: ['L', 'YYYY-MM-DD', 'YYYY/MM/DD'] // For attribute dates
        }
      }
    }
  },
  methods: {
    formatDate(str, format) {
      var res = moment(str).locale('id').format(format);
      return res;
    },
    onFilteringBandwidthPerDay( str, val )
    {
      this.bandwidth.filterdate.text = str;
      this.bandwidth.filterdate.value = val;
      this.getBandwidthUsageClient( this.bandwidth.mac_address );
    },
    onFilteringDate(str, val) {
      this.forms.filterdate = {
        text: str,
        value: val
      };
      this.getClientAsVisitors( this.pagination.path + '?page=1' );
    },
    getClientAsVisitors( pages )
    {
      var url, param;
      if( this.forms.datepicker.start === '' || this.forms.datepicker.start === undefined )
      {
        param = '&keywords=' + this.forms.keywords + '&filterdate=' + this.forms.filterdate.value + '&device=' + this.forms.filterdevice + '&ap=' + this.forms.filterap + '&rows=' + this.forms.selectedrows;
      }
      else
      {
        var startDate = this.formatDate( this.forms.datepicker.start, 'YYYY-MM-DD' );
        var endDate = this.formatDate( this.forms.datepicker.end, 'YYYY-MM-DD' );
        param = '&keywords=' + this.forms.keywords + '&startDate=' + startDate + '&endDate=' + endDate + '&device=' + this.forms.filterdevice + '&ap=' + this.forms.filterap + '&rows=' + this.forms.selectedrows;
      }

      if( pages === undefined )
        url = this.url + 'admin/clients/client_visitor?page=' + this.pagination.current_page + param;
      else
        url = pages + param;

      this.clientasvisitor.isLoading = true;
      axios({
        method: 'get',
        url: url,
        headers: { 'Content-Type': 'application/json' }
      }).then( res => {
        let result = res.data;
        this.clientasvisitor.total = result.total;
        this.clientasvisitor.results = result.data;
        this.clientasvisitor.isLoading = false;
        this.pagination = {
          current_page: result.current_page,
          last_page: result.last_page,
          prev_url: result.prev_page_url,
          next_url: result.next_page_url,
          path: result.path
        };
      }).catch( err => {
        console.log( err.response.statusText );
      });
    },
    getBandwidthUsageClient(mac)
    {
      this.bandwidth.mac_address = mac;
      UIkit.modal('#modal').show();
      axios({
        method: 'get',
        url: this.url + 'admin/clients/bandwidth/' + mac + '?filterdate=' + this.bandwidth.filterdate.value
      }).then( res => {
        let result = res.data;
        this.bandwidth.current_usage = {
          download: result.currentUsage.download,
          upload: result.currentUsage.upload
        };
        this.bandwidth.total_usage = {
          download: result.totalUsage.download,
          upload: result.totalUsage.upload
        };
        this.bandwidth.results = result.usagePerDay;

        if( window.totalBandwidth !== undefined ) window.totalBandwidth.destroy();
        if( window.currentBandwidth !== undefined ) window.currentBandwidth.destroy();
        if( window.totalBandwidthPerDay !== undefined ) window.totalBandwidthPerDay.destroy();

        var totalBandwidth = document.getElementById('canvas_total_bandwidth_usage').getContext('2d');
        var currentBandwidth = document.getElementById('canvas_current_bandwidth_usage').getContext('2d');
        var bandwidthPerDay = document.getElementById('canvas_bandwidth_usage_perday').getContext('2d');

        totalBandwidth.width = 200;
        totalBandwidth.height = 200;
        totalBandwidth.textAlign = 'center';
        totalBandwidth.textBaseline = 'middle';
        currentBandwidth.width = 200;
        currentBandwidth.height = 200;
        currentBandwidth.textAlign = 'center';
        currentBandwidth.textBaseline = 'middle';
        bandwidthPerDay.width = 200;
        bandwidthPerDay.height = 200;

        window.totalBandwidth = new Chart(totalBandwidth, {
          type: 'doughnut',
          data: {
            labels: ['Upload', 'Download'],
            datasets: [{
              data: [
                this.bandwidth.total_usage.upload,
                this.bandwidth.total_usage.download
              ],
              backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            legend: {
              display: true,
              onHover: function(event, legendItem) {
                return legendItem.text
              }
            },
            animation: {
              animateRotate: true,
              animateScale: true
            },
            circumference: 2 * Math.PI,

            tooltips: {
              enabled: true,
              callbacks: {
                label: function(tooltipItem, data) {
                  var index = tooltipItem.index;
                  var label = data.labels[index];
                  var sizes = numeral(data.datasets[0].data[index]).format('0.00 b');
                  var results = label + ': ' + sizes;
                  return results;
                }
              }
            }
          }
        });

        window.currentBandwidth = new Chart(currentBandwidth, {
          type: 'doughnut',
          data: {
            labels: ['Upload', 'Download'],
            datasets: [{
              data: [
                this.bandwidth.current_usage.upload,
                this.bandwidth.current_usage.download
              ],
              backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            legend: {
              display: true,
              onHover: function(event, legendItem) {
                return legendItem.text
              }
            },
            animation: {
              animateRotate: true,
              animateScale: true
            },
            circumference: 2 * Math.PI,

            tooltips: {
              enabled: true,
              callbacks: {
                label: function(tooltipItem, data) {
                  var index = tooltipItem.index;
                  var label = data.labels[index];
                  var sizes = numeral(data.datasets[0].data[index]).format('0.00 b');
                  var results = label + ': ' + sizes;
                  return results;
                }
              }
            }
          }
        });

        var labels = [], uploadUsage = [], downloadUsage = [];
        for( var i = 0; i < this.bandwidth.results.length; i++ )
        {
          labels[i] = this.bandwidth.results[i].date.text;
          uploadUsage[i] = this.bandwidth.results[i].upload;
          downloadUsage[i] = this.bandwidth.results[i].download;
        }
        window.totalBandwidthPerDay = new Chart(bandwidthPerDay, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [
              {
                label: 'Upload',
                data: uploadUsage,
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
                label: 'Download',
                data: downloadUsage,
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: false,
                lineTension: 0.4,
                pointHitRadius: 1,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: 'rgba(54, 162, 235, 1)',
                pointBorderWidth: 1
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            title: {
              display: true,
              text: '# Bandwidth Usage'
            },
            tooltips: {
              mode: 'index',
              intersect: false,
              enabled: true,
              callbacks: {
                label: function(tooltipItem, data) {
                  var index = tooltipItem.index;
                  var datasetIndex = tooltipItem.datasetIndex;
                  var label = data.datasets[datasetIndex].label;
                  var sizes = numeral(data.datasets[datasetIndex].data[index]).format('0.00 b');
                  var results = label + ': ' + sizes;
                  return results;
                }
              }
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
                  labelString: this.bandwidth.filterdate.text
                }
              }],
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  userCallback: function(label, index, labels) {
                    if (Math.floor(label) === label) {
                      return numeral(label).format('0.0 b');
                    }
                  },
                }
              }],
            }
          }
        });
      }).catch( err => {
        swal({
          title: 'Whoops',
          text: err.response.statusText,
          icon: 'warning',
          dangerMode: true
        });
      });
    }
  },
  mounted() {
    this.getClientAsVisitors();
  }
}
</script>
