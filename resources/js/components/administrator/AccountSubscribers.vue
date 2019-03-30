<template>
  <div>
    <div class="uk-modal-full" id="modal" uk-modal>
      <div class="uk-modal-dialog">
        <div class="uk-modal-body modal-body-analytic uk-height-viewport">
          <div class="uk-container">
            <div class="modal-heading-analytic">Client Details Report</div>
            <div class="uk-margin">
              <button class="uk-margin-small-left uk-button uk-button-default uk-button-small modal-button-analytic" @click="getBandwidthUsageClient( clients_detail )"><i class="fas fa-sync-alt"></i></button>
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
                              <span v-if="clients_detail.device_agent === 'ANDROID'" class="fab fa-android"></span>
                              <span v-else-if="clients_detail.device_agent === 'iOS'" class="fab fa-apple"></span>
                              <span v-else-if="clients_detail.device_agent === 'PC/LAPTOP'" class="fas fa-laptop"></span>
                              <span v-else class="fas fa-question-circle"></span>
                              <div class="modal-card-detailclients-osname">{{ clients_detail.device_agent }}</div>
                            </div>
                          </div>
                        </div>
                        <div class="uk-width-expand">
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-wdith-1-1@s">
                              <div class="modal-card-detailclients-label">Account ID:</div>
                            </div>
                            <div class="uk-width-expand">
                              <div class="modal-card-detailclients-value">{{ clients_detail.account_id }}</div>
                            </div>
                          </div>
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-wdith-1-1@s">
                              <div class="modal-card-detailclients-label">Mac Address:</div>
                            </div>
                            <div class="uk-width-expand">
                              <div class="modal-card-detailclients-value">{{ clients_detail.mac_address }}</div>
                            </div>
                          </div>
                          <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-3@m uk-wdith-1-1@s">
                              <div class="modal-card-detailclients-label">Last Connected:</div>
                            </div>
                            <div class="uk-width-expand">
                              <div class="modal-card-detailclients-value">{{ $root.formatDate( clients_detail.login_date, 'MMM DD, YYYY HH:mm' ) }}</div>
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
                      {{ forms.filterdate.text }} <span uk-icon="chevron-down"></span>
                    </button>
                    <div class="modal-dropdown-analytic-form" uk-dropdown="mode: click">
                      <ul class="uk-nav uk-dropdown-nav">
                        <li>
                          <a v-if="forms.filterdate.value == '7days'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last 7 days', '7days')">Last 7 days</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last 7 days ', '7days')">Last 7 days</a>
                        </li>
                        <li>
                          <a v-if="forms.filterdate.value == '14days'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last 14 days', '14days')">Last 14 days</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last 14 days ', '14days')">Last 14 days</a>
                        </li>
                        <li>
                          <a v-if="forms.filterdate.value == '28days'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last 28 days', '28days')">Last 28 days</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last 28 days', '28days')">Last 28 days</a>
                        </li>
                        <li>
                          <a v-if="forms.filterdate.value == '30days'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last 30 days', '30days')">Last 30 days</a>
                          <a v-else @click="onFilteringBandwidthPerDay('Last 30 days', '30days')">Last 30 days</a>
                        </li>
                        <li>
                          <a v-if="forms.filterdate.value == 'this_month'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('This Month', 'this_month')">This Month</a>
                          <a v-else @click="onFilteringBandwidthPerDay('This Month', 'this_month')">This Month</a>
                        </li>
                        <li>
                          <a v-if="forms.filterdate.value == 'last_month'" class="modal-button-form-analytic-active" @click="onFilteringBandwidthPerDay('Last Month', 'last_month')">Last Month</a>
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
    <div class="uk-margin-top">
      <h3 class="content-heading">Account Subscribers</h3>
      <div class="uk-card uk-card-body uk-card-default content-data">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.selectedrows" @change="getAccountSubscribers( pagination.path + '?page=1' )">
              <option value="10">10 rows</option>
              <option value="20">20 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
              <option value="200">200 rows</option>
              <option value="500">500 rows</option>
            </select>
          </div>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.device" @change="getAccountSubscribers( pagination.path + '?page=1' )">
              <option value="all">All Devices</option>
              <option value="iOS">iOS</option>
              <option value="ANDROID">Android</option>
              <option value="PC/LAPTOP">PC/Laptop</option>
              <option value="Unknown">Unknown</option>
            </select>
          </div>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.searchby">
              <option value="account_id">Account ID/Name</option>
              <option value="mac_address">Mac Address</option>
            </select>
          </div>
          <div class="uk-width-expand">
            <div class="uk-width-1-1 uk-inline">
              <a @click="getAccountSubscribers( pagination.path + '?page=1')" class="uk-form-icon" uk-icon="search"></a>
              <input @keyup.enter="getAccountSubscribers( pagination.path + '?page=1' )" type="text" v-model="forms.keywords" placeholder="Type keywords..." class="uk-width-1-1 uk-input form-content-input">
            </div>
          </div>
        </div>
        <div class="uk-margin-top">
          <div class="uk-margin">
            <span class="uk-label">{{ devices.total }} device(s)</span>
            <span class="uk-label">Android: {{ devices.device_total.android }}</span>
            <span class="uk-label">iOS: {{ devices.device_total.ios }}</span>
            <span class="uk-label">PC: {{ devices.device_total.pc }}</span>
            <!--<span class="uk-label">TV: {{ devices.device_total.tv }}</span>-->
            <span class="uk-label">Unknown: {{ devices.device_total.unknown }}</span>
          </div>
          <div v-if="devices.loading === true" class="uk-text-center" v-html="devices.loadingContent"></div>
        </div>
        <div class="uk-overflow-auto">
          <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-hover table-data-content">
            <thead>
              <tr>
                <th class="uk-width-small">Action</th>
                <th>Account ID</th>
                <th>Mac Address</th>
                <th>Device</th>
                <th>Date Registered</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="device in devices.result">
                <td>
                  <a @click="deleteDevice(device.account_id, device.mac_address)" class="uk-button uk-button-default uk-button-small table-btn-action" uk-tooltip="title: Delete" uk-icon="trash"></a>
                  <a @click="getBandwidthUsageClient(device)" class="uk-button uk-button-default uk-button-small table-btn-action" uk-tooltip="title: View"><span class="fas fa-chart-bar"></span></a>
                </td>
                <td>{{ device.account_id }}</td>
                <td>{{ device.mac_address }}</td>
                <td>{{ device.device_agent }}</td>
                <td>{{ $root.formatDate(device.login_date, 'MMM DD, YYYY HH:mm ') }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <ul class="uk-pagination content-data-pagination">
          <li>
            <a v-if="pagination.prev_url" @click="getAccountSubscribers( pagination.prev_url )">
              <span uk-pagination-previous></span>
            </a>
            <a v-else>
              <span uk-pagination-previous></span>
            </a>
          </li>
          <li><a>Page {{ pagination.current }} of {{ pagination.last_page }}</a></li>
          <li>
            <a v-if="pagination.next_url" @click="getAccountSubscribers( pagination.next_url )">
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
export default {
  props: ['url'],
  data() {
    return {
      forms: {
        device: 'all',
        keywords: '',
        searchby: 'account_id',
        selectedrows: 10,
        filterdate: {
          text: 'Last 7 days ago',
          value: '7days'
        }
      },
      pagination: {
        current: 1,
        next_url: '',
        prev_url: '',
        path: '',
        last_page: ''
      },
      devices: {
        total: 0,
        result: {},
        device_total: {
          ios: 0,
          android: 0,
          pc: 0,
          tv: 0,
          unknown: 0
        },
        bandwidth: {
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
        loading: false,
        loadingContent: ''
      },
      clients_detail: {
        account_id: '',
        mac_address: '',
        device_agent: '',
        login_date: new Date(),
      },
      errors: {}
    }
  },
  methods: {
    formatSize(bytes) {
      let sizes = numeral(bytes).format('0.00 b');
      return sizes;
    },
    onFilteringBandwidthPerDay( str, val )
    {
      this.forms.filterdate.text = str;
      this.forms.filterdate.value = val;
      this.getBandwidthUsageClient( this.clients_detail );
    },
    deleteDevice(account_id, mac_address)
    {
      swal({
        title: 'Are you sure?',
        text: 'MAC ' + mac_address + ' will be delete permanent.',
        icon: 'warning',
        dangerMode: true,
        buttons: {
          cancel: 'No',
          confirm: {
            text: 'Sure',
            value: true
          }
        }
      }).then( val => {
        if( val )
        {
          axios({
            method: 'delete',
            url: this.url + 'admin/delete/devices/' + account_id + '/' + mac_address,
            headers: { 'Content-Type': 'application/json' }
          }).then( res => {
            swal({
              title: 'Success',
              text: 'MAC ' + mac_address + ' deleted',
              icon: 'success'
            });
            this.getAccountSubscribers();
          }).catch( err => {
            swal({
              title: 'Whoops',
              text: 'An error has occured. ' + err.response.statusText,
              icon: 'warning',
              dangerMode: true
            });
          });
        }
      });
    },
    getAccountSubscribers(pages)
    {
      this.errors = {};
      var param = '&keywords=' + this.forms.keywords + '&rows=' + this.forms.selectedrows + '&device=' + this.forms.device + '&searchby=' + this.forms.searchby;
      var url = this.url + 'admin/list_account_subscribers';
      if( pages === undefined )
        url = url + '?page=' + this.pagination.current + param;
      else
        url = pages + param;

      if( this.devices.loading === false ) this.devices.loading = true;
      if( this.devices.loading === true ) this.devices.loadingContent = '<span uk-spinner></span>';
      axios({
        method: 'get',
        url: url,
        headers: { 'Content-Type': 'application/json' }
      }).then( res => {
        let results = res.data;
        this.devices.total = results.results.total;
        this.devices.result = results.results.data;
        this.devices.device_total = {
          ios: results.device_total.ios,
          android: results.device_total.android,
          pc: results.device_total.pc,
          tv: results.device_total.tv,
          unknown: results.device_total.unknown
        };
        this.pagination = {
          current: results.results.current_page,
          next_url: results.results.next_page_url,
          prev_url: results.results.prev_page_url,
          path: results.results.path,
          last_page: results.results.last_page
        };
        this.devices.loading = false;
        this.devices.loadingContent = '';
      }).catch( err => {
        this.errors.load_data = err.response.statusText;
      });
    },
    getBandwidthUsageClient( clients )
    {
      this.clients_detail.account_id = clients.account_id;
      this.clients_detail.device_agent = clients.device_agent;
      this.clients_detail.mac_address = clients.mac_address;
      this.clients_detail.date_registered = clients.login_date;

      UIkit.modal('#modal').show();
      axios({
        method: 'get',
        url: this.url + 'admin/clients/bandwidth/' + clients.mac_address + '?filterdate=' + this.forms.filterdate.value
      }).then( res => {
        let result = res.data;
        this.devices.bandwidth.current_usage = {
          download: result.currentUsage.download,
          upload: result.currentUsage.upload
        };
        this.devices.bandwidth.total_usage = {
          download: result.totalUsage.download,
          upload: result.totalUsage.upload
        };
        this.devices.bandwidth.results = result.usagePerDay;

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
                this.devices.bandwidth.total_usage.upload,
                this.devices.bandwidth.total_usage.download
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
                this.devices.bandwidth.current_usage.upload,
                this.devices.bandwidth.current_usage.download
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
        for( var i = 0; i < this.devices.bandwidth.results.length; i++ )
        {
          labels[i] = this.devices.bandwidth.results[i].date.text;
          uploadUsage[i] = this.devices.bandwidth.results[i].upload;
          downloadUsage[i] = this.devices.bandwidth.results[i].download;
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
                  labelString: this.forms.filterdate.text
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
    this.getAccountSubscribers();
  }
}
</script>
