<template>
  <div>
    <div class="uk-modal-full" id="modal" uk-modal>
      <div class="uk-modal-dialog">
        <div class="uk-modal-body modal-body-analytic uk-height-viewport">
          <div class="uk-container">
            <div class="modal-heading-analytic">Client Details Report</div>
            <div class="uk-margin">
              <button class="uk-margin-small-left uk-button uk-button-default uk-button-small modal-button-analytic" @click="getBandwidthUsageClient(clients_detail)"><i class="fas fa-sync-alt"></i></button>
              <button class="uk-button uk-button-default uk-button-small uk-modal-close modal-button-analytic"><i class="fas fa-times"></i></button>
            </div>
            <div class="uk-margin uk-grid-small uk-grid-match" uk-grid>
              <div class="uk-width-1-1">
                <div class="uk-grid-small uk-flex-center" uk-grid>
                  <div class="uk-width-2-3@xl uk-width-2-3@l uk-width-1-2@m uk-width-1-2@s">
                    <div class="uk-card uk-card-body uk-card-default modal-card-detailclients">
                      <div class="uk-card-title uk-margin-bottom modal-card-detailclients-heading">Detail Client</div>
                      <div class="uk-grid-match uk-grid-small" uk-grid>
                        <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-width-1-2@s">
                          <div class="uk-tile uk-tile-default uk-padding-small uk-text-center modal-card-detailclients-icon">
                            <div class="uk-position-center">
                              <span v-if="clients_detail.client_os === 'Android'" class="fab fa-android"></span>
                              <span v-else-if="clients_detail.client_os === 'iOS' || clients_detail.client_os === 'Mac OS'" class="fab fa-apple"></span>
                              <span v-else-if="clients_detail.client_os === 'Windows'" class="fab fa-windows"></span>
                              <span v-else-if="clients_detail.client_os === 'Linux'" class="fab fa-linux"></span>
                              <span v-else class="fas fa-question-circle"></span>
                              <div class="modal-card-detailclients-osname">{{ clients_detail.client_os }}</div>
                            </div>
                          </div>
                        </div>
                        <div class="uk-width-expand">
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-wdith-1-1@s">
                              <div class="modal-card-detailclients-label">IP Address:</div>
                            </div>
                            <div class="uk-width-expand">
                              <div class="modal-card-detailclients-value">{{ clients_detail.client_ip }}</div>
                            </div>
                          </div>
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-wdith-1-1@s">
                              <div class="modal-card-detailclients-label">Mac Address:</div>
                            </div>
                            <div class="uk-width-expand">
                              <div class="modal-card-detailclients-value">{{ clients_detail.client_mac }}</div>
                            </div>
                          </div>
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-wdith-1-1@s">
                              <div class="modal-card-detailclients-label">AP:</div>
                            </div>
                            <div class="uk-width-expand">
                              <div class="modal-card-detailclients-value">
                                <span v-if="clients_detail.ap === 'mikrotik'">Mikrotik</span>
                                <span v-if="clients_detail.ap === 'ruckus'">Ruckus Wireless</span>
                              </div>
                            </div>
                          </div>
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-wdith-1-1@s">
                              <div class="modal-card-detailclients-label">Location:</div>
                            </div>
                            <div class="uk-width-expand">
                              <div class="modal-card-detailclients-value">{{ clients_detail.location_id }}</div>
                            </div>
                          </div>
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-wdith-1-1@s">
                              <div class="modal-card-detailclients-label">Last Connected:</div>
                            </div>
                            <div class="uk-width-expand">
                              <div class="modal-card-detailclients-value">{{ $root.formatDate( clients_detail.last_connected, 'MMM DD, YYYY HH:mm' ) }}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-1@m uk-width-1-1@s">
                <div class="uk-grid-small" uk-grid>
                  <div class="uk-width-1-1">
                    <div class="uk-card uk-card-default uk-card-body modal-card-analytic">
                      <div class="uk-card-title modal-card-analytic-title">Total Bandwidth Usage</div>
                      <canvas id="canvas_total_bandwidth_usage"></canvas>
                    </div>
                  </div>
                  <div class="uk-width-1-1">
                    <div class="uk-card uk-card-default uk-card-body modal-card-analytic">
                      <div class="uk-card-title modal-card-analytic-title">Current Bandwidth Usage</div>
                      <canvas id="canvas_current_bandwidth_usage"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="uk-width-expand">
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
                  <canvas id="canvas_bandwidth_usage_perday" width="300" height="150"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="modal-filterdate" uk-modal>
      <div class="uk-modal-dialog uk-modal-body modal-body-analytic">
        <v-date-picker :formats="datepicker.formats" mode="range" v-model="forms.datepicker" :select-attribute="datepicker.attributes" :input-props="datepicker.props" :theme-styles="datepicker.themeStyles" show-caps></v-date-picker>
        <button class="uk-margin uk-button uk-button-default modal-button-analytic" @click="getClientAsVisitors( pagination.path + '?page=1' )">Apply</button>
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
              <option value="mikrotik">Mikrotik</option>
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
                <th>IP</th>
                <th>Last Connected</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="clients in clientasvisitor.results">
                <td>
                  <a @click="getBandwidthUsageClient(clients)" class="uk-button uk-button-default uk-button-small table-btn-action" uk-tooltip="title: View"><span class="fas fa-chart-bar"></span></a>
                </td>
                <td>{{ clients.client_mac }}</td>
                <td>{{ clients.client_os }}</td>
                <td>
                  <span v-if="clients.ap == 'mikrotik'">Mikrotik</span>
                  <span v-else>Ruckus Wireless</span>
                </td>
                <td>{{ clients.client_ip }}</td>
                <td>{{ $root.formatDate(clients.updated_at, 'MMM DD, YYYY HH:mm ') }}</td>
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
          start: new Date(),
          end: new Date()
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
      clients_detail: {
        client_ip: '::1',
        client_os: 'Unknown',
        client_mac: '',
        location_id: '',
        last_connected: new Date(),
        ap: ''
      },
      datepicker: {
        props: {
          class: "uk-width-1-1 uk-input form-content-input",
          placeholder: "Enter date",
          readonly: true
        },
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
      }
    }
  },
  methods: {
    onFilteringBandwidthPerDay( str, val )
    {
      this.bandwidth.filterdate.text = str;
      this.bandwidth.filterdate.value = val;
      this.getBandwidthUsageClient( this.clients_detail );
    },
    onFilteringDate(str, val) {
      this.forms.filterdate.text = str;
      this.forms.filterdate.value = val;
      if( val === 'custom' )
      {
        UIkit.modal('#modal-filterdate').show();
      }
      else
      {
        this.getClientAsVisitors( this.pagination.path + '?page=1' );
      }
    },
    getClientAsVisitors( pages )
    {
      var url, param;
      if( this.forms.filterdate.value === 'custom' )
      {
        var startDate = this.$root.formatDate( this.forms.datepicker.start, 'YYYY-MM-DD' );
        var endDate = this.$root.formatDate( this.forms.datepicker.end, 'YYYY-MM-DD' );
        param = '&keywords=' + this.forms.keywords + '&startDate=' + startDate + '&endDate=' + endDate + '&device=' + this.forms.filterdevice + '&ap=' + this.forms.filterap + '&rows=' + this.forms.selectedrows;
      }
      else
      {
        param = '&keywords=' + this.forms.keywords + '&filterdate=' + this.forms.filterdate.value + '&device=' + this.forms.filterdevice + '&ap=' + this.forms.filterap + '&rows=' + this.forms.selectedrows;
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
    getBandwidthUsageClient(clients)
    {
      this.clients_detail.client_ip = clients.client_ip;
      this.clients_detail.client_os = clients.client_os;
      this.clients_detail.client_mac = clients.client_mac;
      this.clients_detail.ap = clients.ap;
      this.clients_detail.last_connected = clients.updated_at;
      if( this.$root.isHexadecimal( clients.location_id ) )
        this.clients_detail.location_id = this.$root.hexToAscii( clients.location_id );
      else
        this.clients_detail.location_id = clients.location_id;

      UIkit.modal('#modal').show();
      axios({
        method: 'get',
        url: this.url + 'admin/clients/summary/bandwidth/' + clients.client_mac + '?filterdate=' + this.bandwidth.filterdate.value
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
                '#f15854',
                '#5ba1e0'
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
                '#f15854',
                '#5ba1e0'
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
                borderColor: '#f15854',
                borderWidth: 2,
                lineTension: 0.4,
                fill: false,
                pointHitRadius: 1,
                pointBackgroundColor: '#f15854',
                pointBorderColor: '#f15854',
                pointBorderWidth: 1
              },
              {
                label: 'Download',
                data: downloadUsage,
                borderColor: '#5ba1e0',
                borderWidth: 2,
                fill: false,
                lineTension: 0.4,
                pointHitRadius: 1,
                pointBackgroundColor: '#5ba1e0',
                pointBorderColor: '#5ba1e0',
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
                      return numeral(label).format('0.00 b');
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
