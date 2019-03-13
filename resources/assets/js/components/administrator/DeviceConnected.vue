<template>
  <div>
    <div class="uk-margin-top uk-container">
      <h3 class="content-heading">Device Connected</h3>
      <div class="uk-card uk-card-body uk-card-small content-data">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-6@xl uk-width-1-6@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.selectedrows" @change="getDeviceConnected( pagination.path + '?page=1' )">
              <option value="10">10 rows</option>
              <option value="20">20 rows</option>
              <option value="50">50 rows</option>
              <option value="100">100 rows</option>
              <option value="200">200 rows</option>
              <option value="500">500 rows</option>
            </select>
          </div>
          <div class="uk-width-1-5@xl uk-width-1-5@l uk-width-1-3@m uk-width-1-1@s">
            <select class="uk-select form-content-select" v-model="forms.device" @change="getDeviceConnected( pagination.path + '?page=' + pagination.current )">
              <option value="all">All Devices</option>
              <option value="iOS">iOS</option>
              <option value="ANDROID">Android</option>
              <option value="PC/LAPTOP">PC/Laptop</option>
              <option value="TV">TV</option>
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
              <a @click="getDeviceConnected( pagination.path + '?page=' + pagination.current )" class="uk-form-icon" uk-icon="search"></a>
              <input @keyup.enter="getDeviceConnected( pagination.path + '?page=' + pagination.current )" type="text" v-model="forms.keywords" placeholder="Type keywords..." class="uk-width-1-1 uk-input form-content-input">
            </div>
          </div>
        </div>
        <div class="uk-margin-top">
          <div class="uk-margin">
            <span class="uk-label">{{ devices.total }} device(s)</span>
            <span class="uk-label">Android: {{ devices.device_total.android }}</span>
            <span class="uk-label">iOS: {{ devices.device_total.ios }}</span>
            <span class="uk-label">PC: {{ devices.device_total.pc }}</span>
            <span class="uk-label">TV: {{ devices.device_total.tv }}</span>
            <span class="uk-label">Unknown: {{ devices.device_total.unknown }}</span>
          </div>
          <div v-if="devices.loading === true" class="uk-text-center" v-html="devices.loadingContent"></div>
        </div>
        <div class="uk-card uk-card-default uk-card-body table-overflow-content">
          <div class="uk-overflow-auto">
            <div class="uk-height-medium">
              <table class="uk-table uk-table-small uk-table-middle uk-table-divider uk-table-hover table-data-content">
                <thead>
                  <tr>
                    <th class="uk-table-shrink">Action</th>
                    <th>Account ID</th>
                    <th>Mac Address</th>
                    <th>Device</th>
                    <th>Connected on</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="device in devices.result">
                    <td>
                      <a @click="deleteDevice(device.account_id, device.mac_address)" class="uk-button uk-button-default uk-button-small table-btn-action" uk-tooltip="title: Delete" uk-icon="trash"></a>
                    </td>
                    <td>{{ device.account_id }}</td>
                    <td>{{ device.mac_address }}</td>
                    <td>{{ device.device_agent }}</td>
                    <td>{{ $root.formatDate(device.login_date, 'MMM DD, YYYY HH:mm ') }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <ul class="uk-pagination content-data-pagination">
          <li>
            <a v-if="pagination.prev_url" @click="getDeviceConnected( pagination.prev_url )">
              <span uk-pagination-previous></span>
            </a>
            <a v-else>
              <span uk-pagination-previous></span>
            </a>
          </li>
          <li><a>Page {{ pagination.current }} of {{ pagination.last_page }}</a></li>
          <li>
            <a v-if="pagination.next_url" @click="getDeviceConnected( pagination.next_url )">
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
        selectedrows: 10
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
        loading: false,
        loadingContent: ''
      },
      errors: {}
    }
  },
  methods: {
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
            this.getDeviceConnected();
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
    getDeviceConnected(pages)
    {
      this.errors = {};
      var param = '&keywords=' + this.forms.keywords + '&rows=' + this.forms.selectedrows + '&device=' + this.forms.device + '&searchby=' + this.forms.searchby;
      var url = this.url + 'admin/list_device_connected';
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
    }
  },
  mounted() {
    this.getDeviceConnected();
  }
}
</script>
