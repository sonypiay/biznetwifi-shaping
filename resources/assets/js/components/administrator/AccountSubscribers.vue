<template>
  <div>
    <div class="uk-modal-full" id="modal" uk-modal>
      <div class="uk-modal-dialog">
        <a class="uk-modal-close-full uk-close" uk-close></a>
        <div class="uk-modal-body modal-body-analytic uk-height-viewport">
          <div class="uk-container">
            <h3>Analytic Data</h3>
            <div class="uk-margin uk-grid-small uk-flex-center" uk-grid>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
                <div class="uk-card uk-card-body">
                  <div class="uk-card-title">Total Bandwidth Usage</div>
                  <canvas id="canvas_total_bandwidth_usage"></canvas>
                </div>
              </div>
              <div class="uk-width-1-3@xl uk-width-1-3@l uk-width-1-2@m uk-width-1-1@s">
                <div class="uk-card uk-card-body">
                  <div class="uk-card-title">Current Bandwidth Usage</div>
                  <canvas id="canvas_current_bandwidth_usage"></canvas>
                </div>
              </div>
              <div class="uk-width-1-1">
                <canvas id="canvas_bandwidth_usage_perday"></canvas>
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
                  <a @click="getBandwidthUsageClient(device.mac_address)" class="uk-button uk-button-default uk-button-small table-btn-action" uk-tooltip="title: View"><span class="fas fa-chart-bar"></span></a>
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
          text: '7 days ago',
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
      errors: {}
    }
  },
  methods: {
    formatSize(bytes) {
      let sizes = numeral(bytes).format('0b');
      return sizes;
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
    getBandwidthUsageClient(mac)
    {
      UIkit.modal('#modal').show();
      axios({
        method: 'get',
        url: this.url + 'admin/clients/bandwidth/' + mac
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
                  var sizes = numeral(data.datasets[0].data[index]).format('0 b');
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
                  var sizes = numeral(data.datasets[0].data[index]).format('0 b');
                  var results = label + ': ' + sizes;
                  return results;
                }
              }
            }
          }
        });

        var labels = [], uploadUsage = [], downloadUsage = [];
        for( var i = 0; i < this.devices.usagePerDay.length; i++ )
        {
          labels[i] = result[i].date.text;
        }
        console.log('error');
      }).catch( err => {
        /*swal({
          title: 'Whoops',
          text: err.response.statusText,
          icon: 'warning',
          dangerMode: true
        });*/
      });
    }
  },
  mounted() {
    this.getAccountSubscribers();
  }
}
</script>
